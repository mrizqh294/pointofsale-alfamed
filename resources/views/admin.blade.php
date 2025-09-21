<x-layout>
  <x-sidebar_admin></x-sidebar_admin>

  <x-main_content>
    <x-slot:title>{{ $title }}</x-slot>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-3">
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Penjualan</h2>
        <p class="text-gray-700 text-3xl">1,234</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Pembelian</h2>
        <p class="text-gray-700 text-3xl">56</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Obat</h2>
        <p class="text-green-500 text-3xl">500</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Suplier</h2>
        <p class="text-green-500 text-3xl">10</p>
      </div>
    </div>
  </x-main_content>
</x-layout>
