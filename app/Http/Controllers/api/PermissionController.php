<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Page;

class PermissionController extends Controller
{
    public function index($roleId)
    {
        if (!get_permissions('permissions','read')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to read permissions']);
        }
        $permissions = Permission::where('role_id',$roleId)->get();
        return response()->json(['permissions'=>$permissions,'status'=>200,'message'=>'success get permissions']);
    }

    public function store(Request $request)
    {
        if (!get_permissions('permissions','update')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to update permissions']);
        }
        $request->validate([
            'role_id'=>'required',
            'page_id'=>'required',
        ]);
        $permission = Permission::where('role_id',$request->role_id)->where('page_id',$request->page_id);
        $count = $permission->count();
        if ($count>0) {
            $permission->update([$request->permission => $request->event]);
            return response()->json(['status'=>200,'message'=>'success']);
        }
        if (!get_permissions('permissions','create')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to create permissions']);
        }
        $permission = Permission::create([
            'role_id'=>$request->role_id,
            'page_id'=>$request->page_id,
            $request->permission => $request->event
        ]);

        return response()->json(['status'=>200,'message'=>'success']);
    }
}
