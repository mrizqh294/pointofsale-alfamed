<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function getMedicine(Request $request)
    {
        $kategories = Kategori::all();

        $medics = Obat::from('tb_obat')
            ->join('tb_kategori_obat','tb_obat.id_kategori', '=', 'tb_kategori_obat.id_kategori')
            ->select(
                'tb_obat.*',
                'tb_kategori_obat.*',
                'tb_obat.nama as nama_obat',
                'tb_kategori_obat.nama as nama_kategori',
            );
        
        if($request->query('search')){
            $search = $request->query('search');

            $medics->where('tb_obat.nama', 'like', "%{$search}%")
                ->orWhere('tb_kategori_obat.nama', 'like', "%{$search}%");
        }

        $medics = $medics->paginate(9);

        return view('admin_obat', ['medics'=> $medics, 'kategories' => $kategories,'title' => 'Daftar Obat']);
    }

    public function addMedicine(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required',
            'id_kategori' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'stok' => 'required',
        ]);

        Obat::create($validated);
        return redirect()->route('obat.getMedicine')->with('status', 'Data Berhasil Disimpan!');
    }

    public function updateMedicine(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'id_kategori' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'stok' => 'required',
        ]);

        $medic = Obat::where('id_obat', $id)->first();
        $medic->nama = $validated['nama'];
        $medic->id_kategori = $validated['id_kategori'];
        $medic->harga_jual = $validated['harga_jual'];
        $medic->harga_beli = $validated['harga_beli'];
        $medic->stok = (int) $validated['stok'];
        $medic->save();

        return redirect()->route('obat.getMedicine')->with('status', 'Data Berhasil Diupdate!');
    }

    public function destroyMedicine($id)
    {
        Obat::where('id_obat', $id)->delete();

        return redirect()->route('obat.getMedicine')->with('status', 'Data Berhasil Dihapus!');
    }

    public function findMedicine(Request $request)
    {
        $search = $request->input('data');

        $medics = Obat::from('tb_obat')
            ->join('tb_kategori_obat','tb_obat.id_kategori', '=', 'tb_kategori_obat.id_kategori')
            ->select(
                'tb_obat.*',
                'tb_kategori_obat.*',
                'tb_obat.nama as nama_obat',
                'tb_kategori_obat.nama as nama_kategori',
            )->where(function($query) use ($search){
            $query->where('tb_obat.nama', 'like', "%{$search}%")
            ->orWhere('tb_kategori_obat.nama', 'like', "%{$search}%");
            })->paginate(9); 

        return response()->json($medics);
    }
}
