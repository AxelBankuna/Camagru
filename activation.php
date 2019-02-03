<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

if (isset($_GET['u'])) {

    $username = $_GET['u'];

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(array(':username' => $username));

        // set the resulting array to associative
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
            $status = $row['status'];
        }
    } catch (PDOException $e) {
        echo $stmt . "<br>" . $e->getMessage();
    }

    if ($status == 0) {

        try {
            $stmt = $db->prepare("UPDATE users SET status = :status WHERE username = :username LIMIT 1");
            $stmt->execute(array('status' => 1, ':username' => $username));
        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

    }

}

header("location: login/register_success.php");