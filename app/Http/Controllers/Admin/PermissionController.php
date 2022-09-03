<?php
/*
 *  Project: blog
 *  Last Modified: 7/21/22, 5:04 PM
 * File Created: 7/21/22, 5:35 PM
 * File: PermissionController.php
 * Path: C:/wamp64/www/blogproject/app/Http/Controllers/Admin/Role/PermissionController.php
 * Class: PermissionController.php
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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete|add category', ['only' => ['index', 'create', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        ///  $user = Auth::user();
        // $user->givePermissionTo('add category');

        //return Auth::user()->roles;
        // dd(get_class_methods(Auth::user()));


        $data = [

            'roles' => Role::orderBy('name', 'asc')->paginate(5),
        ];
        return view('admin.role.permission.index')->with($data);
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
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->input('name')]);
//        AppFacade::generateActivityLog('pages', 'create');
        return redirect()->route('admin.permission.index')
            ->with('alert', [
                'type' => 'success',
                'message' => 'Permission inserted successful',
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $permission = Permission::orderBy('name', 'asc')->get();
        return view('admin.role.permission.create', compact('permission'));
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
            'rolePermissions' => Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                ->where("role_has_permissions.role_id", $id)
                ->get(),
            'title' => 'Permissions'
        ];

        return view('admin.role.permission.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $data = [
            'role' => Role::find($id),
            'permission' => Permission::get(),
            'rolePermissions' => DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all(),
        ];

        return view('admin.role.permission.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.permission.index')
            ->with('success', 'Role updated successfully');
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
        return redirect()->route('admin.permission.index')
            ->with('success', 'Role deleted successfully');
    }
}
