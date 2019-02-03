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

if (isset($_POST['commentsubmit'])){
    $image_id = $_POST['image_id'];
    $comment = $_POST['comment'];
    $comment = filter_var($comment, FILTER_SANITIZE_STRING);
//die("insert comment");
    $stmt = $db->prepare("INSERT INTO comments (images_id, user_id, comment)
                                    VALUES (:images_id, :user_id, :comment)");

    $stmt->execute(array(':images_id' => $image_id, ':user_id' => $_SESSION['id'], ':comment' => "$comment"));
    $comment_id = $db->lastInsertId();


    try {
        $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id WHERE images.id = :images_id LIMIT 1");

        $stmt->execute(array(':images_id' => $image_id));

        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
            $email = $row['email'];
            $receive = $row['receive'];
        }
    }
    catch(PDOException $e)
    {
        echo $stmt . "<br>" . $e->getMessage();
    }

    if ($receive == 1) {


        try {
            $stmt = $db->prepare("SELECT comments.*, users.*, comments.id AS my_comments_id FROM comments JOIN users ON users.id = comments.user_id WHERE comments.id = :comments_id LIMIT 1");

            $stmt->execute(array(':comments_id' => $comment_id));

            // set the resulting array to associative
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
                $writer = $row['username'];
            }
        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

        $actual_link = "http://localhost:8080/kamagru";
        $toEmail = $email;
        $subject = "Your picture's got the world talking";
//    $content = "Click this link to view comments. <a href='" . $actual_link . "'>" . $actual_link . "</a>";
        $content = "
<html>
<head>
<title>Comment</title>
</head>
<body>
<h1>Kamagru</h1>
<p>
" . $writer . " has commented on your picture!!!
</p>
<p>
Click this link to view comments. <a href='" . $actual_link . "'> . $actual_link . </a>
</p>
<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>
</body>
</html>
";
        $mailHeaders = 'MIME-Version: 1.0' . "\r\n";
        $mailHeaders .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
        $mailHeaders .= 'From: Admin <admin@kamagru.co.za>' . "\r\n";
        if (mail($toEmail, $subject, $content, $mailHeaders)) {
            $message = "A link to reset your password has been sent to your email. Click the link to reset your password.";
        }
        unset($_POST);

        header("location: viewpic.php?id=$image_id");
    }
    header("location: viewpic.php?id=$image_id");
}
