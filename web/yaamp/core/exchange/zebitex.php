<?php
// https://doc.zebitex.com
// https://staging.zebitex.com/api/v1/orders/tickers
function zebitex_api_query($method, $params=array(), $returnType='object')
{
	$uri = "https://staging.zebitex.com/api/v1/{$method}";
//	$uri = "https://zebitex.com/api/v1/{$method}";
        $first = true;
	$json_body = "";
        foreach ($params as $p => $v)   {
                if (!$first)    $json_body .= "&";
                $json_body .= "$p=$v";
                $first = false;
        }

        if (!empty($params))
              $uri .= "?".$json_body;
 	$ch = curl_init($uri);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 	$execResult = strip_tags(curl_exec($ch));
 	if ($returnType == 'object')
		$ret = json_decode($execResult);
	else
		$ret = json_decode($execResult,true);
 	return $ret;
}

function zebitex_api_user($method, $url_params=array(), $json_body='')
{
// https://doc.zebitex.com/api/v1/funds

	require_once('/etc/yiimp/keys.php');
	if (!defined('EXCH_ZEBITEX_SECRET')) define('EXCH_ZEBITEX_SECRET', '');
 	if (empty(EXCH_ZEBITEX_KEY) || empty(EXCH_ZEBITEX_SECRET)) return false;

 	$base = 'https://staging.zebitex.com';
	$path = '/api/v1/'.$method;
	$payload = "GET|".$path."|";

        if (strpos($method, 'cancel') !== false)
                $payload = "DELETE|".$path."|";

	if ($method == "orders" || $method == "withdrawals")
                $payload = "POST|".$path."|";

        $url_params_string = "";
        if (!empty($url_params)) {
                if (is_array($url_params)) {
                        $first = true;
                        $json_body .= "{";
                        foreach($url_params as $p => $v)        {
                                if (!$first)    {
                                        $url_params_string .= ";";
                                        $json_body .= ",";
                                        }
                                $url_params_string .= $p;
                                $json_body .= "\"$p\":\"$v\"";
                                $first = false;
                                }
                        $json_body .= "}";
                }
        }
	
 	$mt = explode(' ', microtime());
	$nonce = $mt[1].substr($mt[0], 2, 3);
	
        if (empty($url_params))
                $payload = $payload.$nonce."|{}";
        else
                $payload = $payload.$nonce."|".$json_body;
	
        $signature = hash_hmac('sha256', $payload, EXCH_ZEBITEX_SECRET, false);
        $header = "ZEBITEX-HMAC-SHA256 access_key=".EXCH_ZEBITEX_KEY.", signature=".$signature.", tonce=".$nonce.", signed_params=".$url_params_string;
        $headers = array(
                'Authorization:'.$header,
                'Content-Type:application/json',
        );
        $uri = $base.$path;
        $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri);
	if (strpos($method, 'cancel') !== false)
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	if ($method == "orders" || $method == "withdrawals")
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (!empty($json_body) && ($method == "orders" || $method == "withdrawals")) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_body);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_SESSIONID_CACHE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Zebitex API client; '.php_uname('s').'; PHP/'.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.')');
        curl_setopt($ch, CURLOPT_ENCODING , '');

        $data = curl_exec($ch);
        $res = json_decode($data);
        unset($headers);
        if(empty($res)) {
                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                debuglog("zebitex: $method failed ($status) ".strip_data($data).' '.curl_error($ch));
        }
        curl_close($ch);
        return $res;
}
