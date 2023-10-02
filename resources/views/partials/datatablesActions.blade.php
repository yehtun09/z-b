@can($viewGate)
    {{-- <a class="glow rounded btn   btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a> --}}
    <a href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}" class="btn rounded-circle btn-primary p-0 glow"
        style="width: 36px;height: 36px;display: inline-block;line-height: 36px;">
        <i class="bi bi-eye" style="top: 0;"></i>
    </a>
@endcan
@can($editGate)
    {{-- <a class="glow rounded btn   btn-light-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a> --}}
    <a href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}" class="btn rounded-circle btn-light-success p-0 glow"
        style="width: 36px;height: 36px;display: inline-block;line-height: 36px;">
        <i class="bi bi-pen" style="top: 0;"></i>
    </a>
@endcan
@can($deleteGate)
    {{-- <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST"
        onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="glow rounded btn   btn-light-danger" value="{{ trans('global.delete') }}">
    </form> --}}
    <form id="orderDelete-{{ $row->id }}" action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}"
        method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" style="width: 36px;height: 36px;display: inline-block;line-height: 36px;"
            class="btn rounded-circle btn-light-success p-0 glow" value="{{ trans('global.delete') }}">
        <button style="width: 36px;height: 36px;display: inline-block;line-height: 36px;"
            class="btn rounded-circle btn-light-danger p-0 glow"
            onclick="event.preventDefault(); document.getElementById('orderDelete-{{ $row->id }}').submit();">
            <i class="bi bi-trash" style="top: 0;"></i>
        </button>
    </form>
@endcan
