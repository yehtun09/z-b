@extends('layouts.admin')
@section('content')
    <div class=" card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.customer.fields.service_plans') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.service_plans.update', [$service_plan->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="service_plan">{{ trans('cruds.customer.fields.service_plan') }}</label>
                            <input class="form-control {{ $errors->has('service_plan') ? 'is-invalid' : '' }}"
                                type="text" name="service_plan" id="service_plan"
                                value="{{ old('service_plan', $service_plan->service_plan) }}" required>
                            @if ($errors->has('service_plan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('service_plan') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.service_plan_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex mt-2">

                    <button class="btn btn-primary me-1" type="submit">
                        {{ trans('global.update') }}
                    </button>
                    <a href="{{ route('admin.service_plans.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
