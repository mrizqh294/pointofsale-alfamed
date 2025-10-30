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
                'id_pengguna' => Auth::user()->id_pengguna,
                'role' => Auth::user()->role
            ]);

            if($credentials['role'] == 'Admin'){
                return redirect('/admin');
            }

            if($credentials['role'] == 'Kasir'){
                return redirect('/kasir');
            }

            if($credentials['role'] == 'Pemilik'){
                return redirect('/pemilik');
            }
        }
 
        return back()->with(['status'=>'Login Gagal!', 'pesan'=>'Periksa kombinasi username dan password anda!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
