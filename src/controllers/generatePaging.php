<?php
    require_once '../models/functions.php';
    $page_size = 3;

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    $photos = getImages();
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
    // start the form
    echo "<form method='POST' action='front_controller.php?action=/addToCart'>";

    // echo the page of photos
    $photoNum = 0;
    $i=1;
    foreach ($photos as $photo){
        if(($photoNum >= ($page-1)*$page_size) && ($photoNum < ($page*$page_size))){
            //echo $photo inside a hiperlink;
            echo "<a href = ./images/watermarks/{$photo['filename']} target='blank'>";
                echo "<img src = ./images/minis/{$photo['filename']}>";
            echo "</a> <br>";

            // author and title
            echo "title: {$photo['title']} <br>";
            echo "author: {$photo['author']}<br>";
            // add checkbox
            echo "<label for='box{$i}'>Remember this photo</label>
                <input type='checkbox' name='box{$i}' id='box{$i}' value = '{$photo['filename']}'";
            if(in_array($photo['filename'], $_SESSION['cart'])){
                echo " checked";
            }
            echo "><br>";
            $i++;

            echo "<br><br><br>";
        }
        $photoNum++;
    }   
    // close the form
    echo "<input type='submit' name='submit' value='Remember selection'><br><br>";
    echo "<input type='hidden' name='page' value={$page}>";
    echo "<input type='hidden' name='pageSize' value='{$page_size}'>";
    echo "</form>";

    // echo the paging at the bottom, cool operator used 
    $addPage = (($photoNum % $page_size) !== 0) ? 1 : 0; 
    for($i=1; $i<=($photoNum / $page_size) + $addPage; $i++){
        echo "<a href='front_controller.php?action=/hof&page={$i}'> ($i) </a>";
    }  

?>