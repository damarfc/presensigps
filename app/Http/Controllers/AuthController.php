<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if(Auth::guard('perangkat_desa')->attempt(['PD_ID'=> $request->PD_ID,'password'=>$request->password])){
            return redirect('/dashboard');
        }else{
            return redirect('/')->with(['warning' => 'Username / Password Salah!']);
        }
    }

    public function proseslogout()
    {
        if(Auth::guard('perangkat_desa')->check()){
            Auth::guard('perangkat_desa')->logout();
            return redirect('/');
        }

    }

    public function prosesloginadmin(Request $request)
    {
        if(Auth::guard('user')->attempt(['email'=> $request->email,'password'=>$request->password])){
            return redirect('/panel/dashboardadmin');
        }else{
            return redirect('/panel')->with(['warning' => 'Username / Password Salah!']);
        }
    }

    public function proseslogoutadmin() 
    {
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }
    
}
