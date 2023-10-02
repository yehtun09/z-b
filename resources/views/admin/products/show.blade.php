@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.product.title') }}

        </div>

        <div class="card-body">
            <table class="table table-bordered">
                {{-- <tr>
                    <td>{{ trans('cruds.product.fields.id') }}</td>
                    <td>{{ $product->id }}</td>
                </tr> --}}
                <tr>
                    <th>{{ trans('cruds.product.fields.onu_type') }}</th>
                    <td>{{App\Models\Product::ONU_LISTS[$product->onu_type ?? ''] }}</td>

                    <th>{{ trans('cruds.product.fields.onu_model_no') }}</th>
                    <td>{{ $product->onu_model_no ?? '' }}</td>

                    <th>{{ trans('cruds.product.fields.ont_serial_no') }}</th>
                    <td>{{ $product->ont_serial_no ?? '' }}</td>

                    <th>{{ trans('cruds.product.fields.onu') }}</th>
                    <td>{{ $product->onu ?? '' }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.product.fields.drum_no') }}</th>
                    <td>{{ $product->drum_no ?? '' }}</td>

                    <th>{{ trans('cruds.product.fields.patch_cord') }}</th>
                    <td>{{ $product->patch_cord ?? '' }}</td>

                    <th>{{ trans('cruds.product.fields.drop_sleeve') }}</th>
                    <td>{{ $product->drop_sleeve ?? '' }}</td>

                    <th>{{ trans('cruds.product.fields.sleeve_holder') }}</th>
                    <td>{{ $product->sleeve_holder ?? '' }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.product.fields.product_name') }}</th>
                    <td>{{ $product->product_name }}</td>

                    <th>{{ trans('cruds.product.fields.price') }}</th>
                    <td>{{ (int)$product->price }}</td>

                    <th>{{ trans('cruds.product.fields.stock_qty') }}</th>
                    <td>{{ $product->total_stock_qty }}</td>

                    <th>{{ trans('cruds.product.fields.discount') }}</td>
                    <td>{{ $product->discount }}</td>
                </tr>
            </table>
            <div class="form-group mt-2">
                <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs ml-1" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#product_invoices" role="tab" data-toggle="tab">
                    {{ trans('cruds.invoice.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" style="margin-left: 7px" role="tabpanel" id="product_invoices">
                @includeIf('admin.products.relationships.productInvoices', [
                    'invoices' => $product->productInvoices,
                ])
            </div>
        </div>
    </div>
@endsection
