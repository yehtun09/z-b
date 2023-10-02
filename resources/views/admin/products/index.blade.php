@extends('layouts.admin')
@section('content')
    @if (Session('success'))
        <div class="alert alert-success mb-2" role="alert">
            {{ Session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="custom-header">
            {{ trans('cruds.product.title_singular') }} {{ trans('global.listings') }}
            @can('product_create')
                <div class="">
                    @can('product_delete')
                        <a href="{{ route('admin.products.list.trash') }}" class="  btn btn-primary">Trash</a>
                    @endcan
                    <a class="  btn btn-success" href="{{ route('admin.products.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
                    </a>
                    <a class="btn   btn-warning text-white" data-bs-toggle="modal" data-bs-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </a>
                    <a href="{{ route('admin.products.export') }}" class="btn btn-primary text-white">
                        {{ trans('global.export') }}
                    </a>
                    </form>
                    <a href="{{ asset('file/product-example.xlsx') }}" download
                        style="display: block; text-align:end; margin-right:0.5rem; color:black;">
                        <small class="text-primary">{{ trans('global.download_sample') }}</small>
                    </a>
                    @include('csvImport.modal', [
                        'route' => 'admin.products.import',
                    ])

                </div>
            @endcan



        </div>

        {{-- For Search box --}}
        {{-- <form action="{{ route('admin.products.search') }}" method="get">
            <div class="row">
                <div class="col-md-3 offset-9 pe-4">
                    <div class="input-group">

                        <input type="text" class="form-control" id="search" value="{{ request('search_data') }}"
                            placeholder="Search..." aria-label="Recipient's username" aria-describedby="basic-addon2"
                            name="search_data">
                        @csrf
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" id="search_btn" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form> --}}

        <div class="card-body">
            @if (count($products) == 0)
                <div class="alert alert-warning" role="alert">
                    {{ trans('global.no_products') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-sm table-hover datatable datatable-Product">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('global.no') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.onu_type') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.onu_model_no') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.ont_serial_no') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.onu') }}
                                </th>
                                <th class="text-nowrap">
                                 {{ trans('cruds.product.fields.drum_no') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.product_name') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.model_no') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.price') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.stock_qty') }}
                                </th>
                                <th class="text-nowrap">
                                    {{ trans('cruds.product.fields.length') }}
                                </th>
                                <th>
                                    {{ trans('global.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr data-entry-id="{{ $product->id }}">
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ App\Models\Product::ONU_LISTS[$product->onu_type ?? ''] }}
                                    </td>
                                    <td>
                                        {{ $product->onu_model_no ?? '' }}
                                    </td>
                                    <td>
                                        {{ $product->ont_serial_no ?? '' }}
                                    </td>
                                    <td>
                                        {{ $product->onu ?? '' }}
                                    </td>
                                    <td>
                                        {{ $product->drum_no ?? '' }}
                                    </td>

                                    <td>
                                        {{ $product->product_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $product->model_no != null ? $product->model_no : '-' }}
                                    </td>
                                    <td class="text-end">
                                        {{ (int) $product->price ?? '' }}
                                    </td>
                                    <td class="text-end text-nowrap">
                                        {{ $product->total_stock_qty ?? '' }} <i data-bs-toggle="modal"
                                            data-bs-target="#stockModal" data-product="{{ $product->product_name }}"
                                            data-id="{{ $product->id }}"
                                            class="fa-solid fa-circle-plus text-success fs-6 ms-2 stockbtn"></i>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        {{ (int)$product->total_length ?? '' }} <i data-bs-toggle="modal"
                                            data-bs-target="#lengthModal" data-product="{{ $product->product_name }}"
                                            data-id="{{ $product->id }}"
                                            class="fa-solid fa-circle-plus text-success fs-6 ms-2 lengthbtn"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @can('inventory_access')
                                                <a class="p-0 glow me-2"
                                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                    href="{{ route('admin.products.inventory', $product->id) }}">
                                                    <i class="fa-solid fa-warehouse"></i>
                                                </a>
                                            @endcan

                                            @can('product_show')
                                                <a class="p-0 glow"
                                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                    href="{{ route('admin.products.show', $product->id) }}">
                                                    <i class='bx bx-show'></i>
                                                </a>
                                            @endcan

                                            @can('product_edit')
                                                <a class="p-0 glow"
                                                    style="width: 26px;height: 36px;display: inline-block;line-height: 36px;color:grey;"
                                                    href="{{ route('admin.products.edit', $product->id) }}">
                                                    <i class='bx bx-edit'></i>
                                                </a>
                                            @endcan

                                            @can('product_delete')
                                                <form id="orderDelete-{{ $product->id }}"
                                                    action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
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
                                                        onclick="event.preventDefault(); return confirm('Are you sure?'); return confirm('Are you sure?') document.getElementById('orderDelete-{{ $product->id }}').submit();" >
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
            @endif
        </div>
    </div>



    <!-- stock Modal -->
    <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <form action="{{ route('admin.products.add.stock') }}" method="post">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="stockModalLabel">Add Stock Qty</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required"
                                        for="product_name">{{ trans('cruds.product.fields.product_name') }}</label>
                                    <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                        type="text" name="product_name" id="stock_product_name"
                                        value="{{ old('product_name', '') }}" disabled>
                                    <input type="hidden" name="product_id" value="" id="stock_product_id">
                                    @if ($errors->has('product_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('product_name') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.product.fields.product_name_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required"
                                        for="stock_qty">{{ trans('cruds.product.fields.stock_qty') }}</label>
                                    <input class="form-control  {{ $errors->has('stock_qty') ? 'is-invalid' : '' }}"
                                        type="text" name="stock_qty" id="stock_qty"
                                        value="{{ old('stock_qty', '') }}" min="0" required>
                                    @if ($errors->has('stock_qty'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('stock_qty') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.stock_qty_helper') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- length Modal -->
    <div class="modal fade" id="lengthModal" tabindex="-1" aria-labelledby="lengthModalLabel" aria-hidden="true">
        <form action="{{ route('admin.products.add.stock') }}" method="post">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="lengthModalLabel">Add Stock Qty</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required"
                                        for="product_name">{{ trans('cruds.product.fields.product_name') }}</label>
                                    <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                        type="text" name="product_name" id="length_product_name"
                                        value="{{ old('product_name', '') }}" disabled>
                                    <input type="hidden" name="product_id" value="" id="length_product_id">
                                    @if ($errors->has('product_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('product_name') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.product.fields.product_name_helper') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required"
                                        for="length">{{ trans('cruds.product.fields.length') }}</label>
                                    <input
                                        class="form-control  {{ $errors->has('length') ? 'is-invalid' : '' }}"
                                        type="text" name="length" id="length"
                                        value="{{ old('length', '') }}" min="0" required>
                                    @if ($errors->has('length'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('length') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.product.fields.length_helper') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('scripts')
    <script>
        $('#search').on('input', function() {
            var data = $(this).val();
            if (data == null || data == '') {
                $('#search_btn').click();
            }
        })

        $('.stockbtn').on('click', function() {
            let product_name = $(this).data('product');
            let product_id = $(this).data('id');
            $('#stock_product_name').val(product_name);
            $('#stock_product_id').val(product_id);
        })

        $('.lengthbtn').on('click', function() {
            let product_name = $(this).data('product');
            let product_id = $(this).data('id');
            $('#length_product_name').val(product_name);
            $('#length_product_id').val(product_id);
        })
    </script>
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('product_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.products.massDestroy') }}",
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
            let table = $('.datatable-Product:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
        function exportData()
        {
            let data = $(this).val();
            console.log({data})
        }
    </script>
@endsection
