@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.auditLog.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-AuditLog">
                    <thead>
                        <tr>
                            <th width="10">
                                {{ trans('global.no') }}
                            </th>
                            <th>
                                {{ trans('cruds.auditLog.fields.subject_type') }}
                            </th>
                            <th>
                                {{ trans('cruds.auditLog.fields.description') }}
                            </th>
                            <th>
                                {{ trans('cruds.auditLog.fields.created_at') }}
                            </th>
                            <th>
                               {{ trans('global.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 1;
                        @endphp
                        @foreach ($auditLogs as $key => $auditLog)
                            @php
                                $modelType = explode('#', $auditLog['subject_type'])[0];
                                $id = explode('#', $auditLog['subject_type'])[1];
                                $model = $modelType::find($id);
                                $modelName = explode(substr($modelType, 0, 11), $modelType)[1];
                                if ($modelName == 'CustomerAssign') {
                                    $modelName = 'Customer-Assign';
                                }
                                else if ($modelName == 'ServicePlan')
                                {
                                    $modelName = 'service_plan';
                                }
                            @endphp
                            <tr data-entry-id="{{ $auditLog->id }}">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.'.strtolower($modelName).'s.show', $id) }}" class="">
                                        {{ config('zandb.rename_models.'.$modelName) ?? '' }}
                                    </a>
                                </td>
                                <td>
                                    {{ Str::title(explode(':', $auditLog->description)[1]) ?? '' }} by
                                    <a href="{{ route('admin.users.show', $auditLog->user_id) }}" class="">
                                        {{ \App\Models\User::find($auditLog->user_id)->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $auditLog->created_at ?? '' }}
                                </td>
                                <td>
                                    @can('audit_log_show')
                                        {{-- <a class="p-0 glow"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                            href="{{ route('admin.audit-logs.show', $auditLog->id) }}">
                                            <i class='bx bx-show'></i>
                                        </a> --}}
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                // order: [
                //     [1, 'desc']
                // ],
                pageLength: 25,
            });
            let table = $('.datatable-AuditLog:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
