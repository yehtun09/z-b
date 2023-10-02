@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.category.title') }}

        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>{{ trans('cruds.category.fields.id') }}</td>
                    <td>{{ $category->id }}</td>
                </tr>
                <tr>
                    <td>{{ trans('cruds.category.fields.category_name') }}</td>
                    <td>{{ $category->category_name }}</td>
                </tr>
            </table>
            <div class="form-group mt-2">
                <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
