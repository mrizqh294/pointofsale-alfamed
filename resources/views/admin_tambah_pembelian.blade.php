<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
        <x-slot:title>{{ $title }}</x-slot>
        <div class="px-5 py-3">
            <div x-data="formPembelian()">
                <form action="{{ route('pembelian.addPurchase') }}" method="post">
                    @csrf
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
                                     <label for="harga_beli" class="block font-bold mb-2">Harga Beli</label>
                                </th>
                                <th class="py-2 w-1/7">
                                    <label for="tgl_kadaluarsa" class="block font-bold mb-2">Tanggal Kadaluarsa</label>
                                </th>
                                <th class="py-2 w-1/7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="text-light py-2">
                                    <td class="py-2 w-3/7">
                                        <div class="mb-4 me-2">
                                            <select id="id_obat" :name="`items[${index}][id_obat]`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
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
                                            <input type="number" min="0" id="harga_beli" :name="`items[${index}][harga_beli]`" placeholder="Masukkan Harga Beli" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
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

                    {{-- <template x-for="(item, index) in items" :key="index">
                        <div class="py-5 flex flex-cols items-end gap-5">
                            <div class="mb-4 w-2/5">
                                <label for="id_obat" class="block text-gray-700 font-medium mb-2">Obat</label>
                                <select id="id_obat" :name="`items[${index}][id_obat]`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    @foreach ($medics as $medic)
                                    <option value="{{ $medic->id_obat }}">{{ $medic->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 w-1/7">
                                <label for="jumlah_obat" class="block text-gray-700 font-medium mb-2">Jumlah Obat</label>
                                <input type="number" min="0" :name="`items[${index}][jumlah_obat]`" placeholder="Jumlah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4 w-1/4">
                                <label for="harga_beli" class="block text-gray-700 font-medium mb-2">Harga Beli</label>
                                <input type="number" min="0" id="harga_beli" :name="`items[${index}][harga_beli]`" placeholder="Masukkan Harga Beli" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label for="tgl_kadaluarsa" class="block text-gray-700 font-medium mb-2">Tanggal Kadaluarsa</label>
                                <input type="date" id="tgl_kadaluarsa" :name="`items[${index}][tgl_kadaluarsa]`" placeholder="Masukkan Tanggal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4.5">
                                <button type="button" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg" @click="hapusItem(index)"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </template> --}}

                    <div class="flex flex-cols gap-4 py-4 justify-end">
                        <button type="button" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg" @click="tambahItem()">+ Tambah Obat</button>
                        <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg">Simpan</button>
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
    </script>
</x-layout>
