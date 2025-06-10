<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $productId = (int)$_GET['id'];
    
    if (isset($_SESSION['selectedItems'][$productId])) {
        unset($_SESSION['selectedItems'][$productId]);
        echo "1"; 
        exit;
    }
}
echo "0"; 
