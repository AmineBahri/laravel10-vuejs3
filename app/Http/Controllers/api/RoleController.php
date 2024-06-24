<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        if (!get_permissions('roles','read')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to read roles']);
        }
        $roles = Role::get();
        return response()->json(['roles'=>$roles,'message'=>'success get roles']);
    }

    public function store(Request $request)
    {
        if ($request->id) {
            if (!get_permissions('roles','update')) {
                return response()->json(['status'=>401,'message'=>'you are not allowed to update roles']);
            }
            $request->validate([
                'name_role'=>['required',Rule::unique('roles')->ignore($request->id,'id'),]
            ]);
            Role::find($request->id)->update([
                'name_role'=>$request->name_role,
            ]);
            return response()->json(['message'=>'role updated successfully']);
        }
        $request->validate([
            'name_role'=>'required'
        ]);
        if (!get_permissions('roles','create')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to create roles']);
        }
        $role = Role::create([
            'name_role'=>$request->name_role,
        ]);

        return response()->json(['role'=>$role,'message'=>'role created successfully']);
    }

}
