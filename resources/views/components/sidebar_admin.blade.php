<aside class="w-64 bg-green-500 text-white">
    <div class="flex items-center px-6">
      <img src="/images/alfamed-logo.png" alt="Logo" class="w-10 h-10 rounded-full" />
      <span class="p-6 text-xl font-bold">Apotek Alfamed</span>
    </div>
    <nav class="font-semibold" x-data="{ isOpen: false, laporanIsOpen: false }" x-cloak>
        <a href="/admin" class="block py-2.5 px-6 hover:bg-green-400"><i class="fa-solid fa-house p-2"></i>Dashboard</a>
        <button type="button" type="button" @click="isOpen = !isOpen" class="py-2.5 px-6 text-justify w-full cursor-pointer hover:bg-green-400"><i class="fa-solid fa-user p-2"></i>Pengguna<i class="fa fa-caret-down pl-8"></i></button>
        <div 
          x-show="isOpen"
          x-transition:enter="transition ease-out duration-100 transform"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-75 transform"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="bg-green-400"
        >
          <a href="/admin/pengguna" class="block py-2.5 px-6 hover:bg-green-400">Admin</a>
          <a href="/admin/pengguna" class="block py-2.5 px-6 hover:bg-green-400">Manajemen</a>
          <a href="/admin/pengguna" class="block py-2.5 px-6 hover:bg-green-400">Kasir</a>
        </div>
        <a href="/admin/kategori" class="block py-2.5 px-6 hover:bg-green-400"><i class="fa-solid fa-table-cells-large p-2"></i>Kategori</a>
        <a href="/admin/obat" class="block py-2.5 px-6 hover:bg-green-400"><i class="fa-solid fa-tablets p-2"></i>Obat</a>
        <a href="/admin/supplier" class="block py-2.5 px-6 hover:bg-green-400"><i class="fa-solid fa-store p-2"></i>Suplier</a>
        <a href="/admin/pembelian" class="block py-2.5 px-6 hover:bg-green-400"><i class="fa-solid fa-basket-shopping p-2"></i>Pembelian</a>
        <button type="button" type="button" @click="laporanIsOpen = !laporanIsOpen" class="py-2.5 px-6 text-justify w-full cursor-pointer hover:bg-green-400"><i class="fa-solid fa-book p-2"></i>Laporan<i class="fa fa-caret-down pl-8"></i></button>
        <div 
          x-show="laporanIsOpen"
          x-transition:enter="transition ease-out duration-100 transform"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-75 transform"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="bg-green-400"
        >
          <a href="/admin/laporan/penjualan" class="block py-2.5 px-6 hover:bg-green-400">Penjualan</a>
          <a href="/admin/laporan/pembelian" class="block py-2.5 px-6 hover:bg-green-400">Pembelian</a>
          <a href="/admin/laporan/stok" class="block py-2.5 px-6 hover:bg-green-400">Stok Obat</a>
        </div>
    </nav>
</aside>