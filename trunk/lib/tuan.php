<?php

	function fetchurl($url){
	
		$header='';
		$error='';
		$request_sina = $url;
		$response=fetch_url($request_sina, SAE_ACCESSKEY, SAE_SECRETKEY, $header, $error, $opt);
		return $response;
	
	}
	
	function tuan(){
		$content=fetchurl("http://open.client.lashou.com/list/api/");
		$xml=simplexml_load_string($content);
		//urlencode(iconv('gb2312','utf-8',$val['name'])); 
		return json_encode($xml,JSON_FORCE_OBJECT);
		//return Array2Json($xml);
	}
	
	print_r(json_decode( tuan() , true));

?>