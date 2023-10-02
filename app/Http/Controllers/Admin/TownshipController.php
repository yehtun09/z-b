<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Township;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTownshipRequest;
use App\Http\Requests\UpdateTownshipRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class TownshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_if(Gate::denies('township_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $townships = Township::get();

        return view('admin.townships.index', compact('townships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_if(Gate::denies('township_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.townships.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTownshipRequest $request)
    {
        //
        $township = Township::create($request->all());

        return redirect()->route('admin.townships.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Township $township)
    {
        //
        abort_if(Gate::denies('township_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.townships.show', compact('township'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Township $township)
    {
        //
        abort_if(Gate::denies('township_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.townships.edit', compact('township'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTownshipRequest $request, Township $township)
    {
        //
        $township->update($request->all());

        return redirect()->route('admin.townships.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Township $township)
    {
        //
        abort_if(Gate::denies('township_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $township->delete();

        return back();
    }
}
