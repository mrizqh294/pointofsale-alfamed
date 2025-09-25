<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function getSupplier(Request $request)
    {
        $suppliers = Supplier::select('*');

        if($request->query('search')){
            $search = $request->query('search');

            $suppliers->where('nama', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%")
              ->orWhere('kontak', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        }

        $suppliers = $suppliers->paginate(9);

        return view('admin_supplier', compact('suppliers'), ['title' => 'Supplier']);
    }

    public function addSupplier(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kontak' => 'required',
            'email' => 'required'

        ]);

        Supplier::create($validated);
        return redirect()->route('supplier.getSupplier')->with('status', 'Data Berhasil Disimpan!');
    }

    public function updateSupplier(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kontak' => 'required',
            'email' => 'required'

        ]);

        $supplier = Supplier::where('id_supplier', $id)->first();
        $supplier->nama = $validated['nama'];
        $supplier->alamat = $validated['alamat'];
        $supplier->kontak = $validated['kontak'];
        $supplier->email = $validated['email'];
        $supplier->save();

        return redirect()->route('supplier.addSupplier')->with('status', 'Data Berhasil Diupdate!');
    }

    public function destroySupplier($id)
    {
        Supplier::where('id_supplier', $id)->delete();

        return redirect()->route('supplier.getSupplier')->with('status', 'Data Berhasil Dihapus!');
    }

    public function findSupplier(Request $request)
    {
        $search = $request->input('data');

        $suppliers = Supplier::where(function($query) use ($search){
        $query->where('nama', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%")
              ->orWhere('kontak', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        })->paginate(9);

        return response()->json($suppliers);
    }
}
