<?php
    require_once '../models/functions.php';

    ini_set('post_max_size', '150M');
    ini_set('upload_max_filesize', '150M');
    ini_set('memory_limit', '256M');

    $error = "";

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        $error = "Invalid request method<br>";
        // echo "<a href='front_controller.php?action=/hof'>Go back</a>";
        // exit;
    }        
    if(!isset($_FILES['image'])){
        $error = "Trouble with sending the file<br>";
        // echo "<a href='front_controller.php?action=/hof'>Go back</a>";
        // exit;
    }

    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK ){
        $error = "There is something wrong with the file<br>";
        // echo "<a href='front_controller.php?action=/hof'>Go back</a>";
        // exit;
    }

    $filename = $_FILES['image']['name'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'png'];

    // check file extension and size
    if( (!in_array($extension, $allowed_extensions)) || ($_FILES['image']['size'] > 1 * 1024 * 1024)){

        if(!in_array($extension, $allowed_extensions)){
            $error = "Wrong file extension!<br><br>";
        }

        if($_FILES['image']['size'] > 1 * 1024 * 1024){
            $error .= "File is too large! The limit is 1MB<br>";
            $error .= "Current file size: " . round(($_FILES['image']['size'] / (1*1024*1024)), 2) . " MB<br>";
        }

        // echo "<a href='front_controller.php?action=/hof'>Go back</a>";
        // exit;
    }
    if(!empty($error)){
        header ("Location: front_controller.php?action=/hof&error=" . urlencode($error));
        exit;
    }

    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS);
    $watermark = filter_input(INPUT_POST, 'watermark', FILTER_SANITIZE_SPECIAL_CHARS);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    if(isset($_POST['privacy'])){
        $privacy = $_POST['privacy'];
    }
    else{
        $privacy = 'public';
    }
    
    if(uploadImage($author, $watermark, $title, $privacy)){
        // echo "success!<br>";
        header ('Location: front_controller.php?action=/hof');
    }
    else{
        $error = "Possible file upload attack!<br>";
        header ("Location: front_controller.php?action=/hof&error=" . urlencode($error));
        exit;
    }
?>
