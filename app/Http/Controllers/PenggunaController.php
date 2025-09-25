<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function getUser(Request $request)
    {
        $penggunas = Pengguna::select('*');

        if($request->query('search')){
            $search = $request->query('search');

            $penggunas->where('username', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        }

        $penggunas = $penggunas->paginate(9)->appends($request->query());;

        return view('admin_pengguna', compact('penggunas'), ['title' => 'Pengguna']);
    }

    public function addUser(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'role' => 'required'
        ]);

        $username = $validated['username'];
        $password = $validated['password'];

        $pengguna = Pengguna::where('username', $username)->first();

        if($pengguna){
            return redirect()->route('pengguna.getUser')->with('status', 'Username Sudah Terdaftar!');
        }

        Pengguna::create([
            'username' => $username,
            'password' => Hash::make($password),
            'nama' => $validated['nama'],
            'role' => $validated['role']
        ]);

        return redirect()->route('pengguna.getUser')->with('status', 'Data Berhasil Disimpan!');
    }

    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'role' => 'required'
        ]);

        $pengguna = Pengguna::where('id_pengguna', $id)->first();
        $pengguna->nama = $validated['nama'];
        $pengguna->role = $validated['role'];
        $pengguna->save();

        return redirect()->route('pengguna.getUser')->with('status', 'Data Berhasil Diupdate!');
    }

    public function destroyUser($id)
    {
        Pengguna::where('id_pengguna', $id)->delete();

        return redirect()->route('pengguna.getUser')->with('status', 'Data Berhasil Dihapus!');
    }

    public function findUser(Request $request)
    {
        $search = $request->input('data');

        $penggunas = Pengguna::where(function($query) use ($search){
        $query->where('username', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%");
        })->paginate(9);

        return response()->json($penggunas);
    }

}
