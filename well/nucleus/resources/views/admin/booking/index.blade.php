@extends('admin.layouts.master')
@section('master')
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body table-responsive text-nowrap fixed-min-height-table">
                    <a href="{{ route('admin.booking.create') }}" class="btn btn-sm btn-success">
                        <span class="tf-icons las la-plus-circle me-1"></span>
                        @lang('Add New')
                    </a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('SI')</th>
                                <th class="text-center">@lang('Booking Number')</th>
                                <th class="text-center">@lang('Customer Name')</th>
                                <th class="text-center">@lang('Delivery Location')</th>
                                <th class="text-center">@lang('Price')</th>
                                <th class="text-center">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($bookings as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->booking_number }}</td>
                                    <td class="text-center">{{ $item->customer->fullname }}</td>
                                    <td class="text-center">{{ $item->delivery_location->district_city }}/
                                        @if (strlen(__($item->delivery_location->area)) > 20)
                                            {{ substr(__($item->delivery_location->area), 0, 35) . '...' }}
                                        @else
                                            {{ __($item->delivery_location->area) }}
                                        @endif
                                    <td class="text-center"> {{ showAmount($item->bookingNumberGroupPrices($item->booking_number)) }}</td>
                                    @if ($item->status == 1)
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-label-primary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">@lang('Action')</button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.booking.edit', $item->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <span class="tf-icons las la-pen me-1"></span>
                                                            @lang('Edit')
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.booking.view', $item->id) }}"
                                                            class="btn btn-sm btn-info"><span
                                                                class="tf-icons las la-eye me-1"></span>
                                                            @lang('View')
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.booking.payment.list', $item->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <span class="tf-icons las la-money-bill-wave me-1"></span>
                                                            @lang('Payment')
                                                        </a>
                                                    </li>
                                                    @if ($item->sale_price < $item->total_payment_amount)
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.booking.refund.payment', $item->id) }}"
                                                                class="btn btn-sm btn-info">
                                                                <span class="tf-icons las la-money-bill-wave me-1"></span>
                                                                @lang('Refund')
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if ($item->sale_price <= $item->total_payment_amount)
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.booking.delivery.print', $item->id) }}"
                                                                class="btn btn-sm btn-warning">
                                                                <span class="tf-icons las la-print me-1"></span>
                                                                @lang('Print')
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    @elseif($item->status == 3)
                                        <td class="text-center">
                                            <a href="{{ route('admin.booking.cattles.delivery', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <span class="tf-icons las la-truck me-1"></span>
                                                @lang('Delivery')
                                            </a>
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-success">
                                                @lang('Delivered')
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($bookings->hasPages())
                    <div class="card-footer pagination justify-content-center">
                        {{ paginateLinks($bookings) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-decisionModal />
@endsection

@push('breadcrumb')
    <x-searchForm placeholder="Search by number or customer name..." dateSearch="no" />
@endpush
