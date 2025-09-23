<x-layout>
    @if (session('status'))
        <div x-data="{isOpenAlert: true}" x-cloak>
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

    <div class="flex items-center justify-center h-screen w-full bg-gray-100">
        <div class="flex w-full max-w-1/2 bg-white shadow-md rounded-lg">
            <div class= "w-2/5 bg-teal-600 flex flex-col justify-center items-center rounded-s-lg">
                <div class="p-6">
                    <img src="/images/alfamed-logo.png" alt="" class="w-60 h-60 rounded-full"> 
                </div> 
                <div class="p-3">
                    <h1 class="text-white font-bold text-lg">SICATAT ALFAMED</h1>
                </div>
            </div>
            <div class="w-3/5 p-8 ">
                <h2 class="block text-2xl font-bold text-center text-gray-800">Login</h2>
                <form action="{{ route('login') }}" method="post" class="space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-600">Username</label>
                        <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>
                        <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    </div>
                    <div>
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-600">Role</label>
                        <select id="role" name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Pegawai">Pegawai</option>
                            <option value="Admin">Admin</option>
                            <option value="Manajer">Manajer</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full p-3 text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:outline-none">Login</button>
                </form>
            </div>   
        </div>
    </div>


</x-layout>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
     @if (session('status'))
        <div x-data="{isOpenAlert: true}" x-cloak>
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

    <div class="flex w-full max-w-1/2 bg-white rounded-lg shadow-md">
        <div class= "w-2/5 bg-green-400"> 
            <img src="" alt="">  
        </div>
        <div class="w-3/5 bg-white p-8 ">
            <h2 class="block text-2xl font-bold text-center text-gray-800">Login</h2>
            <form action="{{ route('auth.login') }}" method="post" class="space-y-4">
                @csrf
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-600">Username</label>
                    <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                </div>
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-600">Role</label>
                    <select id="role" name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Pegawai">Pegawai</option>
                        <option value="Admin">Admin</option>
                        <option value="Manajer">Manajer</option>
                    </select>
                </div>
                <button type="submit" class="w-full p-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none">Login</button>
            </form>
        </div>   
    </div>

</body>
</html> --}}