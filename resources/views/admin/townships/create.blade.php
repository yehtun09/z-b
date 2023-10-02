@extends('layouts.admin')
@section('content')
    <div class=" card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.customer.fields.township') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.townships.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="township">{{ trans('cruds.customer.fields.township') }}</label>
                            <input class="form-control {{ $errors->has('township') ? 'is-invalid' : '' }}"
                                type="text" name="township" id="township" value="{{ old('township', '') }}"
                                required>
                            @if ($errors->has('township'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('township') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.customer.fields.township_helper') }}</span>
                        </div>
                    </div>
                    
               
                <div class="form-group d-flex mt-2">

                    <button class="btn btn-success me-1" type="submit">
                        {{ trans('global.save') }}
                    </button>
                    <a href="{{ route('admin.townships.index') }}" class="btn btn-secondary">Cancel</a>

                </div>
            </form>
        </div>
    </div>
@endsection
