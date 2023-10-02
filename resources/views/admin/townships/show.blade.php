@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.customer.fields.township') }}

        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Id</td>
                    <td>{{ $township->id }}</td>
                </tr>
                <tr>
                    <td>{{ trans('cruds.customer.fields.township') }}</td>
                    <td>{{ $township->township }}</td>
                </tr>
            </table>
            <div class="form-group mt-2">
                <a class="btn btn-secondary" href="{{ route('admin.townships.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
