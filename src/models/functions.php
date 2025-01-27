<?php

require '../../vendor/autoload.php';
use MongoDB\BSON\ObjectID;

function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',        // just examole username and login, which i used on my virtual machine
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function userExists($login)
{
    $db = get_db();
    $query = ['login' => $login];

    if($db->users->findOne($query)) { return true; }
    else { return false; }
}

function addUser($login, $password, $rule){
    $db = get_db();
    $db->users->insertOne([ 'login' => $login, 'password' => $password, 'rule' => $rule ]);
}

function deleteUser($uid){
    try{
       $db = get_db();
       $db->users->deleteOne(['_id' => new ObjectID($uid)]);
       return true;
    }
    catch( Exception $e) { return $e; }
   }

// if admin removes file from the images/originals directory, this function lets user delete
// the file from the database and from minis and watermarks directories
function deleteImage($img_name){
try{
    $db = get_db();
    // remove image from the database
    $db->images->deleteOne(['filename' => $img_name]);
    // remove image from /originals and /watermarks directions
    $imagesRoot = $_SERVER['DOCUMENT_ROOT'] . '/images/';
    $originalImagePath = $imagesRoot . "originals/" . $img_name;
    $miniImagePath = $imagesRoot . "minis/" . $img_name;
    $watermarkImagePath = $imagesRoot . "watermarks/" . $img_name;

    // Try to remove the images without throwing errors if unlink fails
    if (file_exists($originalImagePath)) {
        unlink($originalImagePath);
    }
    if (file_exists($miniImagePath)) {
        unlink($miniImagePath);
    }
    if (file_exists($watermarkImagePath)) {
        unlink($watermarkImagePath);
    }
}
catch( Exception $e) { return $e; }
}

function uploadImage($author, $watermark, $title, $privacy){
    $db = get_db();
    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/images/";
    if(isset($_SESSION['user_login'])){
        $user = $db->users->findOne(['login' => $_SESSION['user_login']]);
    }
    if(isset($user)){
        $user_id = $user['_id'];
    }
    else{
        $user_id = "";
    }
    
    $filename = basename($_FILES['image']['name']);
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $filename_no_extension = pathinfo($filename, PATHINFO_FILENAME) . "_";
    $newname = uniqid($filename_no_extension) . "." . $extension;


    if((move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir . "originals/" . $newname))){
        // echo "success!<br>";
        $db->images->insertOne([ 'filename' => $newname, 'author' => $author,
                                 'watermark' => $watermark, 'title' => $title, 
                                 'privacy' => $privacy , 'author_id' => $user_id]);
        if(generateThumbnail($newname)){
            $watermarkLocation = $uploaddir . 'watermarks/' . $newname;
            copy($uploaddir . 'originals/' . $newname, $watermarkLocation);
            if(addTextWatermark($newname, $watermark, $position='center', 60)){
                return true;
            }
        }
    }
    //echo "possible file upload attack!<br>";
    return false;
}

function generateThumbnail($originalFileName) {
    // Ścieżka do oryginalnego obrazu
    $originalFile = $_SERVER['DOCUMENT_ROOT'] . '/images/originals/' . $originalFileName;

    // Walidacja rozszerzenia pliku
    $fileExtension = strtolower(pathinfo($originalFile, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, ['png', 'jpg'])) {
        die('Obsługiwane są tylko pliki PNG i JPG.');
    }

    // Ścieżka do zapisania miniatury
    $thumbnailFile = $_SERVER['DOCUMENT_ROOT'] . '/images/minis/' . $originalFileName;

    // Wymiary miniatury
    $thumbnailWidth = 200;
    $thumbnailHeight = 125;

    // Pobranie rozmiarów oryginalnego obrazu i typu MIME
    $imageInfo = getimagesize($originalFile);
    $originalWidth = $imageInfo[0];
    $originalHeight = $imageInfo[1];
    $imageMime = $imageInfo['mime'];

    // Dynamiczne ładowanie obrazu w zależności od jego typu MIME
    switch ($imageMime) {
        case 'image/jpeg': // Obsługuje pliki z rozszerzeniem .jpg
            $image = imagecreatefromjpeg($originalFile);
            break;
        case 'image/png':
            $image = imagecreatefrompng($originalFile);
            break;
        default:
            die('Nieobsługiwany format pliku!');
    }

    // Tworzenie pustego płótna dla miniatury
    $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

    // Obsługa przezroczystości dla PNG
    if ($imageMime === 'image/png') {
        imagealphablending($thumbnail, false);
        imagesavealpha($thumbnail, true);
        $transparent = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127);
        imagefill($thumbnail, 0, 0, $transparent);
    } else {
        // Wypełnienie tła dla JPG (biały kolor)
        $backgroundColor = imagecolorallocate($thumbnail, 255, 255, 255);
        imagefill($thumbnail, 0, 0, $backgroundColor);
    }

    // Skopiowanie i rozciągnięcie oryginalnego obrazu na miniaturę
    imagecopyresampled(
        $thumbnail,
        $image,
        0, 0,                   // Pozycja na miniaturze
        0, 0,                   // Pozycja na oryginalnym obrazie
        $thumbnailWidth, $thumbnailHeight, // Wymiary na miniaturze
        $originalWidth, $originalHeight    // Wymiary oryginalne
    );

    // Zapisanie miniatury
    if ($fileExtension === 'png') {
        imagepng($thumbnail, $thumbnailFile);
    } else {
        imagejpeg($thumbnail, $thumbnailFile, 90); // 90 to jakość JPEG
    }

    // Zwolnienie pamięci
    imagedestroy($thumbnail);
    imagedestroy($image);

    return true;
}

