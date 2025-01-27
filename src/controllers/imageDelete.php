<?php
require_once '../models/functions.php';
$db = get_db();

if(($_SERVER['REQUEST_METHOD'] === 'GET') && (isset($_GET['img_name']))){
    $img_name = $_GET['img_name'];
    deleteImage($img_name);
    header('Location: testImages.php');
    exit;
}

?>