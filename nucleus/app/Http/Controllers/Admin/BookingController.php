<?php

namespace App\Http\Controllers\Admin;

use HTMLPurifier;
use Carbon\Carbon;
use App\Models\Cattle;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CattleBooking;
use App\Models\BookingPayment;
use App\Constants\ManageStatus;
use App\Models\GenTotalExpense;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DeliveryLocation;
use Illuminate\Database\Capsule\Manager;

class BookingController extends Controller
{
    function index()
    {
        $pageTitle = 'Booking List';
        $latestBookingIds = Booking::selectRaw('MAX(id) as id')
            ->groupBy('booking_number');
        $bookings = Booking::with(['customer', 'cattle', 'cattle.primaryImage'])
            ->whereIn('id', $latestBookingIds->pluck('id'))
            ->searchable(['cattle:name', 'cattle:tag_number', 'customer:first_name', 'booking_number'])
            ->dateFilter()
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());


        $cattles = Cattle::where('status', 1)->get();

        return view('admin.booking.index', compact('pageTitle', 'bookings', 'cattles'));
    }

    function create()
    {
        $pageTitle = 'Booking Create';
        $cattles = Cattle::with('lastCattleRecord', 'cattle_expenses')->where('status', 1)->get();

        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.booking.create', compact('pageTitle', 'cattles', 'customers'));
    }
    function store(Request $request)
    {

        $pageTitle = 'Cattle Booking Create';
        $request->validate([
            'customer_id'     => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value !== 'new_customer' && !\App\Models\Customer::where('id', $value)->exists()) {
                        $fail('The selected supplier is invalid.');
                    }
                },
            ],

            'cus_name'     => ['required_if:customer_id,new_customer'],
            'cus_comp_name'   => 'required_if:customer_id,new_customer',
            'contact_number'  => 'required_if:customer_id,new_customer',
            'cus_address'     => 'nullable|string',
            'ref_name'     => 'nullable|string',
            'ref_cont_number'     => 'nullable|string',

            'booking_type' => ['required', 'numeric', Rule::in([1, 2])],
            'payment_method' => ['required', 'string'],
            'delivery_date' => ['required', 'date_format:d/m/Y', 'after_or_equal:today'],
            'distric_city'   => ['required', 'string'],
            'area_location'   => ['required', 'string'],
            'cattles' => ['required', 'array', 'min:1'],
            'cattles.*.cattle_id' => ['required', 'integer', 'exists:cattles,id'],
            'cattles.*.sale_price' => ['required', 'numeric', 'min:0'],
            'cattles.*.advance_price' => ['required', 'numeric', 'min:0', 'lte:cattles.*.sale_price'],


        ], [
            'delivery_date.date' => 'The purchase date must be a valid date.',
            'delivery_date.after_or_equal' => 'Purchase date cannot be in the past date',
        ]);

        DB::beginTransaction();

        try {

            // Convert the custom formatted date to timestamp
            $deliveryDate = Carbon::createFromFormat('d/m/Y', $request->input('delivery_date'));
            // -------------------------------------Customer Create-------------------------------------

            $purifier  = new HTMLPurifier();
            if ($request->customer_id === 'new_customer') {
                $customer = new Customer();
                $customer->first_name = $request->cus_name;
                $customer->company_name = $request->cus_comp_name;
                $customer->phone = $request->contact_number;
                $customer->address = $purifier->purify($request->cus_address);
                $customer->ref_name = $request->ref_name;
                $customer->ref_cont_number = $request->ref_cont_number;
                $customer->save();
            }

            // -------------------------------------End customer Create-------------------------------------


            // -------------------------------------Make Booking number -------------------------------------

            $prefix = $request->booking_type == 1 ? 'INS-' : 'EID-';
            $lastBooking = Booking::where('booking_type', $request->booking_type)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastBooking) {
                $numberPart = Str::of($lastBooking->booking_number)->after($prefix);
                $incrementNumber = (int) $numberPart->value + 1;
           
            } else {
                $incrementNumber = 1;
            }
            $bookingNumber = $prefix . str_pad($incrementNumber, 6, '0', STR_PAD_LEFT);

            // -------------------------------------End make Booking number -------------------------------------



            $totalSalePrice = collect($request->cattles)->sum('sale_price');
            $totalAdvancePrice = collect($request->cattles)->sum('advance_price');



            // -------------------------------------Booking create-------------------------------------
            $booking = new Booking();
            $booking->customer_id = isset($customer) ? $customer->id : $request->customer_id;
            $booking->booking_type = $request->booking_type;
            $booking->booking_number = $bookingNumber;
            $booking->payment_method = $request->payment_method;
            $booking->sale_price = $totalSalePrice;
            $booking->due_price = $totalAdvancePrice;
            $booking->delivery_date = $deliveryDate->toDateTimeString();
            $booking->status = 1;
            $booking->save();

            // -------------------------------------End booking create-------------------------------------




            // -------------------------------------Cattle booking create-------------------------------------
            foreach ($request->cattles as  $cattle) {
                $cattleBooking = new CattleBooking();
                $cattleBooking->cattle_id = $cattle['cattle_id'];
                $cattleBooking->booking_id = $booking->id;
                $cattleBooking->sale_price = $cattle['sale_price'];
                $cattleBooking->advance_price = $cattle['advance_price'];
                $cattleBooking->save();


                $cattle = Cattle::findOrFail($cattle['cattle_id']);
                $cattle->status = 2;
                $cattle->save();
            }
            // -------------------------------------End Cattle booking create-------------------------------------




            // -------------------------------------Delivery location create-------------------------------------

            $deliveryLocation = new DeliveryLocation();
            $deliveryLocation->booking_id = $booking->id;
            $deliveryLocation->district_city = $request->distric_city;
            $deliveryLocation->area = $request->area_location;
            $deliveryLocation->status = 0;
            $deliveryLocation->save();

            // -------------------------------------End Delivery location -------------------------------------


            DB::commit();
            $toast[] = ['success', 'Cattle booking created successfully'];
            return back()->withToasts($toast);
        } catch (\Exception $exp) {
            DB::rollBack();
            $toast[] = ['error', 'Something went wrong! Cattle booking creation failed.'];
            return back()->withToasts($toast);
        }
    }

    function edit($id)
    {
        $pageTitle = 'Cattle Booking Edit';
        $booking = Booking::with(['booking_payments'])->findOrFail($id);
        $cattles = Cattle::where(function ($query) use ($booking) {
            $query->where('status', 1)
                ->orWhere('id', $booking->cattle_id);
        })->get();
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.booking.edit', compact('pageTitle', 'cattles', 'customers', 'booking'));
    }


    function update(Request $request, $id)
    {

        $pageTitle = 'Cattle Booking Update';
        $request->validate([
            'customer_id'   => ['required', 'numeric', "exists:customers,id"],
            'cattle_id'   => ['required', 'numeric', "exists:cattles,id"],
            'booking_number' => ['required', 'string'],
            'booking_type' => ['required', 'numeric', Rule::in([1, 2])],
            'sale_price' => ['required', 'numeric', 'min:1', 'regex:/^\d+(\.\d{1,2})?$/'],
            'booking_type' => ['required', 'numeric', Rule::in([1, 2])],
            'delivery_date' => ['date_format:d/m/Y', 'after_or_equal:today'],
        ], [
            'delivery_date.date' => 'The purchase date must be a valid date.',
            'delivery_date.after_or_equal' => 'Purchase date cannot be in the past date',
        ]);


        $deliveryDate = Carbon::createFromFormat('d/m/Y', $request->input('delivery_date'));
        DB::beginTransaction();

        try {

            // -------------------------------------Customer Cattle Booking-------------------------------------
            $booking = Booking::with('booking_payments')->findOrFail($id);
            $alreadyPaid = $booking->booking_payments->sum('price');

            // if request sale_price > already booking payments price
            if ($request->sale_price > $booking->booking_payments->sum('price')) {
                $booking->sale_price = $request->sale_price;
                $booking->due_price = $booking->sale_price - $alreadyPaid;
                $toast[] = ['success', 'Cattle booking Updated successfully'];
            }

            // existing cattle is and request cattle id both are status change
            if ($booking->cattle_id != $request->cattle_id) {
                Cattle::findOrFail($request->cattle_id)->update(['status' => 0]);
                Cattle::findOrFail($booking->cattle_id)->update(['status' => 1]);
            }

            $booking->customer_id = $request->customer_id;
            $booking->cattle_id = $request->cattle_id;
            $booking->booking_type = $request->booking_type;
            $booking->delivery_date = $deliveryDate->toDateTimeString() ?? $booking->delivery_date;

            $booking->save();

            DB::commit();
            $notifyAdd[] = ['warning', "Cattle booking updated and sale price isn't adjusted based on payments."];
            return back()->withToasts($toast ?? $notifyAdd);
        } catch (\Exception $exp) {
            DB::rollBack();
            $toast[] = ['error', 'Something went wrong! Cattle booking creation failed.'];
            return back()->withToasts($toast);
        }
    }

    public function remove($id)
    {
        $cattle = Cattle::with('cattle_images')->find($id);

        if (!$cattle) {
            $toast[] = ['error', 'Cattle is not valid.'];
            return back()->withToasts($toast);
        }

        DB::beginTransaction();
        try {
            if ($cattle->cattle_images->count() > 0) {
                foreach ($cattle->cattle_images as $image) {
                    $filePath = getFilePath('cattle') . '/' . $image->image_path;

                    // Check if file exists before deleting
                    if (!empty($image->image_path) && FileFacades::exists($filePath)) {
                        $fileDeleted = fileManager()->removeFile($filePath);
                    } else {
                        \Log::warning('File not found: ' . $filePath);
                    }

                    $image->delete();
                }
            }

            $cattle->delete();
            DB::commit();

            $toast[] = ['success', 'Cattle deleted successfully.'];
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Cattle deletion failed: ' . $th->getMessage());
            $toast[] = ['error', 'Something went wrong! Cattle deletion failed.'];
        }

        return back()->withToasts($toast);
    }

    function view($id)
    {
        $pageTitle = 'Booking Cattles';
        
        $booking = Booking::with(['customer', 
        'cattle_bookings', 
        'cattle_bookings.cattle', 
        'cattle_bookings.cattle.primaryImage'])
        ->searchable(['cattle:name', 'cattle:tag_number', 'customer:first_name', 'booking_number'])
        ->where('id',$id)
        ->dateFilter()
        ->orderBy('id', 'desc')
        ->first();
    

        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.booking.booking_number_view', compact('pageTitle', 'customers', 'booking'));
    }

    public function bookingNumberSearch(Request $request)
    {
        $search = $request->get('search');
        $results = Booking::where('booking_number', 'like', "%$search%")
            ->distinct()
            ->limit(15)
            ->get(['booking_number']);

        return response()->json([
            'data' => $results
        ]);
    }

    public function bookingNumberByCustomerSearch(Request $request)
    {
        $bookingNumber = $request->input('booking_number');

        $booking = Booking::with(['customer', 'cattle', 'cattle.primaryImage'])
            ->whereRaw('LOWER(booking_number) = ?', [strtolower($bookingNumber)])
            ->orderBy('id', 'desc')
            ->first();

        if ($booking && $booking->customer) {
            return response()->json([
                'customer_exists' => true,
                'customer_id' => $booking->customer->id,
            ]);
        } else {
            return response()->json([
                'customer_exists' => false,
            ]);
        }
    }

    public function estimateCostAndWeightOnDelivery(Request  $request)
    {
        $cattle = Cattle::with('lastCattleRecord', 'cattle_expenses')->where('id', $request->id)->first();
        if ($cattle->type == ManageStatus::PURCHASE_CATTLE || ($cattle->type == ManageStatus::BORN_CATTLE && Carbon::parse($cattle->purchase_date)->addYear()->lte(now()))) {

            $deliveryDate = Carbon::createFromFormat('d/m/Y', $request->input('deliveryDate'));

            if ($cattle->cattle_category_id == ManageStatus::CATTLE_CATEGORY_COW_GROUP) {
                $genTotalExpence = GenTotalExpense::whereIn('expens_type', [3, 4])->sum('per_cattle_expense');
            } else {
                $genTotalExpence = 1000;
            }
            $purchasePrice =  $cattle->purchase_price ?? 0;
            $dailyTotalExpense =  $cattle->total_cost ?? 0;

            $totalWeight = $cattle->lastCattleRecord->purchase_weight + $cattle->lastCattleRecord->growth_weight;
            $perDayCost = ($totalWeight / $cattle->lastCattleRecord->price_for_weight) * $cattle->lastCattleRecord->weight_for_price;
            $futureCost = $perDayCost * now()->diffInDays($deliveryDate) + 2;
            $totalEtimateCostOnDelivery = $purchasePrice + $dailyTotalExpense + $genTotalExpence + $futureCost;

            $deliveryDate = Carbon::createFromFormat('d/m/Y', $request->input('deliveryDate'));
            $validFromDate = Carbon::parse($cattle->lastCattleRecord->valid_from_date);
            $daysBetween = $validFromDate->diffInDays($deliveryDate);

            $futureWeight = $cattle->lastCattleRecord->growth_weight * ($daysBetween + 2);
            $totalEtimateWeight = $futureWeight + $cattle->lastCattleRecord->last_updated_weight;
        } else {
            $totalEtimateCostOnDelivery = 0;
            $totalEtimateWeight = 0;
        }


        if ($totalEtimateCostOnDelivery) {
            return response()->json([
                'status' => true,
                'totalEtimateCostOnDelivery' => $totalEtimateCostOnDelivery,
                'totalEtimateWeight' => $totalEtimateWeight,
                'cattleType' => $cattle->type,
                'notMature' => 1,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'totalEtimateCostOnDelivery' => $totalEtimateCostOnDelivery,
                'totalEtimateWeight' => $totalEtimateWeight,
                'cattleType' => $cattle->type,
                'notMature' => 2,
            ]);
        }
    }
}
