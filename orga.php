<?php
require_once 'db.php';
session_start();

if ($_SESSION['user_admin'] !== 2) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$organisateurId = null;

$stmt = $pdo->prepare('SELECT idOrganisateur FROM utilisateur WHERE idUser = ?');
$stmt->execute([$userId]);
$result = $stmt->fetch();
if ($result) {
    $organisateurId = $result['idOrganisateur'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $prix = $_POST['prix'];
    $places = $_POST['places'];
    $idCategorie = $_POST['idCategorie'];
    $adresse = $_POST['adresse'];
    $picture = $_POST['picture'];

    if ($organisateurId !== null) {
        $stmt = $pdo->prepare("INSERT INTO events (nom, description, date, prix, places, idCategorie, adresse, idOrganisateur, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $date, $prix, $places, $idCategorie, $adresse, $organisateurId, $picture]);

        header('Location: index.php');
        exit;
    } else {
        echo 'Vous devez être un organisateur pour ajouter un événement.';
    }
}

$stmt = $pdo->prepare('SELECT * FROM categorie WHERE nom IN (SELECT categorie_nom FROM organisateur WHERE idOrganisateur = ?)');
$stmt->execute([$organisateurId]);

$stmt_events = $pdo->prepare('SELECT * FROM events WHERE idOrganisateur = ?');
$stmt_events->execute([$organisateurId]);
$events = $stmt_events->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Organisateur</title>
    <?php echo '<link rel="stylesheet" href="form.css">'; ?>
    <?php echo '<link rel="stylesheet" href="style.css">'; ?>
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />

</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container-orga">
        <h2 class="titre">Organisation</h2>
        <h2 class="titre">Organisation</h2>
        <div class="wrap-collabsible">
            <input id="collapsible" class="toggle" type="checkbox">
            <label for="collapsible" class="lbl-toggle">Ajouter un événement</label>
            <div class="collapsible-content">
                <div class="content-inner">
                    <div class="container">
                        <div class="form-container">
                            <h2 class="titre-form">Ajouter un événement</h2>
                            <form action="orga.php" method="post">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="nom" required><br><br>

                                <label for="description">Description :</label>
                                <textarea id="description" name="description" required></textarea><br><br>

                                <label for="date">Date :</label>
                                <input type="date" id="date" name="date" required><br><br>

                                <label for="prix">Prix :</label>
                                <input type="number" step="0.01" id="prix" name="prix" required><br><br>

                                <label for="places">Nombre de places :</label>
                                <input type="number" id="places" name="places" required><br><br>

                                <label for="idCategorie">Catégorie :</label>
                                <select id="idCategorie" name="idCategorie" required>
                                    <?php
                                    while ($row = $stmt->fetch()) {
                                        echo '<option value="' . $row['idCategorie'] . '">' . htmlspecialchars($row['nom']) . '</option>';
                                    }
                                    ?>
                                </select><br><br>

                                <label for="adresse">Adresse :</label>
                                <input type="text" id="adresse" name="adresse" required><br><br>

                                <label for="picture">Image (URL) :</label>
                                <input type="text" id="picture" name="picture" required><br><br>

                                <button type="submit">Ajouter l'événement</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-collabsible">
                <input id="collapsible2" class="toggle" type="checkbox">
                <label for="collapsible2" class="lbl-toggle">Événements de l'organisateur</label>
                <div class="collapsible-content">
                    <div class="content-inner">
                        <div class="events-container">
                            <div class="events">
                                <?php foreach ($events as $event) : ?>
                                    <?php
                                    $stmt = $pdo->prepare('SELECT nom FROM categorie WHERE idCategorie = ?');
                                    $stmt->execute([$event['idCategorie']]);
                                    $category = $stmt->fetch();

                                    $isJoined = false;
                                    if (isset($_SESSION['user_id'])) {
                                        $stmt = $pdo->prepare('SELECT COUNT(*) FROM participer WHERE idEvents = ? AND idUser = ?');
                                        $stmt->execute([$event['idEvents'], $_SESSION['user_id']]);
                                        if ($stmt->fetchColumn() > 0) {
                                            $isJoined = true;
                                        }
                                    }

                                    $isOrganizer = false;
                                    if (isset($_SESSION['user_id'])) {
                                        $stmt = $pdo->prepare('SELECT idOrganisateur FROM utilisateur WHERE idUser = ?');
                                        $stmt->execute([$_SESSION['user_id']]);
                                        $userOrganizerId = $stmt->fetchColumn();

                                        if ($event['idOrganisateur'] == $userOrganizerId) {
                                            $isOrganizer = true;
                                        }
                                    }
                                    ?>
                                    <div class="wrapper">
                                        <a href="event.php?id=<?php echo $event['idEvents']; ?>" style="text-decoration: none; color: white">
                                            <h2 class="titre content"><?php echo htmlspecialchars($event['nom']); ?></h2>
                                        </a>
                                        <img src="<?= $event['picture'] ?>" class="card" ;>
                                        <p><?php echo htmlspecialchars($category['nom']); ?></p><br>
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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>