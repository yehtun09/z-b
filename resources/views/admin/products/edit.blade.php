@extends('layouts.admin')
@section('content')
    <div class=" card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.product.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.update', [$product->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="onu_type">{{ trans('cruds.product.fields.onu_type') }}</label>
                            <select required class="form-control {{ $errors->has('onu_type') ? 'is-invalid' : '' }}" name="onu_type" id="onu_type">
                                <option value="">{{trans('global.pleaseSelect')}}</option>
                                @foreach (App\Models\Product::ONU_LISTS as $key=>$value )
                                    <option value="{{$key}}" {{$product->onu_type == $key ? 'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('onu_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('onu_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.onu_type_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="onu_model_no">{{ trans('cruds.product.fields.onu_model_no') }}</label>
                            <input class="form-control {{ $errors->has('onu_model_no') ? 'is-invalid' : '' }}"
                                type="text" name="onu_model_no" id="onu_model_no" value="{{ old('onu_model_no', $product->onu_model_no) }}"
                                required>
                            @if ($errors->has('onu_model_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('onu_model_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.onu_model_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="onu_model_no">{{ trans('cruds.product.fields.ont_serial_no') }}</label>
                            <input class="form-control {{ $errors->has('ont_serial_no') ? 'is-invalid' : '' }}"
                                type="text" name="ont_serial_no" id="ont_serial_no" value="{{ old('ont_serial_no', $product->ont_serial_no) }}"
                                required>
                            @if ($errors->has('ont_serial_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ont_serial_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.ont_serial_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="onu">{{ trans('cruds.product.fields.onu') }}</label>
                            <input class="form-control {{ $errors->has('onu') ? 'is-invalid' : '' }}"
                                type="text" name="onu" id="onu" value="{{ old('onu',  $product->onu) }}"
                                required>
                            @if ($errors->has('onu'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('onu') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.onu_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="drum_no">{{ trans('cruds.product.fields.drum_no') }}</label>
                            <input class="form-control {{ $errors->has('drum_no') ? 'is-invalid' : '' }}"
                                type="number" name="drum_no" id="drum_no" value="{{ old('drum_no', $product->drum_no) }}"
                                >
                            @if ($errors->has('drum_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('drum_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.drum_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="patch_cord">{{ trans('cruds.product.fields.patch_cord') }}</label>
                            <input class="form-control {{ $errors->has('patch_cord') ? 'is-invalid' : '' }}"
                                type="text" name="patch_cord" id="patch_cord" value="{{ old('patch_cord', $product->patch_cord) }}"
                                >
                            @if ($errors->has('patch_cord'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('patch_cord') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.patch_cord_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="drop_sleeve">{{ trans('cruds.product.fields.drop_sleeve') }}</label>
                            <input class="form-control {{ $errors->has('drop_sleeve') ? 'is-invalid' : '' }}"
                                type="text" name="drop_sleeve" id="drop_sleeve" value="{{ old('drop_sleeve',$product->drop_sleeve) }}"
                                >
                            @if ($errors->has('drop_sleeve'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('drop_sleeve') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.drop_sleeve_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="sleeve_holder">{{ trans('cruds.product.fields.sleeve_holder') }}</label>
                            <input class="form-control {{ $errors->has('sleeve_holder') ? 'is-invalid' : '' }}"
                                type="text" name="sleeve_holder" id="sleeve_holder" value="{{ old('sleeve_holder',$product->sleeve_holder) }}"
                                >
                            @if ($errors->has('sleeve_holder'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sleeve_holder') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.sleeve_holder_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required"
                                for="product_name">{{ trans('cruds.product.fields.product_name') }}</label>
                            <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}"
                                required>
                            @if ($errors->has('product_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('product_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.product_name_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="model_no">{{ trans('cruds.product.fields.model_no') }}</label>
                            <input class="form-control {{ $errors->has('model_no') ? 'is-invalid' : '' }}" type="text"
                                name="model_no" id="model_no" value="{{ old('model_no', $product->model_no) }}" required>
                            @if ($errors->has('model_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('model_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.model_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="price">{{ trans('cruds.product.fields.price') }}</label>
                            <input
                                class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                                name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="0.01"
                                required>
                            @if ($errors->has('price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.price_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="stock_qty">{{ trans('cruds.product.fields.stock_qty') }}</label>
                            <input
                                class="form-control {{ $errors->has('stock_qty') ? 'is-invalid' : '' }}" type="number"
                                name="stock_qty" id="stock_qty" value="{{ old('stock_qty', $product->total_stock_qty) }}" min="0" >
                            @if ($errors->has('stock_qty'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('stock_qty') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.stock_qty_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount">{{ trans('cruds.product.fields.discount') }}</label>
                            <input
                                class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number"
                                name="discount" id="discount" value="{{ old('discount', $product->discount) }}" min="0">
                            @if ($errors->has('discount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('discount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.discount_helper') }}</span>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="" for="length">{{ trans('cruds.product.fields.length') }}</label>
                            <input
                                class="form-control {{ $errors->has('length') ? 'is-invalid' : '' }}" type="number"
                                name="total_length" id="length" value="{{ old('total_length', $product->total_length) }}" min="0">
                            @if ($errors->has('length'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('length') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.length_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""
                                for="description">{{ trans('cruds.product.fields.description') }}</label>
                            <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                                id="description" rows="1">{{ old('description', $product->description) }}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.description_helper') }}</span>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-primary" type="submit">
                            {{ trans('global.update') }}
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
