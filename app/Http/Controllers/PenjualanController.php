<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExports;
use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        if(session('role')== 'Kasir'){
            $id = session('id_pengguna');
            $sales->where('tb_penjualan.id_pengguna', $id);
        }

        if($request->query()){

            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            $key = $request->query('key');

            if($key){
                $sales->where('tb_pengguna.nama', 'like', "%{$key}%");
            }

            if($startDate && $endDate)
            {
                $sales->whereBetween('tb_penjualan.tgl_penjualan', [$startDate, $endDate]);
            } else if ($startDate){
                $sales->whereDate('tb_penjualan.tgl_penjualan', '>=', $startDate);
            } else if ($endDate){
                $sales->whereDate('tb_penjualan.tgl_penjualan', '<=', $endDate);
            }

        }

        $sales = $sales->orderBy('tb_penjualan.created_at', 'desc')->paginate(9)->appends($request->query());

        if(session('role') == 'Admin'){
            return view('admin_penjualan', compact('sales'), ['title' => 'Penjualan']);
        } else if(session('role') == 'Pemilik'){
            return view('pemilik_penjualan', compact('sales'), ['title' => 'Penjualan']);
        }else if(session('role')== 'Kasir'){
            return view('kasir_riwayat_transaksi', compact('sales'), ['title' => 'Riwayat Transaksi']);
        }
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
        
        foreach($saleDetails as $saleDetail){
            $saleDetail->harga_jual_formatted = 'Rp ' . number_format($saleDetail->harga_jual, 2, ',', '.');
        }

        if(session('role') == 'Admin'){
            return view('admin_detail_penjualan', compact(['saleDetails', 'sale']), ['title' => 'Detail Penjualan']);
        } else if(session('role') == 'Pemilik'){
            return view('pemilik_detail_penjualan', compact(['saleDetails', 'sale']), ['title' => 'Detail Penjualan']);
        }else if(session('role') == 'Kasir'){
            return view('kasir_detail_transaksi', compact(['saleDetails', 'sale']), ['title' => 'Detail Transaksi']);
        }
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

            if($medic->stok <= 0){
                if(session('role') == 'Admin'){
                    return redirect()->route('penjualan.getSale')->with('status', "Stok $medic->nama habis");
                } else if(session('role') == 'Kasir'){
                    return redirect()->route('kasir.transaksi')->with('status', "Stok $medic->nama habis");
                }
            }
            
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

        if(session('role') == 'Admin'){
            return redirect()->route('penjualan.getSale')->with('status', 'Data Berhasil Disimpan!');
        } else if(session('role') == 'Kasir'){
            return redirect()->route('kasir.transaksi')->with('status', 'Data Berhasil Disimpan!');
        }
    }

    public function destroySale($id)
    {
        $details = DetailPenjualan::where('id_penjualan', $id)->get() ;
        
        foreach($details as $detail){
            Obat::where('id_obat', $detail->id_obat)->increment('stok', $detail->jumlah_obat);
        }

        Penjualan::where('id_penjualan', $id)->delete();

        return redirect()->route('pemilik.getSale')->with('status', 'Data Berhasil Dihapus!');
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

    public function exportPenjualan(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'key']);

        $fileName = 'Penjualan_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new PenjualanExports($filters), $fileName);
    }
}
