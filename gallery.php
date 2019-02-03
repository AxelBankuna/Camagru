<?php
//$path = $_SERVER['DOCUMENT_ROOT']. "/kamagru";
//include_once(dirname($path).'/login/includes/db_connect.php');
//include_once(dirname($path).'/login/includes/functions.php');
include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

if (isset($_GET['id'])){
    $image_id = $_GET['id'];
}

if (isset($_POST['commentsubmit'])){
    $comment = $_POST['comment'];
//die("insert comment");
    $stmt = $db->prepare("INSERT INTO comments (images_id, user_id, comment)
                                    VALUES (:images_id, :user_id, :comment)");

    $stmt->execute(array(':images_id' => $image_id, ':user_id' => $_SESSION['id'], ':comment' => "$comment"));

    header("location: viewpic.php?id=$image_id");

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        <?php include "includes/layout/style.css"; ?>
    </style>
</head>
<body>

<div class="container">

    <header>
        <h1><a href="index.php">Kamagru</a></h1>
        <ul id="nav">

            <?php if (login_check($db) == true){ ?>
                <p>Signed in as: <?php echo htmlentities($_SESSION['username']); ?></p>
                <?php echo '<p><a href="login/logout.php">Log out</a>.</p>'; ?>
            <?php } ?>

            <?php if (login_check($db) == false) {?>
            <li><a href="login/index.php">Login</a></li>
            <?php }
            else {?>
            <li><a href="index.php">Home</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="profile.php">Profile</a></li>
            <?php } ?>
        </ul>
    </header>
    <?php if(isset($_GET['error']))
    {
        echo ' <p>
            <span class="error">You are not authorized to access this page.</span> Please <a href="login/index.php">login</a>.
        </p>';
    }
    ?>
<!--    --><?php //if (login_check($db) == true) : ?>
        <nav>
Upload awesome pictures by using one of our amazing superposables!!!

            <ol>
                <li>Select a superposable</li>
                <li>Take a picture using the webcam</li>
                <li>...or upload a an image from your computer.</li>
                <li>Upload and share with the world!!!!</li>
            </ol>
        </nav>

        <article style="min-height: 500px">
            <div class="rowgallery">
                

                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        if ($page == 1){
                            $pg = 0;
                        }
                        else{
                            $pg = ($page * 5) - 5;
                        }
                    }
                    else{
                        $pg = 0;
                    }
                    $count = $db->query("SELECT count(*) FROM images")->fetchColumn();
                    $count = ceil($count / 5);

                    try {
//                        $stmt = $db->prepare("SELECT * FROM images ORDER BY title ASC");
                        $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id ORDER BY title ASC  LIMIT $pg,5");

                        $stmt->execute();

                        // set the resulting array to associative
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $results[] = $row;
                            echo '<div class="gallerycolumn">';
                            echo $row['username'].'<br>';
                            echo "<a href='viewpic.php?id=".$row['my_images_id']."'><img class='resp_img' src='uploads/img".$row['title']."'></a>";
                            echo '</div>';
                        }
                    }
                    catch(PDOException $e)
                    {
                        echo $stmt . "<br>" . $e->getMessage();
                    }

                    ?>
                
            </div>
            <?php
            for ($i=1; $i <= $count; $i++){
                echo "<a href='gallery.php?page=".$i."' style='text-decoration: none'>" .$i. " </a>";
            }
            ?>

        </article>
<!--    --><?php //else : ?>
<!--        <p>-->
<!--            <span class="error">You are not authorized to access this page.</span> Please <a href="login/index.php">login</a>.-->
<!--        </p>-->
<!--    --><?php //endif; ?>

<?php

if (isset($_GET['msg'])){
    if (($_GET['msg']) == 'deleted'){
        echo "
        <script type='text/javascript'>
         alert('Image deleted successfully');
         window.location.href = \"gallery.php\";
        </script>
        ";
    }
}

?>

<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>


</div>

</body>
</html>