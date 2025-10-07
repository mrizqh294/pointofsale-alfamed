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
                <button :class="ubahStyle({{ $medic->id_obat }})" type="button" @click="kurangJumlah({{ $medic->id_obat }}, items)">-</button>
                <input :value="tampilJumlah({{ $medic->id_obat }})" type="text" class="w-15 px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                <button :class="ubahStyle({{ $medic->id_obat }})" type="button" @click="tambahJumlah({{ $medic->id_obat }}); tambahItem( {{ $loop->index }}, @js($medic->id_obat), @js($medic->nama), @js($medic->harga_jual), tampilJumlah({{ $medic->id_obat }})) ">+</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
