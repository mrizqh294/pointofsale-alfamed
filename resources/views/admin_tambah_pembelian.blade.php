<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot>
        @if (session('status'))
              <div x-data="{isOpenAlert: true}">
                <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenAlert">
                  <div class="p-8 bg-white w-1/3 rounded-xl text-center">
                    <h1 class="font-bold mb-4 text-lg">
                      {{ session('status') }}
                    </h1>
                    <button type="button" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenAlert = !isOpenAlert">Oke</button>
                  </div>
                </div>
              </div>
        @endif
        <div class="px-5 py-3">
            <div x-data="formPembelian()">
                <form action="{{ route('pembelian.addPurchase') }}" method="post">
                    @csrf
                    <input type="text" name="id_pengguna" value="{{ session('id_pengguna') }}" hidden>
                    <div class="mb-6">
                      <label for="id_supplier" class="block font-bold mb-5">Suplier</label>
                      <select id="id_supplier" name="id_supplier" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama }}</option>
                        @endforeach
                      </select>
                    </div>

                    <table>
                        <thead class="text-left">
                            <tr class="">
                                <th class="py-2 w-3/7">
                                    <label for="id_obat" class="block font-bold mb-2">Obat</label>
                                </th>
                                <th class="py-2 w-1/6">
                                    <label for="jumlah_obat" class="block font-bold mb-2">Jumlah Obat</label>
                                </th>
                                <th class="py-2 w-2/7">
                                     <label for="harga_beli" class="block font-bold mb-2">Harga Beli/Pcs</label>
                                </th>
                                <th class="py-2 w-1/7">
                                    <label for="tgl_kadaluarsa" class="block font-bold mb-2">Tanggal Kadaluarsa</label>
                                </th>
                                <th class="py-2 w-1/7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="text-light py-2" x-data="{id: '', ...updateHarga()}">
                                    <td class="py-2 w-3/7">
                                        <div class="mb-4 me-2">
                                            <select id="id_obat" x-model="id" @change="tampilHarga(id)" :name="`items[${index}][id_obat]`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                <option value="" disabled selected>Pilih Obat</option>
                                                @foreach ($medics as $medic)
                                                <option value="{{ $medic->id_obat }}">{{ $medic->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td class="py-2 w-1/6">
                                        <div class="mb-4 me-2">
                                            <input type="number" min="0" :name="`items[${index}][jumlah_obat]`" placeholder="Jumlah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        </div>
                                    </td>
                                    <td class="py-2 w-2/7">
                                        <div class="mb-4 me-2">
                                            <input type="number" min="0" id="harga_beli" x-model="price" :name="`items[${index}][harga_beli]`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        </div>
                                    </td>
                                    <td class="py-2 w-1/7">
                                        <div class="mb-4 me-2">
                                            <input type="date" id="tgl_kadaluarsa" :name="`items[${index}][tgl_kadaluarsa]`" placeholder="Masukkan Tanggal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        </div>
                                    </td>
                                    <td class="py-2 w-1/7">
                                        <div class="mb-4.5">
                                            <button type="button" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg" @click="hapusItem(index)"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div class="flex flex-cols gap-4 py-4 justify-end">
                        <button type="button" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg" @click="tambahItem()"><i class="fa-solid fa-plus"></i> Tambah</button>
                        <button type="submit" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </x-main_content>
    <script>
        function formPembelian() {
            return {
                items: [
                    { id_obat: '', jumlah_obat: 1, harga_beli: 0, tgl_kadaluarsa: '' }
                ],
                tambahItem() {
                    this.items.push({ id_obat: '', jumlah_obat: 1, harga_beli: 0, tgl_kadaluarsa: '' });
                },
                hapusItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }

        function updateHarga() {
            return{
                medics: [
                    @foreach ( $medics as $medic )
                        {id : {{ $medic->id_obat }}, harga : {{ $medic->harga_beli }}},
                    @endforeach
                ],

                price: '',

                tampilHarga(id){
                    if(!id){
                        return;
                    }

                    let item = this.medics.find(i=> i.id === Number(id));
                    console.log(item);
                    
                    this.price = item.harga;
                }
            }
        }
    </script>
</x-layout>
