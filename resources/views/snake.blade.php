<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Snake Game</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="js/theme.js"></script>
  <script>
    // Toggle sidebar function
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('-translate-x-full');
    }

  // Toggle dropdown visibility
  const btn = document.getElementById('themeDropdownBtn');
  const dropdown = document.getElementById('themeDropdown');

  btn.addEventListener('click', () => {
    dropdown.classList.toggle('hidden');
  });

  // Example theme switching function
  function setTheme(theme) {
    alert(`Theme changed to: ${theme}`);
    dropdown.classList.add('hidden');

    // Here you can add your logic to actually change the theme
    // For example:
    // document.body.className = ''; // clear existing classes
    // document.body.classList.add(theme + '-theme'); 
  }

  // Optional: Close dropdown when clicking outside
  document.addEventListener('click', (e) => {
    if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('hidden');
    }
  });


  </script>
  <style>
    canvas {
      border: 4px solid white;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-700 to-indigo-900 text-white min-h-screen flex">

  <!-- Sidebar -->
  <aside id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-gray-900 text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-6">Game Menu</h2>
      <ul class="space-y-4">
        <li><a href="#" class="block hover:text-green-400 transition">🏡 Home</a></li>
        <li><a href="#difficulty" class="block hover:text-green-400 transition">💣 Difficulty</a></li>
        <li><a href="#scoreDisplay" class="block hover:text-green-400 transition">🧡 Score</a></li>
        
         <!-- Theme Dropdown -->
    <li class="relative">
      <button id="themeDropdownBtn" 
              class="flex items-center justify-between w-full hover:text-green-400 transition focus:outline-none">
        🎞️ Theme
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" 
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
      <ul id="themeDropdown" class="hidden absolute left-0 mt-2 w-full bg-gray-800 rounded shadow-lg z-10">
        <li><button onclick="setTheme('aerospace')" class="block w-full text-left px-4 py-2 hover:bg-green-600 transition">Aerospace</button></li>
        <li><button onclick="setTheme('modern')" class="block w-full text-left px-4 py-2 hover:bg-green-600 transition">Modern</button></li>
        <li><button onclick="setTheme('traditional')" class="block w-full text-left px-4 py-2 hover:bg-green-600 transition">Traditional</button></li>
      </ul>
    </li>
        
        
        
        <li><a href="#" class="block hover:text-red-400 transition" onclick="startGame()">♾️ Restart</a></li>
      </ul>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 ml-0 md:ml-64 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-gray-800 p-4 flex items-center justify-between shadow-lg">
      <button class="md:hidden text-white focus:outline-none" onclick="toggleSidebar()">
        ☰
      </button>
      <h1 class="text-xl font-semibold">Snake Game</h1>
    </header>

    <!-- Game Content -->
    <main class="flex flex-col items-center justify-start flex-1 p-6">

      <h2 class="text-3xl font-bold mt-6 mb-4">Welcome to Snake Game</h2>

      <div class="controls flex flex-col md:flex-row items-center gap-4 mb-4">
        <label for="difficulty" class="text-lg font-medium">Difficulty:</label>
        <select id="difficulty" class="px-4 py-2 rounded bg-white text-gray-800 focus:outline-none">
          <option value="200">Easy</option>
          <option value="150" selected>Medium</option>
          <option value="80">Hard</option>
        </select>
        <button onclick="startGame()" class="px-4 py-2 rounded bg-green-500 hover:bg-green-700 transition font-semibold">
          Restart Game
        </button>
      </div>

      <div id="scoreDisplay" class="text-xl font-semibold mb-4">Score: 0</div>

      <canvas id="game" width="400" height="400" class="bg-black shadow-lg rounded-lg"></canvas>

    </main>

  </div>

  <!-- Game Script -->
  <script>
    const canvas = document.getElementById("game");
    const ctx = canvas.getContext("2d");
    const scoreDisplay = document.getElementById("scoreDisplay");

    const box = 20;
    let score;
    let snake;
    let food;
    let dir;
    let game;
    let speed = 150;

    document.addEventListener("keydown", direction);

    function direction(event) {
      if (event.keyCode === 37 && dir !== "RIGHT") dir = "LEFT";
      else if (event.keyCode === 38 && dir !== "DOWN") dir = "UP";
      else if (event.keyCode === 39 && dir !== "LEFT") dir = "RIGHT";
      else if (event.keyCode === 40 && dir !== "UP") dir = "DOWN";
    }

    function startGame() {
      clearInterval(game);
      speed = parseInt(document.getElementById("difficulty").value);
      score = 0;
      dir = null;
      updateScore();
      snake = [{ x: 9 * box, y: 10 * box }];
      food = {
        x: Math.floor(Math.random() * 19) * box,
        y: Math.floor(Math.random() * 19) * box
      };
      game = setInterval(draw, speed);
    }

    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      for (let i = 0; i < snake.length; i++) {
        ctx.fillStyle = (i === 0) ? "lime" : "white";
        ctx.fillRect(snake[i].x, snake[i].y, box, box);
      }

      ctx.fillStyle = "red";
      ctx.fillRect(food.x, food.y, box, box);

      let snakeX = snake[0].x;
      let snakeY = snake[0].y;

      if (dir === "LEFT") snakeX -= box;
      if (dir === "RIGHT") snakeX += box;
      if (dir === "UP") snakeY -= box;
      if (dir === "DOWN") snakeY += box;

      if (snakeX === food.x && snakeY === food.y) {
        score++;
        updateScore();
        food = {
          x: Math.floor(Math.random() * 19) * box,
          y: Math.floor(Math.random() * 19) * box
        };
      } else {
        snake.pop();
      }

      let newHead = { x: snakeX, y: snakeY };

      if (
        snakeX < 0 || snakeX >= canvas.width ||
        snakeY < 0 || snakeY >= canvas.height ||
        collision(newHead, snake)
      ) {
        clearInterval(game);
        alert("Game Over! Your score: " + score);
      }

      snake.unshift(newHead);
    }

    function collision(head, array) {
      return array.some(segment => head.x === segment.x && head.y === segment.y);
    }

    function updateScore() {
      scoreDisplay.textContent = "Score: " + score;
    }

    window.onload = () => {
      startGame();
    };


    
  </script>

</body>
</html>
