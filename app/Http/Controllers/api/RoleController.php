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
        $roles = Role::get();
        return response()->json(['roles'=>$roles,'message'=>'sucess get roles']);
    }

    public function store(Request $request)
    {
        if ($request->id) {
            $request->validate([
                'name_role'=>['required',Rule::unique('roles')->ignore($request->id,'id'),]
            ]);
            Role::find($request->id)->update([
                'name_role'=>$request->name_role,
            ]);
            return response()->json(['message'=>'role updated sucessfully']);
        }
        $request->validate([
            'name_role'=>'required'
        ]);
        $role = Role::create([
            'name_role'=>$request->name_role,
        ]);

        return response()->json(['role'=>$role,'message'=>'role created sucessfully']);
    }

}
