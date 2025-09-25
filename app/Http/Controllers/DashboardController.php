<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboardAdmin ()
    {
        $countMedic = Obat::count();

        $countSupplier = Supplier::count();

        $totalStok = Obat::sum('stok');

        $todayRevenue = Penjualan::select('*')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_penjualan');

        $todayRevenueFormatted = 'Rp ' . number_format($todayRevenue, 2, ',', '.');

        $todayProfit = DetailPenjualan::from('tb_detail_penjualan')
            ->join('tb_penjualan', 'tb_detail_penjualan.id_penjualan', '=', 'tb_penjualan.id_penjualan')
            ->join('tb_obat', 'tb_detail_penjualan.id_obat', '=', 'tb_obat.id_obat')
            ->whereDate('tb_penjualan.created_at', Carbon::today())
            ->selectRaw('sum((tb_detail_penjualan.jumlah_obat  *tb_obat.harga_jual)-(tb_detail_penjualan.jumlah_obat* tb_obat.harga_beli)) as profit')
            ->value('profit');

        $todayProfitFormatted = 'Rp ' . number_format($todayProfit, 2, ',', '.');


        $todaySales = Penjualan::from('tb_penjualan')
            ->join('tb_pengguna', 'tb_penjualan.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->select(
                'tb_penjualan.*',
                'tb_pengguna.*',
                'tb_pengguna.nama as nama_pengguna'
            )->whereDate('tb_penjualan.created_at', Carbon::today())->get();

        $minimStocks = Obat::select('*')->where('stok', '<=',  10)->get();

        $minimStockCount = $minimStocks->count();

        return view('admin',
            compact(['countMedic', 'countSupplier', 'todaySales','minimStocks', 'todayRevenueFormatted', 'totalStok', 'todayProfitFormatted', 'minimStockCount']),
            ['title' => 'Dashboard']);
    }
}
