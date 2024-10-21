<?php
require_once 'db.php';
session_start();
$stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE idUser = :idUser');
$stmt->execute(['idUser' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <title>Profile</title>
    <?php echo '<link rel="stylesheet" href="style.css">'; ?>
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <h1 class="spacetitre">Mon profil</h1>
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<div class='success-messages'>";
        foreach ($_SESSION['success_message'] as $message) {
            echo "<div>$message</div>";
        }
        echo "</div>";
        unset($_SESSION['success_message']);
    }
    ?>
    <form action="update_profile.php" method="post" enctype="multipart/form-data">
        <label for="avatar">Photo de profil:</label><br><br>
        <?php if (isset($_SESSION['user_photo']) && $_SESSION['user_photo'] !== "") : ?>
            <img style="border: solid 1px white;" src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Avatar" width="100" height="100"><br><br>
        <?php else : ?>
            <img style="border: solid 1px white;" src="avatar.png" alt="Avatar" width="100" height="100"><br><br>
        <?php endif; ?>
        <label for="photo">Modifier de profil:</label>
        <input type="file" id="photo" name="photo"><br><br>

        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>"><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>"><br><br>

        <label for="mail">Mail:</label>
        <input type="text" id="mail" name="mail" value="<?php echo htmlspecialchars($user['mail']); ?>"><br><br>

        <div class="password-eye">
            <label for="password">Mot de passe actuel :</label>
            <input type="password" id="password" name="password" value="">
            <i class="fas fa-eye-slash" onclick="togglePasswordVisibility('password')"></i>
        </div>
        <?php if (isset($_SESSION['error_message'])) : ?>
            <div style="color: red;"><?php echo $_SESSION['error_message']; ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        <br><br>

        <div class="password-eye">
            <label for="newpassword">Nouveau mot de passe :</label>
            <input type="password" id="newpassword" name="newpassword" value="">
            <i class="fas fa-eye-slash" onclick="togglePasswordVisibility('newpassword')"></i>
        </div>
        <br><br>

        <div class="password-eye">
            <label for="confirnewpassword">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirnewpassword" name="confirnewpassword" value="">
            <i class="fas fa-eye-slash" onclick="togglePasswordVisibility('confirnewpassword')"></i>
        </div>
        <?php if (isset($_SESSION['error_message_newpassword'])) : ?>
            <div style="color: red;"><?php echo $_SESSION['error_message_newpassword']; ?></div>
            <?php unset($_SESSION['error_message_newpassword']); ?>
        <?php endif; ?>
        <span id="confirmPasswordError" style="color: red;"></span>
        <br><br>

        <button type="submit">Mettre à jour le profil</button>
    </form>
    <?php include 'footer.php'; ?>
</body>
<script src="script.js"></script>

</html>