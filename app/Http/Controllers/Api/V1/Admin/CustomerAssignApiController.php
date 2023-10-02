<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\CustomerAssign;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreCustomerAssignRequest;
use App\Http\Requests\UpdateCustomerAssignRequest;
use App\Http\Resources\Admin\CustomerAssignResource;

class CustomerAssignApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_assign_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Auth::user()->roles[0]->title== "Admin") {
            $invoices = Invoice::whereNotNull('customer_assign')->whereNull('invoice_status')->get();
        } else {
            $invoices = Invoice::whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })
            ->whereNull('invoice_status')
            ->get();
        }
        return CustomerAssignResource::collection($invoices);
    }

    public function store(StoreCustomerAssignRequest $request)
    {
        $customerAssign = CustomerAssign::create($request->all());

        return (new CustomerAssignResource($customerAssign))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomerAssign $customerAssign)
    {
        abort_if(Gate::denies('customer_assign_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerAssignResource($customerAssign->load(['service_person', 'created_by']));
    }

    public function update(UpdateCustomerAssignRequest $request, CustomerAssign $customerAssign)
    {
        $customerAssign->update($request->all());

        return (new CustomerAssignResource($customerAssign))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomerAssign $customerAssign)
    {
        abort_if(Gate::denies('customer_assign_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerAssign->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function changeAction(Request $request)
    {
        if (request()->action_id != '3') {
            $invoice_id = $request->invoice_id;
            $action_id = $request->action_id;
            $invoice = Invoice::find($invoice_id);
            $invoice->update([
                'invoice_status' => $action_id
            ]);
        } else {
            $invoice_id = request()->invoice_id;
            $action_id = request()->action_id;
            Invoice::where('id', $invoice_id)->update([
                'invoice_status' => $action_id
            ]);
            $invoice = Invoice::where('id', $invoice_id)->first();
            CustomerAssign::where('id', $invoice->customer_assign)->update([
                'created_at' => request()->date
            ]);
        }

        return response()->json([
            'message' => 'Assigned successfully'
        ],200);
    }

    public function showCompleted()
    {
        if (Auth::user()->roles[0]->title == "Admin") {
            $invoices = Invoice::where('invoice_status', '2')->get();
        } else {
            $invoices = Invoice::whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })->where('invoice_status', '2')
            ->get();
        }
        return CustomerAssignResource::collection($invoices);
    }

    public function showSuspend()
    {
        if (Auth::user()->roles[0]->title == "Admin") {
            $invoices = Invoice::where('invoice_status', '3')->get();
        } else {
            $invoices = Invoice::whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })
                ->where('invoice_status', '3')
                ->get();
        }
        return CustomerAssignResource::collection($invoices);
    }
}