function addTextWatermark($originalFileName, $watermarkText, $position = 'bottom-right', $opacity = 50) {
    // Ścieżka do oryginalnego obrazu
    $originalFile = $_SERVER['DOCUMENT_ROOT'] . '/images/originals/' . $originalFileName;

    // Ścieżka do zapisu obrazu z dodanym znakiem wodnym
    $outputFile = $_SERVER['DOCUMENT_ROOT'] . '/images/watermarks/' . $originalFileName;

    // Walidacja rozszerzenia pliku
    $fileExtension = strtolower(pathinfo($originalFile, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, ['png', 'jpg'])) {
        die('Obsługiwane są tylko pliki PNG i JPG.');
    }

    // Pobranie rozmiarów oryginalnego obrazu i typu MIME
    $imageInfo = getimagesize($originalFile);
    $originalWidth = $imageInfo[0];
    $originalHeight = $imageInfo[1];
    $imageMime = $imageInfo['mime'];

    // Dynamiczne ładowanie obrazu w zależności od jego typu MIME
    switch ($imageMime) {
        case 'image/jpeg': // Obsługuje pliki z rozszerzeniem .jpg
            $image = imagecreatefromjpeg($originalFile);
            break;
        case 'image/png':
            $image = imagecreatefrompng($originalFile);
            break;
        default:
            die('Nieobsługiwany format pliku!');
    }

    // Ustalenie koloru i przezroczystości tekstu
    $textColor = imagecolorallocatealpha($image, 255, 255, 255, 127 * (100 - $opacity) / 100); // Biały kolor z przezroczystością

    // Ścieżka do czcionki TrueType (zmień ścieżkę na rzeczywistą czcionkę na serwerze)
    $fontPath = $_SERVER['DOCUMENT_ROOT'] . '/static/fonts/arial.ttf';
    if (!file_exists($fontPath)) {
        die('Nie znaleziono pliku czcionki!');
    }

        // Dynamiczne dopasowanie rozmiaru czcionki
        $fontSize = 10; // Minimalny rozmiar czcionki
        do {
            $fontSize++;
            $textBox = imagettfbbox($fontSize, 0, $fontPath, $watermarkText);
            $textWidth = abs($textBox[4] - $textBox[0]);
        } while ($textWidth < $originalWidth && $fontSize < 100); // Maksymalny rozmiar czcionki = 100
    
        // Dopasowanie do szerokości obrazu
        if ($textWidth > $originalWidth) {
            $fontSize--;
        }

    // Obliczenie wymiarów tekstu
    $textBox = imagettfbbox($fontSize, 0, $fontPath, $watermarkText);
    $textWidth = abs($textBox[4] - $textBox[0]);
    $textHeight = abs($textBox[5] - $textBox[1]);

    // Obliczenie pozycji tekstu
    switch ($position) {
        case 'top-left':
            $x = 10;
            $y = $textHeight + 10;
            break;
        case 'top-right':
            $x = $originalWidth - $textWidth - 10;
            $y = $textHeight + 10;
            break;
        case 'bottom-left':
            $x = 10;
            $y = $originalHeight - 10;
            break;
        case 'bottom-right':
            $x = $originalWidth - $textWidth - 10;
            $y = $originalHeight - 10;
            break;
        case 'center':
            $x = ($originalWidth - $textWidth) / 2;
            $y = ($originalHeight + $textHeight) / 2;
            break;
        default:
            die('Nieprawidłowa pozycja znaku wodnego!');
    }

    // Dodanie tekstu na obraz
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $watermarkText);

    // Zapisanie obrazu z dodanym znakiem wodnym
    if ($fileExtension === 'png') {
        imagepng($image, $outputFile);
    } else {
        imagejpeg($image, $outputFile, 90); // 90 to jakość JPEG
    }

    // Zwolnienie pamięci
    imagedestroy($image);

    return true;
}

function getImages(){

    $db = get_db();
    $zdjecia = [];
    $images = $db->images->find();

    if(isset($_SESSION['user_login'])){
        $user = $db->users->findOne(['login' => $_SESSION['user_login']]);
        $id = $user['_id'];
    }
    else{
        $id = "";
    }

    foreach($images as $image){
        if(($image['privacy'] === 'public') || ($image['author_id'] == $id)){
            //array_push($zdjecia, "<img src = ./images/minis/{$image['filename']}><br><br>");
            array_push($zdjecia, $image);
        }
    }
    return $zdjecia;
}

// just for debugging
function wafel(){
    return "wafel";
}