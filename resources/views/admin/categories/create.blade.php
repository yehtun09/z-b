@extends('layouts.admin')
@section('content')
    <div class=" card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.category.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="category_name">{{ trans('cruds.category.fields.category_name') }}</label>
                            <input class="form-control {{ $errors->has('category_name') ? 'is-invalid' : '' }}"
                                type="text" name="category_name" id="category_name"
                                value="{{ old('category_name', '') }}" required>
                            @if ($errors->has('category_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.category.fields.category_name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex mt-2">

                    <button class="btn btn-primary me-1" type="submit">
                        {{ trans('global.save') }}
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
