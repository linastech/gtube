<?php
    if ($_FILES['vidfile']['type'] == "video/webm" || $_FILES['vidfile']['type'] == "video/mp4") {
        move_uploaded_file($_FILES['vidfile']['tmp_name'], getcwd()."/video/temp/".$_SERVER['REQUEST_TIME']);
        ob_start();
        echo "File uploaded. Please wait a few minutes for the encode to complete. You will now be returned to the home page";
        header("Location: index.php");
        ob_flush();


        /* This doesn't work, no idea why
           Just going to use a cronjob for the time being */
        /* exec("/bin/sh reencode.sh & 2>&1", $output); */

    }
    else {
        echo "Invalid file format";
    }
?>
