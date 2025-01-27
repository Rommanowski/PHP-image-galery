    <?php
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }
        require_once '../models/functions.php';
        $db = get_db();
        if(!empty($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
            $i = 1;
            echo "<form method='POST' action = 'front_controller.php?action=/removeFromCart'>";
            foreach ($cart as $item){
                $image = $db->images->findOne(['filename' => $item]);
                echo "<a href = 'images/watermarks/{$item}' target='blank'>";
                    echo "<img src = 'images/minis/{$item}'>";
                echo "</a><br>";
                echo "author: " . $image['author'] . "<br>" .
                    "title: " . $image['title'] . "<br>";
                echo "<label for='box{$i}'>delete from remembered </label>";
                echo "<input type='checkbox' name='box{$i}' id='box{$i}' value='{$item}'><br><br>";
                $i++;
            }
            echo "<input type='submit' name='submit' value='Delete selection'>";
            echo "</form>";
            }
            else{
                echo "There are no saved photos! <br>Go to the HoF section ale select some.";
            }
    ?>
