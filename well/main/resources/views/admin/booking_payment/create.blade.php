@extends('admin.layouts.master')

@section('master')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <form class="card-body" action="{{ route('admin.booking.store.payment') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $booking->id }}" name="booking_id">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('Payment Date')</label>
                                <input name="payment_date" id="datepicker" type="text" data-range="false"
                                    data-language="en" class="datepicker-here form-control" data-position='bottom right'
                                    placeholder="@lang('Payment Date')" autocomplete="off" value="{{ old('payment_date') }}">
                            </div>
                        </div>



                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('Cattle Name/number')</label>
                               
                                    <input type="text" class="form-control" name="cattle_name"
                                        placeholder="@lang('Enter your cattle name/number')" required>
                               
                            </div>
                        </div>




                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('Amount')</label>
                              
                                    <input type="number" class="form-control" name="amount"
                                        placeholder="@lang('Enter your payment amount')" required>
                               
                            </div>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary me-sm-2 me-1 sds">@lang('Create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb')
    <a href="{{ route('admin.booking.payment.list', $booking->id) }}" class="btn btn-label-primary">
        <span class="tf-icons las la-arrow-circle-left me-1"></span> @lang('Back')
    </a>
@endpush
@push('page-style-lib')
    <link rel="stylesheet" href="{{ asset('assets/universal/css/datepicker.css') }}">
@endpush
@push('page-script-lib')
    <script src="{{ asset('assets/universal/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/universal/js/datepicker.en.js') }}"></script>
@endpush
@push('page-script')
    <script>
        $(document).ready(function() {
            $('#datepicker').datepicker({
                maxDate: new Date(),
                autoclose: true,
                dateFormat: 'dd/mm/yyyy',
                language: 'en'
            });
        });
    </script>
@endpush
