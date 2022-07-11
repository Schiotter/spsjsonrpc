<?php

namespace wtf\schlosser\siemens\s7;

use wtf\schlosser\jsonrpc2\curl;

class BasicCPUConnector extends curl {

    private const curl_url = 'https://%s/api/jsonrpc'; // IPv4 of the CPU
    private static string $address;
    private const IPv4_regex = '/^(?:(?:25[0-4]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/'; //Without Broadcast 255.255.255.255

    public static function setCPUAddress(string $IPv4):void {
        self::$address = sprintf(self::curl_url, $IPv4);
    }

    function tmp($json, $XAuthToken) {
        
    }

    private  static function error(String $msg) {
        if(php_sapi_name()==='cli') $_SERVER['SERVER_PROTOCOL'] = 'CLI';
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error (Siemens SPS JSON-RPC cURL)', true, 500);
        print '<h1 style="color:red">Error</h1><br>'."\n";
        print "<p>$msg</p>";
        die();
    }

    public static function RunMethod(string $method, ?array $params = null) {
        
        $curl = new curl;
        $data = $curl->exec($curl->build(self::$address, $method, $params));
        var_dump($data);
        #sprintf('X-Auth-Token: %s', $XAuthToken);
    }

}

?>