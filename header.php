<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<link rel="stylesheet" href="style.css">'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="script.js"></script>
    <script src="cursor.js"></script>


    <link rel="shortcut icon" href="logo.png" type="image/x-icon" />
    <title>SpliiT Events</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="navbar-logo">
                <a href="index.php" class="navbar-logo">&nbsp <?php echo '<img src="logo.png" width="80px" alt="logo">'; ?>
                    <span>SpliiT Events &nbsp</span>
                </a>
                <div class="navbar-burger">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>

            <div class="navbar-info">

                <?php if (isset($_SESSION['user_id'])) : ?>
                    <span class="prenom">Bonjour, <?php echo ($_SESSION['user_prenom']); ?></span>
                <?php endif; ?>
                <a href="index.php">Accueil</a>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <a href="profile.php">Profil</a>
                    <a href="events_inscrit.php">événements</a>
                    <?php if (isset($_SESSION['user_admin']) && $_SESSION['user_admin'] == 1) : ?>
                        <a href="admin.php">Administration</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_admin']) && $_SESSION['user_admin'] == 2) : ?>
                        <a href="orga.php">Organisation</a>
                    <?php endif; ?>
                    <a href="logout.php">Déconnexion</a>
                <?php else : ?>
                    <a href="login.php">Connexion</a>
                    <a href="register.php">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>