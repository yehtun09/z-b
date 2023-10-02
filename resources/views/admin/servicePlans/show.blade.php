@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.customer.fields.service_plan') }}

        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Id</td>
                    <td>{{ $service_plan->id }}</td>
                </tr>
                <tr>
                    <td> {{ trans('cruds.customer.fields.service_plan') }}</td>
                    <td>{{ $service_plan->service_plan }}</td>
                </tr>
            </table>
            <div class="form-group mt-2">
                <a class="btn btn-secondary" href="{{ route('admin.service_plans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
