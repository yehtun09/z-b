@extends('layouts.admin')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-edit">
            <!-- Invoice Edit-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row p-sm-3 p-0">
                            <div class="col-md-6 mb-md-0 mb-4">
                                <div class="d-flex svg-illustration mb-4 gap-2">


                                </div>

                            </div>
                            <div class="col-md-6">
                                <dl class="row mb-2">
                                    <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                        <span class="h4 text-capitalize mb-0 text-nowrap">Date #</span>
                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end">
                                        <div class="w-px-150">
                                            <input type="text" class="form-control" value="{{ $invoice->date }}"
                                                name="date" id="date" value="{{ old('date', '') }}" disabled />
                                            <input type="hidden" id="invoice_id" value="{{ $invoice->id }}">
                                        </div>
                                    </dd>
                                    <dt class="col-sm-6 mb-2 mb-sm-0 mt-2 text-md-end">
                                        <span class="fw-normal">Site:</span>
                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end">
                                        <div class="w-px-150">
                                            <select
                                                class="form-select {{ $errors->has('customer_name') ? 'is-invalid' : '' }}"
                                                name="customer_name_id" id="customer_name_id" required>
                                                @foreach ($customer_names as $id => $entry)
                                                    <option value="{{ $id }}"
                                                        @if ($id == $invoice->customer_name_id) selected @endif>
                                                        {{ $entry }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <hr class="my-4 mx-n4" />

                        <form class="source-item py-sm-3">
                            <div class="mb-3" data-repeater-list="group-a">
                                <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item id="container">
                                    @foreach ($invoice->products as $product)
                                        <div class="d-flex border rounded position-relative pe-0 mb-5"
                                            id="product{{ $product->id }}">
                                            <div class="row w-100 m-0 p-3">
                                                <div class="col-md-6 col-12 mb-md-0 mb-3 ps-md-0">
                                                    <p class="mb-2 repeater-title">Product</p>
                                                    <select
                                                        class="form-select product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                                        name="product_name_id0"
                                                        data-product-id="{{ $product->pivot->product_id }}"
                                                        id="product_name{{ $product->id }}" required disabled>
                                                        @foreach ($product_names as $id => $entry)
                                                            <option value="{{ $id }}"
                                                                {{ old('product_name_id') == $id ? 'selected' : '' }}
                                                                @if ($id == $product->pivot->product_id) selected @endif>
                                                                {{ $entry }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                    <p class="mb-2 repeater-title">Sales Price</p>
                                                    <input type="text" style="text-align:right" name=""
                                                        class="form-control unit_price" id="unit_price{{ $product->id }}"
                                                        value="{{ (int) $product->sales_price }}"
                                                        data-unit-price="{{ $product->sales_price }}" disabled>
                                                </div>
                                                <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                    <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.qty') }}
                                                    </p>
                                                    <input type="number" style="text-align:right" name=""
                                                        class="form-control qty" id="qty{{ $product->id }}"
                                                        value="{{ $product->pivot->qty }}"
                                                        data-qty="{{ $product->pivot->qty }}" min="1" disabled>
                                                    <input type="hidden" id="max{{ $product->id }}"
                                                        value="{{ $product->stock_qty }}">
                                                </div>
                                                <div class="col-md-2 col-12 pe-0">
                                                    <p class="mb-2 repeater-title">
                                                        {{ trans('cruds.invoice.fields.unit_total') }}</p>
                                                    <input type="text" style="text-align:right" name=""
                                                        class="form-control total" id="total{{ $product->id }}"
                                                        value="{{ $product->pivot->total }}"
                                                        data-total="{{ $product->pivot->total }}" disabled>
                                                </div>
                                                <div class="col-md-12 pt-2 d-flex justify-content-end pe-0">
                                                    <div class="">
                                                        <button class="btn   btn-success edit" style="width: 80px"
                                                            id="{{ $product->id }}">{{ trans('global.edit') }}</button>
                                                        <button class="btn    btn-primary save ms-1" style="width: 80px"
                                                            id="{{ $product->id }}"> {{ trans('global.save') }} </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                                <i class="bx bx-x fs-4 text-muted cursor-pointer deleteProduct"
                                                    id="{{ $product->id }}"></i>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary" id="add_product">Add Product</button>
                                </div>
                            </div>
                        </form>

                        <hr class="my-4 mx-n4" />

                        <div class="row py-sm-3">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="row mb-1">
                                    <div class="col-md-4">

                                    </div>
                                    <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <div class="col-md-6">
                                            <input type="hidden" name="url" value="{{ request('route') }}">
                                            <input type="hidden" name="total" value="{{ $invoice->total }}"
                                                id="hidden_total">
                                            <input type="hidden" name="sub_total" value="{{ $invoice->sub_total }}"
                                                id="hidden_sub_total">
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="invoice-calculations">

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="w-px-100">{{ trans('cruds.invoice.fields.total') }}:</span>
                                        <span class="fw-semibold" id="sub_total">{{ $invoice->sub_total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Invoice Edit-->

            <!-- Invoice Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="my-3">
                            {{-- <button type="submit" class="btn btn-primary mb-1 w-100" id="update" disabled>{{ trans('global.update') }} {{ trans('cruds.invoice.title') }}</button> --}}
                            <a href="{{ route('admin.invoices.index') }}"
                                class="btn btn-label-secondary d-block w-100 me-3">Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var btnCount = 0;
        $('#add_product').on('click', function() {
            $('#container').append(`<div class="d-flex border rounded position-relative pe-0 mb-5" id="row${btnCount}">
                                        <div class="row w-100 m-0 p-3">
                                            <div class="col-md-6 col-12 mb-md-0 mb-3 ps-md-0">
                                                <p class="mb-2 repeater-title">Product</p>
                                                <select class="form-control select2 add_product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}" name="add_product_name${btnCount}" id="add_product_name${btnCount}" required>
                                                @foreach ($product_names as $id => $entry)

                                                    <option value="{{ $id }}" {{ old('product_name${btnCount}') == $id ? 'selected' : '' }}>
                                                    {{ $entry }}
                                                    </option>

                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                <p class="mb-2 repeater-title">Sales Price</p>
                                                <input type="text" style="text-align:right" name="" class="form-control unit_price" id="add_unit_price${btnCount}" value="0" disabled>
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.qty') }}</p>
                                                <input type="number" style="text-align:right" name="add_qty${btnCount}" class="form-control add_qty" id="add_qty${btnCount}" value="0" min="1">
                                                <input type="hidden" id="add_max${btnCount}" value="0">
                                                </div>
                                            <div class="col-md-2 col-12 pe-0">
                                                <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.unit_total') }}</p>
                                                <input type="text" style="text-align:right" name="" class="form-control total" id="add_total${btnCount}" value="0" disabled>
                                            </div>
                                            <div class="col-md-12 pt-2 d-flex justify-content-end pe-0">
                                                <div class="">
                                                    <button class="btn   btn-primary new_save" style="width: 80px" id="${btnCount}"> {{ trans('global.save') }} </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                            <i class="bx bx-x fs-4 text-muted cursor-pointer remove" id="${btnCount}"></i>


                                        </div>

                                    </div>
        `);
            btnCount++;
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            if ($("#qty" + id).attr('disabled')) {
                $("#qty" + id).removeAttr('disabled');
            } else {
                $("#qty" + id).val($("#qty" + id).data('qty'));
                $("#qty" + id).attr('disabled', 'disabled');
            }

        });

        $(document).on("change", ".product_name", function() {
            var product_name_id = $(this).attr('id');
            var number = parseInt(product_name_id.replace('product_name', ''));
            var id = $(this).find(":selected").val();
            $('#qty' + number).val(1);
            $.ajax({
                type: 'GET',
                url: '/product/price',
                data: {
                    id: id
                },
                success: function(data) {
                    var price = data[0];
                    $('#max' + number).val(data[1]);
                    if (data[1] != 0) {
                        $('#qty' + number).data('qty', data[1]);
                        var qty = $('#qty' + number).val();
                        var subtotal = 0;

                        $('#unit_price' + number).val(price);
                        $('#total' + number).val(price * qty);
                        var linetotals = $('.total');
                        for (var i = 0; i < linetotals.length; i++) {
                            subtotal += parseInt($(linetotals[i]).val());
                        }
                        $('#sub_total').html(subtotal);
                    } else {
                        alert("stock qty is 0! You can't select this product");
                        $(`#product_name${number}`).val($(`#product_name${number}`).data('product-id'));
                        $(`#qty${number}`).val($(`#qty${number}`).data('qty'));
                        $(`#unit_price${number}`).val($(`#unit_price${number}`).data('unit-price'));
                        $(`#total${number}`).val($(`#total${number}`).data('total'));
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        //new products
        $(document).on("change", ".add_product_name", function() {
            var product_name_id = $(this).attr('id');
            var number = parseInt(product_name_id.replace('add_product_name', ''));
            var id = $(this).find(":selected").val();
            $.ajax({
                type: 'GET',
                url: '/product/price',
                data: {
                    id: id
                },
                success: function(data) {
                    var price = data[0];
                    $('#add_max' + number).val(data[1]);
                    if (data[1] != 0) {
                        $('#add_qty' + number).val(1);
                        $('#qty' + number).data('qty', data[1]);
                        var qty = $('#add_qty' + number).val();
                        var subtotal = 0;
                        $('#add_unit_price' + number).val(price);
                        $('#add_total' + number).val(price * qty);
                        var linetotals = $('.total');
                        for (var i = 0; i < linetotals.length; i++) {
                            subtotal += parseInt($(linetotals[i]).val());
                        }
                        $('#sub_total').html(subtotal);
                    } else {
                        alert("stock qty is 0! You can't select this product");
                        $(`#add_product_name${number}`).val($(`#product_name${number}`).data(
                            'product-id'));
                        $(`#add_qty${number}`).val(0);
                        $(`#add_unit_price${number}`).val(0);
                        $(`#add_total${number}`).val(0);
                    }

                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        //new products
        $(document).on('input', '.add_qty', function() {

            var qtyid = $(this).attr('id');
            var number = parseInt(qtyid.replace('add_qty', ''));
            var max = $('#add_max' + number).val();
            var qty = $(this).val();
            var id = $('#add_product_name' + number).find(":selected").val();
            var subtotal = 0;
            if (parseInt($(this).val()) > parseInt(max)) {
                alert('Your product qty is more than stock qty! Stocks = ' + max);
                var cost = parseInt($('#add_unit_price' + number).val());
                $(this).val(max);
                $('#add_total' + number).val(max * cost);
            } else {
                if (parseInt($(this).val()) <= parseInt(max) || $(this).val() < $(this).data('qty')) {
                    $.ajax({
                        type: 'GET',
                        url: `/product/price/`,
                        data: {
                            id: id
                        },
                        success: function(data) {
                            var price = qty * data[0];
                            $('#add_max' + number).val(data[1]);
                            $('#add_total' + number).val(price);
                            var linetotals = $('.total');
                            for (var i = 0; i < linetotals.length; i++) {
                                subtotal += parseInt($(linetotals[i]).val());
                            }
                            $('#sub_total').html(subtotal);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    })
                }
            }
        });

        //save new products
        $(document).on('click', '.new_save', function() {
            var id = $(this).attr('id');
            var product_id = $('#add_product_name' + id).val();
            var invoice_id = $('#invoice_id').val();
            var qty = $('#add_qty' + id).val();
            var line_total = $('#add_total' + id).val();
            var subTotal = $('#sub_total').text();
            $.ajax({
                type: 'PUT',
                url: `/admin/invoices/${invoice_id}`,
                data: {
                    'edit': '2',
                    'product_id': product_id,
                    'invoice_id': invoice_id,
                    'qty': qty,
                    'line_total': line_total,
                    'sub_total': subTotal,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    alert(data);
                    $("#add_product_name" + id).attr('disabled', 'disabled');
                    $("#add_qty" + id).attr('disabled', 'disabled');
                    location.reload(true);
                }
            })
        })

        $(document).on('click', '.remove', function() {
            var id = $(this).attr('id');
            var sub_total = parseInt($('#sub_total').text());
            sub_total -= parseInt($('#add_total' + id).val());
            $('#sub_total').html(sub_total);
            $("#row" + id).remove();
            --btnCount;
        })

        $(document).on('input', '.qty', function() {
            var qtyid = $(this).attr('id');
            var number = parseInt(qtyid.replace('qty', ''));
            var max = $('#max' + number).val();
            var qty = $(this).val();
            var id = $('#product_name' + number).find(":selected").val();
            var subtotal = 0;
            if (parseInt($(this).val()) > parseInt(max) && $(this).val() > $(this).data('qty')) {
                alert('Your product qty is more than stock qty! Stocks = ' + max);
                var cost = parseInt($('#unit_price' + number).val());
                $(this).val(max);
                $('#total' + number).val(max * cost);
            } else {
                if (parseInt($(this).val()) <= parseInt(max) || $(this).val() < $(this).data('qty')) {
                    $.ajax({
                        type: 'GET',
                        url: `/product/price/`,
                        data: {
                            id: id
                        },
                        success: function(data) {
                            var price = qty * data[0];
                            // $('#max' + number).val(data[1]);
                            $('#total' + number).val(price);
                            var linetotals = $('.total');
                            for (var i = 0; i < linetotals.length; i++) {
                                subtotal += parseInt($(linetotals[i]).val());
                            }
                            $('#sub_total').html(subtotal);

                        },
                        error: function(data) {
                            console.log(data);
                        }
                    })
                }
            }
        })

        $(document).on('click', '.save', function() {
            var id = $(this).attr('id');
            var old_product_id = $('#product_name' + $(this).attr('id')).data('product-id');
            var new_product_id = $('#product_name' + $(this).attr('id')).val();
            var invoice_id = $('#invoice_id').val();
            var qty = $('#qty' + $(this).attr('id')).val();
            var line_total = $('#total' + $(this).attr('id')).val();
            var total_qty = 0;
            var qty_inputs = $('.qty');
            for (var i = 0; i < qty_inputs.length; i++) {
                total_qty += +$(qty_inputs[i]).val();
            }
            var subTotal = $('#sub_total').text();
            $.ajax({
                type: 'PUT',
                url: `/admin/invoices/${invoice_id}`,
                data: {
                    'edit': '1',
                    'old_id': old_product_id,
                    'new_id': new_product_id,
                    'invoice_id': invoice_id,
                    'qty': qty,
                    'line_total': line_total,
                    'total_qty': total_qty,
                    'sub_total': subTotal,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    alert(data);
                    $("#product_name" + id).attr('disabled', 'disabled');
                    $("#qty" + id).attr('disabled', 'disabled');
                }
            })
        })

        $('.deleteProduct').on('click', function() {
            var id = $(this).attr('id');
            var invoice_id = $('#invoice_id').val();
            $.ajax({
                type: 'GET',
                url: `/admin/invoices/product/delete`,
                data: {
                    'product_id': id,
                    'invoice_id': invoice_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#product' + id).remove();
                    alert(data);
                }
            })

        })
    </script>
@endsection
