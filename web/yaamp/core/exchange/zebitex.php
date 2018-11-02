<?php
// https://doc.zebitex.com
// https://staging.zebitex.com/api/v1/orders/tickers
function zebitex_api_query($method, $params='', $returnType='object')
{
	$uri = "https://staging.zebitex.com/api/v1/{$method}";
//	$uri = "https://zebitex.com/api/v1/{$method}";
	if (!empty($params)) $uri .= "?{$params}";
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
 	if (!empty($url_params)) {
		if (is_array($url_params)) {
			//$path .= '?'.http_build_query($url_params, '', '&');
		} elseif (is_string($url_params)) {
			//$path .= '?'.$url_params;
		}
	}
 	$mt = explode(' ', microtime());
	$nonce = $mt[1].substr($mt[0], 2, 3);
  $payload = $payload.$nonce."|{}";
	$signature = hash_hmac('sha256', $payload, EXCH_ZEBITEX_SECRET, false);
  $header = "ZEBITEX-HMAC-SHA256 access_key=".EXCH_ZEBITEX_KEY.", signature=".$signature.", tonce=".$nonce.", signed_params=";
 	$headers = array(
		"Authorization:".$header,
	);
 	$uri = $base.$path;
 	$ch = curl_init($uri);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	if (!empty($json_body)) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_body);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_SSLVERSION, 1 /*CURL_SSLVERSION_TLSv1*/);
	curl_setopt($ch, CURLOPT_SSL_SESSIONID_CACHE, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; crex24 API client; '.php_uname('s').'; PHP/'.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.')');
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
