<?php
$confirmMessage = null;
if (isset($_COOKIE[session_name()]) && session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['confirm_message'])) {
    $confirmMessage = $_SESSION['confirm_message'];
    unset($_SESSION['confirm_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servizi Officina</title>
</head>
<body>


    <?php require "config/header.php"; ?>
    <div id="container"></div>

    <?php
    if ($confirmMessage) {
        $class = $confirmMessage['success'] ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;';
        echo '<div style="padding:12px; ' . $class . '">' . htmlspecialchars($confirmMessage['message']) . '</div>';
    }
    ?>

    <script src="js/index.js"></script>
</body>
</html>