@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.customerAssign.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group mt-2">
                    <a class="btn btn-secondary" href="{{ route('admin.customer-assigns.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.customerAssign.fields.id') }}
                            </th>
                            <td>
                                {{ $customerAssign->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.customerAssign.fields.service_person') }}
                            </th>
                            <td>
                                {{ $customerAssign->service_person->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.customerAssign.fields.service_area') }}
                            </th>
                            <td>
                                {{ $customerAssign->service_area }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group mt-2">
                    <a class="btn btn-secondary" href="{{ route('admin.customer-assigns.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
