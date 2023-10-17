<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        $statuses = Status::orderBy('is_active', 'desc')->orderBy('description', 'asc')->get();

        return Inertia::render('Status/Index', ['statuses' => $statuses]);

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
    public function store(StoreStatusRequest $request)
    {
        $status = new Status();

        $status->fill($request->validated());

        $status->save();

        return redirect()->action([StatusController::class, 'show'], $status);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Status $status)
    {
        //
    }
}
