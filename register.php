<?php include('checkRegister.php'); include('header.php'); ?>

<div class="container auth-box">
    <h1><img src="images/notes.png" alt="Notes">Slice Of Life</h1>
    <h2>Register</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" value="<?= $name; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= $email; ?>" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

<?php include('footer.php'); ?>
