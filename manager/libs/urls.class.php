<?php
class URL
{
    public function __construct() {}
    public static function curURL()
    {
        $pageURL = 'http';
        if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    public static function get_site_url()
    {
        $curURL = URL::curURL();
        $urlArray = parse_url($curURL);
        $rootDir = $_SERVER["DOCUMENT_ROOT"];

        //$p = ltrim ($urlArray['path'], '/');
        $p = rtrim($urlArray['path'], '/');
        $path = explode('/', $p);
        $pathURL = $urlArray['scheme']."://".$urlArray['host'];
        $pathFile = $rootDir;

        for($i = 0; $i < sizeof($path); $i++)
        {
            $pathFile .= $path[$i].'/';
            $pathURL .= $path[$i].'/';

            if(file_exists($pathFile."tmp/log/conf_site"))
            {
                $site_id = file_get_contents($pathFile."tmp/log/conf_site", FILE_USE_INCLUDE_PATH);

                if($site_id == md5('trangchu'))
                {
                    break;
                }
            }
        }
        return rtrim($pathURL, '/');
    }

    public static function getPath()
    {
        $curURL = URL::curURL();
        $urlArray = parse_url($curURL);
        $rootDir = $_SERVER["DOCUMENT_ROOT"];

        $p = rtrim($urlArray['path'], '/');
        $path = explode('/', $p);
        $pathFile = $rootDir;

        for($i = 0; $i < sizeof($path); $i++)
        {
            $pathFile .= $path[$i].'/';

            if(file_exists($pathFile."tmp/log/conf_site"))
            {
                $site_id = file_get_contents($pathFile."tmp/log/conf_site", FILE_USE_INCLUDE_PATH);

                if($site_id == md5('trangchu'))
                {
                    break;
                }
            }
        }
        return rtrim($pathFile, '/');
    }

    public static function redirect_to($location)
    {
        if (!headers_sent()) {
            header('Location: ' . $location);
            exit;
        } else
        {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $location . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
            echo '</noscript>';
        }
    }

    public static function http_request($url = '', $data = null)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'PHP cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data
        ));
        // check request error
        if(!curl_exec($curl)){
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        } else
        {
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
        }
        // Close request to clear up some resources
        curl_close($curl);
    }

    public static function goBack($path = false)
    {
        $previous = $_SERVER['HTTP_REFERER'];
        if($path)
            URL::redirect_to($previous.'/'.$path);
        else
            URL::redirect_to($previous);
        exit();
    }
}