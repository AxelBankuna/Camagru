<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

if (isset($_POST['delete'], $_POST['image_id'])){
    try {
        $return_page = $_POST['previous'];
        $image_id = $_POST['image_id'];
        // sql to delete a record
        $stmt = "DELETE FROM images WHERE id = $image_id";

        // use exec() because no results are returned
        $db->exec($stmt);
//        echo "Image deleted successfully";
        header('Location: ' . $return_page . '?msg=deleted');
//        header("locaion: thispage.php");

    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}

