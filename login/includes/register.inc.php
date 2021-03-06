<?php
include_once 'db_connect.php';
//$path = $_SERVER['DOCUMENT_ROOT']. "/kamagru";
//die($path);
//include_once(dirname($path).'/login/includes/db_connect.php');
//include_once 'config.php';

$error_msg = "";

if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");

    // check existing email
    if ($stmt) {
        $stmt->execute(array(':email'=> $email));
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $results[] = $row;
        }


        if ($stmt->rowCount() == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
        $stmt->close();
    }

    // check existing username
    $stmt = $db->prepare("SELECT id 
                                      FROM users 
                                      WHERE username = :username LIMIT 1");

    if ($stmt) {
        $stmt->execute(array(':username' => $username));
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $results[] = $row;
        }

        if ($stmt->rowCount() == 1) {
            // A user with this username already exists
            $error_msg .= '<p class="error">A user with this username already exists</p>';
            $stmt->db = null;
        }
    } else {
        $error_msg .= '<p class="error">Database error line 55</p>';
        $stmt->close();
    }

    // TODO:
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.

    if (empty($error_msg)) {

        // Create hashed password using the password_hash function.
        // This function salts it with a random salt and can be verified with
        // the password_verify function.

        $password = password_hash($password, PASSWORD_BCRYPT);
//        die($password);
        // Insert the new user into the database
        if ($insert_stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)")) {
            // Execute the prepared query.
            if (! $insert_stmt->execute(array(':username' => $username, ':email' => $email, ':password' => $password))) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        $u = $username;
        $e = $email;
        $p = $password;
//        header('Location: ./register_success.php');

        header('Location: ../confirmationemail.php?u='.$u.'&e='.$e.'&p='.$p);
    }
    else {
        die($error_msg);
    }
}
?>