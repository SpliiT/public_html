<h2 class="titre">Inscription</h2>
<h2 class="titre-form">Inscription</h2>
<?php echo '<link rel="stylesheet" href="form.css">'; ?>

<form action="register.php" method="POST">
    <label for="nom">Nom</label>
    <input type="text" name="nom" required>
    <label for="prenom">Prénom</label>
    <input type="text" name="prenom" required>
    <label for="mail">Email</label>
    <input type="email" name="mail" required>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" required>
    <button type="submit">S'inscrire</button>
    <?php if (isset($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
</form>