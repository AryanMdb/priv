<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class SubAdminController extends Controller
{
    public function index()
    {
        try {
            $subadmins = User::where('role', 'subadmin')->latest()->get();
            return view('admin.subadmins.index', compact('subadmins'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create()
    {
        // $permissions = Permission::all();
        // $groupedPermissions = $permissions->groupBy('main');
    
        $roles = Role::where('name', '!=', 'admin')->get();

        return view('admin.subadmins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->where(function ($query) {
                        $query->whereNull('deleted_at')->where('role', 'subadmin');
                    }),
                ],
            ]);

            if ($validator->fails()) {
                Alert::error('message', $validator->errors()->first());
                return redirect()->back();
            }
            $user = User::create([
                'name' => $request->name ?? '',
                'email' => $request->email ?? '',
                'role' => 'subadmin',
                'password' => $request->password,
            ]);

            $user->assignRole($request->role);

            // $permissionSlugs = $request->input('permissions', []);
            // $permissions = Permission::where('guard_name', 'web')
            //                       ->whereIn('slug', $permissionSlugs)
            //                       ->pluck('id')
            //                       ->toArray();

            // $user->syncPermissions($permissions);
            Alert::success('Success', 'Subadmin created successfully');
            return redirect()->route('subadmins.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::where('name', '!=', 'admin')->get();
            // $permissions = Permission::all();
            // $groupedPermissions = $permissions->groupBy('main');

            return view('admin.subadmins.edit', compact('user', 'roles'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->name = $request->name ?? '';
            $user->save();

            $user->syncRoles([$request->role]);

            // Sync the user's permissions
            // $permissionSlugs = $request->input('permissions', []);
            // $permissions = Permission::where('guard_name', 'web')
            //                       ->whereIn('slug', $permissionSlugs)
            //                       ->pluck('id')
            //                       ->toArray();

            // $user->syncPermissions($permissions);
            Alert::success('Success', 'Subadmin updated successfully');
            return redirect()->route('subadmins.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        if(isset($id) && !empty($id))
        {
            $user = User::findOrFail($id);
            $user->delete();
            $user->syncRoles([]);
            $user->syncPermissions([]);
            Alert::success('Success', 'Subadmin deleted successfully');
            return redirect()->route('subadmins.index')->with('success', 'Subadmin deleted successfully');
        } else {
            Alert::error('Failed', 'Subadmin deletion failed');
            return redirect()->back();
        }
    }
}
