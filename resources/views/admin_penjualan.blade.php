<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
      <x-slot:title>{{ $title }}</x-slot>
        <div>

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
                <form method="get" class="">
                  @csrf
                  <div class="flex items-center">
                    <div class="me-1">
                      <input type="text" id="key" name="key" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Pencatat">
                    </div>
                    <div class="mx-1">
                      <input type="date" id="start_date" name="start_date" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mx-1">
                      <p>-</p>
                    </div>
                    <div class="mx-1">
                      <input type="date" id="end_date" name="end_date" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" formaction="{{ route('penjualan.getSale') }}" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-filter"></i></button>
                    <a href="{{ route('penjualan.getSale') }}" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrows-rotate"></i></a>
                    <a href="{{ route('penjualan.exportPenjualan', request()->query()) }}" class="mx-1 cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-excel"></i> Ekspor</a>
                  </div>
                </form>
              </div>
              <a href="{{ route('penjualan.getAddSale') }}" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-plus"></i> Tambah Data</a>
            </div>
            
            {{-- tabel utama --}}
            <div id="main-table" class="block py-1"> 
              <table class="min-w-full table-fixed border">
                <thead class="text-center">
                  <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-400 w-1/8">Tanggal</th>
                    <th class="py-2 px-4 border border-gray-400 w-2/8">Pencatat</th>
                    <th class="py-2 px-4 border border-gray-400 w-2/8">Total Penjualan</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/10">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($sales as $sale)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border border-gray-400">{{ $sale->tgl_penjualan_formatted }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $sale->nama_pengguna }}</td>
                    <td class="text-right py-2 px-4 border border-gray-400">{{ $sale->total_penjualan_formatted }}</td>
                    <td class="text-center py-2 px-4 border border-gray-400">
                      <a href="{{ route('penjualan.getSaleDetail',$sale->id_penjualan) }}"><button class="bg-blue-500 cursor-pointer hover:bg-blue-600 text-white px-3 py-1 rounded"><i class="fa-solid fa-circle-info my-1"></i></button></a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-2 px-4 border border-gray-400">Data Tidak Ditemukan!</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              <div class="mt-4">
                {{ $sales->links() }}
              </div>
            </div>
        </div>     
    </x-main_content>
</x-layout>
