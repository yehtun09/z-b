@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            {{ trans('cruds.invoice.title_singular') }} {{ trans('global.listings') }}
            @can('invoice_create')
                <div class="d-flex">
                    @can('invoice_delete')
                        <div class="me-2">
                            <a href="{{ route('admin.invoices.list.trash') }}" class="  btn btn-primary">Trash</a>
                        </div>
                    @endcan
                    <div class="me-2">
                        <a class="btn   btn-success" href="{{ route('admin.invoices.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.invoice.title_singular') }}
                        </a>
                    </div>
                    <div class="me-2">
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            Import Excel
                        </button>
                    </div>
                    <div class="d-flex flex-column me-2">
                        <a href="{{ route('admin.export-site-informations') }}" class="btn btn-primary">Export Excel</a>
                        <a href="{{asset('file/invoice-example.xlsx')}}" download>Download Sample</a>
                    </div>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="row">


                <div class="table-responsive">
                    <table class=" table table-sm table-bordered table-striped table-hover datatable datatable-Invoice">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('global.no') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.issue_date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.invoice.fields.site') }}
                                </th>
                                {{-- <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.assign_date') }}
                                </th> --}}
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.odb_no') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.odb_lat') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.odb_long') }}
                                </th>
                                {{-- <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.suspend_date') }}
                                </th> --}}
                                {{-- <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.finished_date') }}
                                </th> --}}

                                {{-- <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.received_date') }}
                                </th> --}}

                                {{-- <th>
                                    {{ trans('cruds.invoice.fields.stocks') }}
                                </th> --}}
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.total_qty') }}
                                </th>
                                <th>
                                    {{ trans('cruds.invoice.fields.total') }}
                                </th>
                                <th>
                                    Status
                                </th>
                                {{-- <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.odp1') }} {{ trans('cruds.invoice.fields.images') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.odp2') }} {{ trans('cruds.invoice.fields.images') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.odp3') }} {{ trans('cruds.invoice.fields.images') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.onu') }} {{ trans('cruds.invoice.fields.images') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.invoice.fields.ssr') }} {{ trans('cruds.invoice.fields.images') }}
                                </th> --}}
                                <th>
                                    {{ trans('global.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $key => $invoice)
                                <tr data-entry-id="{{ $invoice->id }}">
                                    <td>
                                        {{ $loop->iteration }}

                                    </td>
                                    <td class="text-nowrap">
                                        {{ $invoice->issue_date ? date('d-m-Y', strtotime($invoice->issue_date)) :'' }}
                                    </td>
                                    <td>
                                        {{ $invoice->customer_name->name ?? '-'}}
                                    </td>
                                    {{-- <td class="text-nowrap">
                                        {{ $invoice->assign_date ? date('d-m-Y', strtotime($invoice->assign_date))  : ''}}
                                    </td> --}}
                                    <td>
                                        {{ $invoice->odb_no ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $invoice->odb_lat ?? '-'}}
                                    </td>
                                    <td>
                                        {{ $invoice->odb_long ?? '-'}}
                                    </td>
                                    {{-- <td class="text-nowrap">
                                         {{ $invoice->suspend_date ? date('d-m-Y', strtotime($invoice->suspend_date)): '' }}
                                    </td> --}}

                                    {{-- <td class="text-nowrap">
                                        {{ $invoice->finished_date ? date('d-m-Y', strtotime($invoice->finished_date)) : ''}}
                                    </td> --}}

                                    {{-- <td class="text-nowrap">
                                        {{ $invoice->received_date ?  date('d-m-Y', strtotime($invoice->received_date)) : '' }}
                                    </td> --}}


                                    {{-- <td>
                                        @foreach ($invoice->products as $product)
                                            <span class="badge bg-info rounded-pill">{{ $product->product_name }} -
                                                {{ $product->pivot->qty }}</span>
                                        @endforeach
                                    </td> --}}
                                    <td>
                                        {{ $invoice->total_qty ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $invoice->total ??'-'}}
                                    </td>
                                    <td>
                                        @if ($invoice->invoice_status == 1)
                                        <span class="badge bg-warning">Pending</span>
                                        @elseif ($invoice->invoice_status == 2)
                                        <span class="badge bg-success">Complete</span>
                                        @elseif ( $invoice->invoice_status == 3 )
                                        <span class="badge bg-warning">Suspend</span>
                                        @elseif ( $invoice->invoice_status == 4 )
                                        <span class="badge bg-danger">Cancel</span>
                                        @else
                                        <span class="badge bg-secondary">Ongoing</span>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @foreach($invoice->media as $key => $media)
                                            @if($media->collection_name == 'odp1')
                                                <a href="{{ $media->getUrl('thumb') }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($invoice->media as $key => $media)
                                            @if($media->collection_name == 'odp2')
                                                <a href="{{ $media->getUrl('thumb') }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($invoice->media as $key => $media)
                                            @if($media->collection_name == 'odp3')
                                                <a href="{{ $media->getUrl('thumb') }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($invoice->media as $key => $media)
                                            @if($media->collection_name == 'onu')
                                                <a href="{{ $media->getUrl('thumb') }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($invoice->media as $key => $media)
                                            @if($media->collection_name == 'ssr')
                                                <a href="{{ $media->getUrl('thumb') }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    </td> --}}

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
                    <label for="" class="required">{{ trans('cruds.customerAssign.fields.service_person') }}</label>
                    <select name="service_person_id" id="" class="form-control form-select">
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    {{-- <label for="">{{ trans('cruds.customerAssign.fields.service_area') }}</label>
                    <textarea name="service_area" id="" cols="30" rows="10" class="form-control"></textarea> --}}
                    <label for="" class="required">{{ trans('cruds.customer.fields.township') }}</label>
                    {{-- <input type="text" class="form-control" name="township" id="township"> --}}
                    <select name="township" id="township" class="form-control township form-select" required>
                        @foreach ($townships as $township)
                            <option value="{{ $township->township }}" id="">
                                {{ $township->township }}</option>
                        @endforeach
                    </select>
                    <label for="" class="required">{{ trans('cruds.customer.fields.address') }}</label>
                    <input type="text" class="form-control" name="address" id="address" required>
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
                        <form class="form-horizontal" method="POST" action="{{ route('admin.invoices.upload') }}" enctype="multipart/form-data">
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
@endsection
@section('scripts')
<script>
    $(function() {
        $('.service_assign').click(function() {
            let invoice_id = $(this).attr('id');
            $('#invoice_id').val(invoice_id);
            $.ajax({
            url: `/admin/invoices/${invoice_id}`,
            }).done(function(data) {
                $('#township option[value="' + data.township.township +'"]').prop('selected', true)
                $('#address').val(data.address)
            });
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


            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                // order: [
                //     [1, 'desc']
                // ],
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
