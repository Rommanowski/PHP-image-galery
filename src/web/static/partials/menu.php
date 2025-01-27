<header class="header">
    <a href = "front_controller.php?action=/home"><img id="header-title" src="static/images/Basshobby.svg" alt="title"></a>
    <img id="header-image" src="static/images/bass-guitar-svgrepo-com.svg" alt="bass guitar">
    <div id="header-username"> 
        <?php if (isset($_SESSION['user_login'])): ?>
            <?= "user: " . htmlspecialchars($_SESSION['user_login']) . "<br>" .
            "<a href = 'front_controller.php?action=/logOut'>log out</a>" ?>
        <?php else: ?>
            Logged in as guest <br>
            <a href = "front_controller.php">log in</a>
        <?php endif; ?> 
    </div>
</header>
<nav class="menu">
    <p id="large-text">
    <a href="front_controller.php?action=/home">Home</a>
    <a href="front_controller.php?action=/about_bass">About Bass</a>
    <div class="dropdown">
        <a href="">Bands</a>
        <div class="drop-content">
            <a href="front_controller.php?action=/metal">Metal</a>
            <a href="front_controller.php?action=/rock">Rock</a>
        </div>    
    </div>
    <a href="front_controller.php?action=/hof">Hall of Fame</a>        
    <a href="front_controller.php?action=/remembered">Remembered</a>   
    <a href="front_controller.php?action=/search_view">Search</a>
    </p>
    <p id="small-text">
    <a href="front_controller.php?action=/home">Home</a>
    <a href="front_controller.php?action=/about_bass">Bass</a> 
    <a href="front_controller.php?action=/metal">Metal</a>
    <a href="front_controller.php?action=/rock">Rock</a>
    <a href="front_controller.php?action=/hof">HoF</a>       
    <a href="front_controller.php?action=/remembered">Remembered</a>   
    <a href="front_controller.php?action=/search_view">Search</a>
    
    </p>   
</nav>
