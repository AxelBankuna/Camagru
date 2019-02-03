<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

$id = $_SESSION['id'];

$db->query("DELETE FROM likes
WHERE user_id = $id AND images_id = 1");

header("Location: viewpic.php");

?>