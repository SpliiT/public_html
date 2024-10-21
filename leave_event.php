<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$idEvent = $_GET['id'];
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare('DELETE FROM participer WHERE idEvents = ? AND idUser = ?');
$stmt->execute([$idEvent, $userId]);

$stmt2 = $pdo->prepare('UPDATE events SET places = places + 1 WHERE idEvents = ?');
$stmt2->execute([$idEvent]);

$fromPage = $_GET['from'] ?? '';
if ($fromPage == 'events_inscrit') {
    header('Location: events_inscrit.php');
} else {
    header('Location: event.php?id=' . $idEvent);
}
exit;
