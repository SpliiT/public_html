<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUser = $_SESSION['user_id'];

    // Update the photo de profile
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier si le fichier est une image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $stmt = $pdo->prepare('UPDATE utilisateur SET photo = :photo WHERE idUser = :idUser');
                $stmt->execute(['photo' => $target_file, 'idUser' => $idUser]);
                $_SESSION['success_message'][] = "Photo de profil mise à jour avec succès";
            } else {
                $_SESSION['error_message'] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                header('Location: profile.php');
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Le fichier n'est pas une image.";
            header('Location: profile.php');
            exit;
        }
    }

    // Get the current user data
    $stmt = $pdo->prepare('SELECT * FROM utilisateur WHERE idUser = :idUser');
    $stmt->execute(['idUser' => $idUser]);
    $user = $stmt->fetch();

    // Vérifier le mot de passe actuel
    if (!password_verify($_POST['password'], $user['password'])) {
        // Le mot de passe actuel est incorrect
        $_SESSION['error_message'] = "Le mot de passe actuel est incorrect.";
        header('Location: profile.php');
        exit;
    }

    // Update the name
    if ($_POST['nom'] != $user['nom']) {
        $nom = $_POST['nom'];
        $stmt = $pdo->prepare('UPDATE utilisateur SET nom = :nom WHERE idUser = :idUser');
        $stmt->execute(['nom' => $nom, 'idUser' => $idUser]);
        $_SESSION['success_message'][] = "Nom mis à jour avec succès";
    }

    // Update the prénom
    if ($_POST['prenom'] != $user['prenom']) {
        $prenom = $_POST['prenom'];
        $stmt = $pdo->prepare('UPDATE utilisateur SET prenom = :prenom WHERE idUser = :idUser');
        $stmt->execute(['prenom' => $prenom, 'idUser' => $idUser]);
        $_SESSION['success_message'][] = "Prénom mis à jour avec succès";
    }

    // Update the email
    if ($_POST['mail'] != $user['mail']) {
        $mail = $_POST['mail'];
        $stmt = $pdo->prepare('UPDATE utilisateur SET mail = :mail WHERE idUser = :idUser');
        $stmt->execute(['mail' => $mail, 'idUser' => $idUser]);
        $_SESSION['success_message'][] = "Mail mis à jour avec succès";
    }

    // Update the mot de passe
    if (!empty($_POST['newpassword']) && $_POST['newpassword'] === $_POST['confirnewpassword']) {
        $password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE utilisateur SET password = :password WHERE idUser = :idUser');
        $stmt->execute(['password' => $password, 'idUser' => $idUser]);
        $_SESSION['success_message'][] = "Mot de passe mis à jour avec succès";
    } else if (!empty($_POST['newpassword']) && $_POST['newpassword'] !== $_POST['confirnewpassword']) {
        $_SESSION['error_message_newpassword'] = "Les nouveaux mots de passe ne correspondent pas.";
    }

    header('Location: profile.php');
    exit;
}
