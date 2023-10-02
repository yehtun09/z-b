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

            {{ trans('global.suspend') }} {{ trans('global.services') }} {{ trans('global.listings') }}
            <div class="d-flex">
                <!-- Range Picker-->
                <div class="mb-4" style="width:14.5rem;">
                    <input type="text" class="form-control" placeholder="DD/MM/YYYY to DD/MM/YYYY" id="flatpickr-range" />
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
            @if(Session::get('err'))
                <div class="alert alert-danger" role="alert">
                {{Session::get('err')}}
              </div>
            @endif
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-CustomerAssign">
                    <thead>
                        <tr>
                            <th class="text-nowrap">
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
                                {{ trans('cruds.invoice.fields.suspend_date') }}
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
                                    {{ $invoice->suspend_date ? date('d/m/Y', strtotime($invoice->suspend_date)) : '' }}
                                </td>
                                <td>
                                    {{ $invoice->remark ?? ''}}
                                </td>
                                <td>
                                    <div class="d-flex">

                                        @can('customer_assign_complete')
                                            <a class="p-0 glow complete"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                onclick="return confirm('Are you sure to restore?')" id="{{ $invoice->id }}"
                                                title="restore" href="{{ route('admin.change.action.restore', $invoice->id) }}">
                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                            </a>
                                        @endcan
                                        @can('customer_assign_complete')
                                            <a class="p-0 glow complete"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                data-bs-toggle="modal" data-bs-target="#completeModal" id="{{ $invoice->id }}"
                                                title="complete">
                                                <i class="fa-regular fa-circle-check"></i>
                                            </a>
                                        @endcan
                                        @can('customer_assign_cancel')
                                            <a class="p-0 glow cancel"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                data-bs-toggle="modal" data-bs-target="#cancelModal" id="{{ $invoice->id }}"
                                                title="cancel">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
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
    <div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content align-center">
                <div class="modal-header d-flex justify-content-center">
                    <i class='bx bx-error-alt' style="font-size:50px;color:red"></i>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.change.action') }}" method="get">
                        @csrf
                        <div class="">
                            <input type="hidden" name="invoice_id" value="" id="invoice_id">
                            <input type="hidden" name="action_id" value="2">
                            <h4 class="text-center">Are you sure?</h4>
                            <label for="remark" class="col-form-label">Remark</label>
                            <input type="text" class="form-control" name="remark" id="remark-complete" placeholder="Remark" value="">
                        </div>
                        <div class="modal-footer d-flex justify-content-center mt-3">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Confirm</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalLabel">{{ trans('global.cancel') }}</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <form action="{{ route('admin.change.action') }}" method="get">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="invoice_id" value="" id="invoiceid">
                        <input type="hidden" name="action_id" value="4">
                        <h4 style="text-align: center">Are you sure to cancel?</h4>
                        <label for="remark" class="col-form-label">Remark</label>
                        <input type="text" class="form-control" name="remark" id="remark-cancel" placeholder="Remark" value="">
                        {{-- <label for="">cancel Date</label> --}}
                        <!-- date -->
                        {{-- <input type="date" name="date" id="date" value="<?= date('Y-m-d') ?>"
                            min="<?php echo date('Y-m-d'); ?>"> --}}
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            $('.cancel').click(function() {
                $('#invoiceid').val($(this).attr('id'));
            });
        });

        $(function() {
            $('.complete').click(function() {
                $('#invoice_id').val($(this).attr('id'));
            });
        });

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

        function formatDate(date){
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
                url: '/admin/customer-assigns/action/suspend',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                },
                success: function(data) {
                    let html = '';
                    data.invoices.forEach((element,index) => {
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
                                    ${ element.suspend_date ?  formatDate(element.suspend_date) : ''}
                                </td>
                                <td>
                                    ${ element.remark || ''}
                                </td>
                                <td>
                                    <div class="d-flex">

                                        @can('customer_assign_complete')
                                            <a class="p-0 glow complete"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                data-bs-toggle="modal" data-bs-target="#completeModal" id="${element.id}"
                                                title="complete">
                                                <i class="fa-regular fa-circle-check"></i>
                                            </a>
                                        @endcan
                                        @can('customer_assign_cancel')
                                            <a class="p-0 glow cancel"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                data-bs-toggle="modal" data-bs-target="#cancelModal" id="${element.id}"
                                                title="cancel">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        @endcan
                                    </div>
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

            var url = "{{ route('admin.export.suspend') }}?" + $.param(query)
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
