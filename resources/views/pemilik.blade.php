<x-layout>
  <x-sidebar_pemilik></x-pemilik_admin>
  <x-main_content>
    <x-slot:title>{{ $title }}</x-slot>
    <div class="h-full">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-3">
        <div class="bg-white p-2 rounded-lg shadow flex flex-cols items-center">
          <div class="p-3">
            <button class="bg-blue-400 text-white rounded-lg p-3"><i class="fa-solid fa-hand-holding-dollar text-3xl"></i></button>
          </div>
          <div>
            <h2 class="text-lg font-bold">Revenue Bulan Ini</h2>
            <p class="text-gray-700 text-lg">{{ $monthlyRevenue }}</p>
          </div>
        </div>
        <div class="bg-white p-2 rounded-lg shadow flex flex-cols items-center">
          <div class="p-3">
            <button class="bg-green-400 text-white rounded-lg p-3"><i class="fa-solid fa-hand-holding-dollar text-3xl"></i></button>
          </div>
          <div>
            <h2 class="text-lg font-bold">Profit Bulan Ini</h2>
            <p class="text-gray-700 text-lg">{{ $monthlyProfit }}</p>
          </div>
        </div>
        <div class="bg-white p-2 rounded-lg shadow flex flex-cols items-center">
          <div class="p-3">
            <button class="bg-purple-400 text-white rounded-lg p-3"><i class="fa-solid fa-basket-shopping text-3xl"></i></i></button>
          </div>
          <div>
            <h2 class="text-lg font-bold">Pembelian Bulan Ini</h2>
            <p class="text-gray-700 text-lg">{{ $monthlyCost }}</p>
          </div>
        </div>
        <div class="bg-white p-2 rounded-lg shadow flex flex-cols items-center">
          <div class="p-3">
            <button class="bg-red-400 text-white rounded-lg p-3"><i class="fa-solid fa-circle-exclamation text-3xl"></i></button>
          </div>
          <div>
            <h2 class="text-lg font-bold">Stok Tipis</h2>
            <p class="text-gray-700 text-lg">{{ $minimStockCount }}</p>
          </div>
        </div>
      </div>
      <div class ="py-6 grid grid-cols-2 gap-6">
        {{-- tabel penjualan hari ini --}}
        <div class=" bg-white h-120 px-6 py-4 rounded-lg shadow flex flex-col content-center">
          <div>
            {!! $salesTrendChart->container() !!}
          </div>
        </div>

        {{-- tabel obat stok tipis --}}
        <div class=" bg-white h-120 px-6 py-4 rounded-lg shadow flex flex-col content-center">
          <div>
            {!! $topProductChart->container() !!}
          </div>
        </div>

        <div class=" bg-white h-120 px-6 py-4 rounded-lg shadow flex flex-col">
          <div class="p-2">
            <h1 class="text-lg font-bold">Penjualan Hari Ini</h1>
          </div>
          <div class="p-2 overflow-y-auto">
            <table class="min-w-full table-fixed border rounded-lg border-gray-200">
              <thead class="text-left">
                <tr class="bg-gray-200">
                  <th class="py-2 px-4  w-2/8">Pencatat</th>
                  <th class="py-2 px-4  w-2/8">Total Penjualan</th>
                  <th class="py-2 px-4  w-1/10">Aksi</th>
                </tr>
              </thead>
              <tbody class="">
                @forelse ($todaySales as $todaySale)
                <tr class="hover:bg-gray-50">
                  <td class="py-2 px-4 ">{{ $todaySale->nama_pengguna }}</td>
                  <td class="py-2 px-4 ">{{ $todaySale->total_penjualan_formatted}}</td>
                  <td class="py-2 px-4 ">
                    <a href="{{ route('penjualan.getSaleDetail', $todaySale->id_penjualan) }}"><button class="border border-blue-500 cursor-pointer hover:bg-grey-200 text-blue-500 px-3 py-1 rounded mr-2"><i class="fa-solid fa-circle-info my-1"></i></button></a>
                  </td>
                </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center py-2 px-4 border border-gray-200">Belum Ada Penjualan Hari Ini</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </x-main_content>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  {!! $salesTrendChart->script() !!}
  {!! $topProductChart->script() !!}
</x-layout>
