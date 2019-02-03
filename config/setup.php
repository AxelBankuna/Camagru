<?php

include_once 'database.php';

try {
    $db = new PDO("mysql:host=$_DB_SERVER", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = "CREATE DATABASE IF NOT EXISTS camagru";
    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Database camagru created successfully<br>";
}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}

$db = null;


try {
//    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $stmt = "CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `images_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table comments created successfully <br>";



    $stmt = "CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table images created successfully <br>";



    $stmt = "CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `images_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table likes created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table login_attempts created successfully <br>";



    $stmt = "CREATE TABLE IF NOT EXISTS `temp_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table temp_image created successfully <br>";



    $stmt = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `forgotpass` varchar(255) DEFAULT NULL,
  `receive` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table users created successfully <br>";

}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}

$db = null;

?>