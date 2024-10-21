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

$idEvent = $_POST['idEvent'];
$nom = $_POST['nom'];
$description = $_POST['description'];
$date = $_POST['date'];
$prix = $_POST['prix'];
$places = $_POST['places'];
$idCategorie = $_POST['idCategorie'];
$adresse = $_POST['adresse'];
$picture = $_POST['photo'];

$stmt = $pdo->prepare("UPDATE events SET nom = ?, description = ?, date = ?, prix = ?, places = ?, idCategorie = ?, adresse = ?, picture = ? WHERE idEvents = ?");
$stmt->execute([$nom, $description, $date, $prix, $places, $idCategorie, $adresse, $picture, $idEvent]);

header('Location: index.php');
exit;
