<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Snake Game</title>
    <style>
        body {
            font-family: Verdana;
            text-align: center;
            margin-top: 30px;
        }
        canvas {
            background: #000;
            display: block;
            margin: 20px auto;
        }
        .controls {
            margin-bottom: 20px;
        }
        select, button {
            padding: 10px 15px;
            font-size: 16px;
            margin: 5px;
        }
        #scoreDisplay {
            font-size: 20px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2>Snake Game</h2>

    <div class="controls">
        <label for="difficulty">Difficulty:</label>
        <select id="difficulty">
            <option value="200">Easy</option>
            <option value="150" selected>Medium</option>
            <option value="80">Hard</option>
        </select>
        <button onclick="startGame()">Restart Game</button>
    </div>

    <div id="scoreDisplay">Score: 0</div>

    <canvas id="game" width="400" height="400"></canvas>

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
        let speed = 150; // default medium

        document.addEventListener("keydown", direction);

        function direction(event) {
            if (event.keyCode === 37 && dir !== "RIGHT") dir = "LEFT";
            else if (event.keyCode === 38 && dir !== "DOWN") dir = "UP";
            else if (event.keyCode === 39 && dir !== "LEFT") dir = "RIGHT";
            else if (event.keyCode === 40 && dir !== "UP") dir = "DOWN";
        }

        function startGame() {
            clearInterval(game);

            // Set speed based on selected difficulty
            speed = parseInt(document.getElementById("difficulty").value);

            score = 0;
            dir = null;
            updateScore();

            snake = [];
            snake[0] = {
                x: 9 * box,
                y: 10 * box
            };

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

            let newHead = {
                x: snakeX,
                y: snakeY
            };

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
            for (let i = 0; i < array.length; i++) {
                if (head.x === array[i].x && head.y === array[i].y) {
                    return true;
                }
            }
            return false;
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
