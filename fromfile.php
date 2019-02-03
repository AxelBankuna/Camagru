<?php

if (isset($_POST['fromfile'])){

    $file_type = $_FILES['image']['type']; //returns the mimetype

    $allowed = array("image/jpeg", "image/gif", "image/png");
    if(in_array($file_type, $allowed)) {

        $target =  "temp_images/".basename($_FILES['image']['name']);
        $image = $_FILES['image']['name'];
        $msg = "";
        $supUploadImage = $_POST['superUploadImage'];

        //The name of the directory that we need to create.
        $directoryName = 'temp_images';

        //Check if the directory already exists.
        if(!is_dir($directoryName)){
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755);
        }

        try{
            $stmt = "INSERT INTO temp_image(image)
                                    VALUES ('$image')";
            $db->exec($stmt);

        }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }


        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            $$msg = "There was a problem uploading image";
        }

        $id = $db->lastInsertId();

        try {
            $stmt = $db->prepare("SELECT * FROM temp_image WHERE id = :id LIMIT 1");
            $stmt->execute(array(':id' => $id));

            // set the resulting array to associative
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $results[] = $row;
                echo "<div id=''>";
                echo "<img id='uploadimage' src='temp_images/".$row['image']."'>";
                echo "<img id='uploadSupimage' src='".$supUploadImage."'>";
                echo "</div>";
            }
        }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }

    }
    else{

        echo "
        
        <script type='text/javascript'>
            alert('Only jpg, gif, and png files are allowed.');
        </script>
        
        ";
    }

}


?>


