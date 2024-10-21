<?php
require_once 'db.php';
session_start();

if ($_SESSION['user_admin'] !== 1) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données du formulaire
    $nom = $_POST['nom'] ?? null;
    $description = $_POST['description'] ?? null;
    $date = $_POST['date'] ?? null;
    $prix = $_POST['prix'] ?? null;
    $places = $_POST['places'] ?? null;
    $idCategorie = $_POST['idCategorie'] ?? null;
    $adresse = $_POST['adresse'] ?? null;
    $idOrganisateur = $_POST['idOrganisateur'] ?? null;
    $picture = $_POST['picture'] ?? null;

    // Validation des données
    if ($nom && $description && $date && $prix && $places && $idCategorie && $adresse && $idOrganisateur && $picture) {
        // Vérifier si l'organisateur existe
        $stmt = $pdo->prepare("SELECT * FROM organisateur WHERE idOrganisateur = ?");
        $stmt->execute([$idOrganisateur]);
        $organisateur = $stmt->fetch();

        if ($organisateur) {
            // Insérer l'événement dans la base de données
            $stmt = $pdo->prepare("INSERT INTO events (nom, description, date, prix, places, idCategorie, adresse, idOrganisateur, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $description, $date, $prix, $places, $idCategorie, $adresse, $idOrganisateur, $picture]);

            header('Location: index.php');
            exit;
        } else {
            echo "Erreur : L'organisateur sélectionné n'existe pas.";
        }
    } else {
        echo "Erreur : Tous les champs sont obligatoires.";
    }
}
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
    <h2 class="titre-form">Ajouter un événement</h2>

    <form action="admin.php" method="post">
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
            $stmt = $pdo->query('SELECT * FROM categorie');
            while ($row = $stmt->fetch()) {
                echo '<option value="' . $row['idCategorie'] . '">' . htmlspecialchars($row['nom']) . '</option>';
            }
            ?>
        </select><br><br>

        <label for="idOrganisateur">Organisateur :</label>
        <select id="idOrganisateur" name="idOrganisateur" required>
            <?php
            $stmt = $pdo->query('SELECT * FROM organisateur');
            while ($row = $stmt->fetch()) {
                echo '<option value="' . $row['idOrganisateur'] . '">' . htmlspecialchars($row['nomOrganisateur']) . '</option>';
            }
            ?>
        </select><br><br>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required><br><br>

        <label for="picture">Image (URL) :</label>
        <input type="text" id="picture" name="picture" required><br><br>

        <button type="submit">Ajouter l'événement</button>
    </form>

    <?php include 'footer.php'; ?>
</body>

</html>