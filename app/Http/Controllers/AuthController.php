<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'role' => ['required']
        ]);
 
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            
            session([
                'nama' => Auth::user()->nama,
                'id_pengguna' => Auth::user()->id_pengguna
            ]);

            if($credentials['role'] == 'Admin'){
                return redirect()->intended('/admin');
            }

            if($credentials['role'] == 'Kasir'){
                return redirect()->intended('/kasir');
            }

            if($credentials['role'] == 'Pemilik'){
                return redirect()->intended('/pemilik');
            }
  
        }
 
        return back()->with('status', 'Login Gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}
