<x-layout>
    <x-sidebar_pemilik></x-sidebar_pemilik>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot:title>
        <div class="flex justify-between py-3">
            <div>
                <form action="{{ route('pemilik.getPurchase') }}" method="get" class="">
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
                        <a href="{{ route('pemilik.getPurchase') }}" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrows-rotate"></i></a>
                        <a href="{{ route('pemilik.exportPembelian', request()->query()) }}" class="mx-1 cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-excel"></i> Ekspor</a>
                    </div>
                </form>
            </div>
        </div>

        <div id="main-table" class="block py-1"> 
            <table class="min-w-full table-fixed border ">
                <thead class="text-center">
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border border-gray-400 w-2/12">Tanggal</th>
                        <th class="py-2 px-4 border border-gray-400 w-1/6">Pencatat</th>
                        <th class="py-2 px-4 border border-gray-400 w-2/8">Suplier</th>
                        <th class="py-2 px-4 border border-gray-400 w-2/8">Total Pembelian</th>
                        <th class="py-2 px-4 border border-gray-400 w-1/9">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                     @forelse ($purchases as $purchase)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border border-gray-400">{{ $purchase->tgl_pembelian_formatted }}</td>
                        <td class="py-2 px-4 border border-gray-400">{{ $purchase->nama_pengguna }}</td>
                        <td class="py-2 px-4 border border-gray-400">{{ $purchase->nama_supplier }}</td>
                        <td class="text-right py-2 px-4 border border-gray-400">{{ $purchase->total_pembelian_formatted }}</td>
                        <td class="text-center py-2 px-4 border border-gray-400">
                        <a href="{{ route('pemilik.getPurchaseDetail',$purchase->id_pembelian) }}"><button class="bg-blue-500 cursor-pointer hover:bg-blue-600 text-white px-3 py-1 rounded"><i class="fa-solid fa-circle-info my-1"></i></button></a>
                        <button class="bg-red-500 cursor-pointer hover:bg-red-600 text-white px-3 py-1 rounded" @click="isOpenDestroy = !isOpenDestroy; id = {{ $purchase->id_pembelian }}"><i class="fa-solid fa-trash"></i></button>
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
                {{ $purchases->links() }}
            </div>
        </div>
    </x-main_content>
</x-layout>
