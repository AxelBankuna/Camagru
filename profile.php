<?php include "includes/profile.inc.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        <?php include "includes/layout/style.css"; ?>
    </style>
</head>

<?php include "includes/layout/header.php"; ?>
    <?php if (login_check($db) == true) : ?>
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
                <div class="height">

                    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
                          method="post"
                          name="edit">
                        <fieldset>
                            <legend><h2>Profile Page</h2></legend>

                            <?php if(isset($_POST['edit'])){
                                if (isset($_POST['password'])){
                                    $password = $_POST['password'];
                                    $password = hash('sha512', $password);
                                }
                                if (isset($_POST['editview'])) {?>

                                <p>Enter Password to edit profile:</p>
                                <p><label class="field" for="password">Password: </label><input type="password" name="password" id="password"/></p>
                                <input type="hidden" name="editprofile" value="true">
                                <input type="submit" value="Submit" name="edit"/>

                                <?php }
                                else if ($_POST['editprofile'] == "true" && password_verify($password, $pass_db)) {?>
                                <p><label class="field" for="email">Username: </label><input type="text" name="username" id="username" value="<?php echo $username; ?>"/></p>
                                <p><label class="field" for="email">Email: </label><input type="email" name="email" id="email" value="<?php echo $email; ?>"/></p>
                                <p><label class="field" for="receive">Receive Email: </label><input type="checkbox" name="receive"
                                                                                                    <?php if ($receive == 1){echo "checked";}?>
                                                                                                    value="<?php echo $receive; ?>"/></p>
                                <p><label class="field" for="password">New Password: </label><input type="password" name="password" id="password"/></p>
                                <p><label class="field" for="confirmpwd">Confirm New Password: </label><input type="password" name="confirmpwd" id="confirmpwd" /></p>
                                <input type="submit" value="Save Changes" name="editsaved"/>

                            <?php }

                                else if ($_POST['editprofile'] == "true" && !password_verify($password, $pass_db)) {?>

                                    <?php
                                    echo "
                                        <script type='text/javascript'>
                                         alert('Passwords do not match!');
                                        </script>
                                        ";
                                    ?>

                                <?php }

                            }else{
                                    echo "<p>Userrname: " .$username. "</p>
                                    <p>Email: " .$email. "</p>
                                    <input type='hidden' name='editview' value='1'>
                                    <input type='submit' value='Edit Profile' name='edit'/>";
                                }?>
                        </fieldset>

                    </form>

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