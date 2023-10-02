@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.expenseCategory.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.expenseCategory.fields.id') }}
                            </th>
                            <td>
                                {{ $expenseCategory->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.expenseCategory.fields.name') }}
                            </th>
                            <td>
                                {{ $expenseCategory->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group mt-2">
                    <a class="btn btn-secondary" href="{{ route('admin.expense-categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
