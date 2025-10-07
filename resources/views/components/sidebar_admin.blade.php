<aside class="w-64 bg-teal-700 text-white">
  <div class="flex flex-col h-full justify-between">
    <div>
      <div class="flex items-center px-7">
        <img src="/images/alfamed-logo.png" alt="Logo" class="w-10 h-10 rounded-full" />
        <span class="p-6 text-xl font-bold">Apotek Alfamed</span>
      </div>
      <nav class="">
        <div class="max-h-full flex flex-col content-between">
          <div>
            <a href="/admin" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-house p-2"></i>Dashboard</a>
            <a href="/admin/pengguna" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-user p-2"></i>Pengguna</a>
            <a href="/admin/kategori" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-table-cells-large p-2"></i>Kategori</a>
            <a href="/admin/obat" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-tablets p-2"></i>Obat</a>
            <a href="/admin/supplier" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-truck-field p-2"></i>Suplier</a>
            <a href="/admin/penjualan" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-chart-column p-2"></i></i>Penjualan</a>
            <a href="/admin/pembelian" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-basket-shopping p-2"></i>Pembelian</a>
          </div>
        </div>
      </nav>
    </div>
    <div class="bg-teal-700 pb-6">
      <a href="{{ route('logout') }}" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-right-from-bracket p-2"></i>Keluar</a>
    </div>
  </div>
</aside>