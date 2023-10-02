@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            {{ trans('cruds.site.title_singular') }} {{ trans('global.listings') }}
            @can('customer_create')
                <div class="d-flex">
                    @if (auth()->user()->is_admin || auth()->user()->is_administrator)
                        <div class="me-2">
                            <a class="btn btn-success" href="{{ route('admin.customers.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.site.title_singular') }}
                            </a>
                        </div>
                    @endif
                    <div class="me-2">
                        @can('customer_delete')
                            <a href="{{ route('admin.customers.list.trash') }}" class="  btn btn-primary">Trash</a>
                        @endcan
                    </div>
                    @if (auth()->user()->is_admin || auth()->user()->is_administrator )
                        <div class="me-2">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                                Import Excel
                            </button>
                        </div>
                    @endif

                    <div class="d-flex flex-column me-2">
                        <a href="{{ route('admin.export-customer-info') }}" class="btn btn-primary">Export Excel</a>
                        <a href="{{asset('file/stocks_sample_download.xlsx')}}" download>Download Sample</a>
                    </div>
                </div>
            @endcan
        </div>

<!-- csv Model -->
<div class="modal fade" id="csvImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('global.app_csvImport')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class='col-md-12'>
                        <form class="form-horizontal" method="POST" action="{{ route('admin.import-customer-info') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                <label for="csv_file" class="col-md-4 control-label">@lang('global.app_csv_file_to_import')</label>
                                <div class="col-md-6">
                                    <input id="csv_file" type="file" class="form-control-file" name="file" required>
                                    @if($errors->has('csv_file'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('csv_file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="header" checked> @lang('global.app_file_contains_header_row')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('global.app_parse_csv')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-sm table-bordered table-sm table-striped table-hover datatable datatable-Customer">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('global.no') }}
                            </th>
                            <th class="text-nowrap">
                                {{-- {{ trans('cruds.customer.fields.sales_voucher_no') }} --}}
                                Voucher No
                            </th>
                            {{-- <th class="text-nowrap"> --}}
                                {{-- {{ trans('cruds.customer.fields.customer_code') }} --}}
                                {{-- Customer Code
                            </th> --}}
                            <th class="text-nowrap">
                                {{-- {{ trans('cruds.customer.fields.name') }} --}}
                               Customer Name
                            </th>
                            <th class="text-nowrap">
                                {{-- {{ trans('cruds.customer.fields.contact_person') }} --}}
                                Contact
                            </th>
                            <th class="text-nowrap">
                                {{-- {{ trans('cruds.customer.fields.phone_number') }} --}}
                                Ph No.
                            </th>
                            {{-- <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.ticket_no') }}
                            </th> --}}
                            <th class="text-nowrap">
                                {{-- {{ trans('cruds.customer.fields.service_type') }} --}}
                                SRV Type
                            </th>
                            <th class="text-nowrap">
                                {{-- {{ trans('cruds.customer.fields.service_plan') }} --}}
                                SRV Plan
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.register_date') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.bandwidth') }}
                            </th>
                            <th class="text-nowrap">
                                {{-- {{ trans('cruds.customer.fields.site_lat') }} --}}
                                Lat/Long
                            </th>
                            {{-- <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.site_long') }}
                            </th> --}}
                            {{-- <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.township') }}
                            </th>
                            <th class="text-nowrap">
                                {{ trans('cruds.customer.fields.address') }}
                            </th> --}}
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach ($customers as $key => $customer)
                            <tr data-entry-id="{{ $customer->id }}">
                                <td>
                                    {{ $loop->iteration }}

                                </td>
                                <td>
                                    {{ $customer->sales_voucher_no ?? '' }}
                                </td>
                                {{-- <td>
                                    {{ $customer->customer_code ?? '' }}
                                </td> --}}
                                <td>
                                    {{ $customer->name ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->contact_person ?? '' }} [ {{ $customer->ticket_no ?? '' }}]
                                </td>
                                <td>
                                    {{ $customer->phone_number ?? '' }}
                                </td>
                                {{-- <td>

                                </td> --}}
                                <td>
                                    {{ $customer->service_type->service_type ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->service_plan->service_plan ?? '' }}
                                </td>
                                <td>
                                    {{ date('d-m-Y', strtotime($customer->register_date ?? '')) }}
                                </td>
                                <td>
                                    {{ $customer->bandwidth ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->site_lat ?? '' }},{{ $customer->site_long ?? '' }}
                                </td>
                                {{-- <td>

                                </td> --}}
                                {{-- <td>
                                    {{ $customer->township->township ?? '' }}
                                </td>
                                <td>
                                    {{ $customer->address ?? '' }}
                                </td> --}}
                                <td>
                                    <div class="d-flex">
                                        @can('customer_show')
                                            <a class="p-0 glow"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                href="{{ route('admin.customers.show', $customer->id) }}">
                                                <i class='bx bx-show'></i>
                                            </a>
                                        @endcan

                                        @can('customer_edit')
                                            <a class="p-0 glow"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                href="{{ route('admin.customers.edit', $customer->id) }}">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                        @endcan

                                        @can('customer_delete')
                                            {{-- <form id="orderDelete-{{ $customer->id }}"
                                                action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
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
                                                    onclick="event.preventDefault(); document.getElementById('orderDelete-{{ $customer->id }}').submit();">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form> --}}
                                            <a onclick="deleteData({{ $customer->id }})"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                                class=" p-0 glow" data-id="{{ $customer->id }}">
                                                <i class="bx bx-trash"></i>
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

