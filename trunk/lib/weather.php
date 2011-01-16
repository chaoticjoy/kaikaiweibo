<?php

	function fetchurl($url){
	
		$header='';
		$error='';
		$request_sina = $url;
		$response=fetch_url($request_sina, SAE_ACCESSKEY, SAE_SECRETKEY, $header, $error, $opt);
		return $response;
	
	}
	
	function weather($city)
	{
		$ret=fetchurl( 'http://pandoralab.appspot.com/api/weather.json?city='.urlencode($city).'&lan=zh_CN' );
		return json_decode( $ret , true);
	}
	
	function g_weather(){
		$content=fetchurl("http://www.google.com/ig/api?hl=zh-cn&weather=beijing");
		$content=iconv('gb2312','utf-8',$content);
		$xml=simplexml_load_string($content);
		//urlencode(iconv('gb2312','utf-8',$val['name'])); 
		return json_encode($xml,JSON_FORCE_OBJECT);
		//return Array2Json($xml);
	}
	
	//print_r(weather('shanghai'));
	print_r(json_decode( g_weather() , true));
	


?>