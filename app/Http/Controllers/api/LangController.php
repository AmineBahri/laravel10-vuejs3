<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function getI18n()
    {
        $langs = Lang::all();
        $messagesAr = $langs->where('lang','ar')->pluck('value','key');
        $messagesEn = $langs->where('lang','en')->pluck('value','key');
        $messagesFr = $langs->where('lang','fr')->pluck('value','key');
        $messagesTr = $langs->where('lang','tr')->pluck('value','key');
        return response()->json(['ar'=>$messagesAr,'fr'=>$messagesFr,'en'=>$messagesEn,'tr'=>$messagesTr]);
    }

    public function store(Request $request)
    {
        $langs = $request->refForm;
        if ($request->isEdit) {
            foreach ($langs as $key => $lang) {
                $translate = Lang::find($lang['id']);
                $translate['key'] = $request['keyValue'];
                $translate['value'] = $lang['value'];
                $translate->save();
            }
            return response()->json(['status'=>200,'message'=>'sucess updated']);
        } else{
            foreach ($langs as $key => $lang) {
                Lang::insert([
                    'key' => $request['keyValue'],
                    'value' => $lang['value'],
                    'lang' => $lang['lang'],
                ]);
            }
            return response()->json(['status'=>200,'message'=>'sucess created']);
        }
    }

    public function update($key)
    {
        $langs = Lang::where('key',$key)->orderBy('lang')->get();
        return response()->json(['succes'=>true,'langs'=>$langs]);
    }

    public function index(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $langs = Lang::where('key','like',"%{$search}%")->orWhere('value','like',"%{$search}%")->orderBy('key')->paginate(5);
        } else {
            $langs = Lang::orderBy('key')->paginate(5);
        }
        
        return response()->json(['succes'=>true,'langs'=>$langs]);
    }
}
