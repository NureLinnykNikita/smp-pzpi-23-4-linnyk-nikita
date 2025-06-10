<?php
session_start();
if (!isset($_SESSION['username']) && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    include 'page404.php';
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Web shop</title>
</head>
<body>
<?php include 'header.php'; ?>
        <div id="content">
                <?php include 'body.php'; ?>
       </div>
    <?php include 'footer.php'; ?>
</body>
</html>
