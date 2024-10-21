<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$idEvent = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM events WHERE idEvents = :idEvent');
$stmt->execute(['idEvent' => $idEvent]);
$event = $stmt->fetch();

$isOrganizer = false;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare('SELECT idOrganisateur FROM utilisateur WHERE idUser = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $userOrganizerId = $stmt->fetchColumn();

    if ($event['idOrganisateur'] == $userOrganizerId || $_SESSION['user_admin'] === 1) {
        $isOrganizer = true;
    }
}

if (!$isOrganizer) {
    echo "Vous n'êtes pas l'organisateur de cet événement.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <title>Modifier un événement</title>
    <?php echo '<link rel="stylesheet" href="style.css">'; ?>
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />
</head>

<body>
    <?php include 'header.php'; ?>

    <h1 class="spacetitre">Modifier un événement</h1>
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
    <form action="update_event.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idEvent" value="<?php echo htmlspecialchars($event['idEvents']); ?>">

        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($event['nom']); ?>"><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($event['description']); ?></textarea><br><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>"><br><br>

        <label for="prix">Prix:</label>
        <input type="number" step="0.01" id="prix" name="prix" value="<?php echo htmlspecialchars($event['prix']); ?>"><br><br>

        <label for="places">Nombre de places:</label>
        <input type="number" id="places" name="places" value="<?php echo htmlspecialchars($event['places']); ?>"><br><br>

        <label for="idCategorie">Catégorie:</label>
        <select id="idCategorie" name="idCategorie">
            <?php
            $stmt = $pdo->query('SELECT * FROM categorie');
            while ($row = $stmt->fetch()) {
                $selected = ($row['idCategorie'] == $event['idCategorie']) ? ' selected' : '';
                echo '<option value="' . $row['idCategorie'] . '"' . $selected . '>' . htmlspecialchars($row['nom']) . '</option>';
            }
            ?>
        </select><br><br>

        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($event['adresse']); ?>"><br><br>

        <label for="photo">Image (URL):</label>
        <input type="text" id="photo" name="photo" value="<?php echo htmlspecialchars($event['picture']); ?>"><br><br>

        <button type="submit">Mettre à jour l'événement</button>
    </form>
    <?php include 'footer.php'; ?>
</body>

</html>