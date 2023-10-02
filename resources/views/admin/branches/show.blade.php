@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.branch.title') }}
            <div class="form-group float-right">
                <a class="btn btn-secondary" href="{{ route('admin.branches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">{{ trans('cruds.branch.fields.branch') }}</div>
                    <div class="col-md-3">{{ trans('cruds.branch.fields.phone') }}</div>
                </div>
                <div class="row">
                    <div class="col-md-3">{{ $branch->branch }}</div>
                    <div class="col-md-3">{{ $branch->phone }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
