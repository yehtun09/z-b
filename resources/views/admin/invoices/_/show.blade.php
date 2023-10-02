@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-9 col-12 mb-lg-0 mb-4">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div class="row p-sm-3 p-0">
                        <div class="col-md-6 mb-md-0 mb-4">
                            <div class="d-flex svg-illustration mb-3 gap-2">
                                <span class="app-brand-text h3 mb-0 fw-bold">Z&B</span>
                            </div>

                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <dl class="row mb-2">
                                <dt class="col-sm-6 mb-2 mb-sm-0 pt-2 text-md-end">
                                    <span
                                        class="h5 text-capitalize mb-0 text-nowrap">{{ trans('cruds.invoice.fields.date') }}</span>
                                </dt>
                                <dd class="col-sm-6 d-flex mt-2">
                                    <h5>{{ date('d-m-Y',strtotime($invoice->issue_date)) ?? '' }}</h5>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <hr class="my-4 mx-n4" />

                    <table class="table">
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
        </div>
        <div class="col-3 invoice-actions">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="my-3">
                        {{-- href="{{ route('admin.invoice.pdf.download', ['id' => $invoice->id, 'invoice_month' => $invoice_month, 'invoice_year' => $invoice_year]) }}" --}}
                        <a class="btn mb-2 btn-primary text-white  w-100"
                            href="{{ route('admin.invoice.pdf.download', $invoice->id) }}">PDF</a>
                        {{-- <a href="{{ route('admin.invoice.pdf.download', ['id' => $invoice->id, 'invoice_month' => $invoice_month, 'invoice_year' => $invoice_year]) }}"  class="btn mb-2 btn-label-primary w-100" id="print">Print</a> --}}
                        <a onclick="history.back()" class="btn btn-secondary d-block w-100 me-3 text-white">Cancel</a>
                    </div>
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
