<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SupplierController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/admin', function () {
    return view('admin', ['title' => 'Dashboard']);
});

Route::get('/pegawai', function () {
    return 'Hello Pegawai';
});

Route::get('/manajer', function () {
    return 'Hello Manajer';
});

// Route::get('/admin/kategori',[KategoriController::class, 'getCategory'])->name('kategori.getCategory');
// Route::get('/admin/kategori/cari', [KategoriController::class, 'findCategory'])->name('kategori.findCategory');
// Route::post('/admin/kategori',[KategoriController::class, 'addCategory'])->name('kategori.addCategory');
// Route::delete('/admin/kategori/{id}',[KategoriController::class, 'destroyCategory'])->name('kategori.destroyCategory');
// Route::put('/admin/kategori/{id}',[KategoriController::class, 'updateCategory'])->name('kategori.updateCategory');


// Route::get('/admin/supplier', [SupplierController::class, 'getsupplier'])->name('supplier.getSupplier');
// Route::get('/admin/supplier/cari', [SupplierController::class, 'findSupplier'])->name('supplier.findSupplier');
// Route::post('/admin/supplier',[SupplierController::class, 'addSupplier'])->name('supplier.addSupplier');
// Route::delete('/admin/supplier/{id}',[SupplierController::class, 'destroySupplier'])->name('supplier.destroySupplier');
// Route::put('/admin/supplier/{id}',[SupplierController::class, 'updateSupplier'])->name('supplier.updateSupplier');


// Route::get('/admin/pengguna',[PenggunaController::class, 'getUser'])->name('pengguna.getUser');
// Route::get('/admin/pengguna/cari', [PenggunaController::class, 'findUser'])->name('pengguna.findUser');
// Route::post('/admin/pengguna',[PenggunaController::class, 'addUser'])->name('pengguna.addUser');
// Route::delete('/admin/pengguna/{id}',[PenggunaController::class, 'destroyUser'])->name('pengguna.destroyUser');
// Route::put('/admin/pengguna/{id}',[PenggunaController::class, 'updateUser'])->name('pengguna.updateUser');

// Route::get('/admin/obat',[ObatController::class, 'getMedicine'])->name('obat.getMedicine');
// Route::get('/admin/obat/cari', [ObatController::class, 'findMedicine'])->name('obat.findMedicine');
// Route::post('/admin/obat',[ObatController::class, 'addMedicine'])->name('obat.addMedicine');
// Route::delete('/admin/obat/{id}',[ObatController::class, 'destroyMedicine'])->name('obat.destroyMedicine');
// Route::put('/admin/obat/{id}',[ObatController::class, 'updateMedicine'])->name('obat.updateMedicine');

Route::post('/login',[AuthController::class, 'login'])->name('login');
route::get('/logout',[AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'checkRole:Admin'])->group(function () {
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
    Route::get('/admin/obat/cari', [ObatController::class, 'findMedicine'])->name('obat.findMedicine');
    Route::post('/admin/obat',[ObatController::class, 'addMedicine'])->name('obat.addMedicine');
    Route::delete('/admin/obat/{id}',[ObatController::class, 'destroyMedicine'])->name('obat.destroyMedicine');
    Route::put('/admin/obat/{id}',[ObatController::class, 'updateMedicine'])->name('obat.updateMedicine');

    Route::get('/admin/pembelian',[PembelianController::class, 'getPurchase'])->name('pembelian.getPurchase');
    Route::get('/admin/pembelian/detail/{id}',[PembelianController::class, 'getPurchaseDetail'])->name('pembelian.getPurchaseDetail');
    Route::get('/admin/pembelian/cari', [PembelianController::class, 'findPurchase'])->name('pembelian.findPurchase');
    Route::get('/admin/pembelian/tambah',[PembelianController::class, 'getAddPurchase'])->name('pembelian.getAddPurchase');
    Route::post('/admin/pembelian/',[PembelianController::class, 'addPurchase'])->name('pembelian.addPurchase');
    Route::delete('/admin/pembelian/{id}',[PembelianController::class, 'destroyPurchase'])->name('pembelian.destroyPurchase');


});