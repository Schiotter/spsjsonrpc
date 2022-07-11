<?php

namespace wtf\schlosser\jsonrpc2;

use function curl_init;
use function curl_setopt;
use function curl_exec;
use function curl_close;
use function json_decode;
use function json_encode;

class curl {

    private static int $id = 0;
    private $ch;
    private const jsonrpc_json_body = '{"jsonrpc": "2.0", "method": "%s", "params": %s, "id": %d}';

    /**
     * Prepare and build an JSON-RPC 2.0 curl, use exec with the here returned int: $req_id to execute the statement and get the result
     *
     * @param string $url the url to the JSON RPC Server
     * @param string $method The method to be executed
     * @param array $params The parameters as Array for the method
     * @param ?array $headers Optional Headers for the Request e.g. Auth
     * @return integer
     */
    protected function build(string $url, string $method, array $params, ?array $headers = null):int {
        
        // Get a new req-id (annd before asigning to current id)
        $req_id = ++self::$id;

        $this->ch[$req_id] = curl_init();
        $json = sprintf(self::jsonrpc_json_body, $method, json_encode($params), $req_id);

        $default_headers = ['Content-Type: application/json', sprintf('Content-Length: %d', strlen($json))];
        if($headers !== null) {
            $headers = $default_headers;
        } else {
            $headers = array_merge($default_headers, $headers);
        }
        
        curl_setopt($this->ch[$req_id], CURLOPT_URL, $url);
        curl_setopt($this->ch[$req_id], CURLOPT_POST, 1);
        curl_setopt($this->ch[$req_id], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch[$req_id], CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch[$req_id], CURLOPT_POSTFIELDS, $json);

        curl_setopt($this->ch[$req_id], CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->ch[$req_id], CURLOPT_SSL_VERIFYPEER, false);

        return $req_id;
    }

    protected function exec(int $req_id):array {
        $response = json_decode(curl_exec($this->ch[$req_id]), true);
        curl_close($this->ch[$req_id]);
        unset($this->ch[$req_id]);
        // Not evry nice :( use [$req_id] !!! (maybe, at some point in the future...)
        if(array_key_exists('error', $response)) {
            return [
                'code'      => $response['code'],
                'message'   => $response['message'],
            ];
        } else {
            return $response['result'];
        }
    }

    // Implement BATCH's !!!
}