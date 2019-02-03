<?php
include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

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
    <title>Kamagru: Forgot Password</title>
    <link rel="stylesheet" href= "includes/layout/style.css" />
    <!--    <link rel="stylesheet" href="styles/main.css" />-->

</head>

<body>
<div class="body_main" style="height: 500px">

    <header>
        <h1><a href="index.php"> kamagru</a></h1>
    </header>

    <form action="forgotemail.php" method="post">
        Email: <input type="email" name="email" />
        <input type="submit" value="Submit" name="forgot_form"/>
    </form>

</div>
<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>
</body>

<script type="text/JavaScript" src="login/js/sha512.js"></script>
<script type="text/JavaScript" src="login/js/forms.js"></script>

</html>