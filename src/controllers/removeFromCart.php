<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    $cart_len = sizeof($_SESSION['cart']);

    for($i=1; $i <= $cart_len; $i++){
        if(isset($_POST["box{$i}"]))
        {
            $post = $_POST["box{$i}"];
            // remove element from the session
            $_SESSION['cart'] = array_diff($_SESSION['cart'], [$post]);
        }
    }
    header('Location: front_controller.php?action=/remembered');
}
?>