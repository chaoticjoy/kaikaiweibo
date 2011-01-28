<?php

	function mc()
	{
		if( !isset( $GLOBALS['LZ_MC'] ) )
			$GLOBALS['LZ_MC'] = memcache_init();
		return $GLOBALS['LZ_MC'];	
	}

	function lz_mc_get( $key )
	{
		return memcache_get( mc() , $key );
	}

	function lz_mc_set( $key , $value )
	{
		return memcache_set( mc() , $key , $value );
	}
	

	function lz_put_contents( $file_name , $data , $domain = 'storage' )
	{
		$storage=new SaeStorage();
		if( !$storage->write( $domain , $file_name , $data ) )
			return false;
		else
			return $storage->getUrl( $domain , $file_name );
	}


	function lz_get_contents( $file_name , $domain = 'storage' )
	{
		$storage=new SaeStorage();
		return $storage->read( $domain , $file_name );
	}

	function lz_get_url( $file_name , $domain = 'storage' )
	{
		$storage=new SaeStorage();
		return $storage->getUrl( $domain , $file_name );
	}

	
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
	
	function tuan_city_list_mc(){
		$mc_city_list=array();
		$cities=tuan_city_list();
		$cities=$cities['city'];
		if(!$cities){
			echo "fetch error!";
			return 0;
		}
		$content="";	
		foreach($cities as $key=>$item){
			$mc_city_list[$item['cityid']]=$item['cityname'];
			$content.=$item['cityid']."|".$item['cityname']."|";
		}
		lz_mc_set( 'city_list' , $mc_city_list );
		lz_put_contents('city_list.txt',$content);
		print_r(lz_mc_get( 'city_list' ));
		echo lz_get_contents( 'city_list.txt' );
	}
	
	function tuan_get_cityid_mc($city="全国"){
		if($city=="全国")
			return 9999;
		$cities=lz_mc_get( 'city_list' );
		if(!$cities)
		{
			$cities=array();
			$sto_city_list=explode("|",lz_get_contents( 'city_list.txt' ));
			array_pop($sto_city_list);
			foreach($sto_city_list as $key=>$item)
			{	
				if($key%2==0){
					continue;
				}
				$cities[$sto_city_list[$key-1]]=$item;
			}
			lz_mc_set( 'city_list' , $cities );
		}	
		if(!$cities)
			return 9999;
		foreach($cities as $key=>$item){
			if($item==$city)
				return $key;
		}
		return 9999;
	}
	
	function tuan_get_cityid($city="全国"){
		if($city=="全国")
			return 9999;
		$cities=tuan_city_list();
		$cities=$cities['city'];
		if(!$cities)
			return 9999;
		foreach($cities as $key=>$item){
			if($item['cityname']==$city)
				return $cities[$key]['cityid'];
		}
		return 9999;
	}

/* 	$cityid=tuan_get_cityid_mc($city="广州");
	print_r(tuan_city($cityid));  */
	//tuan_city_list_mc();
/*  	$cityid=tuan_get_cityid("北京");
	print_r(tuan_city($cityid)); 
 */
?>