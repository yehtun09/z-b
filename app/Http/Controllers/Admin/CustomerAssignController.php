<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Exports\CancelExport;
use App\Exports\PendingExport;
use App\Exports\SuspendExport;
use App\Models\CustomerAssign;
use App\Exports\CompletedExport;
use App\Exports\AllServiceExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreCustomerAssignRequest;
use App\Http\Requests\UpdateCustomerAssignRequest;
use App\Http\Requests\MassDestroyCustomerAssignRequest;

class CustomerAssignController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('customer_assign_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->whereNotNull('customer_assign')->whereNull('invoice_status');
            if($request->startDate){
                $invoices = $invoices->where('assign_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
            }
            if($request->endDate){
                $invoices = $invoices->where('assign_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
            }
            $invoices = $invoices->orderBy('assign_date','asc')->get();
        } else {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                    $query->whereHas('service_person', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    });
                })
                ->whereNull('invoice_status');
                if($request->startDate){
                    $invoices = $invoices->where('assign_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
                }
                if($request->endDate){
                    $invoices = $invoices->where('assign_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
                }
                $invoices = $invoices->orderBy('assign_date','asc')->get();
        }
        if($request->ajax()){
            return response()->json([
                'invoices' => $invoices,
            ]);
        }
        return view('admin.customerAssigns.index', compact('invoices'));
    }

    public function allServiceExport(Request $request)
    {
        try{
            return Excel::download(new AllServiceExport($request->startDate,$request->endDate), 'all-service.xlsx');
        }catch(\Exception $e){
            return back()->with('err',$e->getMessage());
        }
    }

    public function create()
    {
        abort_if(Gate::denies('customer_assign_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_people = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.customerAssigns.create', compact('service_people'));
    }

    public function store(StoreCustomerAssignRequest $request)
    {
        // return $request->all();
        if($request->service_area == null){
            $request['service_area'] = $request->township.'/'.$request->address;
        }

        $customerAssign = CustomerAssign::create($request->all());
        Invoice::find($request->invoice_id)->update([
            'customer_assign' => $customerAssign->id,
            'assign_date'     => date('Y-m-d'),
            'user_id'         => $request->service_person_id,
        ]);
        return redirect()->route('admin.customer-assigns.index');
    }

    public function edit(CustomerAssign $customerAssign)
    {
        abort_if(Gate::denies('customer_assign_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_people = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customerAssign->load('service_person', 'created_by');

        return view('admin.customerAssigns.edit', compact('customerAssign', 'service_people'));
    }

    public function update(UpdateCustomerAssignRequest $request, CustomerAssign $customerAssign)
    {
        $customerAssign->update($request->all());

        return redirect()->route('admin.customer-assigns.index');
    }

    public function show(CustomerAssign $customerAssign)
    {
        abort_if(Gate::denies('customer_assign_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerAssign->load('service_person', 'created_by');

        return view('admin.customerAssigns.show', compact('customerAssign'));
    }

    public function destroy(CustomerAssign $customerAssign)
    {
        abort_if(Gate::denies('customer_assign_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerAssign->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerAssignRequest $request)
    {
        CustomerAssign::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function changeAction(Request $request)
    {
        // dd($request->all());
        if (request()->action_id == '1' || request()->action_id == '3') {
            $invoice_id = $request->invoice_id;
            $action_id = $request->action_id;
            $suspend_date = $request->suspend_date;
            $invoice = Invoice::find($invoice_id);
            if($invoice){
                $invoice->update([
                    'invoice_status' => $action_id,
                    'suspend_date' => $suspend_date,
                    'remark'       => $request->remark,
                ]);
            }else{
                return back()->with('err','Please wait to finish loading and click again.');
            }
        }
        else if (request()->action_id == '4') {
            // dd($request->all());
            $invoice_id = $request->invoice_id;
            $action_id = $request->action_id;
            Invoice::where('id', $invoice_id)->update([
                'invoice_status' => $action_id,
                'finished_date' => Carbon::now()->format('Y-m-d'),
                'remark'       => $request->remark,
            ]);
            $invoice = Invoice::where('id', $invoice_id)->first();
            if($invoice){
            foreach ($invoice->products as $product) {
                $product->update([
                    'stock_qty' => $product->stock_qty + $product->pivot->qty
                ]);
            }
            }else{
                return back()->with('err','Please wait to finish loading and click again.');
            }
        }else{
            $invoice_id = $request->invoice_id;
            $action_id = $request->action_id;
            $invoice = Invoice::find($invoice_id);
            if($invoice){
            $invoice->update([
                'invoice_status' => $action_id,
                'finished_date' => Carbon::now()->format('Y-m-d'),
                'remark'       => $request->remark,
            ]);
            }else{
                return back()->with('err','Please wait to finish loading and click again.');
            }
        }

        // return redirect()->route('admin.customer-assigns.index');
        return back();
    }

    public function changeActionRestore($id)
    {
        if($id){
            $invoice_id = $id;

            Invoice::where('id', $invoice_id)->update([
                'invoice_status' => null,
                'suspend_date' => null,
                'finished_date' => null,
                'remark'       => 'restore',
            ]);
            return redirect()->route('admin.customer-assigns.index');
        }else{
            return back()->with('err','Please wait to finish loading and click again.');
        }
    }

    public function showPending(Request $request)
    {
        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->where('invoice_status', '1');
            if($request->startDate){
                $invoices = $invoices->where('suspend_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
            }
            if($request->endDate){
                $invoices = $invoices->where('suspend_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
            }
            $invoices = $invoices->orderBy('assign_date','asc')->get();
        } else {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                    $query->whereHas('service_person', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    });
                })
                ->where('invoice_status', '1');
                if($request->startDate){
                    $invoices = $invoices->where('suspend_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
                }
                if($request->endDate){
                    $invoices = $invoices->where('suspend_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
                }
                $invoices = $invoices->orderBy('assign_date','asc')->get();
        }

        if($request->ajax()){
            return response()->json([
                'invoices' => $invoices,
            ]);
        }
        return view('admin.customerAssigns.pending', compact('invoices'));
    }

    public function pendingExport(Request $request)
    {
        try{
            return Excel::download(new PendingExport($request->startDate,$request->endDate), 'pending-invoice.xlsx');
        }catch(\Exception $e){
            return back()->with('err',$e->getMessage());
        }
    }

    public function showCompleted(Request $request)
    {
        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->where('invoice_status', '2');
            if($request->startDate){
                $invoices = $invoices->where('finished_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
            }
            if($request->endDate){
                $invoices = $invoices->where('finished_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
            }
            $invoices = $invoices->orderBy('assign_date','asc')->get();
        } else {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                    $query->whereHas('service_person', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    });
                })
                ->where('invoice_status', '2');
                if($request->startDate){
                    $invoices = $invoices->where('finished_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
                }
                if($request->endDate){
                    $invoices = $invoices->where('finished_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
                }
                $invoices = $invoices->orderBy('assign_date','asc')->get();
        }

        if($request->ajax()){
            return response()->json([
                'invoices' => $invoices,
            ]);
        }

        return view('admin.customerAssigns.completed', compact('invoices'));
    }

    public function completedExport(Request $request)
    {
        try{
            return Excel::download(new CompletedExport($request->startDate,$request->endDate), 'completed-invoice.xlsx');
        }catch(\Exception $e){
            return back()->with('err',$e->getMessage());
        }
    }

    public function showSuspend(Request $request)
    {
        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->where('invoice_status', '3');
            if($request->startDate){
                $invoices = $invoices->where('suspend_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
            }
            if($request->endDate){
                $invoices = $invoices->where('suspend_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
            }
            $invoices = $invoices->orderBy('assign_date','asc')->get();
        } else {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                    $query->whereHas('service_person', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    });
                })
                ->where('invoice_status', '3');
                if($request->startDate){
                    $invoices = $invoices->where('suspend_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
                }
                if($request->endDate){
                    $invoices = $invoices->where('suspend_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
                }
                $invoices = $invoices->orderBy('assign_date','asc')->get();
        }

        if($request->ajax()){
            return response()->json([
                'invoices' => $invoices,
            ]);
        }
        return view('admin.customerAssigns.suspend', compact('invoices'));
    }

    public function suspendExport(Request $request)
    {
        try{
            return Excel::download(new SuspendExport($request->startDate,$request->endDate), 'suspended-invoice.xlsx');
        }catch(\Exception $e){
            return back()->with('err',$e->getMessage());
        }
    }

    public function showCancel(Request $request)
    {
        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->where('invoice_status', '4');
            if($request->startDate){
                $invoices = $invoices->where('finished_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
            }
            if($request->endDate){
                $invoices = $invoices->where('finished_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
            }
            $invoices = $invoices->orderBy('assign_date','asc')->get();
        } else {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                    $query->whereHas('service_person', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    });
                })
                ->where('invoice_status', '4');
                if($request->startDate){
                    $invoices = $invoices->where('finished_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$request->startDate))));
                }
                if($request->endDate){
                    $invoices = $invoices->where('finished_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$request->endDate))));
                }
                $invoices = $invoices->orderBy('assign_date','asc')->get();
        }
        if($request->ajax()){
            return response()->json([
                'invoices' => $invoices,
            ]);
        }
        return view('admin.customerAssigns.cancel', compact('invoices'));
    }

    public function cancelExport(Request $request)
    {
        try{
            return Excel::download(new CancelExport($request->startDate,$request->endDate), 'cancel-invoice.xlsx');
        }catch(\Exception $e){
            return back()->with('err',$e->getMessage());
        }
    }
}
