@extends('layouts.admin')
@section('content')
    <div class=" card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.branch.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.branches.update', [$branch->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="branch">{{ trans('cruds.branch.fields.branch') }}</label>
                    <input class="form-control {{ $errors->has('branch') ? 'is-invalid' : '' }}" type="text"
                        name="branch" id="branch" value="{{ old('branch', $branch->branch) }}" required>
                    @if ($errors->has('branch'))
                        <div class="invalid-feedback">
                            {{ $errors->first('branch') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.branch.fields.branch_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="phone">{{ trans('cruds.branch.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text"
                        name="phone" id="phone" value="{{ old('phone', $branch->phone) }}" required>
                    @if ($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.branch.fields.phone_helper') }}</span>
                </div>
                <div class="form-group d-flex mt-2">

                    <a href="{{ route('admin.branches.index') }}" class="btn btn-secondary">Cancel</a>
                    <button class="btn btn-primary ms-1" type="submit">
                        {{ trans('global.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
