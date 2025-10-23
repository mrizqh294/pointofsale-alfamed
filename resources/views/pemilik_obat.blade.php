<x-layout>
    <x-sidebar_pemilik></x-sidebar_pemilik>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot:title>
        <div class="flex justify-between py-3">
            <div>
                <form action="{{ route('pemilik.getMedicine') }}" method="get">
                  @csrf
                  <input type="text" id="search" name="search" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari Obat">
                  <button type="submit" class="ms-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-magnifying-glass"></i></button>
                  <a href="{{ route('pemilik.getMedicine') }}" class="ms-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrows-rotate"></i></a>
                  <a href="{{ route('pemilik.exportObat')}}" class="mx-1 cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-excel"></i> Ekspor</a>
                </form>
            </div>
        </div>
        <div id="main-table" class="block py-1"> 
              <table class="min-w-full table-fixed border ">
                <thead class="text-center">
                  <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-400 w-2/7">Nama</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Kategori</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/15">Stok</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Harga Beli Terakhir</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Harga Jual</th>
                  </tr>
                </thead>
                <tbody class="">
                  @forelse ($medics as $medic)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border border-gray-400">{{ $medic->nama_obat }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $medic->nama_kategori }}</td>
                    <td class="text-center py-2 px-4 border border-gray-400">{{ $medic->stok }}</td>
                    <td class="text-right py-2 px-4 border border-gray-400">{{ $medic->harga_beli_formatted }}</td>
                    <td class="text-right py-2 px-4 border border-gray-400">{{ $medic->harga_jual_formatted }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center py-2 px-4 border border-gray-400">Data Tidak Ditemukan!</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              <div class="mt-4">
                {{ $medics->links() }}
              </div>
        </div>
    </x-main_content>
</x-layout>
