<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        if (!get_permissions('users','read')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to read users']);
        }
        $users = User::with('role')->paginate(10);
        return response()->json(['users'=>$users,'message'=>'sucess get users']);
    }

    public function store(Request $request)
    {
        if ($request->id) {
            if (!get_permissions('users','update')) {
                return response()->json(['status'=>401,'message'=>'you are not allowed to update users']);
            }
            User::find($request->id)->update([
                'name'=>$request->name,
                'father_name'=>$request->father_name,
                'gender'=>$request->gender,
                'mobile'=>$request->mobile,
                'date_of_birth'=>$request->date_of_birth,
                'email'=>$request->email,
                'role_id'=>$request->role_id,
            ]);
            return response()->json(['message'=>'sucess update user']);
        }
        if (!get_permissions('users','create')) {
            return response()->json(['status'=>401,'message'=>'you are not allowed to create users']);
        }
        User::create([
        	'name'=>$request->name,
        	'father_name'=>$request->father_name,
        	'gender'=>$request->gender,
        	'mobile'=>$request->mobile,
        	'date_of_birth'=>$request->date_of_birth,
        	'email'=>$request->email,
        	'password'=> bcrypt($request->password),
            'role_id'=>$request->role_id,
        ]);
        return response()->json(['message'=>'sucess create user']);
    }
}
