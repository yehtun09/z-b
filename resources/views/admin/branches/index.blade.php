@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            <h5>{{ trans('cruds.branch.title_singular') }} {{ trans('global.listings') }}</h5>
            @can('branch_create')
                <div class="">
                    <a class="  btn btn-success" href="{{ route('admin.branches.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.branch.title_singular') }}
                    </a>
                    <a href="{{ route('admin.branches.list.trash') }}" class="  btn btn-primary">Trash</a>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Branch">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('global.no') }}
                            </th>
                            <th>
                                {{ trans('cruds.branch.fields.branch') }}
                            </th>
                            <th>
                                {{ trans('cruds.branch.fields.phone') }}
                            </th>
                            <th>
                                {{ trans('global.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $key => $branch)
                            <tr data-entry-id="{{ $branch->id }}">
                                <td>
                                    {{ $branches->firstItem() + $loop->index }}


                                </td>
                                <td>
                                    {{ $branch->branch ?? '' }}
                                </td>
                                <td>
                                    {{ $branch->phone ?? '' }}
                                </td>
                                <td>

                                    @can('branch_show')
                                        <a class=" btn btn-primary p-0 glow"
                                            style="width: 70px;height: 36px;display: inline-block;line-height: 36px;"
                                            href="{{ route('admin.branches.show', $branch->id) }}"
                                            title="{{ trans('global.view_file') }}">
                                            {{ trans('global.show') }}
                                        </a>
                                    @endcan

                                    @can('branch_edit')
                                        <a class="ms-1 btn btn-success p-0 glow"
                                            style="width: 70px;height: 36px;display: inline-block;line-height: 36px;"
                                            href="{{ route('admin.branches.edit', $branch->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('branch_delete')
                                        <form action="{{ route('admin.branches.destroy', $branch->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button style="width: 70px;height: 36px;display: inline-block;line-height: 36px;"
                                                class="btn ms-1  btn-danger p-0 glow">
                                                {{ trans('global.delete') }}
                                            </button>
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer float-end mb-1">

        {{ $branches->links('pagination::bootstrap-4') }}
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('branch_delete')
                let deleteButtonTrans = '{{ trans('
                        global.datatables.delete ') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.branches.massDestroy') }}",
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
                                                        global.datatables.zero_selected ') }}')

                            return
                        }

                        if (confirm('{{ trans('
                                                global.areYouSure ') }}')) {
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
            let table = $('.datatable-Branch:not(.ajaxTable)').DataTable({
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
