@extends('admin.layouts.master')
@section('master')
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body table-responsive text-nowrap fixed-min-height-table">
                    <a href="{{ route('admin.booking.add.payment',$booking->id) }}" class="btn btn-sm btn-success">
                        <span class="tf-icons las la-plus-circle me-1"></span>
                        @lang('Add New')
                    </a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('SI')</th>
                                <th class="text-center">@lang('Payment Date')</th>
                                <th class="text-center">@lang('Price')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($bookingPayments as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center"> {{ $item->payment_date }}</td>
                                    <td class="text-center"> {{ showAmount(($item->price)) }}</td>
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

