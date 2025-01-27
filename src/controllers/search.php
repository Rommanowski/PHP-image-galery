<?php

if(!isset($_SESSION['user_login'])){
    $user_login = "guest";
}
else{
    $user_login = $_SESSION['user_login'];
}
require_once '../models/functions.php';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!isset($_POST['search'])){
        $search = "";
    }
    if(isset($_POST['search'])){
        $search = $_POST['search'];
    }
    else{
        $search = "";
    }
    $db = get_db();
    $images = iterator_to_array($db->images->find());

    foreach($images as $image){
        if(($image['privacy'] == 'public') || ($image['author'] == $user_login)){
            if((empty($search)) ||  (strpos($image['title'], $search) !== false)){
                //echo $image['title'] . "<br>";
                echo "<a href = 'images/watermarks/{$image['filename']}' target='blank'>";
                    echo "<img src='images/minis/{$image['filename']}'><br>";
                echo "</a>";
                echo "title: " . $image['title'] . "<br>";
                echo "author: " . $image['author'] . "<br><br>";
            }
        }
    }
}

?>