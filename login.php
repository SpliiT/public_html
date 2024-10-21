<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE mail = ?');
    $stmt->execute([$mail]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['idUser'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];
        $_SESSION['user_mail'] = $user['mail'];
        $_SESSION['user_password'] = $user['password'];
        $_SESSION['user_admin'] = $user['admin'];
        $_SESSION['user_photo'] = $user['photo'];

        header('Location: index.php');
        exit;
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />

    <title>Connexion</title>
</head>

<?php
include 'header.php';
include 'login_form.php';
include 'footer.php';
?>


</html>