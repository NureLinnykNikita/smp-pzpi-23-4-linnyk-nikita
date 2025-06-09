<?php include 'header.php'; ?>

<div class="simple-about">
    <h1>Про нас</h1>
    <div class="about-content">
        <p>Наш фруктовий магазин постачає свіжі та якісні фрукти прямо з ферм. Ми пишаємося тим, що пропонуємо лише натуральні сезонні фрукти без шкідливих добавок.</p>
        <p>Наша мета - зробити якісні фрукти доступними для кожного. Усі продукти ретельно відбираються перед тим, як потрапити на полиці нашого магазину.</p>
        <p>Дякуємо, що обираєте нас!</p>
    </div>
</div>

<style>
    .simple-about {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .simple-about h1 {
        color: #27ae60;
        text-align: center;
        margin-bottom: 20px;
    }
    
    .about-content {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        line-height: 1.6;
    }
    
    .about-content p {
        margin-bottom: 15px;
        color: #333;
    }
    
    .about-content p:last-child {
        margin-bottom: 0;
        font-weight: 600;
        color: #27ae60;
    }
</style>

<?php include 'footer.php'; ?>
