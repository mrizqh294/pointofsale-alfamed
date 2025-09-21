<x-layout>
    <x-sidebar_admin></x-sidebar_admin>
    <x-main_content>
      <x-slot:title>{{ $title }}</x-slot>
        <div class="" x-data="{ isOpenAdd: false, isOpenDestroy: false, isOpenUpdate: false, id: null, currentCategory: {} }" x-cloak>

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
                <form action="{{ route('kategori.findCategory') }}" method="get">
                  @csrf
                  <input type="text" id="search" name="search" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari kategori">
                </form>
              </div>
              <button class="btn cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenAdd = !isOpenAdd"><i class="fa-solid fa-plus"></i> Tambah Data</button>

              {{-- modal tambah data --}}
              <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenAdd">
                <div class="p-8 bg-white w-1/3 rounded-xl">
                  <h1 class="font-bold mb-4 text-lg">Tambah Data Kategori</h1>
                  <form action="{{ route('kategori.addCategory') }}" method="post">
                    @csrf
                    <div class="mb-4">
                      <label for="kode" class="block text-gray-700 font-medium mb-2">Kode Kategori</label>
                      <input 
                        type="text" id="kode" name="kode" placeholder="Masukkan kode kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                      <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                      <input type="text" id="nama" name="nama" placeholder="Masukkan nama kategori"class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg">Simpan</button>
                    <button type="button" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenAdd = !isOpenAdd">Batal</button>
                  </form>
                </div>
              </div> 
            </div>

            {{-- modal edit kategori --}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenUpdate">
              <div class="p-8 bg-white w-1/3 rounded-xl">
                <h1 class="font-bold mb-4 text-lg">Edit Data Kategori</h1>
                <form :action="`{{ route('kategori.updateCategory', ':id') }}`.replace(':id', currentCategory.id_kategori)" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="mb-4">
                    <label for="kode" class="block text-gray-700 font-medium mb-2">Kode Kategori</label>
                    <input type="text" id="kode" name="kode" placeholder="" :value="`${currentCategory.kode}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                    <input type="text" id="nama" name="nama" placeholder="" :value="`${currentCategory.nama}`" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  </div>
                  <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg">Simpan</button>
                  <button type="button" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenUpdate = !isOpenUpdate">Batal</button>
                </form>
              </div>
            </div> 

            {{-- delete modal --}}
            <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenDestroy">
              <div class="p-8 bg-white w-1/3 rounded-xl">
                <h1 class="font-bold mb-4 text-lg">Apakah Anda Yakin Ingin Menghapus Data Ini?</h1>
                <p class="my-4">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                <form :action="`{{ route('kategori.destroyCategory', ':id') }}`.replace(':id', id)" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg">Hapus</button>
                  <button type="button" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenDestroy = !isOpenDestroy">Batal</button>
                 </form>
              </div>
            </div>

            {{-- tabel result livesearch --}}
            <div id="result" class="hidden py-1"></div>

            
            {{-- tabel utama --}}
            <div id="main-table" class="block py-1"> 
              <table class="min-w-full table-fixed border ">
                <thead class="text-left">
                  <tr class="bg-gray-200">
                    <th class="py-2 px-4 border border-gray-400 w-2/7">Kode</th>
                    <th class="py-2 px-4 border border-gray-400 w-4/7">Nama</th>
                    <th class="py-2 px-4 border border-gray-400 w-1/7">Aksi</th>
                  </tr>
                </thead>
                <tbody class="">
                  @foreach ($kategories as $kategori)
                  <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border  border-gray-400">{{ $kategori->kode }}</td>
                    <td class="py-2 px-4 border  border-gray-400">{{ $kategori->nama }}</td>
                    <td class="py-2 px-4 border  border-gray-400">
                      <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2"  @click="isOpenUpdate = !isOpenUpdate; currentCategory = {{ $kategori->toJson() }}"><i class="fa-solid fa-pen-to-square"></i></button>
                      <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded mr-2" @click="isOpenDestroy = !isOpenDestroy; id = {{ $kategori->id_kategori }}"><i class="fa-solid fa-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="mt-4">
                {{ $kategories->links() }}
              </div>
            </div>

            {{-- script ajax --}}
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script>
              $(document).ready(function() {
                $('#search').on('keyup', function() {
                  let query = $(this).val();
                  if(query.length > 0){
                    $.ajax({
                      url: "{{ route('kategori.findCategory') }}",
                      type: 'GET',
                      data: { data: query, _token: '{{ csrf_token() }}' },
                      success: function(data) {
                        let html = '';
                        let items = data.data;
                        if(data.data.length > 0) {
                          html += '<table class="min-w-full table-auto border border-gray-400">'
                          html += '<thead class="text-left"><tr class="bg-gray-200 border-b border-gray-400 c"><th class="py-2 px-4 border border-gray-400 w-2/7">Kode</th><th class="py-2 px-4 border border-gray-400 w-4/7">Nama</th><th class="py-2 px-4 border border-gray-400 w-1/7">Aksi</th></tr></thead><tbody>'
                          data.data.forEach(function(item){

                            html += `<tr class="hover:bg-gray-50 border border-gray-400">
                                      <td class="py-2 px-4 border border-gray-400">${item.kode}</td>
                                      <td class="py-2 px-4 border border-gray-400">${item.nama}</td>
                                      <td class="py-2 px-4 border border-gray-400">
                                      <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded mr-2"  @click='isOpenUpdate = !isOpenUpdate; currentCategory= ${JSON.stringify(item)}'><i class="fa-solid fa-pen-to-square"></i></button>
                                      <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded mr-2" @click='isOpenDestroy = !isOpenDestroy; id= ${item.id_kategori}'><i class="fa-solid fa-trash"></i></button>
                                      </td>
                                      </tr>`;
                          });
                          html += `</tbody></table>`
                        } else {
                          html += '<table class="min-w-full table-auto border border-gray-400">'
                          html += '<thead class="text-left"><tr class="bg-gray-200 border-b border-gray-400"><th class="py-2 px-4 w-2/7 border border-gray-400">Kode</th> <th class="py-2 px-4 w-4/7 border border-gray-400">Nama</th><th class="py-2 px-4 w-1/7 border border-gray-400">Aksi</th></tr></thead>'
                          html += '<tbody><tr><td colspan="3" class="py-2 px-4 text-center">Data Tidak Ditemukan!</td></tr></tbody></table>'
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