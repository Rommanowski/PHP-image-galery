<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remembered Photos</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<div class="container">
<?php
    include 'static/partials/menu.php';
?>

<aside class="sidebar">
    <h1>Remembered Photos</h1>
    <p>Section of photos you chose to remember</p>
</aside>

<article class="main" id="mainSection">
    <h1>Gallery</h1>

    <div id="article-list">

    <?php
        require_once '../controllers/displayRemembered.php';
    ?>
    </div>
</article>

<?php
    include 'static/partials/footer.php';
?>

</div>

</body>
</html>