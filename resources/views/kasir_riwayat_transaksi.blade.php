<x-layout>
    <x-sidebar_kasir></x-sidebar_kasir>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot:title>
        <div class="flex justify-between py-3">
            <div>
                <form action="{{ route('kasir.getSale') }}" method="get" class="">
                  @csrf
                    <div class="flex items-center">
                        <div class="me-1">
                            <input type="date" id="start_date" name="start_date" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mx-1">
                            <p>-</p>
                        </div>
                        <div class="mx-1">
                            <input type="date" id="end_date" name="end_date" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-filter"></i></button>
                        <a href="{{ route('kasir.getSale') }}" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrows-rotate"></i></a>
                    </div>
                </form>
            </div>
        </div>

        <div id="main-table" class="block py-1"> 
            <table class="min-w-full table-fixed border ">
                <thead class="text-left">
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border border-gray-400 w-1/8">Tanggal</th>
                        <th class="py-2 px-4 border border-gray-400 w-2/7">Pencatat</th>
                        <th class="py-2 px-4 border border-gray-400 w-2/7">Total Penjualan</th>
                        <th class="py-2 px-4 border text-center border-gray-400 w-1/15">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse ($sales as $sale)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border border-gray-400">{{ $sale->tgl_penjualan_formatted }}</td>
                        <td class="py-2 px-4 border border-gray-400">{{ $sale->nama_pengguna }}</td>
                        <td class="py-2 px-4 border border-gray-400">{{ $sale->total_penjualan_formatted }}</td>
                        <td class="py-2 px-4 border text-center border-gray-400">
                        <a href="{{ route('kasir.getSaleDetail',$sale->id_penjualan) }}"><button class="bg-blue-500 cursor-pointer hover:bg-blue-600 text-white px-3 py-1 rounded mr-2"><i class="fa-solid fa-circle-info"></i></button></a>
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
    </x-main_content>
</x-layout>
