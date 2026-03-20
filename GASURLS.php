<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    require_once("database.php");
    function load(){
        GetAllShortcuts();
    }

    load();
?>