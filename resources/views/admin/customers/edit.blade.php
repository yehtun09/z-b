@extends('layouts.admin')
@section('content')
    <div class=" card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.site.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.customers.update', [$customer->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="sales_voucher_no">{{ trans('cruds.customer.fields.sales_voucher_no') }}</label>
                            <input class="form-control {{ $errors->has('sales_voucher_no') ? 'is-invalid' : '' }}"
                                type="text" name="sales_voucher_no" id="sales_voucher_no"
                                value="{{ old('sales_voucher_no', $customer->sales_voucher_no) }}">
                            @if ($errors->has('sales_voucher_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sales_voucher_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.sales_voucher_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_type" class="required">{{ trans('cruds.customer.fields.customer_code') }}</label>
                            <input class="form-control {{ $errors->has('customer_code') ? 'is-invalid' : '' }}"
                                type="text" name="customer_code" id="customer_code"
                                value="{{ old('customer_code', $customer->customer_code) }}" required>
                            @if ($errors->has('customer_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('customer_code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.customer_code_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="" for="name">{{ trans('cruds.customer.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', $customer->name) }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.name_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="contact_person">{{ trans('cruds.customer.fields.contact_person') }}</label>
                            <input class="form-control {{ $errors->has('contact_person') ? 'is-invalid' : '' }}"
                                type="text" name="contact_person" id="contact_person"
                                value="{{ old('contact_person', $customer->contact_person) }}">
                            @if ($errors->has('contact_person'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact_person') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.contact_person_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">{{ trans('cruds.customer.fields.phone_number') }}</label>
                            <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}"
                                type="text" name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $customer->phone_number) }}">
                            @if ($errors->has('phone_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.phone_number_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="" for="ticket_no">{{ trans('cruds.customer.fields.ticket_no') }}</label>
                            <input class="form-control {{ $errors->has('ticket_no') ? 'is-invalid' : '' }}" type="text"
                                name="ticket_no" id="ticket_no" value="{{ old('ticket_no', $customer->ticket_no) }}">
                            @if ($errors->has('ticket_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ticket_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.ticket_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="service_type_id">{{ trans('cruds.customer.fields.service_type') }}</label>
                            <select class="form-control {{ $errors->has('service_type_id') ? 'is-invalid' : '' }}"
                                name="service_type_id" id="service_type_id">
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach ($service_types as $id => $entry)
                                    <option value="{{ $entry->id }}"
                                        {{ old('service_type_id', $customer->service_type_id) == $entry->id ? 'selected' : ' ' }}>
                                        {{ $entry->service_type }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('service_type_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('service_type_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.service_type_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="service_plan_id">{{ trans('cruds.customer.fields.service_plan') }}</label>
                            <select class="form-control {{ $errors->has('service_plan_id') ? 'is-invalid' : '' }}"
                                name="service_plan_id" id="service_plan_id">
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach ($service_plans as $id => $entry)
                                    <option value="{{ $entry->id }}"
                                        {{ old('service_plan_id', $customer->service_plan_id) == $entry->id ? 'selected' : ' ' }}>
                                        {{ $entry->service_plan }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('service_plan_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('service_plan_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.service_plan_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="register_date">{{ trans('cruds.customer.fields.register_date') }}</label>
                            <input class="form-control date {{ $errors->has('register_date') ? 'is-invalid' : '' }}"
                                type="text" name="register_date" id="register_date" placeholder="YYYY-MM-DD"
                                value="{{ old('register_date', date('Y-m-d', strtotime($customer->register_date))) }}">
                            @if ($errors->has('register_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('register_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.register_date_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="" for="bandwidth">{{ trans('cruds.customer.fields.bandwidth') }}</label>
                            <input class="form-control {{ $errors->has('bandwidth') ? 'is-invalid' : '' }}"
                                type="text" name="bandwidth" id="bandwidth"
                                value="{{ old('bandwidth', $customer->bandwidth) }}">
                            @if ($errors->has('bandwidth'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bandwidth') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.bandwidth_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="site_lat">{{ trans('cruds.customer.fields.site_lat') }}</label>
                            <input class="form-control {{ $errors->has('site_lat') ? 'is-invalid' : '' }}" type="text"
                                name="site_lat" id="site_lat" value="{{ old('site_lat', $customer->site_lat) }}"
                                required>
                            @if ($errors->has('site_lat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('site_lat') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.site_lat_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="site_long">{{ trans('cruds.customer.fields.site_long') }}</label>
                            <input class="form-control {{ $errors->has('site_long') ? 'is-invalid' : '' }}"
                                type="text" name="site_long" id="site_long"
                                value="{{ old('site_long', $customer->site_long) }}" required>
                            @if ($errors->has('site_long'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('site_long') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.site_long_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="" for="township_id">{{ trans('cruds.customer.fields.township') }}</label>
                            <select class="form-control {{ $errors->has('township_id') ? 'is-invalid' : '' }}"
                                name="township_id" id="township_id">
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach ($townships as $id => $entry)
                                    <option value="{{ $entry->id }}"
                                        {{ old('township_id', $customer->township_id) == $entry->id ? 'selected' : ' ' }}>
                                        {{ $entry->township }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('township_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('township_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.township_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="" for="address">{{ trans('cruds.customer.fields.address') }}</label>
                            <textarea rows="1" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address"
                                id="address">{{ old('address', $customer->address) }}</textarea>
                            @if ($errors->has('address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.address_helper') }}</span>
                        </div>
                    </div>
                    <hr class="mt-4 mx-n4" />

                    {{-- Start MultiRow of Site Lat & Site Long --}}
                    <div class="content">
                        <h4>{{ trans('cruds.customer_location.title') }}</h4>
                        <div class="repeater-wrapper pt-0" data-repeater-item id="container">

                            @if (count($locationInfos))
                                @foreach ($locationInfos as $index => $locationInfo)
                                    <div class="mb-3 area-length" id="row{{ $index }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class=""
                                                        for="area_site_lat">{{ trans('cruds.customer_location.fields.area_site_lat') }}</label>
                                                    <input
                                                        class="form-control {{ $errors->has('area_site_lat') ? 'is-invalid' : '' }}"
                                                        type="text" name="area_site_lat[]" id="area_site_lat0"
                                                        value="{{ old('area_site_lat', $locationInfos[$index]->area_site_lat) }}"
                                                        {{ auth()->user()->is_admin || auth()->user()->is_administrator ? '' : 'disabled' }}>
                                                    @if ($errors->has('area_site_lat'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('area_site_lat') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.customer_location.fields.area_site_lat_helper') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class=""
                                                        for="area_site_long">{{ trans('cruds.customer_location.fields.area_site_long') }}</label>
                                                    <input
                                                        class="form-control {{ $errors->has('area_site_long') ? 'is-invalid' : '' }}"
                                                        type="text" name="area_site_long[]" id="area_site_long0"
                                                        value="{{ old('area_site_long', $locationInfos[$index]->area_site_long) }}"
                                                        {{ auth()->user()->is_admin || auth()->user()->is_administrator ? '' : 'disabled' }}>
                                                    @if ($errors->has('area_site_long'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('area_site_long') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.customer_location.fields.area_site_long_helper') }}</span>
                                                </div>
                                            </div>
                                            @if (auth()->user()->is_admin || auth()->user()->is_administrator)
                                                <div class="col-md-1 col-sm-2 col-2">
                                                    <div class="d-flex mt-4 justify-content-end">
                                                        <a class="btn addSiteArea px-0 me-1" id=""><i
                                                                class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                                        <a class="btn deleteSiteArea px-0" id="{{ $index }}"><i
                                                                class='bx bx-minus text-danger fw-bold fs-4'></i></a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="repeater-wrapper pt-0" data-repeater-item id="container">
                                    <div class="mb-3" id="row0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class=""
                                                        for="area_site_lat">{{ trans('cruds.customer_location.fields.area_site_lat') }}</label>
                                                    <input
                                                        class="form-control {{ $errors->has('area_site_lat') ? 'is-invalid' : '' }}"
                                                        type="text" name="area_site_lat[]" id="area_site_lat0">
                                                    @if ($errors->has('area_site_lat'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('area_site_lat') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.customer_location.fields.area_site_lat_helper') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class=""
                                                        for="area_site_long">{{ trans('cruds.customer_location.fields.area_site_long') }}</label>
                                                    <input
                                                        class="form-control {{ $errors->has('area_site_long') ? 'is-invalid' : '' }}"
                                                        type="text" name="area_site_long[]" id="area_site_long0"
                                                        value="{{ old('area_site_long', '') }}">
                                                    @if ($errors->has('area_site_long'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('area_site_long') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.customer_location.fields.area_site_long_helper') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-2 col-2">
                                                <div class="d-flex mt-4 justify-content-end">
                                                    <a class="btn addSiteArea px-0 me-1" id=""><i
                                                            class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                                    <a class="btn deleteSiteArea px-0"><i
                                                            class='bx bx-minus text-danger fw-bold fs-4'
                                                            id="0"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
                <div class="form-group d-flex mt-2">
                    <button class="btn btn-success me-1" type="submit">
                        {{ trans('global.update') }}
                    </button>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(() => {
            var flatpickrDate = document.querySelector('#register_date');

            if (flatpickrDate) {
                flatpickrDate.flatpickr({
                    monthSelectorType: 'static',
                });
            }
        })
    </script>
    <script>
        var btnCount = 10;

        // //add another Site Area
        $(document).on('click', '.addSiteArea', function() {
            ++btnCount;
            var content = ` <div class="mb-3" id="row${btnCount}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=""
                                    for="area_site_lat">{{ trans('cruds.customer_location.fields.area_site_lat') }}</label>
                                <input
                                    class="form-control {{ $errors->has('area_site_lat') ? 'is-invalid' : '' }}"
                                    type="text" name="area_site_lat[]" id="area_site_lat${btnCount}"
                                    value="{{ old('area_site_lat', '') }}">
                                @if ($errors->has('area_site_lat'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('area_site_lat') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.customer_location.fields.area_site_lat_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class=""
                                    for="area_site_long">{{ trans('cruds.customer_location.fields.area_site_long') }}</label>
                                <input
                                    class="form-control {{ $errors->has('area_site_long') ? 'is-invalid' : '' }}"
                                    type="text" name="area_site_long[]" id="area_site_long${btnCount}"
                                    value="{{ old('area_site_long', '') }}">
                                @if ($errors->has('area_site_long'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('area_site_long') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.customer_location.fields.area_site_long_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-2 col-2">
                            <div class="d-flex mt-4 justify-content-end">
                                <a class="btn addSiteArea px-0 me-1" id=""><i
                                        class='bx bx-plus text-primary fw-bold fs-4'></i></a>
                                <a class="btn deleteSiteArea px-0" id="${btnCount}" data-delete="1"><i
                                        class='bx bx-minus text-danger fw-bold fs-4'
                                        id="0"></i></a>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('#container').append(content);

        });

        $(document).on('click', '.deleteSiteArea', function() {

            var currentID = $(this).attr('id');
            var row = "#row" + currentID;
            if (currentID != 0) {
                $(row).remove();
                --btnCount;
            } else {
                console.log(btnCount);
                alert("You can't delete all Site Areas");
            }
        });
    </script>
@endsection
