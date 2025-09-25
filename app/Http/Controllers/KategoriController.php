<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{

    public function getCategory(Request $request)
    {
        $kategories = Kategori::select('*');

        if($request->query('search')){
            $search = $request->query('search');

            $kategories->where('kode', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%");
        }

        $kategories = $kategories->paginate(9)->appends($request->query());;
        
        return view('admin_kategori', compact('kategories'), ['title' => 'Kategori Obat']);
    }

    public function addCategory(Request $request)
    {

        $validated = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);

        Kategori::create($validated);
        return redirect()->route('kategori.getCategory')->with('status', 'Data Berhasil Disimpan!');
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);

        $kategori = Kategori::where('id_kategori', $id)->first();
        $kategori->kode = $validated['kode'];
        $kategori->nama = $validated['nama'];
        $kategori->save();

        return redirect()->route('kategori.addCategory')->with('status', 'Data Berhasil Diupdate!');
    }

    public function destroyCategory($id)
    {
        Kategori::where('id_kategori', $id)->delete();

        return redirect()->route('kategori.getCategory')->with('status', 'Data Berhasil Dihapus!');
    }

    public function findCategory(Request $request)
    {
        $search = $request->input('data');

        $kategories = Kategori::where(function($query) use ($search){
        $query->where('kode', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%");
        })->paginate(9);

        // return view('admin_kategori', compact('kategories'), ['title' => 'Kategori Obat']);
        return response()->json($kategories);
    }
}