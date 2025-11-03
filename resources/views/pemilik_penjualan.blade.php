<x-layout>
    <x-sidebar_pemilik></x-sidebar_pemilik>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot:title>
        <div x-data="{ isOpenDestroy: false,id: null }" x-cloak>
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
                    <form action="{{ route('pemilik.getSale') }}" method="get" class="">
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
                            <button type="submit" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-filter"></i></button>
                            <a href="{{ route('pemilik.getSale') }}" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrows-rotate"></i></a>
                            <a href="{{ route('pemilik.exportPenjualan', request()->query()) }}" class="mx-1 cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-excel"></i> Ekspor</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- delete modal --}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenDestroy">
                <div class="p-8 bg-white w-1/3 rounded-xl place-items-center">
                    <h1 class="font-bold mb-4 text-lg">Apakah Anda Yakin Ingin Menghapus Data Ini?</h1>
                    <p class="text-center py-2"><i class="fa-solid fa-circle-exclamation text-7xl text-red-500"></i></p>
                    <p class="my-4 text-center">Lakukan tindakan ini hanya ketika diperlukan. Menghapus data penjualan dapat menyebakan perubahan data stok obat.</p>
                    <form :action="`{{ route('pemilik.destroySale', ':id') }}`.replace(':id', id)" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Hapus</button>
                    <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded-lg" @click="isOpenDestroy = !isOpenDestroy"><i class="fa-solid fa-xmark"></i> Batal</button>
                    </form>
                </div>
            </div>

            <div id="main-table" class="block py-1"> 
                <table class="min-w-full table-fixed border ">
                    <thead class="text-center">
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 border border-gray-400 w-1/8">Tanggal</th>
                            <th class="py-2 px-4 border border-gray-400 w-2/8">Pencatat</th>
                            <th class="py-2 px-4 border border-gray-400 w-2/8">Total Penjualan</th>
                            <th class="py-2 px-4 border border-gray-400 w-1/10">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @forelse ($sales as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border border-gray-400">{{ $sale->tgl_penjualan_formatted }}</td>
                            <td class="py-2 px-4 border border-gray-400">{{ $sale->nama_pengguna }}</td>
                            <td class="text-right py-2 px-4 border border-gray-400">{{ $sale->total_penjualan_formatted }}</td>
                            <td class="text-center py-2 px-4 border border-gray-400">
                            <a href="{{ route('pemilik.getSaleDetail',$sale->id_penjualan) }}"><button class="bg-blue-500 cursor-pointer hover:bg-blue-600 text-white px-3 py-1 rounded"><i class="fa-solid fa-circle-info"></i></button></a>
                            <button class="bg-red-500 cursor-pointer hover:bg-red-600 text-white px-3 py-1 rounded" @click="isOpenDestroy = !isOpenDestroy; id = {{ $sale->id_penjualan }}"><i class="fa-solid fa-trash"></i></button>
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
