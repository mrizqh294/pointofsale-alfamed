<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  @vite('resources/css/app.css')
  <script src="https://kit.fontawesome.com/fe3ef3fd79.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <style>[x-cloak] { display: none !important; }</style>  
  <title>Apotek Alfamed</title>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    {{ $slot }}
  </div>
</body>
</html>