<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Obat;
use App\Models\Supplier;

class PembelianController extends Controller
{
    public function getPurchase()
    {
        $purchases = Pembelian::paginate(8);

        return view('admin_pembelian', compact('purchases'), ['title' => 'Pembelian']);
    }

    public function getAddPurchase()
    {
        $suppliers = Supplier::all();
        $medics = Obat::all();

        return view('admin_tambah_pembelian',compact(['suppliers','medics']),['title' => 'Tambah Pembelian']);
    }

    public function addPurchase(Request $request)
    {
        dd($request);

        $validated = $request->validate([
            'id_pengguna' => 'required',
            'id_supplier' => 'required',
            'id_obat'=> 'required',
            'jumlah_obat' => 'required',
            'harga_beli' => 'required',
            'tgl_kadaluarsa' => 'required'
        ]);

        $purchase = Pembelian::create([
            'id_pengguna' => $validated['id_pengguna'],
            'id_suplier' => $validated['id_supplier'],
            'total_pembelian' => 0,
            'tgl_pembelian' =>  now()
        ]);

        $total=0;

        foreach($request->items as $item){
            $subtotal = $item['jumlah_obat'] * $item['harga_beli'];
            $total += $subtotal;

            DetailPembelian::create([
                'id_pembelian' => $purchase->id_pembelian,
                'id_obat' => $item['id_obat'],
                'jumlah_obat' => $item['jumlah_obat'],
                'harga_beli' => $item['harga_beli'],
                'subtotal_pembelian' => $subtotal,
                'tgl_kadaluarsa' => $item['tgl_kadaluarsa']
            ]);
        }

        $purchase->update(['total_pembelian'=>$total]);
        
        return redirect()->route('pembelian.showAddPurchase')->with('status', 'Data Berhasil Disimpan!');
    }


    public function destroySupplier($id)
    {
        Pembelian::where('id_pembelian', $id)->delete();

        return redirect()->route('pembelian.getPurchase')->with('status', 'Data Berhasil Dihapus!');
    }

    public function findSupplier(Request $request)
    {
        $search = $request->input('data');

        $purchases = Pembelian::where(function($query) use ($search){
        $query->where('nama', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%")
              ->orWhere('kontak', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })->paginate(9);

        return response()->json($purchases);
    }
}
