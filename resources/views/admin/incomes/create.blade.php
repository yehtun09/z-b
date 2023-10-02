@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.income.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.incomes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="income_category_id">{{ trans('cruds.income.fields.income_category') }}</label>
                            <select class="form-control select2 {{ $errors->has('income_category') ? 'is-invalid' : '' }}"
                                name="income_category_id" id="income_category_id">
                                @foreach ($income_categories as $id => $entry)
                                    <option value="{{ $id }}"
                                        {{ old('income_category_id') == $id ? 'selected' : '' }}>{{ $entry }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('income_category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('income_category') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.income.fields.income_category_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="entry_date">{{ trans('cruds.income.fields.entry_date') }}</label>
                            <input class="form-control date {{ $errors->has('entry_date') ? 'is-invalid' : '' }}"
                                type="text" name="entry_date" id="entry_date" value="{{ old('entry_date') }}" required>
                            @if ($errors->has('entry_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('entry_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.income.fields.entry_date_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.income.fields.amount') }}</label>
                            <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number"
                                name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01" required>
                            @if ($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.income.fields.amount_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.income.fields.description') }}</label>
                            <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                type="text" name="description" id="description" value="{{ old('description', '') }}">
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.income.fields.description_helper') }}</span>
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
@section('scripts')
    <script>
        $(() => {
            var flatpickrDate = document.querySelector('#entry_date');

            if (flatpickrDate) {
                flatpickrDate.flatpickr({
                    monthSelectorType: 'static',
                });
            }
        })
    </script>
@endsection
