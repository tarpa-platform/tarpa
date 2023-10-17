<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\Permission;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $roles = Role::all();

        return Inertia::render('Role/Index', ["roles" => $roles]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {

        return Inertia::render('Role/Create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();

        $role = Role::create(['name' => $validated['name'], 'description' => $validated['description']]);

        $role->syncPermissions($validated['permissions']);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): Response
    {
        $permissions = $role->permissions->pluck('name');

        return Inertia::render('Role/Edit', ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        $role->fill($validated);

        $role->save();

        $role->syncPermissions($validated['permissions']);

        return redirect()->action([RoleController::class, 'show'], $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        //
    }
}
