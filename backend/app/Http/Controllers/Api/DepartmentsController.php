<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DepartmentsController
 *
 * @author lacal
 */
class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Department
     */
    public function index()
    {
        return Department::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDepartmentRequest $request
     * @return Department
     */
    public function store(StoreDepartmentRequest $request)
    {
        return Department::create($request->only(['name', 'id_faculty']));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Department
     */
    public function show($id)
    {
        return Department::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreDepartmentRequest $request
     * @param int $id
     * @return Department
     */
    public function update(StoreDepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->only(['name', 'id_faculty']));
        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete Department
        Department::findOrFail($id)->delete();

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
