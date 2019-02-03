<?php
//$path = $_SERVER['DOCUMENT_ROOT']. "/kamagru";
//include_once(dirname($path).'/login/includes/db_connect.php');
//include_once(dirname($path).'/login/includes/functions.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($db) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

if (isset($_GET['error'])) {
    echo '<p class="error">Error Logging In!</p>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kamagru: Log In</title>
    <link rel="stylesheet" href= "../includes/layout/style.css" />
<!--    <link rel="stylesheet" href="styles/main.css" />-->
    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
</head>

<body>
    <div class="body_main" style="height: 500px">

        <header>
            <a href="index.php" ><h1>kamagru</h1></a>
            <ul id="nav">
                <li><a href="../gallery.php">Gallery</a></li>
            </ul>
        </header>

        <?php if(isset($_GET['s'])){ echo '<p>password changed</p>'; } ?>
<div id="loginform">
        <form action="includes/process_login.php" method="post" name="login_form">
            Username: <input type="text" name="username" />
            Password: <input type="password"
                             name="password"
                             id="password"/>
            <input type="button"
                   value="Login"
                   onclick="formhash(this.form, this.form.password);" />
        </form>
</div>
        <?php
        if (login_check($db) == true) {
            echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';

            echo '<p>Do you want to change user? <a href="logout.php">Log out</a>.</p>';
        }
        else {
            echo '<p>Currently logged ' . $logged . '.</p>';
            echo "<p><a href='../forgotpassword.php'>Forgot Password</a></p>";
            echo "<p>If you don't have a login, please <a href='register.php'>register</a></p>";
        }
        ?>



    </div>
    <footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>
</body>
</html>