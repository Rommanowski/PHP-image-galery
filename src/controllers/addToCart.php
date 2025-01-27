<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }
    $page_size = $_POST['pageSize'];
    for($i=1; $i <= $page_size; $i++){
        if(isset($_POST["box{$i}"])){
            $post = $_POST["box{$i}"];
            if(!in_array($post, $_SESSION['cart'])){
                array_push($_SESSION['cart'], $post);
            }   
        }
    }

    if(isset($_POST['page'])){
        header("Location: front_controller.php?action=/hof&page={$_POST['page']}");
    }
    else{
        header("Location: front_controller.php?action=/hof");
    }
}
?>