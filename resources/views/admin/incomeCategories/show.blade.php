@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.incomeCategory.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.incomeCategory.fields.id') }}
                            </th>
                            <td>
                                {{ $incomeCategory->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.incomeCategory.fields.name') }}
                            </th>
                            <td>
                                {{ $incomeCategory->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group mt-2">
                    <a class="btn btn-secondary" href="{{ route('admin.income-categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
