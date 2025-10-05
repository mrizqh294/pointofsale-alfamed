<?php

use App\Exports\ObatExports;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SupplierController;
use App\Http\Middleware\checkRole;
use App\Models\Penjualan;
use Faker\Guesser\Name;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('login');});
Route::get('/login', function () {return view('login');});
Route::post('/login',[AuthController::class, 'login'])->name('login');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'checkRole:Pemilik'])->group(function(){
    Route::get('/kasir', function () {return view('kasir', ['title' => 'Dashboard']);});
    Route::get('/kasir/transaksi', [ObatController::class, 'getCashierMedicine'])->name('kasir.transaksi');
    Route::post('/kasir/transaksi', [PenjualanController::class, 'addSale'])->name('kasir.addSale');
});

Route::middleware(['auth', 'checkRole:Pemilik'])->group(function(){
    Route::get('/pemilik',[DashboardController::class, 'showDashboardPemilik'])->name('pemilik.dashboard');
    Route::get('/pemilik/obat',[ObatController::class, 'getMedicine'])->name('pemilik.getMedicine');
    Route::get('/pemilik/obat/export', [ObatController::class, 'exportObat'])->name('pemilik.exportObat');
    Route::get('/pemilik/penjualan',[PenjualanController::class, 'getSale'])->name('pemilik.getSale');
    Route::get('/pemilik/penjualan/export', [PenjualanController::class, 'exportPenjualan'])->name('pemilik.exportPenjualan');
    Route::get('/pemilik/pembelian',[PembelianController::class, 'getPurchase'])->name('pemilik.getPurchase');
    Route::get('/pemilik/pembelian/export', [PembelianController::class, 'exportPembelian'])->name('pemilik.exportPembelian');
    Route::get('/pemilik/penjualan/detail/{id}',[penjualanController::class, 'getSaleDetail'])->name('pemilik.getSaleDetail');
    Route::get('/pemilik/pembelian/detail/{id}',[PembelianController::class, 'getPurchaseDetail'])->name('pemilik.getPurchaseDetail');
});

Route::middleware(['auth', 'checkRole:Admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'showDashboardAdmin'])->name('admin.dashboard');

    Route::get('/admin/kategori',[KategoriController::class, 'getCategory'])->name('kategori.getCategory');
    Route::get('/admin/kategori/cari', [KategoriController::class, 'findCategory'])->name('kategori.findCategory');
    Route::post('/admin/kategori',[KategoriController::class, 'addCategory'])->name('kategori.addCategory');
    Route::delete('/admin/kategori/{id}',[KategoriController::class, 'destroyCategory'])->name('kategori.destroyCategory');
    Route::put('/admin/kategori/{id}',[KategoriController::class, 'updateCategory'])->name('kategori.updateCategory');

    Route::get('/admin/supplier', [SupplierController::class, 'getsupplier'])->name('supplier.getSupplier');
    Route::get('/admin/supplier/cari', [SupplierController::class, 'findSupplier'])->name('supplier.findSupplier');
    Route::post('/admin/supplier',[SupplierController::class, 'addSupplier'])->name('supplier.addSupplier');
    Route::delete('/admin/supplier/{id}',[SupplierController::class, 'destroySupplier'])->name('supplier.destroySupplier');
    Route::put('/admin/supplier/{id}',[SupplierController::class, 'updateSupplier'])->name('supplier.updateSupplier');

    Route::get('/admin/pengguna',[PenggunaController::class, 'getUser'])->name('pengguna.getUser');
    Route::get('/admin/pengguna/cari', [PenggunaController::class, 'findUser'])->name('pengguna.findUser');
    Route::post('/admin/pengguna',[PenggunaController::class, 'addUser'])->name('pengguna.addUser');
    Route::delete('/admin/pengguna/{id}',[PenggunaController::class, 'destroyUser'])->name('pengguna.destroyUser');
    Route::put('/admin/pengguna/{id}',[PenggunaController::class, 'updateUser'])->name('pengguna.updateUser');

    Route::get('/admin/obat',[ObatController::class, 'getMedicine'])->name('obat.getMedicine');
    Route::get('/admin/obat/export', [ObatController::class, 'exportObat'])->name('obat.exportObat');
    Route::get('/admin/obat/cari', [ObatController::class, 'findMedicine'])->name('obat.findMedicine');
    Route::post('/admin/obat',[ObatController::class, 'addMedicine'])->name('obat.addMedicine');
    Route::delete('/admin/obat/{id}',[ObatController::class, 'destroyMedicine'])->name('obat.destroyMedicine');
    Route::put('/admin/obat/{id}',[ObatController::class, 'updateMedicine'])->name('obat.updateMedicine');

    Route::get('/admin/pembelian',[PembelianController::class, 'getPurchase'])->name('pembelian.getPurchase');
    Route::get('/admin/pembelian/export', [PembelianController::class, 'exportPembelian'])->name('pembelian.exportPembelian');
    Route::get('/admin/pembelian/detail/{id}',[PembelianController::class, 'getPurchaseDetail'])->name('pembelian.getPurchaseDetail');
    Route::get('/admin/pembelian/cari', [PembelianController::class, 'findPurchase'])->name('pembelian.findPurchase');
    Route::get('/admin/pembelian/tambah',[PembelianController::class, 'getAddPurchase'])->name('pembelian.getAddPurchase');
    Route::post('/admin/pembelian',[PembelianController::class, 'addPurchase'])->name('pembelian.addPurchase');
    Route::delete('/admin/pembelian/{id}',[PembelianController::class, 'destroyPurchase'])->name('pembelian.destroyPurchase');

    Route::get('/admin/penjualan',[PenjualanController::class, 'getSale'])->name('penjualan.getSale');
    Route::get('/admin/penjualan/export', [PenjualanController::class, 'exportPenjualan'])->name('penjualan.exportPenjualan');
    Route::get('/admin/penjualan/detail/{id}',[penjualanController::class, 'getSaleDetail'])->name('penjualan.getSaleDetail');
    Route::get('/admin/penjualan/cari', [penjualanController::class, 'findSale'])->name('penjualan.findSale');
    Route::get('/admin/penjualan/tambah',[penjualanController::class, 'getAddSale'])->name('penjualan.getAddSale');
    Route::post('/admin/penjualan',[penjualanController::class, 'addSale'])->name('penjualan.addSale');
    Route::delete('/admin/penjualan/{id}',[penjualanController::class, 'destroySale'])->name('penjualan.destroySale');
});