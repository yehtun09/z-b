@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Invoice Modify
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-4">Customer Details: </div>
                    <div class="col-md-6">{{ $customer->name }} <br>
                        {{ $customer->phone_number }} <br>
                        {{ $customer->address }}
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-3"> {{ trans('cruds.invoice.fields.invoice_code') }} <br>
                        Issued Date <br> Issued By
                    </div>
                    <div class="col-md-9">
                        <input type="hidden" id="invoice_id" value="{{ $invoice->id }}">
                        {{ $invoice->invoice_code }} <br>
                        {{ date('d/m/Y', strtotime($invoice->created_at)) }} <br>
                        {{ $invoice->created_by->name }}
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @foreach ($invoice->products as $product)
        <div class="row mt-3">
            <div class="col-md-3">
                <label class="required" for="product_name_id">{{ trans('cruds.product.fields.product_name') }}</label>
                <select class="form-control product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}" name="product_name_id0" data-product-id="{{ $product->pivot->product_id }}" id="product_name{{ $product->id }}" required disabled>
                    @foreach ($product_names as $id => $entry)
                    <option value="{{ $id }}" {{ old('product_name_id') == $id ? 'selected' : '' }} @if ($id==$product->pivot->product_id) selected @endif>
                        {{ $entry }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="">{{ trans('cruds.invoice.fields.qty') }}</label>
                <input type="number" style="text-align:right" name="" class="form-control qty" id="qty{{ $product->id }}" value="{{ $product->pivot->qty }}" data-qty="{{ $product->pivot->qty }}" min="1" disabled>
                <input type="hidden" id="max{{ $product->id }}" value="{{ $product->stock_qty }}">

            </div>
            <div class="col-md-2">
                <label for="">{{ trans('cruds.invoice.fields.unit_price') }}</label>
                <input type="text" style="text-align:right" name="" class="form-control unit_price" id="unit_price{{ $product->id }}" value="{{ (int) $product->sales_price }}" data-unit-price="{{ $product->sales_price }}" disabled>
            </div>
            <div class="col-md-2">
                <label for="">{{ trans('cruds.invoice.fields.line_total') }}</label>
                <input type="text" style="text-align:right" name="" class="form-control total" id="total{{ $product->id }}" value="{{ $product->pivot->total }}" data-total="{{ $product->pivot->total }}" disabled>
            </div>
            <div class="col-md-3 pt-2">
                <button class="btn btn-success edit" style="width: 100px" id="{{ $product->id }}">{{ trans('global.edit') }}</button>
                <button class="btn btn-primary save" style="width: 100px" id="{{ $product->id }}"> {{ trans('global.save') }} </button>
            </div>
        </div>
        @endforeach
    </div>
    <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="post">
        @method('PUT')
        @csrf
        <div class="card-footer">
            <div class="row">
                <div class="col-md-3">
                    <input type="hidden" name="url" value="{{request('route')}}">
                    <input type="hidden" name="total" value="{{ $invoice->total }}" id="hidden_total">
                    <input type="hidden" name="sub_total" value="{{ $invoice->sub_total }}" id="hidden_sub_total">
                    <label for=""> {{ trans('cruds.invoice.fields.service_fees') }} </label>
                    <input type="text" name="service_fees" class="form-control" id="service_fees_input" value="{{ $product->pivot->service_fees }}" data-service-fees="{{ $product->pivot->service_fees }}" required>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2" style="font-size : 1rem;margin-top:8px;">
                    {{ strtoupper(trans('cruds.invoice.fields.service_fees')) }} <br>
                    {{ strtoupper(trans('cruds.invoice.fields.sub_total')) }} <br>
                    {{ strtoupper(trans('cruds.product.fields.discount')) }} <br>
                    {{ strtoupper(trans('cruds.invoice.fields.total')) }}
                </div>
                <div class="col-md-2" style="font-size : 1rem;margin-top:8px;text-align:right">
                    <span id="service_fees">{{ $product->pivot->service_fees }}</span> Ks <br>
                    <span id="sub_total">{{ $invoice->sub_total }}</span> Ks <br>
                    <span id="discount">{{ $product->pivot->discount }}</span> %<br>
                    <span id="total">{{ $invoice->total }}</span>
                    Ks
                </div>
                <div class="col-md-2">
                    <a id="add_product" class="btn btn-success text-white mb-1 " style="width:207px">Add Product</a>
                    <button type="submit" class="btn btn-primary mb-1" id="update" style="width:207px" disabled>{{ trans('global.update') }} {{ trans('cruds.invoice.title') }}</button>
                    <a class="btn btn-secondary text-white" style="width:207px" href="{{ route('admin.invoices.index') }}">{{ trans('global.cancel') }}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')

<script>
    var btnCount = 0;
    $('#add_product').on('click', function() {
        $('.card-body').append(`<div class="row mt-3" id="row${btnCount}">
            <div class="col-md-3">
                <label class="required" for="product_name_id">{{ trans('cruds.product.fields.product_name') }}</label>
                <select class="form-control select2 add_product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}" name="add_product_name${btnCount}" id="add_product_name${btnCount}" required>
                    @foreach ($product_names as $id => $entry)
                    @if ($id!=$product->pivot->product_id) 
                    <option value="{{ $id }}" {{ old('product_name${btnCount}') == $id ? 'selected' : '' }}>
                        {{ $entry }}
                    </option>
                    @endif
                    
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="">{{ trans('cruds.invoice.fields.qty') }}</label>
                <input type="number" style="text-align:right" name="add_qty${btnCount}" class="form-control add_qty" id="add_qty${btnCount}" value="0"  min="1">
                <input type="hidden" id="add_max${btnCount}" value="0">

            </div>
            <div class="col-md-2">
                <label for="">{{ trans('cruds.invoice.fields.unit_price') }}</label>
                <input type="text" style="text-align:right" name="" class="form-control unit_price" id="add_unit_price${btnCount}" value="0" disabled>
            </div>
            <div class="col-md-2">
                <label for="">{{ trans('cruds.invoice.fields.line_total') }}</label>
                <input type="text" style="text-align:right" name="" class="form-control total" id="add_total${btnCount}" value="0" disabled>
            </div>
            <div class="col-md-3 pt-2">
                <button class="btn btn-danger remove" style="width: 100px" id="${btnCount}">{{ trans('global.remove') }}</button>
                <button class="btn btn-primary new_save" style="width: 100px" id="${btnCount}"> {{ trans('global.save') }} </button>
            </div>
        </div>
        `);
        btnCount++;
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).attr('id');
        if ($("#qty" + id).attr('disabled')) {
            $("#qty" + id).removeAttr('disabled');
            $("#product_name" + id).removeAttr('disabled');
        } else {
            $("#qty" + id).val($("#qty" + id).data('qty'));
            $("#qty" + id).attr('disabled', 'disabled');
            $("#product_name" + id).attr('disabled', 'disabled');
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
                if(data[1] != 0){
                    $('#qty' + number).data('qty', data[1]);
                    var qty = $('#qty' + number).val();
                    var subtotal = 0;
                    var service_fees = parseInt($('#service_fees').text());
                    var discount = parseInt($('#discount').text());
                    $('#unit_price' + number).val(price);
                    $('#total' + number).val(price * qty);
                    var linetotals = $('.total');
                    for (var i = 0; i < linetotals.length; i++) {
                        subtotal += parseInt($(linetotals[i]).val());
                    }
                    $('#sub_total').html(subtotal + service_fees);
                    discount = (subtotal + service_fees) * discount / 100;
                    $('#total').html(subtotal + service_fees - discount);
                }
                else{
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
                    var service_fees = parseInt($('#service_fees').text());
                    var discount = parseInt($('#discount').text());
                    $('#add_unit_price' + number).val(price);
                    $('#add_total' + number).val(price * qty);
                    var linetotals = $('.total');
                    for (var i = 0; i < linetotals.length; i++) {
                        subtotal += parseInt($(linetotals[i]).val());
                    }
                    $('#sub_total').html(subtotal + service_fees);
                    discount = (subtotal + service_fees) * discount / 100;
                    $('#total').html(subtotal + service_fees - discount);
                } else {
                    alert("stock qty is 0! You can't select this product");
                    $(`#add_product_name${number}`).val($(`#product_name${number}`).data('product-id'));
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
        var service_fees = parseInt($('#service_fees').text());
        var discount = parseInt($('#discount').text());
        if (parseInt($(this).val()) > parseInt(max)) {
            alert('Your product qty is more than stock qty! Stocks = ' + max);
            $(this).val(max);
        } else {
            if (parseInt($(this).val()) < parseInt(max) || $(this).val() < $(this).data('qty')) {
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
                        $('#sub_total').html(subtotal + service_fees);
                        discount = (subtotal + service_fees) * discount / 100;
                        $('#total').html(subtotal + service_fees - discount);

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
        var service_fees = $('#service_fees_input').val();
        var product_id = $('#add_product_name' + id).val();
        var invoice_id = $('#invoice_id').val();
        var qty = $('#add_qty' + id).val();
        var total = $('#total').text();
        var discount = $('#discount').text();
        var line_total = $('#add_total' + id).val();
        // var total_qty = 0;
        // var qty_inputs = $('.qty');
        // for (var i = 0; i < qty_inputs.length; i++) {
        //     total_qty += +$(qty_inputs[i]).val();
        // }
        var subTotal = $('#sub_total').text();
        $.ajax({
            type: 'PUT',
            url: `/admin/invoices/${invoice_id}`,
            data: {
                'edit': '2',
                'product_id': product_id,
                'invoice_id': invoice_id,
                'qty': qty,
                'total': total,
                'line_total': line_total,
                'sub_total': subTotal,
                'service_fees': service_fees,
                'discount' : discount,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                alert(data);
                $("#add_product_name" + id).attr('disabled', 'disabled');
                $("#add_qty" + id).attr('disabled', 'disabled');
            }
        })
    })

    $(document).on('click', '.remove', function() {
        var id = $(this).attr('id');
        var sub_total = parseInt($('#sub_total').text());
        var dis = parseFloat($('#discount').text());
        sub_total -= parseInt($('#add_total'+ id).val());
        $('#sub_total').html(sub_total);
        var total = sub_total - (( sub_total * dis ) / 100) ;
        $('#total').html(total);
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
        var service_fees = parseInt($('#service_fees').text());
        var discount = parseInt($('#discount').text());
        if (parseInt($(this).val()) > parseInt(max) && $(this).val() > $(this).data('qty')) {
            alert('Your product qty is more than stock qty! Stocks = ' + max);
            $(this).val(max);
        } else {
            if (parseInt($(this).val()) < parseInt(max) || $(this).val() < $(this).data('qty')) {
                $.ajax({
                    type: 'GET',
                    url: `/product/price/`,
                    data: {
                        id: id
                    },
                    success: function(data) {
                        var price = qty * data[0];
                        $('#max' + number).val(data[1]);
                        $('#total' + number).val(price);
                        var linetotals = $('.total');
                        for (var i = 0; i < linetotals.length; i++) {
                            subtotal += parseInt($(linetotals[i]).val());
                        }
                        $('#sub_total').html(subtotal + service_fees);
                        discount = (subtotal + service_fees) * discount / 100;
                        $('#total').html(subtotal + service_fees - discount);

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
        var total = $('#total').text();
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
                'total': total,
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

    $('#service_fees_input').on('input', function() {
        if ($('#service_fees_input').data('service-fees') != $(this).val()) {
            $('#update').removeAttr('disabled');
        } else {
            $('#update').attr('disabled', 'disabled');
        }
        var subtotal = 0;
        var service_fees = parseInt($(this).val());
        var discount = parseInt($('#discount').text());
        var linetotals = $('.total');
        for (var i = 0; i < linetotals.length; i++) {
            subtotal += parseInt($(linetotals[i]).val());
        }

        $('#service_fees').html(service_fees);
        $('#sub_total').html(subtotal + service_fees);
        discount = (subtotal + service_fees) * discount / 100;
        $('#total').html(subtotal + service_fees - discount);
        $('#hidden_total').val(subtotal + service_fees - discount);
        $('#hidden_sub_total').val(parseInt(subtotal) + parseInt($(this).val()));
    })
</script>
@endsection
