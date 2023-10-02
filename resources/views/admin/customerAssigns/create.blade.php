@extends('layouts.admin')
@section('content')

<div class="card col-md-4">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.customerAssign.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.customer-assigns.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="service_person_id">{{ trans('cruds.customerAssign.fields.service_person') }}</label>
                <select class="form-control select2 {{ $errors->has('service_person') ? 'is-invalid' : '' }}" name="service_person_id" id="service_person_id" required>
                    @foreach($service_people as $id => $entry)
                        <option value="{{ $id }}" {{ old('service_person_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_person'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_person') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customerAssign.fields.service_person_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.customerAssign.fields.township') }}</label>
                <input type="text" value="{{ old('township') }}" class="form-control {{ $errors->has('township') ? 'is-invalid' : '' }}" name="township" id="township" required>
                @if($errors->has('township'))
                    <div class="invalid-feedback">
                        {{ $errors->first('township') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customerAssign.fields.township_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.customerAssign.fields.address') }}</label>
                <input type="text" value="{{ old('address') }}" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address" required>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customerAssign.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="" for="service_area">{{ trans('cruds.customerAssign.fields.service_area') }}</label>
                <textarea class="form-control {{ $errors->has('service_area') ? 'is-invalid' : '' }}" name="service_area" id="service_area" >{{ old('service_area') }}</textarea>
                @if($errors->has('service_area'))
                    <div class="invalid-feedback">
                        {{ $errors->first('service_area') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customerAssign.fields.service_area_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
