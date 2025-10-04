<x-layout>
    <x-sidebar_kasir></x-sidebar_kasir>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot>
        <div class="w-full h-full flex">
            <div class="w-2/3">
                <div class="bg-white px-4 py-4  rounded-lg shadow">
                    <div class="">
                        <input type="text" id="search" name="search" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari Obat">
                    </div>
                </div>
                <div class="h-130 bg-white my-4 rounded-lg shadow">
                    <div class="border border-gray-300 rounded-lg overflow-hidden">
                        <div class="overflow-y-auto max-h-130">
                            <table class="w-full border-collapse">
                                <thead class="bg-gray-200 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-4 py-2 text-left w-2/5">Obat</th>
                                        <th class="px-4 py-2 text-right w-1/5">Harga</th>
                                        <th class="px-4 py-2 text-center w-1/8">Stok</th>
                                        <th class="px-4 py-2 text-left w-1/5"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($medics as $medic)
                                     <tr>
                                        <td class="px-4 py-2">{{ $medic->nama }}</td>
                                        <td class="px-4 py-2 text-right">{{ $medic->harga_jual_formatted }}</td>
                                        <td class="px-4 py-2 text-center">{{ $medic->stok }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <input type="text" id="jumlah" name="jumlah" class="w-20 px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <button class="text-center cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg">+</button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="ms-4 w-1/3 h-full flex flex-col items-stretch">
                <div class="bg-white p-4 w-full rounded-lg shadow">
                    <div class="w-2/3 my-2 mx-auto text-center">
                        <h1 class="font-bold text-xl">Keranjang Transaksi</h1>
                    </div>
                    <div class="my-6 ms-1">
                        <p class="text-sm">Paracetamol 500 gram</p>
                    </div>

                </div>
                <button class="mt-4 inline-block w-full text-center cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-3 rounded-lg">Simpan</button>
            </div>
        </div>
    </x-main_content>
</x-layout>
