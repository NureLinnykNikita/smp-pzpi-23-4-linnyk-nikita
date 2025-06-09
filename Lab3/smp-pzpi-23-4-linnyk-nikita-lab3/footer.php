<footer class="footer">
  <nav aria-label="Футер меню">
    <ul class="footer-nav">
      <li><a href="index.php">Головна</a></li>
      <li><a href="index.php#products">Товари</a></li>
      <li><a href="basket.php">Кошик</a></li>
      <li><a href="aboutus.php">Про нас</a></li>
    </ul>
  </nav>
</footer>

<style>
  .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #f7f7f7;
    padding: 14px 0;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    z-index: 999;
  }

  .footer-nav {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 25px;
  }

  .footer-nav li {
  }

  .footer-nav a {
    color: #333;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: color 0.25s ease;
  }

  .footer-nav a:hover,
  .footer-nav a:focus {
    color: #27ae60;
    outline: none;
  }

  body {
    margin-bottom: 50px; 
  }
</style>

