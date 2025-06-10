<?php
session_start();
require_once 'products.php';

function displayForm($products, $errorMsg = '', $submittedData = []) {
    ?>
    <!DOCTYPE html>
    <html lang="uk">
    <head>
        <meta charset="UTF-8">
        <title>Вибір товарів</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f9f9f9;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .form-wrapper {
                background: white;
                padding: 35px 30px;
                border-radius: 12px;
                box-shadow: 0 6px 15px rgba(0,0,0,0.12);
                width: 320px;
                text-align: center;
            }
            h2 {
                margin-bottom: 25px;
                color: #333;
            }
            .error-message {
                color: #e74c3c;
                margin-bottom: 18px;
                font-weight: 600;
            }
            .item-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 12px 0;
            }
            input[type="number"] {
                width: 60px;
                padding: 6px;
                border: 1.5px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
                transition: border-color 0.3s;
            }
            input[type="number"]:focus {
                border-color: #27ae60;
                outline: none;
            }
            .price-label {
                color: #555;
                font-size: 13px;
                font-style: italic;
            }
            input[type="submit"] {
                margin-top: 28px;
                background-color: #27ae60;
                border: none;
                padding: 11px 25px;
                border-radius: 8px;
                color: white;
                font-size: 17px;
                cursor: pointer;
                font-weight: 600;
                box-shadow: 0 4px 10px rgba(39, 174, 96, 0.5);
                transition: background-color 0.3s ease;
            }
            input[type="submit"]:hover {
                background-color: #219150;
            }
        </style>
    </head>
    <body>
        <div class="form-wrapper">
            <h2>Оберіть товари</h2>
            <?php if ($errorMsg): ?>
                <div class="error-message"><?= htmlspecialchars($errorMsg) ?></div>
            <?php endif; ?>
            <form method="post">
                <?php foreach ($products as $id => $product): 
                    $val = isset($submittedData[$id]) ? (int)$submittedData[$id] : 0;
                ?>
                    <div class="item-row">
                        <label for="prod_<?= $id ?>"><?= htmlspecialchars($product['name']) ?></label>
                        <span class="price-label">₴<?= number_format($product['price'], 2, '.', '') ?></span>
                        <input type="number" 
                               name="products[<?= $id ?>]" 
                               id="prod_<?= $id ?>" 
                               value="<?= $val ?>" 
                               min="0" />
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="До кошика">
            </form>
        </div>
    </body>
    </html>
    <?php
}

$productsConfig = include 'products.php';
$products = $productsConfig['products'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['products'])) {
    $cart = [];
    foreach ($_POST['products'] as $id => $qty) {
        $id = (int)$id;
        $qty = (int)$qty;
        if ($qty > 0 && isset($products[$id])) {
            $cart[$id] = $qty;
        }
    }

    if (count($cart) > 0) {
        $_SESSION['selectedItems'] = $cart;
        header('Location: basket.php');
        exit();
    } else {
        displayForm($products, 'Ви не вибрали жодного товару.', $_POST['products']);
    }
} else {
    displayForm($products);
}

