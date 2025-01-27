<?php
require_once '../models/functions.php';

$forbidenNames = ['guest', 'admin'];

$err = "";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if((!empty($_POST['login'])) && (!empty($_POST['pass'])) && (!empty($_POST['repeat_pass']))){
        // sanitize
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = $_POST['pass'];
        $repeat_pass = $_POST['repeat_pass'];
        $controllerURL = "Location: front_controller.php?action=";
        $errorURL = "/registerForm&error=";

        if(userExists($login)){
            $err = "User called --> {$login} <-- already exists!";
        }
        else if($pass !== $repeat_pass){
            $err = "Passwords should be the same!";
        }
        else if(in_array($login, $forbidenNames)){
            $err = "Login --> {$login} <-- is forbiden!";
        }
        else{
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            addUser($login, $hash, 0);
            header($controllerURL . "/loginForm&login={$login}");
            exit;
        }
    }
    // this should not be executed, but im adding it just in case
    else { $err = "Please fill the form!";}
}
header($controllerURL . $errorURL . urlencode($err));
exit;
?>