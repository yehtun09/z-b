@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            Deleted Product List
            <div class="float-right">
                <a class="btn   btn-success" href="{{ route('admin.products.index') }}">
                    Products
                </a>

            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('global.no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.onu_type') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.onu_model_no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.ont_serial_no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.onu') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.product_name') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.model_no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.price') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.product.fields.stock_qty') }}
                            </th>
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr data-entry-id="{{ $product->id }}">
                                <td>
                                    {{ $products->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    {{ $product->onu_type ?? '' }}
                                </td>
                                <td>
                                    {{ $product->onu_model_no ?? '' }}
                                </td>
                                <td>
                                    {{ $product->ont_serial_no ?? '' }}
                                </td>
                                <td>
                                    {{ $product->onu ?? '' }}
                                </td>

                                <td>
                                    {{ $product->product_name ?? '' }}
                                </td>
                                <td>
                                    {{ $product->model_no != null ? $product->model_no : '-' }}
                                </td>
                                <td class="text-end">
                                    {{ (int)$product->price ?? '' }}
                                </td>
                                <td class="text-end text-nowrap">
                                    {{ $product->total_stock_qty ?? '' }} <i data-bs-toggle="modal"
                                        data-bs-target="#stockModal" data-product="{{ $product->product_name }}"
                                        data-id="{{ $product->id }}" id="stockbtn"
                                        class="fa-solid fa-circle-plus text-success fs-6 ms-2"></i>
                                </td>

                                <td>
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.products.restore.trash', $product->id) }}" title="restore" onclick=" return confirm('Are you sure?');">
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
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('product_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.products.massDestroy') }}",
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
            let table = $('.datatable-Product:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
