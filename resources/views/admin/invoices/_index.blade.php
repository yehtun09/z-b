@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            {{ trans('cruds.invoice.title_singular') }} {{ trans('global.listings') }}
            @can('invoice_create')
                <div class="">

                    <a class="btn   btn-success" href="{{ route('admin.invoices.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.invoice.title_singular') }}
                    </a>
                    <a href="{{ route('admin.invoices.list.trash') }}" class="  btn btn-primary">Trash</a>
                    <a href="{{ route('admin.export-site-informations') }}" class="btn btn-warning">Excel</a>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Invoice">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('global.no') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.date') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.site') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.stocks') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.total_qty') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.total') }}
                            </th>
                            <th>
                                {{ trans('cruds.invoice.fields.created_by') }}
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
                                    {{ date('d-m-Y', strtotime($invoice->date)) }}
                                </td>
                                <td>
                                    {{ $invoice->customer_name->name }}
                                </td>
                                <td>
                                    @foreach ($invoice->products as $product)
                                        <span class="badge bg-info rounded-pill">{{ $product->product_name }} -
                                            {{ $product->pivot->qty }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $invoice->total_qty ?? '' }}
                                </td>
                                <td>
                                    {{ $invoice->sub_total }}
                                </td>
                                <td>
                                    {{ $invoice->created_by->name }}
                                </td>
                                <td style="text-align:center">

                                    <div class="d-flex">

                                        @can('customer_assign_create')
                                            <a class="p-0 glow service_assign"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                data-bs-toggle="modal" data-bs-target="#serviceAssignModal"
                                                id="{{ $invoice->id }}"
                                                href="{{ route('admin.invoices.edit', $invoice->id) }}">
                                                <i class="fa-solid fa-clipboard-user"></i>
                                            </a>
                                        @endcan

                                        @can('invoice_show')
                                            <a class="p-0 glow"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                href="{{ route('admin.invoices.show', $invoice->id) }}">
                                                <i class='bx bx-show'></i>
                                            </a>
                                        @endcan

                                        {{-- @can('invoice_edit')
                                            <a class="p-0 glow"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                href="{{ route('admin.invoices.edit', $invoice->id) }}">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                        @endcan --}}

                                        @can('invoice_delete')
                                            <form id="orderDelete-{{ $invoice->id }}"
                                                action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST"
                                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden"
                                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;"
                                                    class=" p-0 glow" value="{{ trans('global.delete') }}">
                                                <button
                                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                                    class=" p-0 glow"
                                                    onclick="event.preventDefault(); document.getElementById('orderDelete-{{ $invoice->id }}').submit();">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="serviceAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('cruds.customerAssign.title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.customer-assigns.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="invoice_id" value="" id="invoice_id">
                        <label for="">{{ trans('cruds.customerAssign.fields.service_person') }}</label>
                        <select name="service_person_id" id="" class="form-control form-select">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <label for="">{{ trans('cruds.customerAssign.fields.service_area') }}</label>
                        <textarea name="service_area" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary modal_close" data-bs-dismiss="modal"
                            id="">{{ trans('global.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('global.save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="card-footer float-end mb-1">

        {{ $invoices->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('.service_assign').click(function() {
                $('#invoice_id').val($(this).attr('id'));
                $('#serviceAssignModal').modal('show')
            })

            $('.modal_close').click(() => {
                $('#serviceAssignModal').modal('hide')
            })
        })
    </script>
    @parent
    <script>
        $(function() {
                    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                    @can('invoice_delete')
                        let deleteButtonTrans =
                            '{{ trans('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    global.datatables.delete ') }}'
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
                                    alert(
                                        '{{ trans('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        global.datatables.zero_selected ') }}'
                                    )

                                    return
                                }

                                if (confirm(
                                        '{{ trans('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        global.areYouSure ') }}'
                                    )) {
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
                        order: [
                            [1, 'desc']
                        ],
                        pageLength: 100,
                    });
                    let table = $('.datatable-Invoice:not(.ajaxTable)').DataTable({
                        buttons: dtButtons
                    })
                    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                        $($.fn.dataTable.tables(true)).DataTable()
                            .columns.adjust();
                    });

                    // $(document).on('click', '.service_assign', function() {
                    //     alert('hi');
                    // });

                }
    </script>
@endsection
