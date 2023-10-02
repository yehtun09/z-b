@extends('layouts.admin')
@section('content')
    <div class=" card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.customer.fields.service_types') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.service-types.update', [$service_type->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="service_type">{{ trans('cruds.customer.fields.service_type') }}</label>
                            <input class="form-control {{ $errors->has('service_type') ? 'is-invalid' : '' }}"
                                type="text" name="service_type" id="service_type"
                                value="{{ old('service_type', $service_type->service_type) }}" required>
                            @if ($errors->has('service_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('service_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.service_type_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex mt-2">

                    <button class="btn btn-primary me-1" type="submit">
                        {{ trans('global.update') }}
                    </button>
                    <a href="{{ route('admin.service-types.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
