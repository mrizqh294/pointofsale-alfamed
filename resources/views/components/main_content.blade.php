<div class="flex-1 flex flex-col">
    <header class="bg-gray-100 px-6 py-6 mb-1 flex justify-between items-center shadow-md">
      <h2 class="font-semibold text-2xl">{{ $title }}</h2>
      <div class="relative ml-3 flex space-x-4">
        <span class="text-gray-600 pt-1">{{ session('nama') }}</span>
        <span class="text-3xl text-gray-500"><i class="fa-solid fa-circle-user"></i></span>
      </div>
    </header>

    <main class="p-4 w-full h-full overflow-y-auto">
      {{ $slot }}
    </main>
</div>