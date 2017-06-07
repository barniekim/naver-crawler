<?php

/** commonly used functions */

/**
 * Get random http stream context 
 * to avoid the block by the webserver.
 *
 * @return http-stream-context
 */
function get_rand_context(){
    // generate a random ip-address of Mainland China
    $ip = "114.114.".rand(1,250).".".rand(1,250);
    $context = stream_context_create(array(
        "http" => array(
            "header"=>"Accept-language: en\r\n".
            "X-Forwarded-For: ".$ip."\r\n".
            "Client-Ip: ".$ip."\r\n".
            "User-agent: Mozilla/".rand(5,6).".0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.".rand(0,152)." Safari/537.22\r\n"
        )
    ));
    return $context;
}
?>
