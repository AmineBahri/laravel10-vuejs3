<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        if (!get_permissions('pages','read')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to read pages']);
        }
        $pages = Page::with(['pages','page_name','permissions'])->orderBy('order','asc')->get();
        return response()->json(['pages'=>$pages,'message'=>'sucess get pages']);
    }

    public function store(Request $request)
    {
        if ($request->id) {
            if (!get_permissions('pages','update')) {
                return response()->json(['status'=>401,'message'=>'you are not allowed to update pages']);
            }
            $request->validate([
                'page'=>['required',Rule::unique('pages')->ignore($request->id,'id'),]
            ]);
            Page::find($request->id)->update([
                'page'=>$request->page,
                'icon'=>$request->icon,
                'path'=>$request->path,
                'order'=>$request->order,
                'page_id'=>$request->page_id,
            ]);
            return response()->json(['message'=>'page updated sucessfully']);
        }
        $request->validate([
            'page'=>'required|string|unique:pages'
        ]);
        if (!get_permissions('pages','create')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to create pages']);
        }
        $page = Page::create([
            'page'=>$request->page,
            'icon'=>$request->icon,
            'path'=>$request->path,
            'order'=>$request->order,
            'page_id'=>$request->page_id,
        ]);

        return response()->json(['page'=>$page,'message'=>'page created sucessfully']);
    }
}
