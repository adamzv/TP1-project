<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RolesController
 *
 * @author lacal
 */
class RolesController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api', ['scopes: admin-user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Role
     */
    public function index()
    {
        return Role::orderBy('type', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return Role
     */
    public function store(StoreRoleRequest $request)
    {
        return Role::create($request->only(['type']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Role
     */
    public function show($id)
    {
        return Role::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRoleRequest $request
     * @param int $id
     * @return Role
     */
    public function update(StoreRoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->only(['type']));
        return $role;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete Role with cascade
        Role::findOrFail($id)->delete();

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
