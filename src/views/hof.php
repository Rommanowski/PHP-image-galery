<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoF</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<div class="container">
<?php
    include 'static/partials/menu.php';
?>

<aside class="sidebar">
    <h1>Hall of Fame</h1>
    <p>This section covers the most famous and influential bassists of all time.</p>
        <h3>Add a bassist:</h3>
    <?php include 'static/partials/addImageForm.php' ?>
    <?php if(isset($_GET['error'])){
        echo "<p style='color:red; font-weight:bold;'>" . urldecode($_GET['error']) . "</p>";
    }?>
</aside>

<article class="main" id="mainSection">
    <h1>Hall of Fame</h1>

    <div id="article-list">

        <?php
            require_once '../controllers/generatePaging.php';
        ?>

    </div>
</article>

<?php
    include 'static/partials/footer.php';
?>

</div>

</body>
</html>