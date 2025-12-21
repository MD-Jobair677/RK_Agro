@extends('admin.layouts.master')
@section('master')
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body table-responsive text-nowrap fixed-min-height-table">
                  
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('SI')</th>
                                <th class="text-center">@lang('Cattle Image')</th>
                                <th class="text-center">@lang('Cattle Name')</th>
                                <th class="text-center">@lang('Customer Name')</th>
                                <th class="text-center">@lang('Sale Price')</th>
                                <th class="text-center">@lang('Advance Price')</th>
                    
                                <th class="text-center">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($booking->cattle_bookings as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <img class="rounded"
                                            src="{{ getImage(getFilePath('cattle') . '/' . optional($item->cattle->primaryImage)->image_path) }}"
                                            alt="admin-image" style="width:50px">
                                    </td>
               
                                    <td class="text-center">{{ $item->cattle->name }}</td>
                                    <td class="text-center">{{ $item->customer->full_name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ showAmount($item->sale_price) }}</td>
                                    <td class="text-center">{{ showAmount($item->advance_price) }}</td>
                                   
                                    <td class="text-center">
                                        <a href="{{ route('admin.booking.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                            <span class="tf-icons las la-pen me-1"></span>
                                            @lang('Edit')
                                        </a>
                                        <a href="{{ route('admin.booking.payment.index', $item->id) }}" class="btn btn-sm btn-info">
                                            <span class="tf-icons las la-money-bill-wave me-1"></span>
                                            @lang('Payments')
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

            </div>
        </div>
    </div>

    <x-decisionModal />
@endsection

@push('breadcrumb')
    <x-searchForm placeholder="Search cattle name..." dateSearch="no" />
@endpush






