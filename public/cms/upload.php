<?php
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $_GET['path']."/".iconv('UTF-8', 'windows-1251', $_FILES['userfile']['name']))) {
    //echo "File is valid, and was successfully uploaded.";
    //exit(0);
} else {
    //echo "There some errors!";
    //exit(0);
}
?>