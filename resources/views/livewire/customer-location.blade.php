<div class="row">
    @foreach ($locationInfo as $location)
        <div class="col-4">
            <div class="form-group">
                <label class="required" for="site_lat">{{ trans('cruds.customer.fields.site_lat') }}</label>
                <textarea rows="1" class="form-control {{ $errors->has('site_lat') ? 'is-invalid' : '' }}" name="site_lat"
                    id="site_lats[]" required>{{ old('site_lat') }}</textarea>
                @if ($errors->has('site_lat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site_lat') }}
                    </div>
                @endif
                <h1>{{ $location['site_lat'] }}</h1>
                <span class="help-block">{{ trans('cruds.customer.fields.address_helper') }}</span>
            </div>
        </div>
        <div class="col-4">
            <h1>{{ $locationInfo[count($locationInfo) - 1]['site_lat'] }} hello</h1>
            <div class="form-group">
                <label class="required" for="site_long">{{ trans('cruds.customer.fields.site_long') }}</label>
                <textarea rows="1" class="form-control {{ $errors->has('site_long') ? 'is-invalid' : '' }}" name="site_longs[]"
                    id="site_long" required>{{ old('site_long') }}</textarea>
                @if ($errors->has('site_long'))
                    <div class="invalid-feedback">
                        {{ $errors->first('site_long') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.site_long_helper') }}</span>
            </div>
        </div>
        <div class="col-4">
            <div class="d-flex mt-4">
                <button type="button" class="btn deleteProduct px-0" wire:click="deleteItem('1')">
                    <i class='bx bx-minus text-danger fw-bold fs-4' id="0"></i>
                </button>
            </div>
        </div>
    @endforeach
    <button type="button" class="btn addProduct px-0 me-1" wire:click.prevent="addItem">
        <i class='bx bx-plus text-primary fw-bold fs-4'></i>
    </button>
</div>
