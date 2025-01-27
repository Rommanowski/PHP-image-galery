<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<div class="container">
<?php
    include 'static/partials/menu.php';
?>

        <aside class="sidebar">
            <h1>About me</h1>
            <p>This section is about my interests</p>
            <!-- <img src="http://placehold.it/100x200"> -->
             <div class="js-hidden">
                <label for="colorP">color of paragraphs</label>
                <input type="color" id="colorP" name="colorP">
                <label for="colorH">color of headers</label>
                <input type="color" id="colorH" name="colorH">
             </div>
                     
        </aside>

        <article class="main">
            <div id="home-image">
                
            </div>
            
            <h1>About me</h1>
            <p>My name is Jakub Romanowski. I am the first year student at Gdańsk University of Technology (GUT). One of my biggest passions is music. Two years ago I decided to try playing a bass guitar. I formed a band with 3 of my highschool classmates and I was hooked from that point. I think that the role of the bass guitar in music is largely underestimated, so I made this page to promote knowledge about this beatiful instrument.</p>
            <br><br>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Age</th>
                    <th>School</td>
                </tr>
                <tr>
                    <td>Jakub</td>
                    <td>Romanowski</td>
                    <td>19</td>
                    <td>GUT</td>
                </tr>
            </table>
            <br><br>
            <a id="gotop" href="contact.html">newsletter</a>
            </article>
    <?php
        include 'static/partials/footer.php';
    ?>
    
    </div>

</body>
</html>