<?php
require_once 'db.php';
session_start();

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM events WHERE idEvents = ?');
$stmt->execute([$id]);
$event = $stmt->fetch();

$isJoined = false;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT * FROM participer WHERE idEvents = ? AND idUser = ?');
    $stmt->execute([$id, $userId]);
    $isJoined = $stmt->fetch() !== false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />
    <title>Détails de l'événement</title>
</head>

<body>
    <?php
    include 'header.php';
    include 'event_detail.php';
    include 'footer.php';

    ?>
</body>

</html>