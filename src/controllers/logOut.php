<?php
//session_start();
session_destroy();
session_unset();
session_regenerate_id();
//usunięcie cookies ustawianych na określony czas
// (jeśli były ustawiane jakieś ciasteczka niesesyjne)
header("Location: front_controller.php");
exit;