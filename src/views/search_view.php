<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<div class="container">
<?php
    include 'static/partials/menu.php';
?>

<aside class="sidebar">
    <h1>Search Photos</h1>
    <p>You can search for photos here</p>
</aside>

<article class="main" id="mainSection">
    <h1>Search</h1>

    <label for='search'>photo's title: </label>
    <input type='text' id='search' onkeyup="search(this);">
    <br><br>

    <div id="article-list">
        
    </div>

</article>

<?php
    include 'static/partials/footer.php';
?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function(){
        search("");
    });
    
    function search(param){
    $.ajax({
        method: "POST",
        url: "front_controller.php?action=/search",
        data: { search: param.value }   //wartość z inputa
        })
        .done(function( msg ) {
        $('#article-list').html(msg);

    });
	
};
</script>
</body>
</html>