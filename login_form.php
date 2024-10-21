<div class="login">
    <h2 class="titre">Connexion</h2>
    <?php echo '<link rel="stylesheet" href="form.css">'; ?>

    <h1 class="titre-form"> Se connecter </h1>
    <form action="login.php" method="POST">
        <label for="mail">Email</label>
        <input type="email" name="mail" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" required>
        <button type="submit">Se connecter</button>
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
</div>