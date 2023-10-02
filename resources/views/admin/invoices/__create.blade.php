@extends('layouts.admin')
@section('content')
    <form method="POST" action="{{ route('admin.invoices.store') }}" enctype="multipart/form-data" id="form">
        @csrf
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
                                            <span class=" text-capitalize mb-0 text-nowrap">{{trans('cruds.invoice.fields.date')}}</span>
                                        </dt>
                                        <dd class="col-sm-6 d-flex justify-content-md-end">
                                            <div class="w-px-150">
                                                <input type="text" class="form-control" name="date" id="date"
                                                    value="{{ old('date', '') }}" placeholder="YYYY-MM-DD" required />
                                                @if ($errors->has('date'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('date') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.invoice.fields.assign_date_helper') }}</span>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                            <span class=" text-capitalize mb-0 text-nowrap">{{trans('cruds.invoice.fields.assign_date')}}</span>
                                        </dt>
                                        <dd class="col-sm-6 d-flex justify-content-md-end">
                                            <div class="w-px-150">
                                                <input type="text" class="form-control" name="assign_date" id="assign_date"
                                                    value="{{ old('assign_date', '') }}" placeholder="YYYY-MM-DD" required />
                                                @if ($errors->has('assign_date'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('assign_date') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.invoice.fields.assign_date_helper') }}</span>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                            <span class=" text-capitalize mb-0 text-nowrap">{{trans('cruds.invoice.fields.assign_date')}}</span>
                                        </dt>
                                        <dd class="col-sm-6 d-flex justify-content-md-end">
                                            <div class="w-px-150">
                                                <input type="text" class="form-control" name="assign_date" id="assign_date"
                                                    value="{{ old('assign_date', '') }}" placeholder="YYYY-MM-DD" required />
                                                @if ($errors->has('assign_date'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('assign_date') }}
                                                    </div>
                                                @endif
                                                <span
                                                    class="help-block">{{ trans('cruds.invoice.fields.assign_date_helper') }}</span>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                                            <span class="fw-normal">Site:</span>
                                        </dt>
                                        <dd class="col-sm-6 d-flex justify-content-md-end">
                                            <div class="w-px-150">
                                                <select
                                                    class="form-select {{ $errors->has('customer_name') ? 'is-invalid' : '' }}"
                                                    name="customer_name_id" id="customer_name_id" required>
                                                    @foreach ($customer_names as $id => $entry)
                                                        <option value="{{ $id }}"
                                                            {{ old('customer_name_id') == $id ? 'selected' : '' }}>
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
                                        <div class="d-flex border rounded position-relative pe-0 mb-5" id="row0">
                                            <div class="row w-100 m-0 p-3">
                                                <div class="col-md-6 col-12 mb-md-0 mb-3 ps-md-0">
                                                    <p class="mb-2 repeater-title">Product</p>
                                                    <select
                                                        class="form-select product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                                        name="product_name_id0" id="product_name_id0" required>
                                                        @foreach ($product_names as $id => $entry)
                                                            <option value="{{ $id }}"
                                                                {{ old('product_name_id') == $id ? 'selected' : '' }}>
                                                                {{ $entry }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                    <p class="mb-2 repeater-title">Price</p>
                                                    <input type="number" style="text-align:right" value="0"
                                                        class="form-control invoice-item-price mb-2" id="cost0"
                                                        disabled />
                                                </div>
                                                <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                    <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.qty') }}
                                                    </p>
                                                    <input type="number" class="form-control qty" style="text-align:right"
                                                        name="qty0" id="qty0" value="{{ old('qty0', 0) }}"
                                                        step="1" min="1" required />
                                                    <input type="hidden" id="max0" value="0">
                                                </div>
                                                <div class="col-md-2 col-12 pe-0">
                                                    <p class="mb-2 repeater-title">
                                                        {{ trans('cruds.invoice.fields.unit_total') }}</p>
                                                    <input
                                                        class="form-control unit_total {{ $errors->has('unit_total') ? 'is-invalid' : '' }}"
                                                        type="number" name="unit_total0" id="unit_total0"
                                                        style="text-align:right" value="{{ old('unit_total', 0) }}"
                                                        step="1" readonly style="text-align:right">
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                                <i class="bx bx-x fs-4 text-muted cursor-pointer deleteProduct"
                                                    id="row0"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary" id="addProduct">Add Product</button>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-4 mx-n4" />

                            <div class="row py-sm-3">
                                <div class="col-md-6 mb-md-0 mb-3">

                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="invoice-calculations">

                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="w-px-100">{{ trans('cruds.invoice.fields.total') }}:</span>
                                            <span class="fw-semibold" id="subtotal">0</span>
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
                                <button type="submit" class="btn mb-2 btn-primary w-100">Save</button>
                                <a href="{{ route('admin.invoices.index') }}"
                                    class="btn btn-label-secondary d-block w-100 me-3">Cancel</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Invoice Actions -->
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        var btnCount = 0;
        //add another invoice
        $(document).on('click', '#addProduct', function() {
            ++btnCount;
            var content = `<div class="d-flex border rounded position-relative pe-0 mb-5" id="row${btnCount}">
                                        <div class="row w-100 m-0 p-3">
                                            <div class="col-md-6 col-12 mb-md-0 mb-3 ps-md-0">
                                                <p class="mb-2 repeater-title">Product</p>
                                                <select class="form-select product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}" name="product_name_id${btnCount}" id="product_name_id${btnCount}" required>
                                                    @foreach ($product_names as $id => $entry)
                                                        <option value="{{ $id }}" {{ old('product_name_id') == $id ? 'selected' : '' }}>
                                                        {{ $entry }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                <p class="mb-2 repeater-title">Price</p>
                                                <input type="number" class="form-control invoice-item-price mb-2"
                                                    id="cost${btnCount}" value="0" style="text-align:right" disabled />
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0 mb-3">
                                                <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.qty') }}</p>
                                                <input type="number" class="form-control qty" style="text-align:right" name="qty${btnCount}" id="qty${btnCount}" value="{{ old('qty${btnCount}', 0) }}" step="1" min="1" required />
                                                <input type="hidden" id="max${btnCount}" value="0">
                                                </div>
                                            <div class="col-md-2 col-12 pe-0">
                                                <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.unit_total') }}</p>
                                                <input class="form-control unit_total {{ $errors->has('unit_total') ? 'is-invalid' : '' }}" type="number" name="unit_total${btnCount}" id="unit_total${btnCount}" style="text-align:right" value="{{ old('unit_total${btnCount}', 0) }}" step="1" readonly style="text-align:right">
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                            <i class="bx bx-x fs-4 text-muted cursor-pointer deleteProduct" id="row${btnCount}"></i>

                                        </div>
                                    </div>`;
            $('#container').append(content);
        });

        //delete product
        $(document).on('click', '.deleteProduct', function() {
            if (btnCount != 0) {

                var row = '#' + $(this).attr('id');
                $(row).remove();
                --btnCount;
                var subtotal = 0;
                var unit_total = $(".unit_total");

                for (var i = 0; i < unit_total.length; i++) {
                    if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                        subtotal += parseInt($(unit_total[i]).val());
                    }
                }
                $('#subtotal').html(subtotal + " Ks");
            } else {
                alert("You can't delete all Products")
            }
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
            for (var i = 0; i < length; i++) {
                if ($(`#product_name_id${i}`).find(":selected").val() == $(this).find(":selected").val() && $(
                        `#product_name_id${i}`).attr('id') != $(this).attr('id')) {
                    alert('product has been already selected');
                    $(`#${product_name_id}`).prop('selectedIndex', 0);
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

                    var price = data[0];
                    var subtotal = 0;
                    $('#max' + number).val(data[1]);
                    if (data[1] != 0) {
                        $('#qty' + number).val(1);
                        $('#cost' + number).val(price);
                        $('#unit_total' + number).val(price);
                        var unit_total = $(".unit_total");

                        for (var i = 0; i < unit_total.length; i++) {
                            if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                                subtotal += parseInt($(unit_total[i]).val());
                            }
                        }

                        $('#subtotal').html(subtotal + " Ks");

                    } else {
                        alert("stock qty is 0! You can't select this product");
                        $(`#${product_name_id}`).prop('selectedIndex', 0);
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

                    var price = qty * data[0];
                    $('#unit_total' + number).val(price);
                    var subtotal = 0;
                    var unit_total = $(".unit_total");

                    for (var i = 0; i < unit_total.length; i++) {
                        if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                            subtotal += parseInt($(unit_total[i]).val());
                        }
                    }
                    $('#subtotal').html(subtotal + " Ks");
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        $("#customer_name_id").on('change', function() {
            var id = $(this).find(":selected").val();
            $.ajax({
                type: 'GET',
                url: '/admin/customer/info',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#name').html(data.name);
                    $('#address').html(data.address);
                    $('#phone').html(data.phone_number);
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        $(() => {
            var flatpickrDate = document.querySelector('#date');
            if (flatpickrDate) {
                flatpickrDate.flatpickr({
                    monthSelectorType: 'static'
                });
            }
        })
    </script>
@endsection
