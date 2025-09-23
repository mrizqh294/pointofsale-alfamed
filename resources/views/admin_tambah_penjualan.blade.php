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
            <div x-data="formPenjualan()">
                <form action="{{ route('penjualan.addSale') }}" method="post">
                    @csrf
                    <input type="text" name="id_pengguna" value="{{ session('id_pengguna') }}" hidden>
                    <table>
                        <thead class="text-left">
                            <tr class="">
                                <th class="py-2 w-2/4">
                                    <label for="id_obat" class="block font-bold mb-2">Obat</label>
                                </th>
                                <th class="py-2 w-2/4">
                                    <label for="jumlah_obat" class="block font-bold mb-2">Jumlah Obat</label>
                                </th>
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
                        <button type="button" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg" @click="tambahItem()"><i class="fa-solid fa-plus"></i> Tambah</button>
                        <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </x-main_content>
    <script>
        function formPenjualan() {
            return {
                items: [
                    { id_obat: '', jumlah_obat: 1}
                ],
                tambahItem() {
                    this.items.push({ id_obat: '', jumlah_obat: 1 });
                },
                hapusItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
</x-layout>

