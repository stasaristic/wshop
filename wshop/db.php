<?php 
    $server = "localhost";
    $user = "root";
    $password = "";

    $database = mysqli_connect($server,$user,$password,"wshop");

    if(!$database){
        die("Greska prilikom povezivanja na bazu");
    }
?>