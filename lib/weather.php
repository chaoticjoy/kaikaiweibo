<?php

	function fetchurl($url){
	
		$header='';
		$error='';
		$request_sina = $url;
		$response=fetch_url($request_sina, SAE_ACCESSKEY, SAE_SECRETKEY, $header, $error, $opt);
		return $response;
	
	}
	
/* 	function weather($city)
	{
		$ret=fetchurl( 'http://pandoralab.appspot.com/api/weather.json?city='.urlencode($city).'&lan=zh_CN' );
		return json_decode( $ret , true);
	} */
	
	function gg_weather($city='北京'){
		$content=fetchurl("http://www.google.com/ig/api?hl=zh-cn&weather=".urlencode($city));
		$content=iconv('gb2312','utf-8',$content);
		/* $content=str_replace('/ig/images/weather','../image/weather',$content);
		$content=str_replace('.gif','.png',$content); */
		$content=str_replace('/ig/images/weather','http://www.google.ru/ig/images/weather',$content);
		$xml=simplexml_load_string($content);
		//urlencode(iconv('gb2312','utf-8',$val['name'])); 
		$result=json_encode($xml,JSON_FORCE_OBJECT);
		return json_decode( $result, true);
		//return Array2Json($xml);
	}
	
	//print_r(g_weather('北京'));


?>