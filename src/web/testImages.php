<?php
session_start();

if(!isset($_SESSION['rule']) || $_SESSION['rule'] === 0){
    header('Location: front_controller.php?action=/home');
    exit;
}

require_once '../models/functions.php';

$db = get_db();
// images that are in all 3 arrays
$actual_images_names_array = array_diff(scandir("./images/originals"), array('..', '.'));
$minis_images_names_array = array_diff(scandir("./images/minis"), array('..', '.'));
$watermarks_images_names_array = array_diff(scandir("./images/watermarks"), array('..', '.'));

$common_images_array = array_intersect( $actual_images_names_array,
                                        $minis_images_names_array,
                                        $watermarks_images_names_array);

$images = $db->images->find();
$images_array = iterator_to_array($images); // Convert cursor to an array

// images on the device
echo "images on the computer below:<br>";
foreach($common_images_array as $image){
    echo $image . "<br>";
}
echo "<br>";

// images in the database (names):
$database_images_names_array = [];
foreach($images_array as $image){
    array_push($database_images_names_array, $image['filename']);
}

echo "images on the database below: <br>";
foreach($database_images_names_array as $image_name){
    echo $image_name . "<br>";
}
echo "<br>";

// print images that are in database but not on the server
echo "excess images below:<br>";
$excess_images_array = array_diff($database_images_names_array, $common_images_array);
foreach($excess_images_array as $excess_image){
    echo $excess_image . " <a href = 'front_controller.php?action=/imageDelete&img_name={$excess_image}'>delete</a>" . "<br>";
}

echo "<br><br>-----------all images in database------------<br><br>";

foreach($images_array as $image){
    foreach($image as $key => $val){
        echo $key . " --> " . $val . "<br>";
    }
    echo "<br>----next----<br><br>";
}


?>
