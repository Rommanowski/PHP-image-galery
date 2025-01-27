<?php
    session_start();
    require_once 'routing.php';

    if(isset($_GET['action']) && array_key_exists($_GET['action'], $routing)){
            $action = $_GET['action'];
            $controller_name = $routing[$action];
    }
    else if(isset($_GET['action'])){
        http_response_code(404);
        echo "Error 404: Page not found.";
        exit;
    }
    else{
        $controller_name = "/views/start";
    }
    // require "/var/www/dev/src/views/" . $controller_name . ".php";
    require "../" . $controller_name . ".php";