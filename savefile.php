<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';


try{
    $id = $_SESSION['id'];

    $stmt = "INSERT INTO images(title, user_id)
                                    VALUES ('$filename', '$id')";
    $db->exec($stmt);

}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}

?>