@endsection
@section('scripts')
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
    <script>
        function deleteData(id) {
            Swal.fire({
                title: 'Are you sure want to delete?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                            headers: {
                                'x-csrf-token': "{{ csrf_token() }}"
                            },
                            method: 'POST',
                            url: `/admin/customers/${id}`,
                            data: {
                                _method: 'DELETE'
                            }
                        })
                        .done(function(data) {
                            let html = '';
                            data.customers.forEach((element, index) => {
                                html += `
                        <tr data-entry-id="${element.id} " class="text-nowrap">
                                <td>
                                    ${ element.index + 1 }
                                </td>
                                <td>
                                    ${ element.name || ''}
                                </td>
                                <td>
                                    ${ element.phone_number || ''}
                                </td>
                                <td>
                                    ${ element.service_type || ''}
                                </td>
                                <td>
                                    ${ element.service_plan || ''}
                                </td>
                                <td>
                                    ${ element.customer_code || ''}
                                </td>
                                <td>
                                    ${ element.bandwidth || ''}
                                </td>
                                <td>
                                    ${ element.register_date || ''}
                                </td>
                                <td>
                                    ${ element.sales_voucher_no || ''}
                                </td>
                                <td>
                                    ${ element.contact_person || ''}
                                </td>
                                <td>
                                    ${ element.township || ''}
                                </td>
                                <td>
                                    ${ element.site_lat || ''}
                                </td>
                                <td>
                                    ${ element.site_long || ''}
                                </td>
                                <td>
                                    ${ element.ticket_no || ''}
                                </td>
                                <td>
                                    ${ element.address || ''}
                                </td>
                                <td>
                                    @can('customer_show')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="/admin/customers/${element.id}">
                                            <i class='bx bx-show'></i>
                                        </a>
                                    @endcan

                                    @can('customer_edit')
                                        <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="/admin/customers/${element.id}/edit">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                    @endcan
                                    @can('customer_delete')
                                        <a onclick="deleteData(${element.id})"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                            class=" p-0 glow"
                                                data-id="${element.id}">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    @endcan
                                </td>

                            </tr>`;
                            });
                            $('#table_body').html(html);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        })

                }
            })
        }
    </script>
@endsection
