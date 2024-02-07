<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <header>
        <img src="lu.webp" height="60px" alt="logo">
        <nav>
            <ul class="nav__links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Aplikasi</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </nav>
        <a class="cta" href="#"><button>Kontak</button></a>
    </header>
    <div class="slider">
  <img id="img-1" src="rog.jpg" alt="Image 1"/>
  <img id="img-2" src="img-2.jpg" alt="Image 2"/>
  <img id="img-3" src="img-3.jpg" alt="Image 3"/>
</div>
<div class="navigation-button">
  <span class="dot active" onclick="changeSlide(0)"></span>
  <span class="dot" onclick="changeSlide(1)"></span>
  <span class="dot" onclick="changeSlide(2)"></span>
</div>
<script src="slide.js"></script>

</body>
</html>