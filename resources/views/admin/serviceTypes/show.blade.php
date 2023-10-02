@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.customer.fields.service_type') }}

        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Id</td>
                    <td>{{ $service_type->id }}</td>
                </tr>
                <tr>
                    <td> {{ trans('cruds.customer.fields.service_type') }}</td>
                    <td>{{ $service_type->service_type }}</td>
                </tr>
            </table>
            <div class="form-group mt-2">
                <a class="btn btn-secondary" href="{{ route('admin.service-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
