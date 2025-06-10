<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $credentials = include 'credential.php';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $error = 'Усі поля є обов’язковими.';
    } elseif ($username === $credentials['username'] && $password === $credentials['password']) {
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неправильне ім’я користувача або пароль.';
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід</title>
</head>
<body>
<?php include 'header.php'; ?>
<div style="padding: 60px; text-align: center;">
    <h2>Авторизація</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Логін"><br><br>
        <input type="password" name="password" placeholder="Пароль"><br><br>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
