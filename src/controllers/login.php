<?php
require_once '../models/functions.php';

if(($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['login'])) && (isset($_POST['pass']))){
    $db = get_db();
    // sanitize
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['pass'];
    $user = $db->users->findOne(['login' => $login]);

    $blad = "";

    if( ($user !== null) && (password_verify($password, $user['password'])) ){
        if(userExists($login)){
            session_regenerate_id();
            $_SESSION['user_login'] = $login;
            $_SESSION['rule'] = $user['rule'];
            header('Location: front_controller.php?action=/home');
            exit;
        }
    }
    else{
        $blad = "Invalid login and/or password!";
    }
    header("Location: front_controller.php?action=/loginForm&error=" . urlencode($blad));
    exit;
}

?>