<div class="flex justify-between pt-3 pb-3 px-1" x-data="{ isOpenAdd: false }" x-cloak>
    <div>
        <input type="search" class="px-4 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari Data">
    </div>
    <button class="btn cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg" @click="isOpenAdd = !isOpenAdd"><i class="fa-solid fa-plus"></i>Tambah Data</button>
    <div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-show="isOpenAdd">
        <div class="p-8 bg-white w-1/3 rounded-xl">
            <h1 class="font-bold mb-4 text-lg">{{ $title }}</h1>
            {{ $slot }}
        </div>
    </div> 
</div>