@can('invoice_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.invoices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.invoice.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.invoice.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-customerNameInvoices">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.invoice.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoice.fields.invoice_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoice.fields.customer_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoice.fields.product') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoice.fields.customer_assign') }}
                        </th>
                        <th>
                            {{ trans('cruds.invoice.fields.invoice_status') }}
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $key => $invoice)
                        <tr data-entry-id="{{ $invoice->id }}">
                            <td>
                                {{ $invoice->id ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->invoice_code ?? '' }}
                            </td>
                            <td>
                                {{ $invoice->customer_name->name ?? '' }}
                            </td>
                            <td>
                                @foreach ($invoice->products as $key => $item)
                                    <span class="badge bg-info my-1 rounded-pill">{{ $item->product_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $invoice->customer_assign ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Invoice::INVOICE_STATUS_SELECT[$invoice->invoice_status] ?? '' }}
                            </td>
                            <td>
                                @can('invoice_show')
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.invoices.show', $invoice->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('invoice_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.invoices.edit', $invoice->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('invoice_delete')
                                    <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                            value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@endsection
