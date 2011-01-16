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
		$xml=simplexml_load_string($content,"SimpleXMLElement",LIBXML_NOCDATA);
		//urlencode(iconv('gb2312','utf-8',$val['name'])); 
		$result=json_encode($xml,JSON_FORCE_OBJECT);
		return json_decode( $result, true);
		//return Array2Json($xml);
	}
	
	function tuan_city_list(){
		$content=fetchurl("http://open.client.lashou.com/list/cities/");
		$xml=simplexml_load_string($content,"SimpleXMLElement",LIBXML_NOCDATA);
		$result=json_encode($xml,JSON_FORCE_OBJECT);
		return json_decode( $result, true);
	}
	
	function tuan_city($cityid){
		$content=fetchurl("http://open.client.lashou.com/list/goods/cityid/".$cityid);
		$xml=simplexml_load_string($content,"SimpleXMLElement",LIBXML_NOCDATA);
		$result=json_encode($xml,JSON_FORCE_OBJECT);
		return json_decode( $result, true);
	}
	
	function tuan_get_cityid($city="全国"){
		if($city=="全国")
			return 9999;
		$cities=tuan_city_list();
		$cities=$cities['city'];
		foreach($cities as $key=>$item){
			if($item['cityname']==$city)
				return $cities[$key]['cityid'];
		}
		return 9999;
	}
	
/*  	$cityid=tuan_get_cityid("北京");
	print_r(tuan_city($cityid)); 
 */
?>