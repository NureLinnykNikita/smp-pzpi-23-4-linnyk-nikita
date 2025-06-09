<?php 
include 'header.php';
session_start();

$productsConfig = include 'products.php';
$products = $productsConfig['products'];
$selectedItems = $_SESSION['selectedItems'] ?? [];

function formatPrice($price) {
    return number_format($price, 2, '.', '');
}

if (!empty($selectedItems)) {
    $basketItems = [];
    $totalPrice = 0.0;

    foreach ($selectedItems as $id => $qty) {
        if (!isset($products[$id])) continue;
        
        $product = $products[$id];
        $sum = $product['price'] * $qty;
        $totalPrice += $sum;

        $basketItems[] = [
            'id' => $id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $qty,
            'sum' => $sum
        ];
    }
    ?>

    <div class="basket-container">
        <form action="index.php" method="post" class="basket-form">
            <table class="basket-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Ціна (₴)</th>
                        <th>Кількість</th>
                        <th>Сума (₴)</th>
                        <th>Видалити</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($basketItems as $item): ?>
                        <tr id="row_<?= $item['id'] ?>">
                            <td><?= $item['id'] ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td class="price"><?= formatPrice($item['price']) ?></td>
                            <td class="quantity"><?= $item['quantity'] ?></td>
                            <td class="sum"><?= formatPrice($item['sum']) ?></td>
                            <td>
                                <button type="button" class="remove-btn" data-id="<?= $item['id'] ?>">Вилучити</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="total-cell">
                            Сумарна вартість: <span id="totalPrice"><?= formatPrice($totalPrice) ?></span> ₴
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="checkout-cell">
                            <input type="submit" name="submit" value="Продовжити покупки" class="btn-submit" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>

    <style>
        .basket-container {
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
            background: #fafafa;
        }
        .basket-form {
            width: 700px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .basket-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .basket-table th, .basket-table td {
            border: 1px solid #ddd;
            padding: 10px 15px;
            text-align: center;
        }
        .basket-table th {
            background-color: #27ae60;
            color: white;
        }
        .remove-btn {
            background-color: #e74c3c;
            border: none;
            color: white;
            padding: 7px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.25s ease;
        }
        .remove-btn:hover {
            background-color: #c0392b;
        }
        .total-cell {
            text-align: right;
            font-weight: 700;
            font-size: 18px;
            background-color: #f0f0f0;
        }
        .checkout-cell {
            text-align: center;
            padding-top: 15px;
        }
        .btn-submit {
            background-color: #27ae60;
            border: none;
            color: white;
            font-size: 17px;
            padding: 10px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.5);
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #219150;
        }
    </style>

    <script>
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', () => {
                const itemId = button.dataset.id;

                fetch(`remove_item.php?id=${itemId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network error');
                        return response.text();
                    })
                    .then(status => {
                        if (status === "1") {
                            document.getElementById(`row_${itemId}`).remove();
                            
                            // Recalculate total
                            let total = 0;
                            document.querySelectorAll('.sum').forEach(cell => {
                                total += parseFloat(cell.textContent);
                            });
                            document.getElementById('totalPrice').textContent = total.toFixed(2);

                            // Empty basket handling
                            if (!document.querySelector('tbody tr')) {
                                document.querySelector('.basket-container').innerHTML = `
                                    <div style="text-align:center; padding: 50px;">
                                        <p>Ваш кошик порожній.</p>
                                        <a href="index.php" class="empty-basket-link">Повернутись до покупок</a>
                                    </div>
                                `;
                            }
                        } else {
                            alert('Помилка при видаленні товару');
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        alert('Сталася помилка при вилученні товару');
                    });
            });
        });
    </script>

<?php
} else {
    ?>
    <div class="empty-basket">
        <div class="empty-basket-content">
            <p>Ваш кошик порожній.</p>
            <a href="index.php" class="empty-basket-link">Повернутись до покупок</a>
        </div>
    </div>
    
    <style>
        .empty-basket {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .empty-basket-content {
            text-align: center;
        }
        .empty-basket-link {
            display: inline-block;
            text-decoration: none;
            background: #27ae60;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .empty-basket-link:hover {
            background-color: #219150;
        }
    </style>
<?php
}

include 'footer.php';
?>
