<?php
require_once '../models/functions.php';
$db = get_db();

if(($_SERVER['REQUEST_METHOD'] === 'GET') && (isset($_GET['uid']))){
    $uid = $_GET['uid'];
    deleteUser($uid);
    header('Location: testUsers.php');
    exit;
}

?>