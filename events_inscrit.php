<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT events.* FROM events INNER JOIN participer ON events.idEvents = participer.idEvents WHERE participer.idUser = ?');
$stmt->execute([$userId]);
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />

    <title>Événements inscrits</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>

    <h2 class="titre"></h2>
    <div class="events">
        <?php if (empty($events)) : ?>
            <p class="spacetitre">Vous n'êtes inscrit à aucun événement.</p>
        <?php else : ?>
            <?php foreach ($events as $event) : ?>
                <?php
                $stmt = $pdo->prepare('SELECT nom FROM categorie WHERE idCategorie = ?');
                $stmt->execute([$event['idCategorie']]);
                $category = $stmt->fetch();
                ?>

                <div class="event-detail">


                    <h2 class="titre"><?php echo htmlspecialchars($event['nom']); ?></h2>
                    <img src="<?= $event['picture'] ?>" class="card">
                    <p>Catégorie : <?php echo htmlspecialchars($category['nom']); ?></p><br>
                    <p>Description : <?php echo htmlspecialchars($event['description']); ?></p><br>
                    <p>Date : <?php echo htmlspecialchars($event['date']); ?></p><br>
                    <p>Adresse : <?php echo htmlspecialchars($event['adresse']); ?></p><br>
                    <p>Places disponibles : <?php echo htmlspecialchars($event['places']); ?></p><br>
                    <p class="prices">Prix : <?php echo htmlspecialchars($event['prix']); ?>€</p><br>
                    <a href="leave_event.php?id=<?php echo $event['idEvents']; ?>&from=events_inscrit" class="color-link">Se désinscrire</a><br>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php
    include 'footer.php';
    ?>
</body>

</html>