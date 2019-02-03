<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

$id = $_SESSION['id'];
$img = $_GET['id'];
die("unlike");
$stmt = $db->prepare("DELETE FROM likes WHERE images_id = :images_id AND user_id = :user_id");

$stmt->execute(array(':images_id' => $img, ':user_id' => $id));

header("location: viewpic.php?id=$img");




?>