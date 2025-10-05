<x-layout>
    <x-sidebar_kasir></x-sidebar_kasir>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot>
        <div x-data="{ ...transaksiBaru(), ...jumlahObat() }" class="w-full h-full flex">
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
                                <thead class="bg-teal-600 text-white sticky top-0 z-10">
                                    <tr>
                                        <th class="ps-6 pe-4 py-2 text-left w-2/5">Obat</th>
                                        <th class="px-4 py-4 text-right w-1/5">Harga</th>
                                        <th class="px-4 py-2 text-center w-1/8">Stok</th>
                                        <th class="px-4 py-2 text-left w-1/5"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($medics as $medic)
                                     <tr>  
                                        <td class="ps-6 pe-4 py-2">{{ $medic->nama }}</td>
                                        <td class="px-4 py-2 text-right">{{ $medic->harga_jual_formatted }}</td>
                                        <td class="px-4 py-2 text-center">{{ $medic->stok }}</td>
                                        <td class="px-4 py-2 text-right">
                                            <input x-model="jumlah[{{ $loop->index }}].jumlah_obat" type="text" class="w-20 px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <button type="button" @click="tambahJumlah({{ $loop->index }}); tambahItem( @js($medic->id_obat), @js($medic->nama), @js($medic->harga_jual), jumlah[{{ $loop->index }}].jumlah_obat)" class="text-center cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg">+</button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div x-data="{isOpenConfirm: false}" x-cloak class="ms-4 w-1/3 h-full flex flex-col items-stretch">
                <div class="bg-white p-4 w-full rounded-lg shadow">
                    <div class="w-2/3 my-2 mx-auto text-center">
                        <h1 class="font-bold text-xl">Keranjang Transaksi</h1>
                    </div>
                    <div class="w-full my-6 ms-1 h-95">
                        <table class="w-full">
                            <thead class="bg-teal-600 text-white sticky top-0 z-10">
                                <tr class="text-sm">
                                    <th class="px-4 py-2 text-left w-2/3">Obat</th>
                                    <th class="px-4 py-2 text-center w-1/5">Qty</th>
                                    <th class="px-4 py-2 text-right w-1/5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr>
                                        <td class="px-4 py-1 text-left w-2/3" x-text="item.nama"></td>
                                        <td class="px-4 py-1 text-center w-1/5" x-text="item.jumlah_obat"></td>
                                        <td class="px-4 py-1 text-right w-1/5"><button type="button" class="cursor cursor-pointer"><i class="fa-solid fa-trash text-red-500" @click="hapusItem(index); resetJumlah(item.id_obat)"></i></button></td>
                                    </tr>
                                </template> 
                            </tbody>
                        </table>  
                    </div>
                    <h1 class="font-bold">Total Item : <span class="font-normal" x-text="jumlahItem()"></span></h1>
                    <h1 class="font-bold">Total Transaksi : <span class="font-normal" x-text="totalTransaksi()"></span></h1>
                </div>
                <button type="button" class="mt-4 inline-block w-full text-center cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-3 rounded-lg" @click="isOpenConfirm = !isOpenConfirm">Simpan</button>

                {{-- modal confirm simpan transaksi --}}
                <div>
                    <div class="fixed top-0 left-0 z-20 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenConfirm">
                        <div class="p-8 bg-white w-1/3 rounded-xl text-center grid gird-cols-1 place-items-center">
                            <h1 class="font-bold text-lg">
                                Apakah anda yakin akan menyimpan data ini?
                            </h1>
                            <img src="/images/store.svg" class="p-5">
                            <div class="w-full items-start">
                                <form action="{{ route('kasir.addSale') }}" method="post">
                                    @csrf
                                    <input type="text" name="id_pengguna" value="{{ session('id_pengguna') }}" hidden>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div>
                                            <input type="number" :name="`items[${index}][id_obat]`" :value="item.id_obat" hidden>
                                            <input type="number" :name="`items[${index}][jumlah_obat]`" :value="item.jumlah_obat" hidden>
                                        </div>
                                    </template>
                                    <button type="submit" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Simpan</button>
                                    <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded-lg" @click="isOpenConfirm = !isOpenConfirm"><i class="fa-solid fa-xmark"></i> Batal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-main_content>
    <script>
        function transaksiBaru() {
            return {
                items: [],

                tambahItem(id, nama, harga, jumlah) {
                    let item = this.items.find(i=> i.id_obat === id)
                    if(item){
                        item.jumlah_obat = jumlah
                    }else{
                        this.items.push({ id_obat: id, nama: nama, harga_jual: harga, jumlah_obat: jumlah });
                    }
                },

                hapusItem(index) {
                    this.items.splice(index, 1);
                },

                jumlahItem(){
                    return this.items.reduce((sum, item) => sum + item.jumlah_obat, 0);
                },

                totalTransaksi(){
                    let totalTransaksi = this.items.reduce((sum, item) => sum + (item.harga_jual * item.jumlah_obat), 0);
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }
                    ).format(totalTransaksi)
                }
            }
        }

        function jumlahObat() {
            return {
                jumlah: [
                    @foreach ($medics as $medic)
                        { id_obat: {{ $medic->id_obat }}, jumlah_obat: 0 },
                    @endforeach
                ],

                tambahJumlah(index) {
                    this.jumlah[index].jumlah_obat++;
                },

                resetJumlah(id){
                    let data = this.jumlah.find(i=> i.id_obat === id);
                    console.log(data)
                    if(data){
                        data.jumlah_obat = 0;
                    }
                }
            }
        }
    </script>
</x-layout>
