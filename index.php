<?php

include_once 'login/includes/db_connect.php';
include_once 'login/includes/functions.php';

sec_session_start();

if (login_check_new($db) == true) :


endif;

if(isset ($_POST['img'])){
    if (count($_POST) && (strpos($_POST['img'], 'data:image/png;base64') === 0)) {

        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = 'uploads/img' . date("YmdHis") . '.png';
        $filename = date("YmdHis") . '.png';

        if (file_put_contents($file, $data)) {
            include "savefile.php";
            echo "
        <script type='text/javascript'>
         alert('The canvas was saved as $file.');
        </script>
        ";
//            echo "<p>The canvas was saved as $file.</p>";
        } else {
            echo "<p>The canvas could not be saved.</p>";
        }
    }

}

if (isset($_GET['msg'])){
    if (($_GET['msg']) == 'deleted'){
        echo "
        <script type='text/javascript'>
         alert('Image deleted successfully');
         window.location.href = \"index.php\";
        </script>
        ";
    }
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
<body onload="uploadImg()">

<div class="container">

    <?php include "includes/layout/header.php"; ?>
    
    <nav>
        <h3>Recent Uploads</h3>

        <?php

        try {
            $stmt = $db->prepare("SELECT * FROM images WHERE user_id = :user_id ORDER BY id DESC LIMIT 6");
            $stmt->execute(array(':user_id' => $_SESSION['id']));

            // set the resulting array to associative
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $results[] = $row;
                echo "<div class='recentpics'>";
                echo "<a href='viewpic.php?id=".$row['id']."'><img id='recent' src='uploads/img".$row['title']."'></a>";
                echo "</div>";
            }
        }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }

        ?>
    </nav>

    <article>
        <div class="row">
            <div class="column" style="background-color:#aaa;">
                <div id="super">
<!--                    <h2>Select a superposable image and then capture your picture.</h2>-->

                    <form>
                        <label>
                            <img class="super" id="ball" src="includes/images/basketball.png" width="120" height="120" onclick="merge(this)">
                        </label>
                        <label>
                            <img class="super" id="confetti" src="includes/images/confetti.png" width="120" height="120" onclick="merge(this)">
                        </label>
                        <label>
                            <img class="super" id="sun" src="includes/images/sun.png" width="120" height="120" onclick="merge(this)">
                        </label>
                        <label>
                            <img class="super" id="smoke" src="includes/images/smoke.png" width="120" height="120" onclick="merge(this)">
                        </label>

                    </form>
                </div>

                <div id="booth">
                    <img src="" id="superImage" class="media" />
                    <video autoplay="true" id="video" class="media" ></video>
                    <?php include "fromfile.php"; ?>
                    <hr>
                    <input type="button" id ="capture" value = "Take photo" disabled>
                </div>

                <div id="fromfile">

                    <form method="post" action="index.php?a=1" enctype="multipart/form-data">
                        <input type="file" name="image">
                        <input type="hidden" id="superUploadImage" name="superUploadImage" value="">
                        <input type="submit" id="upload_image" name="fromfile">
                    </form>

                </div>

            </div>

            <div id="preview" class="column" style="background-color:#bbb;">
                <h2>Photo Preview</h2>
                <div class="mycanvas">

                    <canvas id="canvas" width='390' height='390'></canvas>
                    <img id="photo" class="resp_img" src="includes/images/placeholder.png" class="media" alt="">

                    <form method="post" action="index.php" onsubmit="prepareImg();">
                        <input id="inp_img" name="img" type="hidden" value="">
                        <input id="bt_upload" type="submit" value="Upload" disabled  onclick="able(this)">
                    </form>

                </div>
            </div>
        </div>
    </article>

<?php include "includes/layout/footer.php"; ?>

<?php

if (isset($_GET['a'])){
    if ($_GET['a'] == 1){
        echo '<script type="text/javascript">
        able();
        </script>
        ';
    }
}
?>