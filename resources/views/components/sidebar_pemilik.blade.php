<aside class="w-64 bg-teal-700 text-white">
  <div class="flex flex-col h-full justify-between">
    <div>
      <div class="flex items-center px-7">
        <img src="/images/alfamed-logo.png" alt="Logo" class="w-10 h-10 rounded-full" />
        <span class="p-6 text-xl font-bold">Apotek Alfamed</span>
      </div>
      <nav class="" x-data="{ isOpen: false, laporanIsOpen: false }" x-cloak>
        <div class="max-h-full flex flex-col content-between">
          <div>
            <a href="/pemilik" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-house p-2"></i>Dashboard</a>
            <a href="/pemilik/pengguna" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-user p-2"></i>Pengguna</a>
            <a href="/pemilik/obat" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-tablets p-2"></i>Obat</a>
            <a href="/pemilik/penjualan" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-chart-column p-2"></i></i>Penjualan</a>
            <a href="/pemilik/pembelian" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-basket-shopping p-2"></i>Pembelian</a>
          </div>
        </div>
      </nav>
    </div>
    <div class="bg-teal-700 pb-6">
      <a href="{{ route('logout') }}" class="block py-2.5 px-6 hover:bg-teal-600"><i class="fa-solid fa-right-from-bracket p-2"></i>Keluar</a>
    </div>
  </div>
</aside>