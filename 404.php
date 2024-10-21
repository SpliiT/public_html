<?php
require_once 'db.php';
session_start();


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />
</head>

<body>
    <?php include 'header.php'; ?>
    <h2 class="titre">Ajouter un événement</h2>
    <h1 class="titre-form">Erreur 404</h1>
    <div class="container-orga">
        <p class="color-details">La page que vous recherchez n'existe pas.</p>
        <h3> <a href="index.php" class="color-link">Retourner à la page d'accueil <ion-icon name="return-down-back-sharp"></ion-icon></a></h3>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>