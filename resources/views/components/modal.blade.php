<div class="fixed top-0 left-0 w-full h-screen bg-black/40 flex justify-center items-center" x-data="{ {{ $x_data ?? 'open:false' }} }" x-show="{{ $x_show ?? 'open' }}">
    <div class="p-8 bg-white w-1/3 rounded-xl">
        <h1 class="font-bold mb-4 text-lg">{{ $modalTitle }}</h1>
        {{ $slot }}
    </div>
</div>