<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AppFont;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppFontController extends Controller
{
    public function index()
    {
        if (!get_permissions('fonts','read')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to read fonts']);
        }
        $fonts = AppFont::get();
        return response()->json(['fonts'=>$fonts,'message'=>'sucess get fonts']);
    }

    public function store(Request $request)
    {
        $file = $request->file_font;
        if ($request->id) {
            if (!get_permissions('fonts','update')) {
                return response()->json(['status'=>401,'message'=>'you are not allowed to update fonts']);
            }
            $request->validate([
                'name_font'=>['required',Rule::unique('app_fonts')->ignore($request->id,'id'),]
            ]);
            if ($file) {
                $fileName = $request->name_font.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('app-assets/fonts'),$fileName);
                $path = 'app-assets/fonts'.$fileName;
            } else {
                $path = $request->path;
            }
            AppFont::find($request->id)->update([
                'name_font'=>$request->name_font,
                'path'=>$path
            ]);
            return response()->json(['message'=>'font updated sucessfully']);
        }
        $request->validate([
            'name_font'=>'required',
        ]);
        if (!get_permissions('fonts','create')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to create fonts']);
        }
        $fileName = $request->name_font.'.'.$file->getClientOriginalExtension();
        $file->move(public_path('app-assets/fonts'),$fileName);
        $path = 'app-assets/fonts'.$fileName;
        $font = AppFont::create([
            'name_font'=>$request->name_font,
            'path'=>$path,
        ]);

        return response()->json(['font'=>$font,'message'=>'font created sucessfully']);
    }

}
