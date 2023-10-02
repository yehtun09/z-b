<?php

namespace App\Http\Controllers\Admin;


use Gate;

use App\Models\ServicePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreServicePlanRequest;
use App\Http\Requests\UpdateServicePlanRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyProductRequest;

class ServicePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('service_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_plans = ServicePlan::get();

        return view('admin.servicePlans.index', compact('service_plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('service_plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_plans = ServicePlan::pluck('service_plan', 'id');

        return view('admin.servicePlans.create', compact('service_plans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicePlanRequest $request)
    {
        //
        $service_plan = ServicePlan::create($request->all());

        return redirect()->route('admin.service_plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ServicePlan $service_plan)
    {
        //
        abort_if(Gate::denies('service_plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.servicePlans.show', compact('service_plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicePlan $service_plan)
    {
        //
        abort_if(Gate::denies('service_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.servicePlans.edit', compact('service_plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicePlanRequest $request, ServicePlan $service_plan)
    {
        //
        $service_plan->update($request->all());

        return redirect()->route('admin.service_plans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicePlan $service_plan)
    {
        //
        abort_if(Gate::denies('service_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_plan->delete();

        return back();
    }
}
