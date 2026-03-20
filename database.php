<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: *");

  $servername = "localhost";
  $username = "phpAdmin";
  $password = "#Queso4Life#";
  $dbname = "Shortener";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  function CreateShortcut($surl,$url,$domain){
    global $conn;
    $sql = "CALL InsertShortCut(\"$surl\",\"$url\",\"$domain\");";
    $conn->query($sql);
  }

  function GetAllShortcuts(){
    global $conn;
    $sql = "CALL GetAllShortCuts()";
    $result = $conn->query($sql);
    $Rstring = "";
    if ($result->num_rows > 0) {
  // Output data of each row
      while($row = $result->fetch_assoc()) {
        //id_short_cut, short_code, original_url, base_url, creation_date
        $Rstring = $Rstring . $row["base_url"] . $row["short_code"] . " " . $row["original_url"]."\n";
      }
    }
    echo $Rstring;
  }
  
  function GetUrlByCode($surl){
    global $conn;
    $sql = "CALL GetUrlByCode(\"$surl\");";
    $result = $conn->query($sql)->fetch_assoc();
    return $result["original_url"];
  }

  function GetTotalAccessesByShortcut($surl){
    global $conn;
    $sql = "CALL GetTotalAccessesByShortcut(\"$surl\");";
    $result = $conn->query($sql)->fetch_assoc();
    return $result["total_access"];
  }

  function GetCreationDateUrl($surl){
    global $conn;
    $sql = "CALL GetCreationDateUrl(\"$surl\");";
    $result = $conn->query($sql)->fetch_assoc();
    return $result["creation_date"];
  }
?>