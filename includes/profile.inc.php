<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

try {
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(array(':id' => $_SESSION['id']));

    // set the resulting array to associative
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
        $username = $row['username'];
        $email = $row['email'];
        $pass_db = $row['password'];
        $receive = $row['receive'];
    }
}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}


if (isset($_POST['editsaved'])){

    if (isset($_POST['password'], $_POST['confirmpwd'])) {

        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $password = hash('sha512', $password);

        $password = password_hash($password, PASSWORD_BCRYPT);
//die($password);
        $username = $_POST['username'];

        $email = $_POST['email'];


        if (isset($_POST['receive'])){
            $receive = 1;
        }
        else{

            $receive = 0;
        }

        if ($_POST['password'] == $_POST['confirmpwd']) {

            try {
                $stmt = $db->prepare("UPDATE users SET username = :username, email = :email, receive = :receive WHERE id = :id LIMIT 1");
                $stmt->execute(array(':username' => $username, ':email' => $email, ':receive' => $receive,':id' => $_SESSION['id']));
            } catch (PDOException $e) {
                echo $stmt . "<br>" . $e->getMessage();
            }


            if ($_POST['password'] != '') {

                try {
                    $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id LIMIT 1");
                    $stmt->execute(array(':password' => $password, ':id' => $_SESSION['id']));
                } catch (PDOException $e) {
                    echo $stmt . "<br>" . $e->getMessage();
                }
            }
            else
            {
                $pwd_error_msg .= '<p class="error">Passwords do not match.</p>';
            }

            //        header('Location: ./register_success.php');

            header('Location: ../kamagru/login/index.php');

        }
        else
        {
            $pwd_error_msg .= '<p class="error">Passwords do not match.</p>';

        }



    }
}


?>