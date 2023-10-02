<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomerExport;
use App\Http\Controllers\Controller;
use App\Exports\ExportCustomer;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\ServiceType;
use App\Models\ServicePlan;
use App\Models\Township;
use App\Models\CustomerLocation;
use Gate;
use Excel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->roles->pluck('title')[0]);
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        if(auth()->user()->roles->pluck('title')[0] == 'Engineer'){
            $customers = Customer::with(['service_type','service_plan','customerNameInvoices','township','created_by'])
            ->orderBy('created_at','asc')
            ->whereHas('customerNameInvoices',function($q){
                $q->where('user_id',auth()->user()->id);
            })->get();
        }else{
            $customers = Customer::with(['service_type','service_plan','customerNameInvoices','township','created_by'])->orderBy('created_at','asc')->get();
        }
    //    return $customers;
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $service_types = ServiceType::get();
        $service_plans = ServicePlan::get();
        $townships   = Township::get();
        return view('admin.customers.create', compact('service_types','service_plans','townships'));
    }

    public function store(Request $request)
    {

        // return $request->all();
        $validatedData = $request->validate([
            // Validate other customer fields here
            // 'register_date'     =>'required',
            // 'sales_voucher_no'  =>'required',
            // 'service_type_id'   =>'required',
            // 'name'              =>'required',
            // 'service_plan_id'   =>'required',
            // 'township_id'       =>'required',
            'site_lat'      => 'required',
            'site_long'     => 'required',
        ]);
        // $customerData = [
        //     'sales_voucher_no' => $request->get('sales_voucher_no' , '-'),
        //     'customer_code' => $request->get('customer_code', '-'),
        //     'address' => $request->get('address', '-'),
        //     'name' => $request->get('name', '-'),
        //     'contact_person' => $request->get('contact_person', '-'),
        //     'phone_number' => $request->get('phone_number', '-'),
        //     'ticket_no' => $request->get('ticket_no', '-'),
        //     'service_type_id' => $request->get('service_type_id', null),
        //     'service_plan_id' => $request->get('service_plan_id', null),
        //     'register_date' => $request->get('register_date', '-'),
        //     'bandwidth' => $request->get('bandwidth', '-'),
        //     'site_lat' => $request->get('site_lat', '-'),
        //     'site_long' => $request->get('site_long', '-'),
        //     'township_id' => $request->get('township_id', null),
        // ];

        // return $customerData;
        $customer = Customer::create($request->all());


        $locations = [];
        $latitudes = $request->input('area_site_lat', []);

        $longitudes = $request->input('area_site_long', []);

        foreach ($latitudes as $index => $latitude) {

           $customer->location()->create(['area_site_lat'=>$latitude,'area_site_long' => $longitudes[$index]]);
        }
        // dd($locations);
        //   dd("don");
        // $customer->location()->saveMany($locations);

        return redirect()->route('admin.customers.index');
    }

    public function edit(Customer $customer)
    {
        abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $customer->load('township','location','created_by');

        $service_types = ServiceType::get();
        $service_plans = ServicePlan::get();
        $townships = Township::get();
        $locationInfos = CustomerLocation::where('customer_id',$customer->id)->get();
        // dd($locationInfo);
        return view('admin.customers.edit', compact('customer','townships','service_types','service_plans','locationInfos'));
    }

    public function update(Request $request, Customer $customer)
    {
        // dd($request->all());
        $customer->update($request->all());

        $locations = [];
        $latitudes = $request->input('area_site_lat', []);
        // dd($latitudes);
        $longitudes = $request->input('area_site_long',[]);
        // dd($longitudes);
        $customer->location()->delete();
        foreach($latitudes as $index =>$latitude){
            $customer->location()->create(['area_site_lat'=>$latitudes[$index],'area_site_long' => $longitudes[$index]]);
        }

        return redirect()->route('admin.customers.index');
    }

    public function show(Customer $customer)
    {

        // return $customer->load('created_by', 'customerNameInvoices','service_type','service_plan','township');

        // return $customer->site_lat;

        abort_if(Gate::denies('customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->load('created_by', 'customerNameInvoices','service_type','service_plan','township');

        if(request()->ajax()){
            return response()->json([
                'customer' => $customer
            ]);
        }


        $initialMarkers  = $customer->location()->get();


        if(
            isset($initialMarkers[0]['position']['lat']) &&
            isset($initialMarkers[0]['position']['lng']) &&
            isset($initialMarkers[1]['position']['lat']) &&
            isset($initialMarkers[1]['position']['lng'])
          ) {

            $lat1 = $initialMarkers[0]['position']['lat'];
            $lon1 = $initialMarkers[0]['position']['lng'];
            $lat2 = $initialMarkers[1]['position']['lat'];
            $lon2 = $initialMarkers[1]['position']['lng'];

            $meters = $this->getDistance($lat1, $lon1, $lat2, $lon2);

          } else {
            $meters = 0;
          }


        //  return $initialMarkers;
        //  dd($customer->customerNameInvoices->first()->odb_long);
        return view('admin.customers.show', compact('customer','initialMarkers','meters'));
    }

    public function destroy(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->delete();

        $customers = Customer::with(['created_by'])->orderBy('created_at','asc')->get();

        return response()->json([
            'customers' => $customers,
        ]);
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Customer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function showTrash()
    {
        $customers = Customer::onlyTrashed()->orderBy('created_at','asc')->paginate(10);
        return view('admin.customers.trashList', compact('customers'));
    }

    public function restoreTrash($id)
    {
        $customer = Customer::withTrashed()->find($id)->restore();
        return redirect()->route('admin.customers.index');
    }

    public function getInfo(Request $request){
        return Customer::find($request->id);
    }


    //this function calculate distance

    function getDistance($lat1, $lon1, $lat2, $lon2) {
        $radius = 6371; // Radius of earth in km
        $dLat = deg2rad($lat2-$lat1);
        $dLon = deg2rad($lon2-$lon1);

        $a =
          sin($dLat/2) * sin($dLat/2) +
          cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
          sin($dLon/2) * sin($dLon/2)
          ;

        $c = 2 * asin(sqrt($a));
        $d = $radius * $c; // Distance in km
        return $d;
    }


    public function export()
    {
        return Excel::download(new CustomerExport, 'stocks.xlsx');
    }

    public function import(Request $request)
    {
        // return $request->all();
        Excel::import(new CustomerImport, $request->file);

        return redirect()->back();
    }

}
