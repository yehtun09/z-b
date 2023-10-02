@extends('layouts.admin')
@section('content')
<form method="POST" action="{{ route("admin.invoices.store") }}" enctype="multipart/form-data" id="form">
    @csrf
    <div class="">
        <div class="row border bg-white pt-3 shadow " style="border-radius: 10px;">
            <div class="col-12" id="container">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="required" for="invoice_code">{{ trans('cruds.invoice.fields.invoice_code') }}</label>
                            <input class="form-control {{ $errors->has('invoice_code') ? 'is-invalid' : '' }}" type="text" name="invoice_code" id="invoice_code" value="{{ old('invoice_code', '') }}" required>
                            @if($errors->has('invoice_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('invoice_code') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.invoice_code_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="required" for="customer_name_id">{{ trans('cruds.invoice.fields.customer_name') }}</label>
                            <select class="form-control {{ $errors->has('customer_name') ? 'is-invalid' : '' }}" name="customer_name_id" id="customer_name_id" required>
                                @foreach($customer_names as $id => $entry)
                                <option value="{{ $id }}" {{ old('customer_name_id') == $id ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('customer_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('customer_name') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.customer_name_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-2 p-0">
                        <div class="form-group">
                            <label class="required" for="service_fees">{{ trans('cruds.invoice.fields.service_fees') }}</label>
                            <input class="form-control" type="number" type="text" name="service_fees" id="service_fees" style="text-align:right" value="{{ old('service_fees', 0) }}" required>
                            <span class="help-block">{{ trans('cruds.invoice.fields.service_fees_helper') }}</span>
                        </div>
                    </div>

                </div>
                <div class="row" id="row0">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="required" for="product_name_id">{{ trans('cruds.product.fields.product_name') }}</label>
                            <select class="form-control product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}" name="product_name_id0" id="product_name_id0" required>
                                @foreach($product_names as $id => $entry)
                                <option value="{{ $id }}" {{ old('product_name_id') == $id ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('product_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('product_name') }}
                            </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="required" for="qty">{{ trans('cruds.invoice.fields.qty') }}</label>
                            <input class="form-control qty {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number" name="qty0" style="text-align:right" id="qty0" value="{{ old('qty', 0) }}" step="1" min="1" required>
                            <input type="hidden" id="max0" value="0">
                            @if($errors->has('qty'))
                            <div class="invalid-feedback">
                                {{ $errors->first('qty') }}
                            </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-2 p-0">
                        <div class="form-group">
                            <label class="required" for="unit_total">{{ trans('cruds.invoice.fields.unit_total') }}</label>
                            <input class="form-control unit_total {{ $errors->has('unit_total') ? 'is-invalid' : '' }}" type="number" name="unit_total0" id="unit_total0" style="text-align:right" value="{{ old('unit_total', 0) }}" step="1" readonly style="text-align:right">
                            @if($errors->has('unit_total'))
                            <div class="invalid-feedback">
                                {{ $errors->first('unit_total') }}
                            </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group col-3" id="button">
                        <div class="mx-auto pt-2">
                            <button style="padding:6px 10px 5px 10px;" class="rounded-circle circle-button btn btn-success mx-1" id="addInvoice">
                                <i class="bi bi-plus" style="top: 0 !important"></i>
                            </button>
                            <button style="padding:6px 10px 5px 10px;" class="rounded-circle circle-button btn btn-danger deleteInvoice" id="row0">
                                <i class="bi bi-dash" style="top: 0 !important"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row mt-1">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="required" for="discount">{{ trans('cruds.product.fields.discount') }} (%)</label>
                            <input class="form-control" type="text" name="discount" id="discount" value="{{ old('discount', 0) }}" style="text-align:right" required>
                            <span class="help-block">{{ trans('cruds.product.fields.discount_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="required" for="discount_mmk">{{ trans('cruds.product.fields.discount') }} (MMK)</label>
                            <input class="form-control" type="text" name="discount_mmk" id="discount_mmk" value="{{ old('discount_mmk', 0) }}" style="text-align:right" required>
                            <span class="help-block">{{ trans('cruds.product.fields.discount_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-3 font-weight-bold" style="font-size:15px;">
                        <div class="row">
                            <div class="col-md-5">
                                {{ strtoupper(trans('cruds.invoice.fields.service_fees')) }} <br>
                                {{ strtoupper(trans('cruds.invoice.fields.sub_total')) }} <br>
                                {{ strtoupper(trans('cruds.product.fields.discount')) }} <br>
                                {{ strtoupper(trans('cruds.invoice.fields.total')) }}
                            </div>
                            <div class="col-md-4" style="text-align: right;padding-right:20px">
                               <span id="services_fees"></span> <br>
                               <span id="subtotal"></span> <br>
                               <span id="dis"></span> <br>
                               <span id="total"></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-7"></div>
                    <div class="col-3 mx-auto pt-2">
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary" type="submit" style="width:6rem" id="saveBtn">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@section('scripts')

<script>
    var btnCount = 0;
    //add another invoice
    $(document).on('click', '#addInvoice', function() {
        ++btnCount;
        var content = `<div class="row" id="row${btnCount}">
    <div class="col-3">
        <div class="form-group">
            <label class="required" for="product_name_id">Product Name</label>
            <select class="form-control product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                name="product_name_id${btnCount}" id="product_name_id${btnCount}" required>
                @foreach($product_names as $id => $entry)
                <option value="{{ $id }}" {{ old('product_name_id') == $id ? 'selected' : '' }}>
                    {{ $entry }}
                </option>
                @endforeach
            </select>
            @if($errors->has('product_name'))
            <div class="invalid-feedback">
                {{ $errors->first('product_name') }}
            </div>
            @endif
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="required" for="qty">Qty</label>
            <input class="form-control qty {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number"
                name="qty${btnCount}" id="qty${btnCount}" value="{{ old('qty', '') }}" step="1" min="0" style="text-align:right"required>
            <input type="hidden" id="max${btnCount}" value="0">
                @if($errors->has('qty'))
            <div class="invalid-feedback">
                {{ $errors->first('qty') }}
            </div>
            @endif

        </div>
    </div>
    <div class="col-2 p-0">
        <div class="form-group">
            <label class="required" for="unit_total">Unit Total</label>
            <input class="form-control unit_total {{ $errors->has('unit_total') ? 'is-invalid' : '' }}" type="number"
                name="unit_total${btnCount}" id="unit_total${btnCount}" value="{{ old('unit_total', '') }}" step="1"
                readonly style="text-align:right">
            @if($errors->has('unit_total'))
            <div class="invalid-feedback">
                {{ $errors->first('unit_total') }}
            </div>
            @endif

        </div>
    </div>
    <div class="form-group col-3" id="button">
        <div class="mx-auto pt-2">

            <button style="padding:6px 10px 5px 10px;" class="rounded-circle circle-button btn btn-success mx-1"
                id="addInvoice" style="border-radius:50%">
                <i class="bi bi-plus" style="top: 0 !important"></i>
            </button>
            <button style="padding:6px 10px 5px 10px;" class="rounded-circle circle-button btn btn-danger deleteInvoice"
                id="row${btnCount}" style="border-radius:50%">
                <i class="bi bi-dash" style="top: 0 !important"></i>
            </button>
        </div>
    </div>
</div>`;
        $('#container').append(content);
    });
    var qtyTag = document.querySelector('.qty');
    var nameTag = document.querySelector('.product_name');
    var max = 0;
    // qtyTag.addEventListener('input', updateValue);
    //test multiple forms
    $(document).on("change", ".product_name", function() {
        var product_name_id = $(this).attr('id');
        var number = parseInt(product_name_id.replace('product_name_id', ''));
        var length = $('.product_name').length;
        for(var i = 0 ; i<length ; i++){
            if($(`#product_name_id${i}`).find(":selected").val() == $(this).find(":selected").val() && $(`#product_name_id${i}`).attr('id') != $(this).attr('id')){
                alert('product has been already selected');
                $(`#${product_name_id}`).prop('selectedIndex',0);
                $(`#qty${number}`).val('');
                $(`#unit_total${number}`).val('');
                return
            };
        }
        var id = $(this).find(":selected").val();
        $.ajax({
            type: 'GET',
            url: '/product/price',
            data: {
                id: id
            },
            success: function(data) {
                var service_fees = parseInt($('#service_fees').val());
                var price = data[0];
                var subtotal = 0;
                $('#max' + number).val(data[1]);
                if(data[1] != 0){
                    $('#qty' + number).val(1);
                    $('#unit_total' + number).val(price);
                    var unit_total = $(".unit_total");
                    var discount = $('#discount').val();
                    for (var i = 0; i < unit_total.length; i++) {
                        if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                            subtotal += parseInt($(unit_total[i]).val());
                        }
                    }
                    $('#services_fees').html(service_fees + " Ks");
                    $('#subtotal').html(subtotal + service_fees + " Ks");
                    var dis = (subtotal + service_fees) * discount / 100;
                    $('#dis').html(dis + " Ks");
                    var total = subtotal + service_fees - dis;
                    $('#total').html(total + " Ks");
                    $('#discount_mmk').val(dis);
                }else{
                    alert("stock qty is 0! You can't select this product");
                    $(`#${product_name_id}`).prop('selectedIndex',0);
                    $(`#qty${number}`).val('');
                    $(`#unit_total${number}`).val('');
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
    $(document).on('input', '.qty', function() {
        var qtyid = $(this).attr('id');
        var number = parseInt(qtyid.replace('qty', ''));
        var qty = $(this).val();
        var max = $('#max' + number).val();
        if (parseInt($(this).val()) > parseInt(max)) {
            alert('Your product qty is more than stock qty! Stocks = ' + max);
            $(this).val(max);
            qty = max;
        }
        var id = $('#product_name_id' + number).find(":selected").val();
        $.ajax({
            type: 'GET',
            url: '/product/price',
            data: {
                id: id
            },
            success: function(data) {
                var service_fees = parseInt($('#service_fees').val());
                var price = qty * data[0];
                $('#unit_total' + number).val(price);
                var subtotal = 0;
                var unit_total = $(".unit_total");
                var discount = $('#discount').val();
                for (var i = 0; i < unit_total.length; i++) {
                    if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                        subtotal += parseInt($(unit_total[i]).val());
                    }
                }
                $('#subtotal').html(subtotal + service_fees + " Ks");
                var dis = (subtotal + service_fees) * discount / 100;
                $('#dis').html(dis + " Ks");
                var total = subtotal + service_fees - dis;
                $('#total').html(total + " Ks");
                $('#discount_mmk').val(dis);
            },
            error: function(data) {
                console.log(data);
            }
        })
    })
    $(document).on('click', '.deleteInvoice', function() {
        if (btnCount != 0) {
            var service_fees = parseInt($('#service_fees').val());
            var row = '#' + $(this).attr('id');
            $(row).remove();
            --btnCount;
            var subtotal = 0;
            var unit_total = $(".unit_total");
            var discount = $('#discount').val();
            for (var i = 0; i < unit_total.length; i++) {
                if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                    subtotal += parseInt($(unit_total[i]).val());
                }
            }
            $('#subtotal').html(subtotal + service_fees + " Ks");
            var dis = (subtotal + service_fees) * discount / 100;
            $('#dis').html(dis + " Ks");
            var total = subtotal + service_fees - dis;
            $('#total').html(total + " Ks");
            $('#discount_mmk').val(dis);
        } else {
            alert("You can't delete all invoices")
        }
    });
    $('#discount').on('change input', function() {
        var service_fees = parseInt($('#service_fees').val());
        var subtotal = 0;
        var unit_total = $(".unit_total");
        var discount = $('#discount').val();
        for (var i = 0; i < unit_total.length; i++) {
            if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                subtotal += parseInt($(unit_total[i]).val());
            }
        }
        $('#subtotal').html(subtotal + service_fees + " Ks");
        var dis = (subtotal + service_fees) * discount / 100;
        $('#dis').html(dis + " Ks");
        var total = subtotal + service_fees - dis;
        $('#total').html(total + " Ks");
        $('#discount_mmk').val(dis.toFixed(2));
    });

    $('#discount_mmk').on('change input', function() {
        if (!Number.isNaN(parseInt($('#discount_mmk').val()))) {
            var service_fees = parseInt($('#service_fees').val());
            var subtotal = 0;
            var unit_total = $(".unit_total");
            var discount = parseInt($('#discount_mmk').val());
            for (var i = 0; i < unit_total.length; i++) {
                if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                    subtotal += parseInt($(unit_total[i]).val());
                }
            }
            $('#subtotal').html(subtotal + service_fees + " Ks");
            var dis = (discount * 100) / (subtotal + service_fees);
            $('#dis').html(discount + " Ks");
            var total = subtotal + service_fees - discount;
            $('#total').html(total + " Ks");
            $('#discount').val(dis.toFixed(1));
        }
        else{
            $('#dis').html("0 Ks");
            $('#discount').val('0');
        }
    });

    $('#service_fees').on('change input', function() {
        if ($.trim($(this).val()).length != 0) {
            var service_fees = parseInt($(this).val());
            var subtotal = 0;
            var unit_total = $(".unit_total");
            var discount = $(' #discount ').val();
            for (var i = 0; i < unit_total.length; i++) {
                if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                    subtotal += parseInt($(unit_total[i]).val());
                }
            }
            $('#services_fees').html($(this).val() + " Ks");
            $('#subtotal').html(subtotal + service_fees + " Ks");
            var dis = (subtotal + service_fees) * discount / 100;
            $('#dis').html(dis + " Ks");
            var total = service_fees + subtotal - dis;
            $('#total').html(total + " Ks");
            $('#discount_mmk').val(dis);
        }
    })
</script>

@endsection
