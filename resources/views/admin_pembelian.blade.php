<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
      <x-slot:title>{{ $title }}</x-slot>
        <div class="" x-data="{ isOpenAdd: false, isOpenDestroy: false, isOpenUpdate: false, id: null, current: {} }" x-cloak>

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

            <div class="flex justify-between py-3">
              <div>
                <form action="{{ route('pembelian.findPurchase') }}" method="get">
                  @csrf
                  <input type="text" id="search" name="search" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari Pembelian">
                </form>
              </div>
              <a href="{{ route('pembelian.getAddPurchase') }}" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-plus"></i> Tambah Data</a>
            </div>

            {{-- delete modal --}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenDestroy">
              <div class="p-8 bg-white w-1/3 rounded-xl">
                <h1 class="font-bold mb-4 text-lg">Apakah Anda Yakin Ingin Menghapus Data Ini?</h1>
                <p class="my-4">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                <form :action="`{{ route('pembelian.destroyPurchase', ':id') }}`.replace(':id', id)" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg">Hapus</button>
                  <button type="button" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenDestroy = !isOpenDestroy">Batal</button>
                 </form>
              </div>
            </div>

            {{-- tabel result livesearch --}}
            <div id="result" class="hidden"></div>

            
            {{-- tabel utama --}}
            <div id="main-table" class="block py-1"> 
              <table class="min-w-full table-fixed border ">
                <thead class="text-left">
                  <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-400 w-2/7">Pencatat</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Suplier</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Total Pembelian</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Aksi</th>
                  </tr>
                </thead>
                <tbody class="">
                  @foreach ($purchases as $purchase)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border border-gray-400">{{ $purchase->nama_pengguna }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $purchase->nama_supplier }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $purchase->total_pembelian }}</td>
                    <td class="py-2 px-4 border border-gray-400">
                      <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2"  @click="isOpenUpdate = !isOpenUpdate; current = {{ $medic->toJson() }}"><i class="fa-solid fa-pen-to-square"></i></button>
                      <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded mr-2" @click="isOpenDestroy = !isOpenDestroy; id = {{ $medic->id_obat }}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="mt-4">
                {{ $purchases->links() }}
              </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script>
              $(document).ready(function() {
                $('#search').on('keyup', function() {
                  let query = $(this).val();
                  if(query.length > 0){
                    $.ajax({
                      url: "{{ route('pembelian.findPurchase') }}",
                      type: 'GET',
                      data: { data: query, _token: '{{ csrf_token() }}' },
                      success: function(data) {
                        let html = '';
                        let items = data.data;
                        if(data.data.length > 0) {
                          html += '<table class="min-w-full table-auto border border-gray-400">'
                          html += '<thead class="text-left"><tr class="bg-gray-200"><th class="py-2 px-4 border border-gray-400 w-2/7">Nama</th><th class="py-2 px-4 border border-gray-400 w-1/7">kategori</th><th class="py-2 px-4 border border-gray-400 w-1/7">Harga Jual</th><th class="py-2 px-4 border border-gray-400 w-1/15">Stok</th><th class="py-2 px-4 border border-gray-400 w-1/7">Aksi</th></tr></thead><tbody class="">'
                          items.forEach(function(item){
                            html += `<tr class="hover:bg-gray-50">
                                      <td class="py-2 px-4 border border-gray-400">${item.nama_obat}</td>
                                      <td class="py-2 px-4 border border-gray-400">${item.nama_kategori}</td>
                                      <td class="py-2 px-4 border border-gray-400">${item.harga_jual}</td>
                                      <td class="py-2 px-4 border border-gray-400">${item.stok}</td>
                                      <td class="py-2 px-4 border border-gray-400">
                                      <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2"  @click='isOpenUpdate = !isOpenUpdate; current= ${JSON.stringify(item)}'><i class="fa-solid fa-pen-to-square"></i></button>
                                      <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded mr-2" @click='isOpenDestroy = !isOpenDestroy; id= ${item.id_obat}'><i class="fa-solid fa-trash"></i></button>
                                      </td>
                                      </tr>`;
                          });
                          html += `</tbody></table>`
                        } else {
                          html += '<table class="min-w-full table-auto border border-gray-400">'
                          html += '<thead class="text-left"><tr class="bg-gray-200"><th class="py-2 px-4 border border-gray-400 w-2/7">Nama</th><th class="py-2 px-4 border border-gray-400 w-1/7">kategori</th><th class="py-2 px-4 border border-gray-400 w-1/7">Harga Jual</th><th class="py-2 px-4 border border-gray-400 w-1/15">Stok</th><th class="py-2 px-4 border border-gray-400 w-1/7">Aksi</th></tr></thead><tbody class="">'
                          html += '<tbody><tr><td colspan="5" class="py-2 px-4 text-center">Data Tidak Ditemukan!</td></tr></tbody></table>'
                        }
                        $('#main-table').addClass('hidden');
                        $('#result').html(html).removeClass('hidden');
                      }
                    });
                  } else {
                    $('#result').addClass('hidden');
                    $('#main-table').removeClass('hidden');
                  }
                });
              });
            </script>
        </div>     
    </x-main_content>
</x-layout>


