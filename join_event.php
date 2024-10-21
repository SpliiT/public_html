<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$idEvent = $_GET['id'];
$userId = $_SESSION['user_id'];

$stmt3 = $pdo->prepare('SELECT places FROM events WHERE idEvents = ?');
$stmt3->execute([$idEvent]);
$eventData = $stmt3->fetch();
$placesDisponibles = $eventData['places'];

if ($placesDisponibles <= 0) {
    header('Location: event.php?id=' . $idEvent);
    exit;
}

$stmt = $pdo->prepare('INSERT INTO participer (idEvents, idUser) VALUES (?, ?);');
$stmt->execute([$idEvent, $userId]);

$stmt2 = $pdo->prepare('UPDATE events SET places = places - 1 WHERE idEvents = ?');
$stmt2->execute([$idEvent]);

$fromPage = $_GET['from'] ?? '';
if ($fromPage == 'events_inscrit') {
    header('Location: index.php');
} else {
    header('Location: event.php?id=' . $idEvent);
}
exit;
