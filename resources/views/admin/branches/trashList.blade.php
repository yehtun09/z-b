@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="custom-header">
            Deleted Branch List
            <div class="float-right">
                <a class="btn   btn-success" href="{{ route('admin.branches.index') }}">
                    Branches
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Branch">
                    <thead>
                        <tr>
                            <th width="10">
                                {{ trans('global.no') }}
                            </th>
                            <th>
                                {{ trans('cruds.branch.fields.branch') }}
                            </th>
                            <th>
                                {{ trans('cruds.branch.fields.phone') }}
                            </th>
                            <th>
                                Actions
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
                                    <a class="p-0 glow"
                                        style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                        href="{{ route('admin.branches.restore.trash', $branch->id) }}" title="restore">
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
            @can('branch_delete')
                let deleteButtonTrans =
                    '{{ trans('
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
            let table = $('.datatable-Branch:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
