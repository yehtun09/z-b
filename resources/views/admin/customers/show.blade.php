@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header border-bottom p-3 mb-2">
            {{-- {{ trans('global.show') }} {{ trans('cruds.site.title') }} --}}
            <h5 class="mb-0">Site Information</h5>
        </div>

        {{-- @dd($customer->customerNameInvoices->first()->odb_lat ?? '-') --}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="row gx-2">
                        <div class="col-md-4 fw-bold">{{ trans('cruds.customer.fields.sales_voucher_no') }}:</div>
                        <div class="col-md-8"> {{ $customer->sales_voucher_no ?? '-' }} </div>
                        <div class="col-md-4 fw-bold">{{ trans('cruds.customer.fields.customer_code') }}:</div>
                        <div class="col-md-8"> {{ $customer->customer_code ?? '-' }} </div>
                        <div class="col-md-4 fw-bold">{{ trans('cruds.customer.fields.name') }}:</div>
                        <div class="col-md-8">
                            {{ $customer->name ?? '-' }} ({{ $customer->contact_person ?? '-' }}) <br>
                            {{ $customer->phone_number ?? '-' }} <br />
                            {{ $customer->address ?? '-' }},{{ $customer->township->township ?? '-' }}.
                        </div>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <div class="row gx-2">
                        <div class="col-md-4 fw-bold">
                            {{ trans('cruds.customer.fields.ticket_no') }}
                        </div>
                        <div class="col-md-8">
                            {{ $customer->ticket_no ?? '-' }}
                        </div>
                        <div class="col-md-4 fw-bold">
                            {{ trans('cruds.customer.fields.service_type') }}
                        </div>
                        <div class="col-md-8">
                            {{ $customer->service_type->service_type ?? '-' }}
                        </div>
                        <div class="col-md-4 fw-bold">
                            {{ trans('cruds.customer.fields.service_plan') }}
                        </div>
                        <div class="col-md-8">
                            {{ $customer->service_plan->service_plan ?? '-' }}
                        </div>
                        <div class="col-md-4 fw-bold">
                            {{ trans('cruds.customer.fields.register_date') }}
                        </div>
                        <div class="col-md-8">
                            {{ date('d-m-Y', strtotime($customer->register_date ?? '-')) }}
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <td>{{ trans('cruds.customer.fields.bandwidth') }}</td>
                            <td>{{ $customer->bandwidth ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.customer.fields.site_lat') }}</td>
                            <td>{{ $customer->site_lat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.customer.fields.site_long') }}</td>
                            <td>{{ $customer->site_long ?? '-' }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Total distance (meters)</td>
                            <td>{{ round($meters, 2) }}</td>
                        </tr> --}}
                        <tr>
                            <td>{{ trans('cruds.customer.fields.township') }}</td>
                            <td>{{ $customer->township->township ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('cruds.customer.fields.address') }}</td>
                            <td>{{ $customer->address ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="form-group mt-2">
                <a class="btn btn-secondary" href="{{ route('admin.customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">
                    Site location by google maps
                </a>
            </div>

        </div>
    </div>
     <div class="">
         <input type="hidden" name="first_lat"    id="first_lat"     value="{{$customer->site_lat ?? '0'}}">
         <input type="hidden" name="first_long"   id="first_long"    value="{{$customer->site_long ?? '0'}}">
         <input type="hidden" name="second_lat"  id="second_lat"   value=" {{ $customer->customerNameInvoices->first()->odb_lat ?? '0'}}">
         <input type="hidden" name="second_long" id="second_long"   value="{{$customer->customerNameInvoices->first()->odb_long ?? '0'}}">
     </div>
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalToggleLabel">Site location by google maps</h5> --}}

                    <h4>Total Distance : <span id="msg"></span> <span id="lth"></span></h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="map" style="height:600px !important;">

                </div>
                <div id="msg "></div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCN2leNVwOzRRLdv-0DGBksyUFcigD_9jo&callback=initMap"
        ></script>
    <script>
        var first_lat = document.getElementById('first_lat').value;
        var first_long = document.getElementById('first_long').value;
        var second_lat = document.getElementById('second_lat').value;
        var second_long = document.getElementById('second_long').value;
        console.log(first_lat,first_long,second_lat,second_long);
        var map;
    function initMap() {
        const center = {lat: 16.840431210023, lng: 96.17536188739223};
        const options = {zoom: 13, scaleControl: true, center: center};
        map = new google.maps.Map(
            document.getElementById('map'), options);


        // Locations of landmarks
        const firstLocation = {lat: parseFloat(first_lat) , lng: parseFloat(first_long) };
        if(second_lat != 0)
        {
            var secondLocation = { lat: parseFloat(second_lat) , lng: parseFloat(second_long) };
        }
        // const firstLocation = {lat: 16.820056947085995, lng: 96.16883875494881};
        // const secondLocation = {lat: 16.855546180509904, lng: 96.24883295264097};


        // The markers for The firstLocation and The secondLocation Collection
        var mk1 = new google.maps.Marker({position: firstLocation, map: map});
         var mk2 = new google.maps.Marker({position: secondLocation, map: map});
        var line = new google.maps.Polyline({path: [firstLocation, secondLocation], map: map,strokeColor: "red",});

        // Calculate and display the distance between markers ,
        var distance = haversine_distance(mk1, mk2);
        document.getElementById('msg').innerHTML = distance.toFixed(2) + " mi.";

    }
    // Draw a line showing the straight distance between the markers

    function haversine_distance(mk1, mk2) {
      var R = 3958.8;
      var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
      var rlat2 = mk2.position.lat() * (Math.PI/180); // Convert degrees to radians
      var difflat = rlat2-rlat1; // Radian difference (latitudes)
      var difflon = (mk2.position.lng()-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

      var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
      return d;
    }
    // Calculate and display the distance between markers ,


</script>

@endsection
