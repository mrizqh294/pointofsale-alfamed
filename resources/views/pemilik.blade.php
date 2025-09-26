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
      </div>
    </div>
  </x-main_content>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  {!! $salesTrendChart->script() !!}
  {!! $topProductChart->script() !!}
</x-layout>
