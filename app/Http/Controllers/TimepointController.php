<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimepointRequest;
use App\Http\Requests\UpdateTimepointRequest;
use App\Models\Timepoint;
use Inertia\Inertia;
use Inertia\Response;

class TimepointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $timepoints = Timepoint::all();

        return Inertia::render('Timepoint/Index', ['timepoints' => $timepoints]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimepointRequest $request)
    {
        $timepoint = new Timepoint();

        $timepoint->fill($request->validated());

        $timepoint->save();

        return redirect()->action([TimepointController::class, 'show'], $timepoint);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timepoint $timepoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timepoint $timepoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimepointRequest $request, Timepoint $timepoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Timepoint $timepoint)
    {
        //
    }
}
