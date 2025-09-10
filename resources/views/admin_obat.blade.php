<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
      <x-slot:title>{{ $title }}</x-slot>
        <div class="overflow-x-auto">
            <div class="flex justify-between pb-3">
                <span class="block font-bold">Daftar Obat</span>
                <a href="#" class="block bg-blue-500 text-white px-3 py-1 rounded mr-2">Tambah Data</a>
                
            </div>
            <table class="min-w-full bg-white border border-gray-300">
              <thead>
                <tr class="bg-gray-200">
                  <th class="py-3 px-4 border-b">No</th>
                  <th class="py-3 px-4 border-b">Kode</th>
                  <th class="py-3 px-4 border-b">Nama</th>
                  <th class="py-3 px-4 border-b">Kategori</th>
                  <th class="py-3 px-4 border-b">Harga</th>
                  <th class="py-3 px-4 border-b">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr class="hover:bg-gray-50">
                  <td class="py-3 px-4 border-b">1</td>
                  <td class="py-3 px-4 border-b">Budi Santoso</td>
                  <td class="py-3 px-4 border-b">budi@example.com</td>
                  <td class="py-3 px-4 border-b">08123456789</td>
                  <td class="py-3 px-4 border-b">Jl. Merdeka No. 10</td>
                  <td class="py-3 px-4 border-b">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded mr-2">Edit</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded mr-2">Hapus</button>
                    <button class="bg-gray-500 text-white px-3 py-1 rounded">Detail</button>
                  </td>
                </tr>
                <tr class="hover:bg-gray-50">
                  <td class="py-3 px-4 border-b">2</td>
                  <td class="py-3 px-4 border-b">Siti Aminah</td>
                  <td class="py-3 px-4 border-b">siti@example.com</td>
                  <td class="py-3 px-4 border-b">08987654321</td>
                  <td class="py-3 px-4 border-b">Jl. Sudirman No. 20</td>
                  <td class="py-3 px-4 border-b">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded mr-2">Edit</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded mr-2">Hapus</button>
                    <button class="bg-gray-500 text-white px-3 py-1 rounded">Detail</button>
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
    </x-main_content>
</x-layout>