<!DOCTYPE html>
<html>
<head>
    <title>prueba php</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
        URLGET: <input type="text" name="url">
        <input type="submit">
    </form>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        URLPOST: <input type="text" name="urlcode">
        <input type="submit">
    </form>
    <?php
    //header('Content-Type: application/json');

    $validcharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $Domain = "el/nombre/del/dominio/va/aqui/";
    
    $shortcutAccess = [];
    $ShortURL = [];

    
    function createSURL($url = "test"){
        $newShortURL = true;
        $RString = "";
        global $validcharacters, $ShortURL, $Domain;
        while($newShortURL){
            $RString = "";
            for($x = 0; $x < 8; $x++){
                $RString .= $validcharacters[rand(0,51)];

            }
            if (!$ShortURL[$RString]) {
                $newShortURL = false;
            }
        }
        $ShortURL[$RString] = $url;
        //print_r($ShortURL);//borrar esto despues
        //echo "<br>".$Domain.$RString."<br>";//borrar esto despues?
        $res = [
            "shortURL" => $Domain.$RString,
            "ShortcutCode" => $RString,
            "urlID" => $RString

        ];
        //echo json_encode($res, JSON_PRETTY_PRINT);
        echo "creo la nueva url: ".$RString;
        //getURL($RString);//borrar esto despues
    }

    function getIP(){
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            echo 'Forwarding IP: ' . $_SERVER['HTTP_X_FORWARDED_FOR'].'<br>';//borrar esto despues
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        echo 'Regular IP: '.$_SERVER['REMOTE_ADDR'].'<br>';//borrar esto despues
        return $_SERVER['REMOTE_ADDR'];
    }

    function getIPCountry($ip){// instalar curl para que funcione sudo apt-get install php-curl
        $ch = curl_init("https://ipinfo.io/{$ip}/json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $details = json_decode(curl_exec($ch));
        curl_close($ch);
        return $details->country;
    }

    function getURL($urlCode){
        global $ShortURL, $shortcutAccess;
        $url = $ShortURL[$urlCode];
        if(!$url){
            echo "error URL no encontrada";//cambiar por error real
        }
        $ip = getIP();
        $country = getIPCountry($ip);
        $date = date("l jS \of F Y h:i:s A");
        if(!$shortcutAccess[$urlCode]){
            $shortcutAccess[$urlCode] = [];
        }
        $shortcutAccess[$urlCode] += [["userIP" =>$ip, "country"=>$country, "date"=>$date]];
        print_r($shortcutAccess);//borrar esto despues
        echo "<br>";//borrar esto despues
        header('Location: '.$url);
        exit();
    }
    if($_GET['url']){
        createSURL($_GET['url']);
    }
    if($_POST['urlcode']){
        getURL($_POST['urlcode']);
    }
    ?>
</body>
</html>