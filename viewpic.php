<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

if (isset($_GET['id'])){
    $image_id = $_GET['id'];
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

<?php include "includes/layout/header.php"; ?>
    <?php if (login_check($db) == true) : ?>
        <nav>
            <h3>Likes</h3>

            <?php
            try {
                $stmt = $db->prepare("SELECT likes.*, users.*, likes.id AS my_likes_id FROM likes JOIN users ON users.id = likes.user_id WHERE images_id = :images_id");
                $stmt->execute(array(':images_id' => $image_id));

                // set the resulting array to associative
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $results[] = $row;
                    echo "<strong><i>".$row['username']."</i></strong><br>";
                }
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>

        </nav>

        <article>
            <div class="row">
                <div class="column" style="background-color:#aaa;">

                    <?php
                    try {
                    $stmt = $db->prepare("SELECT * FROM images WHERE id = :id LIMIT 1");
//                        $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id WHERE images.id = :images.id");

                        $stmt->execute(array(':id' => $image_id));

                    // set the resulting array to associative
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $results[] = $row;
                    echo "<div>";
                        echo "<img class='resp_img' src='uploads/img".$row['title']."'>";
                        echo "</div>";
                    }
                    }
                    catch(PDOException $e)
                    {
                    echo $stmt . "<br>" . $e->getMessage();
                    }
                    ?>

                    <?php
                    try {
                        $stmt = $db->prepare("SELECT * FROM likes WHERE images_id = :images_id  AND user_id = :user_id LIMIT 1");
                        $stmt->execute(array(':images_id' => $image_id, ':user_id' => $_SESSION['id']));

                        // set the resulting array to associative
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $results[] = $row;
                        }

                        if ($stmt->rowCount() == 1){
                            echo "You like this picture";
                            echo '<a href="like.php?id='.$image_id.'" id="like" value="" onclick="liked_function()"><img id="likeimg" src="includes/images/liked.png" width="40px"></a>';
                        }
                        else{
                            echo '<a href="like.php?id='.$image_id.'" id="like" value="" onclick="like_function()"><img id="likeimg" src="includes/images/like.png" width="40px"></a>';
                        }
                    }
                    catch(PDOException $e)
                    {
                        echo $stmt . "<br>" . $e->getMessage();
                    }
                    ?>

                    <hr>
                    Comment:
                    <br>
                    <textarea rows="4" cols="50" name="comment" form="commentform"></textarea>
                    <form action="commentemail.php?id=<?php echo $image_id; ?>" name="commentform" id="commentform" method="post">
                        <input type="hidden" name="image_id" value="<?php echo $image_id; ?>">
                        <input type="submit" name="commentsubmit">
                    </form>
                    <br>

                    <?php
                    try {
                        $stmt = $db->prepare("SELECT * FROM images WHERE id = :id  AND user_id = :user_id LIMIT 1");
                        $stmt->execute(array(':id' => $image_id, ':user_id' => $_SESSION['id']));
                        $previous = $_SERVER['HTTP_REFERER'];

                        if ($stmt->fetchColumn()){
                            echo "<form action='deletepic.php' method='post'>
                                        <input type='hidden' name='image_id' value='$image_id'>
                                        <input type='hidden' name='previous' value='$previous'>
                                        <input type='submit' name='delete' value='Delete Image' id='delete'>
                                   </form>";
                           }
                    }
                    catch(PDOException $e)
                    {
                        echo $stmt . "<br>" . $e->getMessage();
                    }
                    ?>


                </div>

                <div class="column" style="background-color:#aaa;">

                    <h1 class="heading">Comments</h1>

                    <?php
                    try {
                        $stmt = $db->prepare("SELECT comments.*, users.*, comments.id AS my_comments_id FROM comments JOIN users ON users.id = comments.user_id WHERE images_id = :images_id");
                        $stmt->execute(array(':images_id' => $image_id));

                        // set the resulting array to associative
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $results[] = $row;
                            echo "<strong><i>".$row['username']."</i></strong><br>";
                            echo $row['comment']. "<br><br>";
                        }
                    }
                    catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>

                </div>
            </div>
        </article>
    <?php else : ?>
        <p>
            <span class="error">You are not authorized to access this page.</span> Please <a href="login/index.php">login</a>.
        </p>
    <?php endif; ?>

<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>


</div>

</body>
</html>
