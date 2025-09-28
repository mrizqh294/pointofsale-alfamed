<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
      <x-slot:title>{{ $title }}</x-slot>
        <div class="" x-data="{ isOpenAdd: false, isOpenDestroy: false, isOpenUpdate: false, id: null, current: {} }" x-cloak>

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
                <form method="get">
                  @csrf
                  <input type="text" id="search" name="search" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari Obat">
                  <button type="submit" formaction="{{ route('obat.getMedicine') }}" class="ms-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-magnifying-glass"></i></button>
                  <a href="{{ route('obat.getMedicine') }}" class="mx-1 cursor-pointer border border-teal-600 bg-gray-100 hover:bg-gray-200 text-teal-600 px-3 py-2 rounded-lg"><i class="fa-solid fa-arrows-rotate"></i></a>
                  <a href="{{ route('obat.exportObat')}}" class="mx-1 cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-excel"></i> Ekspor</a>
                </form>
              </div>
              <button class="btn cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded-lg" @click="isOpenAdd = !isOpenAdd"><i class="fa-solid fa-plus"></i> Tambah Data</button>
              

              {{-- modal tambah data --}}
              <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenAdd">
                <div class="p-8 bg-white w-1/3 rounded-xl">
                  <h1 class="font-bold mb-4 text-lg">Tambah Data Obat</h1>
                  <form action="{{ route('obat.addMedicine') }}" method="post">
                    @csrf
                    <div class="mb-4">
                      <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Obat</label>
                      <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Obat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                      <label for="kategori" class="block text-gray-700 font-medium mb-2">Kategori</label>
                      <select id="kategori" name="id_kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach ($kategories as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->kode }} - {{ $kategori->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label for="harga_jual" class="block text-gray-700 font-medium mb-2">Harga Jual</label>
                      <input type="number" min="0" id="harga_jual" name="harga_jual" placeholder="Masukkan Harga Jual" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                      <label for="harga_beli" class="block text-gray-700 font-medium mb-2">Harga Beli</label>
                      <input type="number" min="0" id="harga_beli" name="harga_beli" placeholder="Masukkan Harga Beli" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                      <label for="stok" class="block text-gray-700 font-medium mb-2">Stok Obat</label>
                      <input type="number" min="0" id="stok" name="stok" placeholder="Masukkan Total Stok" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <button type="submit" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Simpan</button>
                    <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded-lg" @click="isOpenAdd = !isOpenAdd"><i class="fa-solid fa-xmark"></i> Batal</button>
                  </form>
                </div>
              </div> 
            </div>

            {{-- modal edit--}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenUpdate">
              <div class="p-8 bg-white w-1/3 rounded-xl">
                <h1 class="font-bold mb-4 text-lg">Edit Data Obat</h1>
                <form :action="`{{ route('obat.updateMedicine', ':id') }}`.replace(':id', current.id_obat)" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Obat</label>
                    <input type="text" id="nama" name="nama" :value="`${current.nama_obat}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="mb-4">
                    <label for="kategori" class="block text-gray-700 font-medium mb-2">Kategori</label>
                    <select id="kategori" name="id_kategori" x-model ="current.id_kategori"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                      @foreach ($kategories as $kategori)
                        <option value="{{ $kategori->id_kategori }}">{{ $kategori->kode }} - {{ $kategori->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-4">
                    <label for="harga_jual" class="block text-gray-700 font-medium mb-2">Harga Jual</label>
                    <input type="number" min="0" id="harga_jual" name="harga_jual" :value="`${current.harga_jual}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="mb-4">
                    <label for="harga_beli" class="block text-gray-700 font-medium mb-2">Harga Beli</label>
                    <input type="number" min="0" id="harga_beli" name="harga_beli" :value="`${current.harga_beli}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="mb-4">
                    <label for="stok" class="block text-gray-700 font-medium mb-2">Stok Obat</label>
                    <input type="number" min="0" id="stok" name="stok" :value="`${current.stok}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <button type="submit" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Simpan</button>
                  <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5  rounded-lg" @click="isOpenUpdate = !isOpenUpdate"><i class="fa-solid fa-xmark"></i> Batal</button>
                </form>
              </div>
            </div> 

            {{-- delete modal --}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenDestroy">
              <div class="p-8 bg-white w-1/3 rounded-xl">
                <h1 class="font-bold mb-4 text-lg">Apakah Anda Yakin Ingin Menghapus Data Ini?</h1>
                <p class="my-4">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                <form :action="`{{ route('obat.destroyMedicine', ':id') }}`.replace(':id', id)" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg"><i class="fa-solid fa-check"></i> Hapus</button>
                  <button type="button" class="cursor-pointer border-gray-300 text-gray-600 hover:bg-gray-100 px-3 py-1.5 rounded-lg" @click="isOpenDestroy = !isOpenDestroy"><i class="fa-solid fa-xmark"></i> Batal</button>
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
                    <th class="py-2 px-4 border border-gray-400 w-2/7">Nama</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Kategori</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Harga Jual</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/15">Stok</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Aksi</th>
                  </tr>
                </thead>
                <tbody class="">
                  @forelse ($medics as $medic)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border border-gray-400">{{ $medic->nama_obat }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $medic->nama_kategori }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $medic->harga_jual_formatted }}</td>
                    <td class="py-2 px-4 border border-gray-400">{{ $medic->stok }}</td>
                    <td class="py-2 px-4 border border-gray-400">
                      <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2"  @click="isOpenUpdate = !isOpenUpdate; current = {{ $medic->toJson() }}"><i class="fa-solid fa-pen-to-square"></i></button>
                      <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded mr-2" @click="isOpenDestroy = !isOpenDestroy; id = {{ $medic->id_obat }}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center py-2 px-4 border border-gray-400">Data Tidak Ditemukan!</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              <div class="mt-4">
                {{ $medics->links() }}
              </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script>
              $(document).ready(function() {
                $('#search').on('keyup', function() {
                  let query = $(this).val();
                  if(query.length > 0){
                    $.ajax({
                      url: "{{ route('obat.findMedicine') }}",
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

