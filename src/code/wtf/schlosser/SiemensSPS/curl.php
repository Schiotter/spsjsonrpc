<?php

namespace wtf\schlosser\SiemensSPS;

use \resource, \CurlHandle;
use function \curl_init, curl_setopt, curl_exec, curl_close, json_decode, json_encode;

class curl {

    private const curl_url = 'https://%s/api/jsonrpc'; // IPv4 of the CPU
    private const IPv4_regex = '/^(?:(?:25[0-4]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/'; //Without Broadcast 255.255.255.255

    private resource|false|CurlHandle $ch;

    function request(string $IPv4, array $body, string $XAuthToken = '') {

        if(!self::is_valid_IPv4($IPv4))
            self::error("'$IPv4' is not an valid IPv4 Address");

        $json = json_encode($body);

        $headers = array(
            'Content-Type: application/json',
            sprintf('Content-Length: %d', strlen($json)),
            sprintf('X-Auth-Token: %s', $XAuthToken),
        );

        $this->ch = curl_init();
        
        curl_setopt($this->ch, CURLOPT_URL, sprintf(self::curl_url, $IPv4));
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

        return $this;
    }

    protected function get():array {
        $response = curl_exec($this->ch);
        curl_close($this->ch);
        return json_decode($response, true);
    }

    private static function is_valid_IPv4(String $test):bool {

        if(substr_count($test, '.') !== 3) return false; //IPv4 need to have 3 dots aka 4 octets

        if(preg_match(self::IPv4_regex, $test) === 1) {
            return true;
        } else {
            return false;
        }
    }

    private  static function error(String $msg) {
        if(php_sapi_name()==='cli') $_SERVER['SERVER_PROTOCOL'] = 'CLI';
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error (Siemens SPS JSON-RPC cURL)', true, 500);
        print '<h1 style="color:red">Error</h1><br>'."\n";
        print "<p>$msg</p>";
        die();
    }
}