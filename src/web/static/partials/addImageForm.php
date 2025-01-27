<form method="POST" action = "front_controller.php?action=/addImage" enctype="multipart/form-data">

    <label for="author">author:</label><br>
    <input type="text" name="author"
        <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login'] !== 'guest'): ?> gfhf
            <?= "value = " . $_SESSION['user_login']; ?>
        <?php endif ?>
    required /><br/>

    <label for="watermark">watermark:</label><br>
    <input type="text" name="watermark" required/><br/>

    <label for="title">title:</label><br>
    <input type="text" name="title" required/><br/>

    <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login'] !== 'guest'): ?>
        <label for="public">Public</label>
        <input type="radio" name="privacy" value="public" id="public" checked>

        <label for="private">Private</label>
        <input type="radio" name="privacy" value="private" id="private">
        <br>
    <?php endif ?>
    

    <label for="image">image:</label>
    <input type="file" name="image" accept=".png, .jpg" required><br>

    <input type="submit" name="submit" value="Submit">
</form>