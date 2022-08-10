<?php
/*
 *  Project: blog
 *  Last Modified: 7/21/22, 4:30 PM
 * File Created: 7/21/22, 5:35 PM
 * File: RoleController.php
 * Path: C:/wamp64/www/blogproject/app/Http/Controllers/Admin/Role/RoleController.php
 * Class: RoleController.php
 * Copyright (c) $year
 * Created by Ariful Islam
 *  This file is created and maintained by Mediasoft. You are not allowed to change or modify any part or fully without Mediasoft concern. All Rights Preserved By Mediasoft Data Systems Limited.
 *  If you have any query then knock me at
 *  arif98741@gmail.com
 *  See my profile @ https://github.com/arif98741
 *
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('permission:add role|edit role|delete role|view roles', ['only' => ['index', 'create', 'store']]);
        //$this->middleware('permission:role-create', ['only' => ['create','store']]);
        //$this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //$this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        /* $user = Auth::user();
         //  return $user->getAllPermissions();
         // $user->givePermissionTo('edit role');
         //    $role = Role::findByName('admin');
         // $role->givePermissionTo(['add role', 'delete role', 'edit role', 'view roles']);

         // return Auth::user();
         // dd(get_class_methods(Auth::user()));
 */
        $roles = Role::orderBy('name', 'ASC')->paginate(5);
        return view('admin.role.role.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));


        return redirect()->route('admin.role.index')->with('alert', [
            'type' => 'success',
            'message' => 'Role created successfully',
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $data = [
            'permission' => Permission::orderBy('name', 'asc')->get(),
            'title' => 'Add Role',

        ];
        return view('admin.role.role.create')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $data = [
            'role' => Role::find($id),
            'permission' => Permission::orderBy('name', 'asc')->get(),
            'rolePermissions' => Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                ->where("role_has_permissions.role_id", $id)
                ->get(),
            'title' => 'View Role',
        ];


        return view('admin.role.role.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {

        $data = [
            'role' => Role::find($id),
            'permission' => Permission::orderBy('name', 'asc')->get(),
            'rolePermissions' => DB::table("role_has_permissions")
                ->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all(),
            'title' => 'Edit Role',
        ];

        return view('admin.role.role.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.role.index')->with('alert', [
            'type' => 'success',
            'message' => 'Role updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();

        return redirect()->route('admin.role.index')->with('alert', [
            'type' => 'success',
            'message' => 'Role deleted successfully',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function assignPermission(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);

        $role = Role::findById($request->role_id);
        try {
            $role->givePermissionTo($request->role_name);
            return \response()->json([
                'success' => true,
                'message' => 'Permission assigned successfully'
            ]);
        } catch (PermissionDoesNotExist|PermissionAlreadyExists $e) {
            return \response()->json([
                'success' => false,
                'message' => 'Failed to assign permission ',
            ]);
        }


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function deletePermission(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);

        try {
            DB::table('role_has_permissions')->where([
                'permission_id' => $request->permission_id,
                'role_id' => $request->role_id,
            ])->delete();
            return \response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully'
            ]);
        } catch (PermissionDoesNotExist|PermissionAlreadyExists $e) {
            return \response()->json([
                'success' => false,
                'message' => 'Failed to delete permission. Unexpected error',
            ]);
        }


    }
}
