<?php include('header.php'); include('checkLogin.php'); ?>

<div class="container auth-box">
    <h1><img src="images/notes.png" alt="Notes">Slice Of Life</h1>
    <h2>Login</h2>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <form action="" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>No account? <a href="register.php">Register</a></p>
</div>

<?php include('footer.php'); ?>
