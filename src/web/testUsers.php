<?php
session_start();

if(!isset($_SESSION['rule']) || $_SESSION['rule'] === 0){
    header('Location: front_controller.php?action=/home');
    exit;
}

use MongoDB\Operation\Find;

require_once '../models/functions.php';
$db = get_db();
$users = $db->users->find();
// print_r($users);
foreach($users as $user){
    
    echo "user ---> " . $user['login'] . " ---> rule: ---> " . $user['rule'];

    if(isset($_SESSION['rule'])){
        if($_SESSION['rule'] === 2 && $user['rule'] === 0){
            echo "<a href = 'front_controller.php?action=/userDelete&uid={$user['_id']}'> delete</a>";
        }
    }

    echo "<br>";
}

?>