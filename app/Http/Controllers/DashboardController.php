<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Supplier;
use ArielMejiaDev\LarapexCharts\LarapexChart;
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

    public function showDashboardPemilik()
    {
        $monthlyRevenueQuery = Penjualan::select('total_penjualan')
            ->whereMonth('tgl_penjualan', Carbon::now()->month)
            ->whereYear('tgl_penjualan', Carbon::now()->year)
            ->sum('total_penjualan');
        
        $monthlyProfitQuery = DetailPenjualan::from('tb_detail_penjualan')
            ->join('tb_penjualan', 'tb_detail_penjualan.id_penjualan', '=', 'tb_penjualan.id_penjualan')
            ->join('tb_obat', 'tb_detail_penjualan.id_obat', '=', 'tb_obat.id_obat')
            ->whereMonth('tb_penjualan.tgl_penjualan', Carbon::now()->month)
            ->whereYear('tb_penjualan.tgl_penjualan', Carbon::now()->year)
            ->selectRaw('sum(tb_detail_penjualan.jumlah_obat *tb_obat.harga_jual)-sum(tb_detail_penjualan.jumlah_obat* tb_obat.harga_beli) as profit')
            ->first()->profit;
        
        $monthlyCostQuery = Pembelian::select('total_pembelian')
            ->whereMonth('tgl_pembelian', Carbon::now()->month)
            ->whereYear('tgl_pembelian', Carbon::now()->year)
            ->sum('total_pembelian');

        $tahun = date('Y');
        $bulan = date('m');

        for($i=1; $i<=$bulan; $i++){
            $totalRevenue = Penjualan::select('total_penjualan')
                ->whereMonth('tgl_penjualan', $i)
                ->whereYear('tgl_penjualan', $tahun)
                ->sum('total_penjualan');

            $totalCost = Pembelian::select('total_pembelian')
                ->whereMonth('tgl_pembelian', $i)
                ->whereYear('tgl_pembelian', $tahun)
                ->sum('total_pembelian');

            $dataBulan[] = date("M", mktime(0, 0, 0, $i, 1));

            $dataPenjualan[] = $totalRevenue;
            $dataPembelian[] = $totalCost;
            
        }
        
        $salesTrendChart = (new LarapexChart)->lineChart()
            ->setTitle('Tren Penjualan vs Pembelian Bulanan')
            ->setSubtitle('Total Pendapatan vs Total Pembelian Setiap Bulan')
            ->addData('Penjualan', $dataPenjualan)
            ->addData('Pembelian', $dataPembelian)
            ->setHeight(440)
            ->setXAxis($dataBulan);
        
        
        $topProductChart = (new LarapexChart)->barChart()
            ->setTitle('Top 5 Obat')
            ->setSubtitle('Top 5 Obat Paling Laris Bulan Ini')
            ->addData('Jumlah Penjualan', [6, 9, 3, 4, 10])
            ->setHeight(440)
            ->setXAxis(['Paracetamol', 'Tolak Angin', 'Paraflu', 'STMJ', 'Pasifrim']);

        $monthlyRevenue = 'Rp ' . number_format($monthlyRevenueQuery, 2, ',', '.');

        $monthlyProfit = 'Rp ' . number_format($monthlyProfitQuery, 2, ',', '.');

        $monthlyCost = 'Rp ' . number_format($monthlyCostQuery, 2, ',', '.');
        
        $minimStocks = Obat::select('*')->where('stok', '<=',  10)->get();

        $minimStockCount = $minimStocks->count();

        return view('pemilik', compact('monthlyRevenue', 'monthlyProfit', 'monthlyCost', 'minimStockCount', 'salesTrendChart', 'topProductChart'), ['title'=>'Dashboard']);
    }
}
