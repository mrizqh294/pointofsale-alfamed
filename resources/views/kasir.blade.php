<x-layout>
    <x-sidebar_kasir></x-sidebar_kasir>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot>
        <div class="flex flex-col w-full h-full items-center justify-center">
            <div>
                <h1 class="font-bold text-3xl">Selamat Datang Kasir, {{ session('nama') }}</h1>
            </div>
            <div class="my-8">
                <a href="/kasir/transaksi" class="inline-block w-70 text-center cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-3 rounded-lg">Transaksi Baru</a>
                <a href="/kasir/riwayat" class="inline-block w-70 text-center cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-3 rounded-lg">Riwayat</a>
            </div>
        </div>
    </x-main_content>
</x-layout>
