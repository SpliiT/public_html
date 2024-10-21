<?php
require_once 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT e.*, o.nomOrganisateur AS organisateur_nom FROM events e JOIN organisateur o ON e.idOrganisateur = o.idOrganisateur WHERE e.idEvents = ?');
if ($stmt->execute([$id])) {
    $event = $stmt->fetch();
}

$stmt = $pdo->prepare('SELECT nom FROM categorie WHERE idCategorie = ?');
if ($stmt->execute([$event['idCategorie']])) {
    $category = $stmt->fetch();
}

$isJoined = false;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare('SELECT * FROM participer WHERE idEvents = ? AND idUser = ?');
    $stmt->execute([$event['idEvents'], $_SESSION['user_id']]);
    $isJoined = $stmt->rowCount() > 0;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'événement</title>
    <?php echo '<link rel="stylesheet" href="style.css">'; ?>
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />
</head>

<body>
    <div class="event-detail">

        <h2 class="titre"></h2>

        <h2 class="titre"><?php echo htmlspecialchars($event['nom']); ?></h2>
        <img src="<?= $event['picture'] ?>" class="card">
        <p>Catégorie : <?php echo !empty($category) ? htmlspecialchars($category['nom']) : 'N/A'; ?></p><br>
        <p>Description : <?php echo htmlspecialchars($event['description']); ?></p><br>
        <p>Date : <?php echo htmlspecialchars($event['date']); ?></p><br>
        <p>Adresse : <?php echo htmlspecialchars($event['adresse']); ?></p><br>
        <p>Places disponibles : <?php echo htmlspecialchars($event['places']); ?></p><br>
        <p class="prices">Prix : <?php echo htmlspecialchars($event['prix']); ?>€</p><br>
        <p>Organisateur : <?php echo htmlspecialchars($event['organisateur_nom']); ?></p><br>

        <?php if (isset($_SESSION['user_id'])) : ?>
            <?php if (isset($isJoined) && $isJoined) : ?>
                <a href="leave_event.php?id=<?php echo $event['idEvents']; ?>" class="color-link">Se désinscrire</a><br>
            <?php elseif ($event["places"] == 0) : ?>
                <p class="color-details">Cet événement est complet.</p>
            <?php else : ?>
                <a href="join_event.php?id=<?php echo $event['idEvents']; ?>" class="color-link">S'inscrire +</a><br>
            <?php endif; ?>
        <?php else : ?>
            <p class="color-details"><a href="login.php" class="login">Connectez-vous</a> pour vous inscrire à cet événement.</p>
        <?php endif; ?>
    </div>

    <?php include 'header.php'; ?>
    <?php include 'footer.php'; ?>
</body>

</html>