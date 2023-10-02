@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="custom-header">
                    <h5>{{ trans('cruds.product.fields.inventory') }} {{ trans('cruds.product.fields.for') }}
                        {{ $product_name }}</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr align="center">
                                <th>{{ trans('global.no') }}</th>
                                <th>{{ trans('cruds.product.fields.date') }}</th>
                                <th>{{ trans('cruds.product.fields.status') }}</th>
                                <th>{{ trans('cruds.product.fields.site') }}</th>
                                <th>{{ trans('cruds.product.fields.qty') }}</th>
                                <th>{{ trans('cruds.product.fields.length') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>{{ $product['date'] ?? '' }} </td>
                                    <td><span
                                            class="{{ $product['status'] == 'in' ? 'text-success' : 'text-danger' }}">{{ $product['status'] }}
                                            ({{ $product['status'] == 'in' ? '+' : '-' }})</span></td>
                                    <td>
                                        @if (count($product['site']) > 0)
                                            {{ $product['site']['customer'] }} ( {{ $product['site']['engineer'] }} )
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td align="right"><span
                                            class="
                                    @if ($product['status'] == 'out') text-danger
                                    @else
                                    text-success @endif
                                    ">{{ $product['qty'] ?? '0' }}</span>
                                    </td>
                                    <td align="right"><span
                                            class="
                                    @if ($product['status'] == 'out') text-danger
                                    @else
                                    text-success @endif
                                    ">{{ $product['length'] ?? '0' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        <tfoot>
                            <tr class="text-primary">
                                <td colspan="4" align="center">{{ trans('cruds.product.fields.total') }}
                                </td>
                                <td class="fw-bold" align="right">{{ $total_stock_qty ?? '0' }}</td>
                                <td class="fw-bold" align="right">{{ $total_length ?? '0' }}</td>
                            </tr>
                            {{-- <tr class="text-primary">
                                <td colspan="4" align="center">{{ trans('cruds.product.fields.total_length') }}
                                </td>
                                <td colspan="2" class="fw-bold" align="right">{{ $total_length ?? '0' }}</td>
                            </tr> --}}
                        </tfoot>
                        </tbody>
                    </table>
                    <div class="form-group mt-2">
                        <a class="btn btn-primary" href="{{ route('admin.products.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#search').on('input', function() {
            var data = $(this).val();
            if (data == null || data == '') {
                $('#search_btn').click();
            }
        })

        $('#stockbtn').on('click', function() {
            let product_name = $(this).data('product');
            let product_id = $(this).data('id');
            $('#product_name').val(product_name);
            $('#product_id').val(product_id);
        })
    </script>
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('product_delete')
                let deleteButtonTrans =
                    '{{ trans('global.datatables.delete ') }}'
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
                            alert(
                                '{{ trans('global.datatables.zero_selected') }}'
                            )

                            return
                        }

                        if (confirm(
                                '{{ trans(' global.areYouSure ') }}'
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
                    [2, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Product:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                "bPaginate": false,
                "bInfo": false
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
