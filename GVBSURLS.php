<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    require_once("database.php");
    if($_GET['surl']){
        echo GetTotalAccessesByShortcut($_GET['surl']);
    }
?>