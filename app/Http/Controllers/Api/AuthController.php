<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\JwtToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'password' => 'required',
        ]);
        $secretApiKey = $request->header('authorization');

        if($validator->fails()){
            return $this->sendBadRequest($validator->messages());
        }

        $credentials = $request->only('phone','password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role===2 && Auth::user()->is_active===1) {
                if ($secretApiKey==config('services.api_secret_key')) {
                    $token = JwtToken::setData([
                        'id' => Auth::user()->id
                    ])
                    ->build();
                    return $this->sendSuccess($token);
                }else{
                    return $this->sendBadRequest("API key tidak valid");
                }

            }else{
                return $this->sendBadRequest("Anda tidak memiliki hak akses untuk login");
            }

        }else{
            return $this->sendBadRequest("Login gagal");
        }

    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendBadRequest($validator->messages());
        }

        User::create([
            'role'=>2,
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
            'phone'=>preg_replace('/[^0-9]/', '', $request->phone)
        ]);

        return $this->sendMessage("Berhasil registrasi");
    }

    public function logout(){
        JwtToken::blacklist();
        return $this->sendSuccess("Berhasil logout");
    }

    public function forgetPassword(){
        $adminPhone = User::find(1)->phone;
        return $this->sendSuccess($adminPhone);
    }
}
