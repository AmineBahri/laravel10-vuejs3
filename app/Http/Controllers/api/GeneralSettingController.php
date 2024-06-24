<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!get_permissions('generalSettings','read')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to read general Settings']);
        }
        $generalSettings = GeneralSetting::get();
        return response()->json(['generalSettings'=>$generalSettings,'message'=>'success get general Settings']);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file_image;
        if ($request->id) {
            if (!get_permissions('generalSettings','update')) {
                return response()->json(['status'=>401,'message'=>'you are not allowed to update generalSettings']);
            }
            $request->validate([
                'name'=>['required',Rule::unique('general_settings')->ignore($request->id,'id'),]
            ]);
            if ($file) {
                $fileName = $request->name.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('app-assets/images'),$fileName);
                $logo = 'app-assets/images/'.$fileName;
            } else {
                $logo = $request->logo;
            }
            GeneralSetting::find($request->id)->update([
                'name'=>$request->name,
                'font_id'=>$request->font_id,
                'font_size'=>$request->font_size,
                'email'=>$request->email,
                'facebook'=>$request->facebook,
                'youtube'=>$request->youtube,
                'logo'=>$logo
            ]);
            return response()->json(['message'=>'generalSettings updated successfully']);
        }
        $request->validate([
            'name'=>'required',
        ]);
        if (!get_permissions('generalSettings','create')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to create generalSettings']);
        }
        $fileName = $request->name.'.'.$file->getClientOriginalExtension();
        $file->move(public_path('app-assets/images'),$fileName);
        $logo = 'app-assets/images/'.$fileName;
        $generalSettings = GeneralSetting::create([
            'name'=>$request->name,
            'font_id'=>$request->font_id,
            'font_size'=>$request->font_size,
            'email'=>$request->email,
            'facebook'=>$request->facebook,
            'youtube'=>$request->youtube,
            'logo'=>$logo,
        ]);

        return response()->json(['generalSettings'=>$generalSettings,'message'=>'generalSettings created successfully']);
    }

}
