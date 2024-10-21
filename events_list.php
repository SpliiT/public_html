<?php
require_once 'db.php';

$stmt = $pdo->prepare('
    SELECT e.*, c.nom AS category_name,
           (SELECT COUNT(*) FROM participer p WHERE p.idEvents = e.idEvents AND p.idUser = :user_id1) AS is_joined,
           (SELECT u.idOrganisateur FROM utilisateur u WHERE u.idUser = :user_id2) AS user_organizer_id
    FROM events e
    LEFT JOIN categorie c ON e.idCategorie = c.idCategorie
');
$stmt->execute([
    'user_id1' => $_SESSION['user_id'] ?? null,
    'user_id2' => $_SESSION['user_id'] ?? null
]);
$events = $stmt->fetchAll();
?>

<div class="events">
    <?php foreach ($events as $event) : ?>
        <?php
        $isJoined = $event['is_joined'] > 0;
        $isOrganizer = isset($_SESSION['user_id']) && $event['idOrganisateur'] == $event['user_organizer_id'];
        ?>
        <div class="wrapper">
            <a href="event.php?id=<?php echo $event['idEvents']; ?>" style="text-decoration: none; color: white">
                <h2 class="titre content"><?php echo htmlspecialchars($event['nom']); ?></h2>
            </a>

            <img src="<?= $event['picture'] ?>" class="card">
            <p><?php echo htmlspecialchars($event['category_name']); ?></p><br>
            <p><?php echo htmlspecialchars($event['description']); ?></p>
            <p>Date : <?php echo htmlspecialchars($event['date']); ?></p><br>
            <p class="prices">Prix : <?php echo htmlspecialchars($event['prix']); ?> €</p>
            <div class="wrapper2">
                <a href="event.php?id=<?php echo $event['idEvents']; ?>" class="color-details">Voir les détails</a>
                <?php if (isset($_SESSION['user_admin']) && ($_SESSION['user_admin'] == 1 || ($_SESSION['user_admin'] == 2 && $isOrganizer))) : ?>
                    <a href="edit_event.php?id=<?php echo $event['idEvents']; ?>" class="color-details"><ion-icon name="settings-sharp"></ion-icon></a>
                    <a href="delete_event.php?id=<?php echo $event['idEvents']; ?>" class="color-details"><ion-icon name="trash-sharp"></ion-icon></a>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php if ($isJoined) : ?>
                    <a href="leave_event.php?id=<?php echo $event['idEvents']; ?>&from=events_inscrit" class="color-link">Se désinscrire</a><br>
                <?php elseif ($event["places"] == 0) : ?>
                    <p class="color-details">Cet événement est complet.</p>
                <?php else : ?>
                    <a href="join_event.php?id=<?php echo $event['idEvents']; ?>&from=events_inscrit" class="color-link">S'inscrire +</a><br>
                <?php endif; ?>
            <?php else : ?>
                <p class="color-details"><a href="login.php" class="login">Connectez-vous</a> pour vous inscrire à cet événement.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>