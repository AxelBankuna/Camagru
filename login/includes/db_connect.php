<?php
//include_once '../config/database.php';
//include_once '/kamagru/config/database.php';
require __DIR__ . "/../../config/database.php";
//$path = $_SERVER['DOCUMENT_ROOT'];
//$path = "/goinfre/abukasa/MAMP/apache2/htdocs/kamagru/kamagru/";
//$path='.:/goinfre/abukasa/MAMP/php/lib/php:/goinfre/abukasa/MAMP/frameworks/smarty/libs';
//die($path);
//
//include_once(dirname($path).'/config/database.php/');

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
//    echo $stmt . "<br>" . $e->getMessage();
}

?>