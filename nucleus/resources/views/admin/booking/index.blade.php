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
                                    <td class="text-center">{{ showAmount($item->bookingNumberGroupPrices($item->booking_number)) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.booking.view', $item->id) }}" class="btn btn-sm btn-info"><span class="tf-icons las la-eye me-1"></span>
                                            @lang('View')
                                        </a>
                                    </td>
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
    <x-searchForm placeholder="Search cattle name..." dateSearch="no" />
@endpush






