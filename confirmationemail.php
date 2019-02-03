<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

$message = "";

if (isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])){

    $username = $_GET['u'];
    $email = $_GET['e'];
    $password = $_GET['p'];

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(array(':username' => $username));

        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
            $status = $row['status'];
        }
    }
    catch(PDOException $e)
    {
        echo $stmt . "<br>" . $e->getMessage();
    }

    $actual_link = "http://localhost:8080/kamagru/activation.php?u=".$username."&e=".$email."&p=".$password."";
    $toEmail = $_GET["e"];
    $subject = "User Registration Activation Email";
//    $content = "Click this link to activate your account. <a href='" . $actual_link . "'>" . $actual_link . "</a>";

    $content = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<h1>Kamagru</h1>
<p>
Click this link to activate your Kamagru account. <a href='".$actual_link."'> . $actual_link . </a>
</p>
<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>
</body>
</html>
";
    $mailHeaders = 'MIME-Version: 1.0' . "\r\n";
    $mailHeaders .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $mailHeaders .= 'From: Admin <admin@kamagru.co.za>' . "\r\n";
    if(mail($toEmail, $subject, $content, $mailHeaders)) {
        $message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";
    }
    unset($_POST);

    header("location: confirmation.php?");

}


?>