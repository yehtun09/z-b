@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            Deleted Site List
            <div class="float-right">
                <a class="btn   btn-success" href="{{ route('admin.customers.index') }}">
                    Sites
                </a>

            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Customer">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('global.no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.name') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.phone_number') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.service_type') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.service_plan') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.customer_code') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.bandwidth') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.register_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.sales_voucher_no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.contact_person') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.township') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.site_lat') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.site_long') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.ticket_no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.address') }}
                            </th>
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $customer)
                            <tr data-entry-id="{{ $customer->id }}">
                                <td>
                                    {{ $customers->firstItem() + $loop->index }}

                                </td>
                                <td>
                                    {{ $customer->name ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->phone_number ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->service_type->service_type ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->service_plan->service_plan ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->customer_code ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->bandwidth ?? '' }}
                                </td>
                                <td>
                                    {{ date('d-m-Y',strtotime($customer->register_date ?? '')) }}
                                </td>
                                <td>
                                    {{ $customer->sales_voucher_no ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->contact_person ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->township->township ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->site_lat ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->site_long ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->ticket_no ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->address ?? '' }}
                                </td>
                                <td>
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.customers.restore.trash', $customer->id) }}" title="restore" onclick=" return confirm('Are you sure?');">
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
            @can('customer_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.customers.massDestroy') }}",
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
            let table = $('.datatable-Customer:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
