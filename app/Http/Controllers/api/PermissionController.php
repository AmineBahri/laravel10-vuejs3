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
        $pageId = Page::where('page','permissions')->value('id');
        if (!auth()->user()->role->permissions()->where('page_id',$pageId)->where('read',1)->exists()) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to read permissions']);
        }
        $permissions = Permission::where('role_id',$roleId)->get();
        return response()->json(['permissions'=>$permissions,'status'=>200,'message'=>'sucess get permissions']);
    }

    public function store(Request $request)
    {
        $pageId = Page::where('page','permissions')->value('id');
        if (!auth()->user()->role->permissions()->where('page_id',$pageId)->where('update',1)->exists()) {
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
            return response()->json(['status'=>200,'message'=>'sucess']);
        }
        $permission = Permission::create([
            'role_id'=>$request->role_id,
            'page_id'=>$request->page_id,
            $request->permission => $request->event
        ]);

        return response()->json(['status'=>200,'message'=>'sucess']);
    }
}
