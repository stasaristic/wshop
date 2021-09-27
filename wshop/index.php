<?php
require "SessionActions.php";
SessionActions::startSession();
    $_SESSION['user']['username'] = null;
    $_SESSION['user']['type'] = "gost";
    $_SESSION['cart'] = [];

    header("location: pocetna.php");
?>