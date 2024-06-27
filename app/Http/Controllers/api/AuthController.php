<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        Validator($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|confirmed'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['status'=>200 ,'access_token'=>$token, 'token_type'=>'Bearer']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['status'=>401,'message'=>'Unauthorized']);
        }
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['status'=>200 ,'access_token'=>$token, 'token_type'=>'Bearer']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status'=>200 , 'message'=>'Token removed']);
    }

    public function user(Request $request)
    {
        $id = $request->user()->id;
        $user = User::with(['photos','role'=>function($q)
        {
            $q->with(['permissions'=>function($q){
                $q->with('page');
            }]);
        }])->find($id);
        $setting = GeneralSetting::with('font')->first();
        return response()->json(['status'=>200 , 'user'=>$user, 'setting'=>$setting]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>'Invalid email format']);
        }
        $user = User::where('email',$request->email)->first();
        if (!$user) {
            return response()->json(['message'=>'We cant find user with that e-mail address']);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $to_email = $request->email;
        $subject = 'Reset Password Notification';
        $from_email = 'bahrimohamedamin7@gmail.com';
        $name = $user->name;
        $data = array('name'=>$name,'token'=>$token);
        Mail::send('emails.mail',$data,function ($message) use($to_email, $subject, $from_email) {
           $message->to($to_email)->subject($subject);
           $message->from($from_email);
        });
        return response()->json(['status'=>200 , 'message'=>'email sent']);
    }

    public function resetPass(Request $request)
    {
        $id = $request->user()->id;
        $user = User::find($id)->update(['password'=>bcrypt($request->password)]);
        return response()->json(['status'=>200 , 'message'=>'password change success']);
    }

    public function userUpdate(Request $request)
    {
        $id = $request->user()->id;
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>['required',Rule::unique('users')->ignore($id,'id')],
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>'Invalid email format']);
        }
        $user = User::find($id)->update([
            'name'=>$request->name,
            'father_name'=>$request->father_name,
            'email'=>$request->email,
            'date_of_birth'=>$request->date_of_birth,
            'mobile'=>$request->mobile,
        ]);

        return response()->json(['status'=>200 , 'message'=>'user change success']);
    }

    public function profileUplaod(Request $request)
    {
        $user = User::find($request->id);
        $file = $request->file('file');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move('images/user',$fileName);
        $user->update([
            'photo'=>$fileName,
        ]);
        UserPhoto::create([
            'user_id'=>$request->id,
            'photo'=>$fileName,
        ]);
        return response()->json(['status'=>200 , 'path'=>$fileName, 'message'=>'success image upload']);
    }

    public function deletePhoto(Request $request)
    {
        $photo = UserPhoto::find($request->id);
        $photo->delete();
        return response()->json(['status'=>200 , 'message'=>'success image delete']);
    }

    public function selectPhoto(Request $request)
    {
        $photo = UserPhoto::find($request->id);
        $user = User::find($request->user()->id);
        $user->update([
            'photo'=>$photo->photo,
        ]);
        return response()->json(['status'=>200 , 'message'=>'success image select ']);
    }
}
