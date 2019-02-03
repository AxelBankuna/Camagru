<?php
include_once 'newpassword.inc.php';
include_once 'includes/functions.php';



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Secure Login: Registration Form</title>
    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
    <link rel="stylesheet" href="../includes/layout/style.css" />
</head>

<body>

<header>
    <h1>Kamagru</h1>
</header>

<div class="row">
    <div class="column">

        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
              method="post"
              name="registration_form">
            <fieldset>
                <legend><h2>Create New Password</h2></legend>

                <p><?php echo $error_msg; ?>
                <?php if(empty($error_msg)){ ?>
                <p>Userrname: <?php echo $username;?> </p>
                <p>Email: <?php echo $email;?></p>
                <p><label class="field" for="password">New Password: </label><input type="password" name="password" id="password"/></p>
                <p><label class="field" for="confirmpwd">Confirm New Password: </label><input type="password" name="confirmpwd" id="confirmpwd" /></p>
                <input type="submit" value="Update" />
<!--                <input type="button" value="Update" onclick="return newpassformhash(this.form,-->
<!--                                                                                   this.form.password,-->
<!--                                                                                   this.form.confirmpwd);" />-->
                <?php } ?>
            </fieldset>

        </form>

        <p>Return to the <a href="index.php">login page</a>.</p>

    </div>
</div>

<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>

</body>
</html>