<?php
session_start();

// Якщо користувач неавторизований — редірект на логін
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$profileDir = __DIR__ . '/user_profiles';
if (!is_dir($profileDir)) {
    mkdir($profileDir, 0777, true);
}

$profileFile = "$profileDir/{$username}.php";
$errors = [];
$success = '';

// Читаємо існуючі дані профілю
if (file_exists($profileFile)) {
    $profileData = include $profileFile;
} else {
    $profileData = [
        'first_name' => '',
        'last_name' => '',
        'birthdate' => '',
        'bio' => '',
        'photo' => ''
    ];
}

// Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    // Валідація 
    if ($first_name === '') $errors[] = 'Вкажіть ім’я';
    if ($last_name === '') $errors[] = 'Вкажіть прізвище';
    if ($birthdate === '') $errors[] = 'Вкажіть дату народження';

    // Обробка фото
    $photoName = $profileData['photo']; 
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($ext), $allowed)) {
            $errors[] = 'Неприпустимий формат фото';
        } else {
            $photoName = $username . '_' . time() . '.' . $ext;
            $dest = __DIR__ . '/uploads/' . $photoName;

            if (!move_uploaded_file($tmpName, $dest)) {
                $errors[] = 'Помилка завантаження фото';
            }
        }
    }

    // Якщо немає помилок — зберігаємо профіль у файл
    if (empty($errors)) {
        $profileData = compact('first_name', 'last_name', 'birthdate', 'bio');
        $profileData['photo'] = $photoName;

        file_put_contents($profileFile, '<?php return ' . var_export($profileData, true) . ';');
        $success = 'Профіль оновлено';
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Профіль користувача</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .profile-wrapper {
            background: white;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 25px;
        }
        .success-message {
            color: #27ae60;
            margin-bottom: 18px;
            font-weight: 600;
            text-align: center;
        }
        .error-message {
            color: #e74c3c;
            margin-bottom: 18px;
            font-weight: 600;
        }
        .error-message ul {
            padding-left: 20px;
            margin: 10px 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: #27ae60;
            outline: none;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        .photo-preview {
            margin: 15px 0;
            text-align: center;
        }
        .photo-preview img {
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        button[type="submit"] {
            background-color: #27ae60;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.5);
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="profile-wrapper">
        <h1>Профіль користувача: <?= htmlspecialchars($username) ?></h1>

        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="first_name">Ім'я:</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($profileData['first_name']) ?>">
            </div>

            <div class="form-group">
                <label for="last_name">Прізвище:</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($profileData['last_name']) ?>">
            </div>

            <div class="form-group">
                <label for="birthdate">Дата народження:</label>
                <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($profileData['birthdate']) ?>">
            </div>

            <div class="form-group">
                <label for="bio">Про себе:</label>
                <textarea id="bio" name="bio"><?= htmlspecialchars($profileData['bio']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="photo">Фото профілю:</label>
                <?php if ($profileData['photo']): ?>
                    <div class="photo-preview">
                        <img src="uploads/<?= htmlspecialchars($profileData['photo']) ?>" alt="Фото профілю" width="150">
                    </div>
                <?php endif; ?>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>

            <button type="submit">Зберегти зміни</button>
        </form>
    </div>
</body>
</html>
