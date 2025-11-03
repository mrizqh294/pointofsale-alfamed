<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
      <x-slot:title>{{ $title }}</x-slot>
        <div class="" x-data="{ isOpenAdd: false, isOpenDestroy: false, isOpenUpdate: false, id: null, current: {} }" x-cloak>

          @if (session('status'))
              <div x-data="{isOpenAlert: true}">
                <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenAlert">
                  <div class="p-8 bg-white w-1/3 rounded-xl text-center grid gird-cols-1 place-items-center">
                    <h1 class="font-bold text-lg">
                      {{ session('status') }}
                    </h1>
                    <img src="/images/confirm.svg" class="p-5">
                    <button type="button" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg" @click="isOpenAlert = !isOpenAlert">Oke</button>
                  </div>
                </div>
              </div>
          @endif

            <div class="flex justify-between py-3">
              <div>
                <form action="{{ route('supplier.getSupplier') }}" method="get">
                  @csrf
                  <input type="text" id="search" name="search" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari Supplier">
                  <button type="submit" class="ms-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-magnifying-glass"></i></button>
                  <a href="{{ route('supplier.getSupplier') }}" class="ms-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrows-rotate"></i></a>
                </form>
              </div>
              <button class="btn cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg" @click="isOpenAdd = !isOpenAdd"><i class="fa-solid fa-plus"></i> Tambah Data</button>

              {{-- modal tambah data --}}
              <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenAdd">
                <div class="p-8 bg-white w-1/3 rounded-xl">
                  <h1 class="font-bold mb-4 text-lg">Tambah Data Supplier</h1>
                  <form action="{{ route('supplier.addSupplier') }}" method="post">
                    @csrf
                    <div class="mb-4">
                      <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Supplier</label>
                      <input 
                        type="text" id="nama" name="nama" placeholder="Masukkan Nama Supplier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                      <label for="kontak" class="block text-gray-700 font-medium mb-2">Kontak</label>
                      <input 
                        type="text" id="kontak" name="kontak" placeholder="Masukkan Kontak" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                      <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                      <input type="text" id="email" name="email" placeholder="Masukkan Alamat Email"class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                      <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                      <textarea name="alamat" id="alamat" placeholder="Masukkan Alamat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>
                    <button type="submit" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Simpan</button>
                    <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded-lg" @click="isOpenAdd = !isOpenAdd"><i class="fa-solid fa-xmark"></i> Batal</button>
                  </form>
                </div>
              </div> 
            </div>

            {{-- modal edit--}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenUpdate">
              <div class="p-8 bg-white w-1/3 rounded-xl">
                <h1 class="font-bold mb-4 text-lg">Edit Data Supplier</h1>
                <form :action="`{{ route('supplier.updateSupplier', ':id') }}`.replace(':id', current.id_supplier)" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Supplier</label>
                    <input type="text" id="nama" name="nama" placeholder="" :value="`${current.nama}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="mb-4">
                    <label for="kontak" class="block text-gray-700 font-medium mb-2">Kontak</label>
                    <input type="text" id="kontak" name="kontak" placeholder="" :value="`${current.kontak}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" placeholder="" :value="`${current.email}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" :value="`${current.alamat}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                  </div>
                  <button type="submit" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Simpan</button>
                  <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded-lg" @click="isOpenUpdate = !isOpenUpdate"><i class="fa-solid fa-xmark"></i> Batal</button>
                </form>
              </div>
            </div> 

            {{-- delete modal --}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenDestroy">
              <div class="p-8 bg-white w-1/3 rounded-xl place-items-center">
                <h1 class="font-bold mb-4 text-lg text-center">Apakah Anda Yakin Ingin Menghapus Data Ini?</h1>
                <p class="text-center py-2"><i class="fa-solid fa-circle-exclamation text-7xl text-red-500"></i></p>
                <p class="my-4 text-center">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                <form :action="`{{ route('supplier.destroySupplier', ':id') }}`.replace(':id', id)" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Hapus</button>
                  <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded-lg" @click="isOpenDestroy = !isOpenDestroy"><i class="fa-solid fa-xmark"></i> Batal</button>
                 </form>
              </div>
            </div>

            {{-- tabel utama --}}
            <div id="main-table" class="block py-1"> 
              <table class="min-w-full table-fixed border ">
                <thead class="text-center">
                  <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-400 w-2/7">Nama</th>
                    <th class="py-2 px-4 border border-gray-400 w-3/7">Alamat</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Kontak</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Aksi</th>
                  </tr>
                </thead>
                <tbody class="">
                  @forelse ($suppliers as $supplier)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border border-gray-400">{{ $supplier->nama }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $supplier->alamat }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $supplier->kontak }}</td>
                    <td class="text-center py-2 px-4 border border-gray-400">
                      <button class="bg-blue-500 cursor-pointer hover:bg-blue-600 text-white px-3 py-1 rounded"  @click="isOpenUpdate = !isOpenUpdate; current = {{ $supplier->toJson() }}"><i class="fa-solid fa-pen-to-square"></i></button>
                      <button class="bg-red-500 cursor-pointer hover:bg-red-600 text-white px-3 py-1 rounded" @click="isOpenDestroy = !isOpenDestroy; id = {{ $supplier->id_supplier }}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-2 px-4 border border-gray-400">Data Tidak Ditemukan</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              <div class="mt-4">
                {{ $suppliers->links() }}
              </div>
            </div>
        </div>     
    </x-main_content>
</x-layout>
