<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
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



Route::get('/admin/obat', function () {
    return view('admin_obat', ['title' => 'Daftar Obat']);
});
