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


if (isset($_POST['forgot_form'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
//                        $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id WHERE images.id = :images.id");

        $stmt->execute(array(':email' => $email));

        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
            $username = $row['username'];
        }
    }
    catch(PDOException $e)
    {
        echo $stmt . "<br>" . $e->getMessage();
    }

    $key = generateRandomString();

    try {
        $stmt = $db->prepare("UPDATE users SET forgotpass = :forgotpass WHERE email = :email");
        $stmt->execute(array(':email' => $email, ':forgotpass' => $key));
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $actual_link = "http://localhost:8080/kamagru/newpassword.php?u=".$username."&key=".$key."&e=".$email."";
    $toEmail = $email;
    $subject = "Reset Kamagru Account Password";
//    $content = "Click this link to activate your account. <a href='" . $actual_link . "'>" . $actual_link . "</a>";
    $content = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<h1>Kamagru</h1>
<p>
Click this link to reset your Kamagru account password. <a href='".$actual_link."'> . $actual_link . </a>
</p>
<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>
</body>
</html>
";
    $mailHeaders = 'MIME-Version: 1.0' . "\r\n";
    $mailHeaders .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $mailHeaders .= 'From: Admin <admin@kamagru.co.za>' . "\r\n";
    if(mail($toEmail, $subject, $content, $mailHeaders)) {
        $message = "A link to reset your password has been sent to your email. Click the link to reset your password.";
    }
    unset($_POST);

    header("location: resetconfirmation.php?");

}
?>
