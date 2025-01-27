<?php
session_start();

// if(!isset($_SESSION['rule']) || $_SESSION['rule'] === 0){
//     header('Location: front_controller.php?action=/home');
//     exit;
// }

if(isset($_SESSION['cart'])){
    $cart = $_SESSION['cart'];
    foreach ($cart as $item){
        echo $item . "<br>";
    }
}
?>