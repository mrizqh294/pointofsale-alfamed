<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function getSale(Request $request)
    {
        $sales = Penjualan::from('tb_penjualan')
            ->join('tb_pengguna', 'tb_penjualan.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->select(
                'tb_penjualan.*',
                'tb_pengguna.*',
                'tb_pengguna.nama as nama_pengguna'
            );

        if($request->query()){

            if($request->query('start_date') && $request->query('end_date') && $request->query('key'))
            {
                
                $startDate = $request->query('start_date');
                $endDate = $request->query('end_date');
                $key = $request->query('key');

                $sales = $sales
                    ->where('tb_pengguna.nama', 'like', "%{$key}%")
                    ->whereBetween('tgl_penjualan', [$startDate, $endDate]);

            } else if ($request->query('start_date')){

                $startDate = $request->query('start_date');
                $key = $request->query('key');

                $sales = $sales
                    ->where('tb_pengguna.nama', 'like', "%{$key}%")
                    ->whereDate('tgl_penjualan', '>=', $startDate);
            } else if ($request->query('end_date')){

                $endDate = $request->query('end_date');
                $key = $request->query('key');

                $sales = $sales
                    ->where('tb_pengguna.nama', 'like', "%{$key}%")
                    ->whereDate('tgl_penjualan', '>=', $endDate);
            }

        }

        $sales = $sales->paginate(9);

        return view('admin_penjualan', compact('sales'), ['title' => 'Penjualan']);
    }

    public function getSaleDetail($id)
    {
        $sale = Penjualan::from('tb_penjualan')
            ->join('tb_pengguna', 'tb_penjualan.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->select(
                'tb_penjualan.*',
                'tb_pengguna.*',
                'tb_pengguna.nama as nama_pengguna',
            )->where('id_penjualan', $id)->first();

        $saleDetails = DetailPenjualan::from('tb_detail_penjualan')
            ->join('tb_obat', 'tb_detail_penjualan.id_obat', '=', 'tb_obat.id_obat')
            ->select(
                'tb_detail_penjualan.*',
                'tb_obat.*',
                'tb_obat.nama as nama_obat'
            )
            ->where('id_penjualan',$id)
            ->paginate(9);
        
        return view('admin_detail_penjualan', compact(['saleDetails', 'sale']), ['title' => 'Detail Penjualan']);
    }

    public function getAddSale()
    {
        $medics = Obat::all();

        return view('admin_tambah_penjualan',compact('medics'),['title' => 'Tambah Penjualan']);
    }

    public function addSale(Request $request)
    {

        $sale = Penjualan::create([
            'id_pengguna' => $request->id_pengguna,
            'total_penjualan' => 0,
            'tgl_penjualan' => now()
        ]);

        $total=0;

        foreach($request->items as $item){
            $medic = Obat::where('id_obat', $item['id_obat'])->first();
            $subtotal = $item['jumlah_obat'] * $medic->harga_jual;
            $total += $subtotal;

            DetailPenjualan::create([
                'id_penjualan' => $sale->id_penjualan,
                'id_obat' => $item['id_obat'],
                'jumlah_obat' => $item['jumlah_obat'],
                'subtotal_penjualan' => $subtotal,
            ]);

            Obat::where('id_obat', $item['id_obat'])->decrement('stok', $item['jumlah_obat']);
        }

        $sale->update(['total_penjualan'=>$total]);
        
        return redirect()->route('penjualan.getSale')->with('status', 'Data Berhasil Disimpan!');
    }


    public function destroySale($id)
    {
        Penjualan::where('id_penjualan', $id)->delete();

        return redirect()->route('penjualan.getSale')->with('status', 'Data Berhasil Dihapus!');
    }

    public function findSale(Request $request)
    {
        $search = $request->input('data');

        $sales = Penjualan::from('tb_penjualan')
            ->join('tb_pengguna', 'tb_penjualan.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->select(
                'tb_penjualan.*',
                'tb_pengguna.*',
                'tb_pengguna.nama as nama_pengguna',
            )->where(function($query) use ($search){
                $query->where('tb_pengguna.nama', 'like', "%{$search}%");
            })->paginate(9);

        return response()->json($sales);
    }
}
