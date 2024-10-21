<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['user_admin'] !== 1 && $_SESSION['user_admin'] !== 2) {
    header('Location: login.php');
    exit;
}

$idEvent = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM events WHERE idEvents = ?');
$stmt->execute([$idEvent]);

$stmt2 = $pdo->prepare('DELETE FROM participer WHERE idEvents = ?');
$stmt2->execute([$idEvent]);

header('Location: index.php');
exit;
