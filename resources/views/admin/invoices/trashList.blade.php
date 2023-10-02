@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            Deleted Invoice List
            <div class="float-right">
                <a class="btn   btn-success" href="{{ route('admin.invoices.index') }}">
                    Invoices
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Invoice">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('global.no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.assign_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.odb_no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.odb_lat') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.odb_long') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.suspend_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.finished_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.issue_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.received_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.site') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.stocks') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.total_qty') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.total') }}
                            </th>

                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $key => $invoice)

                            <tr data-entry-id="{{ $invoice->id }}">
                                <td>
                                    {{ $invoices->firstItem() + $loop->index }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $invoice->assign_date ?  date('d-m-Y', strtotime($invoice->assign_date)) :'' }}
                                </td>
                                <td>
                                    {{ $invoice->odb_no ?? '-' }}
                                </td>
                                <td>
                                    {{ $invoice->odb_lat ?? '-'}}
                                </td>
                                <td>
                                    {{ $invoice->odb_long ?? '-'}}
                                </td>
                                <td class="text-nowrap">
                                     {{ $invoice->suspend_date ? date('d-m-Y', strtotime($invoice->suspend_date)): '' }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $invoice->finished_date ? date('d-m-Y', strtotime($invoice->finished_date)) : ''}}
                                </td>
                                <td class="text-nowrap">
                                    {{ $invoice->issue_date ? date('d-m-Y', strtotime($invoice->issue_date)) :'' }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $invoice->received_date ?  date('d-m-Y', strtotime($invoice->received_date)) : '' }}
                                </td>

                                <td>
                                    {{ $invoice->customer_name->name ?? '-'}}
                                </td>
                                <td>
                                    @foreach ($invoice->products as $product)
                                        <span class="badge bg-info rounded-pill">{{ $product->product_name }} -
                                            {{ $product->pivot->qty }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $invoice->total_qty ?? '-' }}
                                </td>
                                <td>
                                    {{ $invoice->total ??'-'}}
                                </td>
                                <td>
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.invoices.restore.trash', $invoice->id) }}" title="restore" onclick="return confirm('Are you sure ?');">
                                        <i class="fa-solid fa-trash-can-arrow-up"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="float-right mb-1">
        {{ $invoices->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('scripts')
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('invoice_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.invoices.massDestroy') }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                                headers: {
                                    'x-csrf-token': _token
                                },
                                method: 'POST',
                                url: config.url,
                                data: {
                                    ids: ids,
                                    _method: 'DELETE'
                                }
                            })
                            .done(function() {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            // order: [[ 1, 'desc' ]],
            pageLength: 25,
        });
        let table = $('.datatable-Invoice:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })
</script>
@endsection
