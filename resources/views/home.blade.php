@extends('layouts.admin')
@section('content')
    <!-- <div class="content"> -->



    {{-- You are logged in! --}}

    <div class="row">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6>Dashboard</h6>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center ">
                        <div class="col-lg-2 col-md-4 col-sm-6 col-12 card m-2 p-3">
                            <h6>Total : {{ $allservices }}</h6>
                            <h5> <i class="fa-solid fa-diagram-project me-2"></i> All services</h5>
                            <a href="{{ '/admin/customer-assigns' }}" class=" fw-bold">Show more.. <i
                                    class="fas fa-arrow-circle-right ms-2"></i></a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 col-12 card  m-2 p-3">
                            <h6>Total : {{ $completed }}</h6>
                            <h5><i class="fa-solid fa-flag me-2"></i> Completed</h5>
                            <a href="/admin/customer-assigns/action/completed" class=" fw-bold">Show
                                more.. <i class="fas fa-arrow-circle-right ms-2"></i></a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 col-12 card m-2 p-3">
                            <h6>Total : {{ $suspend }}</h6>
                            <h5><i class="fa-solid fa-hourglass-start me-2"></i>Suspend</h5>
                            <a href="/admin/customer-assigns/action/suspend" class=" fw-bold">Show more..
                                <i class="fas fa-arrow-circle-right ms-2"></i></a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 col-12 card m-2 p-3">
                            <h6>Total : {{ $pending }}</h6>
                            <h5><i class="fa-solid fa-spinner me-2"></i>Pending</h5>
                            <a href="/admin/customer-assigns/action/pending" class=" fw-bold">Show more..
                                <i class="fas fa-arrow-circle-right ms-2"></i></a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 col-12 card m-2 p-3">
                            <h6>Total : {{ $cancel }}</h6>
                            <h5><i class="fa-solid fa-rectangle-xmark me-2"></i>Cancel</h5>
                            <a href="/admin/customer-assigns/action/cancel" class=" fw-bold">Show more..
                                <i class="fas fa-arrow-circle-right ms-2"></i></a>
                        </div>

                    </div>
                </div>
            </div>


        </div>

    </div>

    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6>Stock History</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <th>Site</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Service Person</th>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                @php
                                    $customer = \App\Models\Customer::find($product->customer_name_id); // site
                                    $engineer = \App\Models\CustomerAssign::find($product->customer_assign);
                                    $prod = \App\Models\Product::find($product->product_id);
                                    
                                @endphp
                                <tr>
                                    <td>{{ $customer->name ?? '' }}</td>
                                    <td>{{ $prod->product_name ?? '' }}</td>
                                    <td>{{ $product->qty ?? '' }}</td>
                                    <td>{{ $engineer->service_person->name ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- </div> -->
@endsection
@section('scripts')
    @parent
@endsection
