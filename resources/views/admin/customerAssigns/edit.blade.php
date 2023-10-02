@extends('layouts.admin')
@section('content')

<div class="card col-md-4">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.customerAssign.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.customer-assigns.update", [$customerAssign->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="service_person_id">{{ trans('cruds.customerAssign.fields.service_person') }}</label>
                <select class="form-control select2 {{ $errors->has('service_person') ? 'is-invalid' : '' }}" name="service_person_id" id="service_person_id" required>
                    @foreach($service_people as $id => $entry)
                    <option value="{{ $id }}" {{ (old('service_person_id') ? old('service_person_id') : $customerAssign->service_person->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <label class="required" for="service_area">{{ trans('cruds.customerAssign.fields.service_area') }}</label>
                <textarea class="form-control {{ $errors->has('service_area') ? 'is-invalid' : '' }}" name="service_area" id="service_area" required>{{ old('service_area', $customerAssign->service_area) }}</textarea>
                @if($errors->has('service_area'))
                <div class="invalid-feedback">
                    {{ $errors->first('service_area') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.customerAssign.fields.service_area_helper') }}</span>
            </div>
            <div class="form-group float-right">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.update') }}
                </button>
                <a href="{{ route('admin.customer-assigns.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>



@endsection
