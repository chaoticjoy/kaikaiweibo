<?php

	function fetchurl($url){
	
		$header='';
		$error='';
		$request_sina = $url;
		$response=fetch_url($request_sina, SAE_ACCESSKEY, SAE_SECRETKEY, $header, $error, $opt);
		return $response;
	
	}
	
	function doubansearch($q,$location,$start_index=1,$max_results=10){
		$content=fetchurl("http://api.douban.com/events?apikey=08cc7bfbba9d55841a6573f32fd8008c&q=".urlencode($q)."&location=".$location."&start-index=".$start_index."&max-results=1=".$max_results);
		$xml=simplexml_load_string($content);
		//urlencode(iconv('gb2312','utf-8',$val['name'])); 
		return json_encode($xml,JSON_FORCE_OBJECT);
		//return Array2Json($xml);
	}
	
	function douban_event($location='beijing',$start_index=1,$max_results=10){
		$content=fetchurl("http://api.douban.com/event/location/".$location."?apikey=0082e8f57232f6d00188bae05698e470&start-index=".$start_index."&max-results=".$max_results);
		if(strpos($content,'wrong location id:')!==false)
			return 0;
		$content=str_replace('gd:','',$content);
		$content=str_replace('db:','',$content);
		$xml=simplexml_load_string($content);
		$result=json_encode($xml,JSON_FORCE_OBJECT);
		return json_decode( $result, true);
	}

	//print_r(douban_event('Yunfu',5,5));
	//print_r(douban_event());
/* 	function Array2Json($array) { 
		arrayRecursive($array, 'urlencode', true); 
		$json = json_encode($array); 
		$json = urldecode($json); 
		// ext需要不带引号的bool类型 
		$json = str_replace("\"false\"","false",$json); 
		$json = str_replace("\"true\"","true",$json); 
		return $json; 
	} 

	function arrayRecursive(&$array, $function, $apply_to_keys_also = false) 
	{ 
		static $recursive_counter = 0; 
		if (++$recursive_counter > 1000) { 
			die('possible deep recursion attack'); 
		} 
		foreach ($array as $key => $value) { 
			if (is_array($value)) { 
				arrayRecursive($array[$key], $function, $apply_to_keys_also); 
			} else { 
				$array[$key] = $function($value); 
			} 

			if ($apply_to_keys_also && is_string($key)) { 
				$new_key = $function($key); 
				if ($new_key != $key) { 
					$array[$new_key] = $array[$key]; 
					unset($array[$key]); 
				} 
			} 
		} 
		$recursive_counter--; 
	}  */
	
	//echo doubansearch("hi","all",1,10);
?>