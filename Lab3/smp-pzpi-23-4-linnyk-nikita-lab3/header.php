<?php
session_start(); 
?>
<style>
  header {
    position: fixed;
    top: 0; left: 0; right: 0;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    padding: 12px 25px;
    z-index: 1000;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }

  header.scrolled {
    background-color: #fefefe;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  }

  nav.navbar {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between; /* Розподіл між крайніми елементами */
    align-items: center;
  }

  .nav-left, .nav-right, .nav-center {
    display: flex;
    gap: 25px;
    align-items: center;
  }

  .nav-center {
    position: absolute;
    left: 50%;
    transform: translateX(-50%); /* Точне центрування */
  }

  nav.navbar a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #333;
    font-weight: 600;
    font-size: 16px;
    padding: 6px 8px;
    border-radius: 6px;
    transition: background-color 0.25s ease, color 0.25s ease;
  }

  nav.navbar a:hover,
  nav.navbar a:focus {
    background-color: #27ae60;
    color: white;
    outline: none;
  }

  nav.navbar img {
    width: 20px;
    height: 20px;
    margin-right: 8px;
    object-fit: contain;
  }

  nav.navbar span.separator {
    color: #999;
    user-select: none;
  }

  body {
    margin-top: 56px;
  }
</style>

<header>
  <nav class="navbar" role="navigation" aria-label="Головне меню">
    <div class="nav-left">
      <a href="index.php">
        Головна
      </a>
    </div>

    <div class="nav-center">
      <a href="index.php#products">
        Товари
      </a>
    </div>

    <div class="nav-right">
      <a href="basket.php">
        Кошик
      </a>
    </div>
  </nav>
</header>
