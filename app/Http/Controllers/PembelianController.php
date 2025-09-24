<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Obat;
use App\Models\Supplier;

class PembelianController extends Controller
{
    public function getPurchase(Request $request)
    {
        $purchases = Pembelian::from('tb_pembelian')
            ->join('tb_pengguna', 'tb_pembelian.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->join('tb_supplier', 'tb_pembelian.id_supplier', '=', 'tb_supplier.id_supplier')
            ->select(
                'tb_pembelian.*',
                'tb_pengguna.*',
                'tb_supplier.*',
                'tb_pengguna.nama as nama_pengguna',
                'tb_supplier.nama as nama_supplier'
            );
        
        if($request->query()){

            if($request->query('start_date') && $request->query('end_date') && $request->query('key'))
            {
                $startDate = $request->query('start_date');
                $endDate = $request->query('end_date');
                $key = $request->query('key');

                $purchases = $purchases
                    ->where('tb_supplier.nama', 'like', "%{$key}%")
                    ->where('tb_pengguna.nama', 'like', "%{$key}%")
                    ->whereBetween('tgl_pembelian', [$startDate, $endDate]);
                    
            } else if ($request->query('start_date')){
                $key = $request->query('key');
                $startDate = $request->query('start_date');

                $purchases = $purchases
                    ->where('tb_supplier.nama', 'like', "%{$key}%")
                    ->where('tb_pengguna.nama', 'like', "%{$key}%")
                    ->whereDate('tgl_pembelian', '>=', $startDate);

            } else if ($request->query('start_date')){
                $key = $request->query('key');
                $endDate = $request->query('end_date');

                $purchases = $purchases
                    ->where('tb_supplier.nama', 'like', "%{$key}%")
                    ->where('tb_pengguna.nama', 'like', "%{$key}%")
                    ->whereDate('tgl_pembelian', '<=', $endDate);

            }
        }

        $purchases = $purchases->paginate(9);

        return view('admin_pembelian', compact('purchases'), ['title' => 'Pembelian']);
    }

    public function getPurchaseDetail($id)
    {
        $purchase = Pembelian::from('tb_pembelian')
            ->join('tb_pengguna', 'tb_pembelian.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->join('tb_supplier', 'tb_pembelian.id_supplier', '=', 'tb_supplier.id_supplier')
            ->select(
                'tb_pembelian.*',
                'tb_pengguna.*',
                'tb_supplier.*',
                'tb_pengguna.nama as nama_pengguna',
                'tb_supplier.nama as nama_supplier'
            )->where('id_pembelian', $id)->first();

        $purchaseDetails = DetailPembelian::from('tb_detail_pembelian')
            ->join('tb_obat', 'tb_detail_pembelian.id_obat', '=', 'tb_obat.id_obat')
            ->select(
                'tb_detail_pembelian.*',
                'tb_obat.nama',
                'tb_obat.nama as nama_obat'
            )
            ->where('id_pembelian',$id)
            ->paginate(9);
        
        return view('admin_detail_pembelian', compact(['purchaseDetails', 'purchase']), ['title' => 'Detail Pembelian']);
    }

    public function getAddPurchase()
    {
        $suppliers = Supplier::all();
        $medics = Obat::all();

        return view('admin_tambah_pembelian',compact(['suppliers','medics']),['title' => 'Tambah Pembelian']);
    }

    public function addPurchase(Request $request)
    {

        $purchase = Pembelian::create([
            'id_pengguna' => $request->id_pengguna,
            'id_supplier' => $request->id_supplier,
            'total_pembelian' => 0,
            'tgl_pembelian' => now()
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

            Obat::where('id_obat', $item['id_obat'])->increment('stok', $item['jumlah_obat']);
        }

        $purchase->update(['total_pembelian'=>$total]);
        
        return redirect()->route('pembelian.getPurchase')->with('status', 'Data Berhasil Disimpan!');
    }


    public function destroyPurchase($id)
    {
        Pembelian::where('id_pembelian', $id)->delete();

        

        return redirect()->route('pembelian.getPurchase')->with('status', 'Data Berhasil Dihapus!');
    }

    public function findPurchase(Request $request)
    {
        $search = $request->input('data');

        $purchases = Pembelian::from('tb_pembelian')
            ->join('tb_pengguna', 'tb_pembelian.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->join('tb_supplier', 'tb_pembelian.id_supplier', '=', 'tb_supplier.id_supplier')
            ->select(
                'tb_pembelian.*',
                'tb_pengguna.*',
                'tb_supplier.*',
                'tb_pengguna.nama as nama_pengguna',
                'tb_supplier.nama as nama_supplier'
            )->where(function($query) use ($search){
                $query->where('tb_pengguna.nama', 'like', "%{$search}%")
                    ->orWhere('tb_supplier.nama', 'like', "%{$search}%");
            })->paginate(9);

        return response()->json($purchases);
    }
}
