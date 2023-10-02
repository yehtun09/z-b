@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.invoice.title') }}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#site-info" type="button" role="tab" aria-controls="site-info" aria-selected="true">Site Infos</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#product" type="button" role="tab" aria-controls="product" aria-selected="false">Products</button>
            </li>

          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="site-info" role="tabpanel" aria-labelledby="site-info-tab">
                <h5 class="text-primary">{{ trans('cruds.invoice.title') }}</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.customer_name') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->customer_name->name ?? '-' }} ({{$invoice->customer_name->customer_code ?? '-' }})
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>Lat/Long Location</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->odb_lat ?? '-' }},{{ $invoice->odb_long ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.odb_no') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->odb_no ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>ODB Splitter No / Pair No</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->odb_splitter_no ?? '-' }} / {{ $invoice->odb_splitter_pair_no ?? '-' }}
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.ont_received_power') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->ont_received_power ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.olt_name') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->olt_name ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.assign_team') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->user->name ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.installation_period') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->installation_period ?? ' ' }}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h5 class="text-danger">Material Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.resolution') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->resolution ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.cable_drum_no') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->cable_drum_no ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.start_meter') }} / {{ trans('cruds.invoice.fields.end_meter') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->start_meter ?? '-' }} - {{ $invoice->end_meter ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>Total {{ trans('cruds.invoice.fields.drop_cable_length') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->drop_cable_length ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b> {{ trans('cruds.invoice.fields.drop_sleeve_pcs') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->drop_sleeve_pcs ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.core_jc_sleeve_holder_pcs') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->core_jc_sleeve_holder_pcs ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b> {{ trans('cruds.invoice.fields.patch_cord') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->patch_cord ?? '-'}}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.cable_tiles_pcs') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->cable_tiles_pcs ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.label_tape_rol') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->label_tape_rol ?? '-' }}
                            </div>
                        </div>
                        <div class="row gx-0">
                            <div class="col-md-4">
                                <b>{{ trans('cruds.invoice.fields.onu_sticker') }}</b>
                            </div>
                            <div class="col-md-4">
                                {{ $invoice->onu_sticker ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>


                <table class="table table-bordered table-striped">
                    <tbody>

                        {{-- <tr>
                            <th>
                                {{ trans('cruds.invoice.fields.odb') }}
                            </th>
                            <td>
                                @foreach($invoice->odb as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                        </tr> --}}

                        <tr>
                            <th>
                                {{ trans('cruds.invoice.fields.onu') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.customer_acceptance_form') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.sale_person_remark') }}
                            </th>
                            <th colspan="2">
                                {{ trans('cruds.invoice.fields.installation_remark') }}
                            </th>

                        </tr>
                        <tr>
                            <td>
                                @if($invoice->onu)
                                    <a href="{{ $invoice->onu->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $invoice->onu->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ App\Models\Invoice::CUSTOMER_ACCEPTANCE_FORM_RADIO[$invoice->customer_acceptance_form] ?? '-' }}
                            </td>
                            <td>
                                {{ $invoice->sale_person_remark ?? '-' }}
                            </td>
                            <td colspan="2">
                                {{ $invoice->installation_remark ?? '-' }}
                            </td>

                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.invoice.fields.invoice_status') }}
                            </th>
                            <th colspan="3">
                                {{ trans('cruds.invoice.fields.remark') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.ssr') }}
                            </th>
                        </tr>
                        <tr>
                            <td>
                                {{ App\Models\Invoice::INVOICE_STATUS_SELECT[$invoice->invoice_status ?? '-'] ??'-'}}
                            </td>
                            <td colspan="3">
                                {{ $invoice->remark ?? '-' }}
                            </td>
                            <td>
                                @if($invoice->ssr)
                                    <a href="{{ $invoice->ssr->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $invoice->ssr->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.invoice.fields.issue_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.assign_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.suspend_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.finished_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.received_date') }}
                            </th>

                        </tr>
                        <tr>
                            <td>
                                {{ $invoice->issue_date ? date('d-m-Y',strtotime($invoice->issue_date)) : '-' }}
                            </td>
                            <td>
                                {{ $invoice->assign_date ? date('d-m-Y',strtotime($invoice->assign_date)) : '-' }}
                            </td>


                            <td>
                                {{ $invoice->suspend_date ? date('d-m-Y',strtotime($invoice->suspend_date)) : '-' }}
                            </td>

                            <td>
                                {{ $invoice->finished_date ? date('d-m-Y',strtotime($invoice->finished_date)) : '-' }}
                            </td>


                            <td>
                                {{ $invoice->received_date ? date('d-m-Y',strtotime($invoice->received_date)) : '-' }}
                            </td>
                        </tr>
                        <tr>


                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="product-tab">
                <h5>Products</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr align="center">
                            <th>{{ trans('cruds.invoice.fields.item') }}</th>
                            <th>{{ trans('cruds.invoice.fields.unit_price') }}</th>
                            <th>{{ trans('cruds.invoice.fields.qty') }}</th>
                            <th>{{ trans('cruds.invoice.fields.price') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($invoice->products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td align="right">{{ (int) $product->price }}</td>
                                <td align="right">{{ $product->pivot->qty }}</td>
                                <td align="right">{{ $product->price * $product->pivot->qty }}</td>

                            </tr>
                        @endforeach
                        <tr>

                        </tr>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" align="right">{{ trans('cruds.invoice.fields.total') }}</td>
                            <td align="right">{{ $invoice->total }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
          </div>
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.invoices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
@endsection
<style>
    .card .card-header {
        display: initial !important;
    }
</style>
