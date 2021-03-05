<?php
function curl(
    $url,
    $method = null,
    $postfields = null,
    $followlocation = null,
    $headers = null,
    $conf_proxy = null
) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if ($conf_proxy !== null) {
        curl_setopt($ch, CURLOPT_PROXY, $conf_proxy['Proxy']);
        curl_setopt($ch, CURLOPT_PROXYPORT, $conf_proxy['Proxy_Port']);
        if ($conf_proxy['Proxy_Type'] == 'SOCKS4') {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
        }
        if ($conf_proxy['Proxy_Type'] == 'SOCKS5') {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        if ($conf_proxy['Proxy_Type'] == 'HTTP') {
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLOPT_HTTPPROXYTUNNEL);
        }
        if ($conf_proxy['Auth'] !== null) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $conf_proxy['Auth']['Username'].':'.$conf_proxy['Auth']['Password']);
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        }
    }
    if ($followlocation !== null) {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, $followlocation['Max']);
    }
    if ($method == "PUT") {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    }
    if ($method == "GET") {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    }
    if ($method == "POST") {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
    }
    if ($headers !== null) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $result = curl_exec($ch);
    $header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
    $cookies = array();
    foreach ($matches[1] as $item) {
        parse_str($item, $cookie);
        $cookies = array_merge($cookies, $cookie);
    }
    return array(
        'HttpCode' => $httpcode,
        'Header' => $header,
        'Body' => $body,
        'Cookie' => $cookies,
        'Requests Config' => [
                'Url' => $url,
                'Header' => $headers,
                'Method' => $method,
                'Post' => $postfields
        ]
    );
}


function getStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, ($str[1]));
    return $str[0];
}

function random($length, $a)
{
    $str = "";
    if ($a == 0) {
        $characters = array_merge(range('0', '9'));
    } elseif ($a == 1) {
        $characters = array_merge(range('0', '9'), range('A', 'Z'), range('a', 'z'));
    }
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}