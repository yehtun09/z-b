@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            {{ trans('cruds.customer.fields.service_type') }} {{ trans('global.list') }}
            @can('service_type_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('admin.service-types.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.customer.fields.service_type') }}
                        </a>
                    </div>
                </div>
            @endcan
        </div>

        <div class="card-body">
            @if (count($service_types) == 0)
                <div class="alert alert-warning" role="alert">
                    {{ trans('global.no_service_types') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Income">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('global.no') }}
                                </th>

                                <th>
                                    {{ trans('cruds.customer.fields.service_type') }}
                                </th>
                                <th>
                                    {{ trans('global.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($service_types as $key => $service_type)
                                <tr data-entry-id="{{ $service_type->id }}">
                                    <td>
                                        {{ $loop->iteration }}

                                    </td>

                                    <td>
                                        {{ $service_type->service_type ?? '' }}
                                    </td>

                                    <td class="text-nowrap">
                                        @can('service_type_show')
                                            <a class="p-0 glow"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                href="{{ route('admin.service-types.show', $service_type->id) }}">
                                                <i class='bx bx-show'></i>
                                            </a>
                                        @endcan

                                        @can('service_type_edit')
                                            <a class="p-0 glow"
                                                style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                href="{{ route('admin.service-types.edit', $service_type->id) }}">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                        @endcan

                                        @can('service_type_delete')
                                            <form id="orderDelete-{{ $service_type->id }}"
                                                action="{{ route('admin.service-types.destroy', $service_type->id) }}"
                                                method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden"
                                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;"
                                                    class=" p-0 glow" value="{{ trans('global.delete') }}">
                                                <button
                                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:grey;background:none;"
                                                    class=" p-0 glow"
                                                    onclick="event.preventDefault(); document.getElementById('orderDelete-{{ $service_type->id }}').submit();">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
{{-- @section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('income_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.incomes.massDestroy') }}",
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
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Income:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection --}}
