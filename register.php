<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $admin = 0;
    $photo = '';

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error = "Format de l'email invalide";
    } else {
        $stmt = $pdo->prepare('INSERT INTO utilisateur (nom, prenom, mail, password, admin, photo) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nom, $prenom, $mail, $password, $admin, $photo]);

        header('Location: login.php');
        exit;
    }
}

include 'header.php';
include 'register_form.php';
include 'footer.php';
