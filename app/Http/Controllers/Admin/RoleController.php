<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $roles = Role::all();
            return view('admin.roles.index', compact('roles'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name',
            ]);
            if ($validator->fails()) {
                Alert::error('message', $validator->errors()->first());
                return redirect()->back();
            }
            Role::create(['name' => $request->name]);
            Alert::success('Success', 'Role created successfully');
            return redirect()->route('roles.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        try{
            $request->validate([
                'name' => 'required|unique:roles,name,'.$role->id,
            ]);

            $role->update(['name' => $request->name]);
            Alert::success('Success', 'Role updated successfully');
            return redirect()->route('roles.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try{
            $role->delete();
            Alert::success('Success', 'Role deleted successfully');
            return redirect()->route('roles.index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
