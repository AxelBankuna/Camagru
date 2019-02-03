<header>
    <h1><a href="index.php">Kamagru</a></h1>
    <ul id="nav">

        <?php if (login_check($db) == true){ ?>
            <p>Signed in as: <?php echo htmlentities($_SESSION['username']); ?></p>
            <?php echo '<p><a href="login/logout.php">Log out</a></p>'; ?>
        <?php } ?>
        <li><a href="index.php">Home</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="profile.php">Profile</a></li>
    </ul>
</header>