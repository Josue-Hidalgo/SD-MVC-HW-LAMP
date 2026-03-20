    <?php
    //header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    date_default_timezone_set('America/Costa_Rica');
    
    require_once("database.php");

    $validcharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $Domain = "http://147.224.54.66/shortcutController.php?urlcode=";
    
    $shortcutAccess = [];
    $ShortURL = [];

    function createSURL($url = 'test'){
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
        //$date = date("l jS \of F Y h:i:s A e");
        
        CreateShortcut($RString,$url,$Domain);
        echo $Domain.$RString." ".$url;
    }

    function getIP(){
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //echo 'Forwarding IP: ' . $_SERVER['HTTP_X_FORWARDED_FOR'].'<br>';//borrar esto despues
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //echo 'Regular IP: '.$_SERVER['REMOTE_ADDR'].'<br>';//borrar esto despues
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
        $url = GetUrlByCode($urlCode);
        
        echo $url;
        if(!$url){
            httpNotFound();
        }
        $ip = getIP();
        $country = getIPCountry($ip);
        
        InsertAccessLogByCode($surl,$ip,$country);

        header('Location: '.$url);//esto si
        exit();
    }
    function httpNotFound()
    {
        http_response_code(404);
        header('Content-type: text/html');

        // Generate standard apache 404 error page
        echo <<<HTML
        <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
        <html><head>
        <title>404 Not Found</title>
        </head><body>
        <h1>Not Found</h1>
        <p>The requested URL was not found on this server.</p>
        </body></html>
        HTML;

        exit;
    }
    
    if($_GET['urlcode']){
        getURL($_GET['urlcode']);
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){  
        // Get the JSON contents
        $json = file_get_contents('php://input');
        // decode the json data
        $data = json_decode($json);

        $sendURL = $data->url;    
        createSURL($sendURL);
    }
    ?>