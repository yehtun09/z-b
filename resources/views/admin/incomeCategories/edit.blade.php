@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.incomeCategory.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.income-categories.update', [$incomeCategory->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.incomeCategory.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', $incomeCategory->name) }}" required>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.incomeCategory.fields.name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <button class="btn btn-primary" type="submit">
                        {{ trans('global.save') }}
                    </button>
                    <a onclick="history.back()" class="btn btn-secondary text-white">{{ trans('global.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
