<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

$id = $_SESSION['id'];
$img = $_GET['id'];
//die($id);

try {
    $stmt = $db->prepare("SELECT * FROM likes WHERE images_id = :images_id AND user_id = :user_id LIMIT 1");
    $stmt->execute(array(':images_id' => $img, ':user_id' => $id));

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (!$stmt->fetchColumn()){
    $stmt = $db->prepare("INSERT INTO likes (images_id, user_id)
                                    VALUES (:images_id, :user_id)");

    $stmt->execute(array(':images_id' => $img, ':user_id' => $id));
}



header("location: viewpic.php?id=$img");

?>