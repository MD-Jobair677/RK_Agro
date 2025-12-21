<?php

namespace App\Http\Controllers\Admin;

use HTMLPurifier;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\InventoryStore;
use App\Models\InvStkQuantity;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\File;

class InventoryController extends Controller
{
    function stockIndex()
    {
        $pageTitle = 'Inventory Stock History';
        $invStocks = InventoryStore::searchable(['name', 'code'])
            ->dateFilter()
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate(getPaginate());
        return view('admin.inventory_manage.inv_stk_index', compact('pageTitle', 'invStocks'));
    }


    function create()
    {

        $pageTitle = 'Stock Item';
        $items = Item::orderBy('id')->latest()->get();
        $suppliers = Supplier::orderBy('id')->where('supplier_type', 1)->where('status',1)->latest()->get();
        $categories = Category::orderBy('id')->latest()->get();
        $warehouses = Warehouse::orderBy('id')->latest()->get();
        return view('admin.inventory_manage.inv_stk_create', compact('pageTitle', 'items', 'suppliers', 'categories', 'warehouses'));
    }

    function store(Request $request)
    {

        $pageTitle = 'Item Store';
        $request->validate([
            'supplier_id'     => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value !== 'new_supplier' && !\App\Models\Supplier::where('id', $value)->exists()) {
                        $fail('The selected supplier is invalid.');
                    }
                },
            ],

            'category_id'     => ['required_if:supplier_id,new_supplier', 'numeric', 'exists:categories,id',],
            'sup_name'        => 'required_if:supplier_id,new_supplier',
            'contact_number'  => 'required_if:supplier_id,new_supplier',
            'sup_address'     => 'nullable',
            'item_id'         => 'required|exists:items,id',
            'warehouse_id'    => 'required|exists:warehouses,id',
            'stock_in'        => 'required|numeric',
            'uom'             => 'required|string',
            'rate_per_unit'   => 'required|numeric',
            'purchase_date'   => 'required|date_format:d/m/Y',
            'note'            => 'nullable|string',
            'remark'          => 'nullable|string',
            'reference'       => 'nullable|string',
        ], [
            'code.unique'               => 'The item code has already been taken.',
            'purchase_date.date_format' => 'Purchase date must be in format DD/MM/YYYY.'
        ]);
        DB::beginTransaction();
        try {

            // Convert the custom formatted date to timestamp
            $purchaseDate = Carbon::createFromFormat('d/m/Y', $request->input('purchase_date')); 

            $purifier  = new HTMLPurifier();
            if($request->supplier_id === 'new_supplier'){
                $supplier = new Supplier();
                $supplier->category_id = $request->category_id;
                $supplier->name = $request->sup_name;
                $supplier->contact_number = $request->contact_number;
                $supplier->address = $purifier->purify($request->sup_address);
                $supplier->save();
            }

            $inventoryStore = new InventoryStore();
            $inventoryStore->item_id = $request->item_id;
            $inventoryStore->supplier_id = isset($supplier) ? $supplier->id : $request->supplier_id;
            $inventoryStore->warehouse_id = $request->warehouse_id;
            $inventoryStore->purchase_date = $purchaseDate->toDateTimeString();
            $inventoryStore->quntity_in = $request->stock_in;
            $inventoryStore->unit_of_measurement = $request->uom;
            $inventoryStore->rate_per_unit = $request->rate_per_unit;
            $inventoryStore->total_amount = $request->stock_in * $request->rate_per_unit;
            $inventoryStore->remark = $request->remark;
            $inventoryStore->reference = $request->reference;
            $inventoryStore->save();
            $existingInventoryStockQuentity = InvStkQuantity::where('item_id',$request->item_id)->where('warehouse_id',$request->warehouse_id)->first();

            if($existingInventoryStockQuentity){
                $existingInventoryStockQuentity->quantity += $request->stock_in;
                $existingInventoryStockQuentity->save();
            }else{
                $inventoryStoreQuentity = new InvStkQuantity();
                $inventoryStoreQuentity->item_id = $request->item_id;
                $inventoryStoreQuentity->warehouse_id = $request->warehouse_id;
                $inventoryStoreQuentity->quantity = $request->stock_in;
                $inventoryStoreQuentity->save();
            }

            DB::commit();
            $toast[] = ['success', 'Inventory Store successfully'];
            return back()->withToasts($toast);
        } catch (\Exception $exp) {
            DB::rollBack();
            $toast[] = ['error', 'Something went wrong! Inventory Store failed.'];
            return back()->withToasts($toast);
        }
    }
}
