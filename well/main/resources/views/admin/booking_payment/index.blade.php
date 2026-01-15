@extends('admin.layouts.master')

<style>
    .print-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 36px;
        height: 36px;
        background-color: #28a745;
        /* green */
        color: #fff;
        border: none;
        border-radius: 10%;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .print-btn:hover {
        background-color: #218838;
        /* darker green */
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .print-btn i {
        pointer-events: none;
    }
</style>
@section('master')
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body table-responsive text-nowrap fixed-min-height-table">
                    <a href="{{ route('admin.booking.add.payment', $booking->id) }}" class="btn btn-sm btn-success">
                        <span class="tf-icons las la-plus-circle me-1"></span>
                        @lang('Add New')
                    </a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('SI')</th>
                                <th class="text-center">@lang('Cattle Name/number')</th>
                                <th class="text-center">@lang('Payment Date')</th>
                                <th class="text-center">@lang('Price')</th>
                                <th class="text-center">@lang('Action')</th>
                                <th class="text-center">@lang('Is Print')</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                            @forelse ($bookingPayments as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->cattle_name}} 

           




                                    </td>
                                    <td class="text-center">{{ $item->payment_date }}</td>
                                    <td class="text-center">{{ showAmount($item->price) }}</td>

                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.booking.edit.payment', [
                                            'booking' => $booking->id,
                                            'payment' => $item->id,
                                        ]) }}"
                                            class="btn btn-sm btn-warning print-btn" title="Edit">
                                            <i class="las la-edit"></i>
                                        </a>


                                        <!-- Print Button -->
                                        <button type="button" class="btn btn-sm btn-info print-btn"
                                            onclick="submitWithComment({{ $item->id }})" title="Print">
                                            <i class="las la-print"></i>
                                        </button>



                                        {{-- <button onclick="addCattle()" type="button" class="btn btn-sm btn-info print-btn">
                                            <i class="las la-print"></i></button> --}}

                                        <!-- Hidden Print Form -->
                                        <form id="print-form-{{ $item->id }}"
                                            action="{{ route('admin.booking.payment.slip', $item->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                            {{-- <input type="hidden" name="comment" id="hidden-comment-{{ $item->id }}"> --}}
                                        </form>
                                    </td>
                                    <td class="text-center">{{ $is_printed == 'yes' ? 'Printed' : 'Not Printed' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>

                @if ($bookingPayments->hasPages())
                    <div class="card-footer pagination justify-content-center">
                        {{ paginateLinks($bookingPayments) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-decisionModal />
@endsection

@push('breadcrumb')
    <a href="{{ route('admin.booking.index') }}" class="btn btn-label-primary">
        <span class="tf-icons las la-arrow-circle-left me-1"></span> @lang('Back')
    </a>
@endpush

@push('page-script')
    <script>
        function submitWithComment(id) {
            // let comment = document.getElementById('comment-' + id).value;
            // document.getElementById('hidden-comment-' + id).value = comment;
            document.getElementById('print-form-' + id).submit();
        }
    </script>
@endpush
