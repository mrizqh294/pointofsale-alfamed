<x-layout>
    <x-sidebar_pemilik></x-sidebar_pemilik>
    <x-main_content>
      <x-slot:title>{{ $title }}</x-slot>
        <div class="">

          @if (session('status'))
              <div x-data="{isOpenAlert: true}">
                <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenAlert">
                  <div class="p-8 bg-white w-1/3 rounded-xl text-center">
                    <h1 class="font-bold mb-4 text-lg">
                      {{ session('status') }}
                    </h1>
                    <button type="button" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenAlert = !isOpenAlert">Oke</button>
                  </div>
                </div>
              </div>
          @endif

            <div class="flex justify-between py-3">
              <div>
                <a href="{{ route('pemilik.getSale') }}" class="cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
              </div>
            </div>

            <div class="text-left px-2 pb-3 mt-4 mb-3">
                <table>
                  <tbody>
                  <tr>
                    <th class="w-2/4">Pencatat</th>
                    <td class="w-5">:</td>
                    <td>{{ $sale->nama_pengguna}}</td>
                  </tr>
                  <tr>
                    <th class="w-2/4">Tanggal Penjualan</th>
                    <td>:</td>
                    <td>{{ $sale->tgl_penjualan_formatted }}</td>
                  </tr>
                  </tbody>
                </table>
            </div>

            
            {{-- tabel utama --}}
            <div id="main-table" class="block py-1"> 
              <table class="min-w-full table-fixed border ">
                <thead class="text-left">
                  <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-400 w-2/7">Nama Obat</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Harga Jual</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Jumlah</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Sub Total</th>
                  </tr>
                </thead>
                <tbody class="">
                  @foreach ($saleDetails as $saleDetail)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border border-gray-400">{{ $saleDetail->nama_obat }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $saleDetail->harga_jual_formatted }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $saleDetail->jumlah_obat }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $saleDetail->subtotal_penjualan_formatted }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="mt-4">
                {{ $saleDetails->links() }}
              </div>
            </div>

        </div>     
    </x-main_content>
</x-layout>



