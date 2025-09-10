<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="flex w-full max-w-1/2 bg-white rounded-lg shadow-md">
        <div class= "w-2/5 bg-green-400"> 
            <img src="" alt="">  
        </div>
        <div class="w-3/5 bg-white p-8 ">
            <h2 class="block text-2xl font-bold text-center text-gray-800">Login</h2>
            <form action="/login" method="POST" class="space-y-4">
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
                        <option value="user">Kasir</option>
                        <option value="admin">Admin</option>
                        <option value="moderator">Manajer</option>
                    </select>
                </div>
                <button type="submit" class="w-full p-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none">Login</button>
            </form>
        </div>
        
    </div>
</body>
</html>