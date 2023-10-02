@extends('layouts.admin')
@section('content')
    <!-- @can('customer_assign_create')
        <div style="margin-bottom: 10px;" class="row">
                                <div class="col-lg-12">
                                    <a class="btn btn-success" href="{{ route('admin.customer-assigns.create') }}">
                                        {{ trans('global.add') }} {{ trans('cruds.customerAssign.title_singular') }}
                                    </a>
                                </div>
                            </div>
    @endcan -->
    <div class="card">
        <div class="custom-header">

            {{ trans('global.cancel') }} {{ trans('global.services') }} {{ trans('global.listings') }}
            <div class="d-flex">
                <!-- Range Picker-->
                <div class="mb-4" style="width:14.5rem;">
                    <input type="text" class="form-control" placeholder="DD/MM/YYYY to DD/MM/YYYY"
                        id="flatpickr-range" />
                </div>
                <!-- /Range Picker-->
                <div>
                    <button class="btn btn-success ms-2" id="filter">Filter</button>
                </div>
                <div>
                    <a class="btn btn-primary text-white ms-2" id="export">
                        {{ trans('global.export') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if (Session::get('err'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('err') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-CustomerAssign">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('global.no') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.customer_name') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customerAssign.fields.township') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customerAssign.fields.address') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customerAssign.fields.service_area') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customerAssign.fields.engineer') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customerAssign.fields.service_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.invoice.fields.finished_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customerAssign.fields.remark') }}
                            </th>
                            <th class="text-nowrap">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach ($invoices as $key => $invoice)
                            <tr data-entry-id="{{ $invoice->id }}">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $invoice->customer_name->name }} ({{ $invoice->customer_name->customer_code }})
                                </td>
                                <td>
                                    {{ $invoice->customerAssign->township ?? '-' }}
                                </td>
                                <td>
                                    {{ $invoice->customerAssign->address ?? '-' }}
                                </td>
                                <td>
                                    {{ $invoice->customerAssign->service_area }}
                                </td>
                                <td>
                                    {{ $invoice->customerAssign->service_person->name }}
                                </td>
                                <td>
                                    {{ $invoice->assign_date ? date('d/m/Y', strtotime($invoice->assign_date)) : '' }}
                                </td>
                                <td>
                                    {{ $invoice->finished_date ? date('d/m/Y', strtotime($invoice->finished_date)) : '' }}
                                </td>
                                <td>
                                    {{ $invoice->remark ?? '' }}
                                </td>
                                <td>
                                    @can('customer_assign_complete')
                                        <a class="p-0 glow complete"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            onclick="return confirm('Are you sure to restore?')" id="{{ $invoice->id }}"
                                            title="restore" href="{{ route('admin.change.action.restore', $invoice->id) }}">
                                            <i class="fa-solid fa-trash-can-arrow-up"></i>
                                        </a>
                                    @endcan
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
        $(() => {
            var flatpickrDate = document.querySelector('#flatpickr-range');

            if (flatpickrDate) {
                flatpickrDate.flatpickr({
                    monthSelectorType: 'static',
                    mode: "range",
                    dateFormat: "d/m/Y",
                });
            }

        })

        function formatDate(date) {
            let dateObj = new Date(date);
            let day = dateObj.getDate();
            let month = dateObj.getMonth();
            let year = dateObj.getFullYear();
            return `${day}/${month}/${year}`;
        }

        $(document).on('click', '#filter', function() {
            let dateRange = $('#flatpickr-range').val();
            let startDate = dateRange ? dateRange.split('to')[0].trim() : '';
            let endDate = dateRange ? dateRange.split('to')[1]?.trim() : '';
            $.ajax({
                type: 'GET',
                url: '/admin/customer-assigns/action/cancel',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                },
                success: function(data) {
                    let html = '';
                    data.invoices.forEach((element, index) => {
                        html += `
                            <tr data-entry-id="${element.id}">
                                <td>
                                    ${index + 1}
                                </td>
                                <td>
                                    ${ element.customer_name.name }
                                </td>
                                <td>
                                    ${ element.customer_assign.township || '-'}
                                </td>
                                <td>
                                    ${ element.customer_assign.address || '-'}
                                </td>
                                <td>
                                    ${ element.customer_assign.service_area || ''}
                                </td>
                                <td>
                                    ${ element.customer_assign.service_person.name || ''}
                                </td>
                                <td>
                                    ${ element.issue_date ?  formatDate(element.issue_date) : ''}
                                </td>
                                <td>
                                    ${ element.finished_date ?  formatDate(element.finished_date) : ''}
                                </td>
                                <td>
                                    ${ element.remark || ''}
                                </td>
                            </tr>
                        `;
                    });
                    $('#tableBody').html(html);
                },
                error: function(data) {
                    console.log('error', data);
                }
            })
        })

        $(document).on('click', '#export', function() {
            let dateRange = $('#flatpickr-range').val();
            let startDate = dateRange ? dateRange.split('to')[0].trim() : '';
            let endDate = dateRange ? dateRange.split('to')[1]?.trim() : '';

            var query = {
                startDate: startDate,
                endDate: endDate,
            }

            var url = "{{ route('admin.export.cancel') }}?" + $.param(query)
            window.location = url;
        })
    </script>
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('customer_assign_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.customer-assigns.massDestroy') }}",
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
            let table = $('.datatable-CustomerAssign:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
