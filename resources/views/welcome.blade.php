<!DOCTYPE html>
<html>
<head>
    <title>My Casino</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: Arial;
            background: #111;
            color: white;
        }
        nav {
            background: black;
            padding: 15px;
            text-align: center;
        }
        nav a {
            color: gold;
            margin: 10px;
            text-decoration: none;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: gold;
        }
        .games img {
            margin: 10px;
            border-radius: 10px;
        }
        .btn-play {
            background: gold;
            color: black;
            padding: 10px 20px;
            border: none;
            margin-top: 20px;
        }
        footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            background: black;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <a href="#">Home</a>
    <a href="#">About</a>
    <a href="#">Game</a>
    <a href="#">Customer</a>
    <a href="#">Contact</a>
</nav>

<h1>🎰 Welcome to My Casino 🎰</h1>

<!-- GAMES -->
<div class="games" style="text-align:center;">
    <img src="{{ asset('images/img-1.png') }}" width="200">
    <img src="{{ asset('images/img-2.png') }}" width="200">
    <img src="{{ asset('images/img-3.png') }}" width="200">
</div>

<div style="text-align:center;">
    <button class="btn-play">Play Now</button>
</div>

<!-- ABOUT -->
<div style="padding:20px; text-align:center;">
    <h2>About Casino</h2>
    <p>
        There are many variations of passages of Lorem Ipsum available,
        but the majority have suffered alteration in some form.
    </p>
</div>

<!-- CONTACT -->
<div style="text-align:center;">
    <h2>Contact Us</h2>
    <input type="text" placeholder="Name"><br><br>
    <input type="text" placeholder="Phone"><br><br>
    <input type="email" placeholder="Email"><br><br>
    <textarea placeholder="Message"></textarea><br><br>
    <button class="btn-play">Send</button>
</div>

<!-- FOOTER -->
<footer>
    <p>© 2026 Casino Website</p>
</footer>

</body>
</html>