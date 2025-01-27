<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<div class="container">
<?php
    include 'static/partials/menu.php';
?>

        <aside class="sidebar">
            <h1>Receive emails</h1>
            <p>Do you want to receive fresh informations about music? Fill the newsletter application!</p>
            <!-- <img src="http://placehold.it/100x200"> -->
            
        </aside>

        <article class="main">
            
            <h1>Newsletter</h1>
            
            <p>Please fill the below form to join my newsletter:</p>
            

            <br>

            <form action="wyslij.php" method="post">
                <label for="name">name
                    <input id="name" name="name" type="text" placeholder="enter your name..." required>
                </label>
                <br>
                <label for="surname">surname
                    <input id="surname" name="surname"  type="text" placeholder="enter your surname..." required>
                </label>
                <br>
                <label for="email">email
                    <input id="email" name="email" type="email" placeholder="enter your email..." required>
                </label>
                <br>
                <label for="university">University
                    <select id="university" name="university" required>
                        <option value="">Select your university...</option>
                        <option value="g">Gdansk University of Technology</option>
                        <option value="u">University of Gdansk</option>
                        <option value="m">Gdansk Medical University</option>
                        <option value="o">Other/not a student</option>
                    </select>
                </label>
                <br>
                <label for="gender">gender
                    <input name="gender" type="radio" value="male">Male
                    <input name="gender" type="radio" value="female">Female
                    <input name="gender" type="radio" value="other">don't want to specify
                </label>
                <br>
                <label for="birthdate">date of birth (dd/mm/yy)
                    <input name="birthdate" type="text" id="datepicker">
                </label>
                <br>
                <label>your favourite color
                    <input id="color" name="color" type="color">
                </label>
                <br>
                <label>I want to join the newsletter
                    <input id="news" name="news" type="checkbox">
                </label>
                <br>
                <label>
                    <input type="reset" value="Reset the form">
                </label>
                <br>
                <label>
                    <input type="submit" value="submit">
                </label>
                
            </form>
            <br>
            <a id="gotop" href="home.html">go back</a>
            </article>

    <?php
        include 'static/partials/footer.php';
    ?>

    </div>

</body>
</html>