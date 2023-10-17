<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchiveRequest;
use App\Http\Requests\UpdateArchiveRequest;
use App\Models\Archive;
use Inertia\Inertia;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $archives = Archive::with('archivable')->get();

        return Inertia::render('Archive/Index', ['archives' => $archives]);
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
    public function store(StoreArchiveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Archive $archive)
    {
        $model = $archive->archivable;
        $props = app($archive->archivable_type)->resolve();

        return Inertia::render($props['view'], [$props['data'] => $model]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArchiveRequest $request, Archive $archive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Archive $archive)
    {
        //
    }
}
