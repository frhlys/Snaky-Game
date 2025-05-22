<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
        <style>
    canvas {
      border: 4px solid white;
    }
  </style><script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Snake Game</h1>
        <a href="{{ route('game') }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
            Start Game
        </a>
    </div>
</body>
</html>
