<?php


class kaikai 
{
	function __construct( $akey , $skey = '' ) 
	{
		$this->akey = $akey;
		$this->skey = $skey;
		$this->base = 'http://open.k.ai/';
		$this->curl = curl_init();
		curl_setopt( $this->curl , CURLOPT_RETURNTRANSFER, true); 
		
		$this->postInit();
		
	}
	
	function postInit()
	{
		$this->postdata = array('key=' . $this->akey);
	
	}

	function setUser( $name , $pass ) 
	{
		$this->user['oname'] = $name;
		$this->user['opass'] = $pass;
		$this->user['name'] = urlencode($name);
		$this->user['pass']  = urlencode($pass);
		curl_setopt( $this->curl , CURLOPT_USERPWD , "$name:$pass" );
	}

	function verify_credentials()
	{
		return $this->call_method( 'public' , 'account','verify_credentials' );
	}
	
	function user_info($id=0)
	{
		if($id==0)
			return $this->call_method( 'public' , 'users','show' );
		else
			return $this->call_method( 'public' , 'users','show','?id='.$id );
	}
	
	function friends_timeline($page=1,$count=20)
	{
		return $this->call_method( 'public' , 'statuses','friends_timeline','?page='.$page.'&count='.$count );
	}
	
	function user_timeline($username,$page=1,$count=20)
	{
		return $this->call_method( 'public' , 'statuses','user_timeline','?username='.urlencode($username).'&page='.$page.'&count=' .$count );
	}
	
	function friends($id,$page=1,$count=20)
	{
		return $this->call_method( 'public' , 'users','friends','?id='.$id.'&page='.$page.'&count=' .$count );
	}
	
	function followers($id,$page=1,$count=20)
	{
		return $this->call_method( 'public' , 'users','followers','?id='.$id.'&page='.$page.'&count=' .$count );
	}

	function search($lat,$lon,$query='',$rawgps='',$range=5000,$page=1,$count=20,$category='',$certified=true)
	{
		return $this->call_method( 'public' , 'poi','search','?lat='.$lat.'&lon='.$lon.'&query=' .$query.'&rawgps=' .$rawgps.'&range=' .$range.'&page=' .$page.'&count=' .$count.'&category=' .$category.'&certified=' .$certified );
	}
	
	function tips($poi_id,$page=1,$count=20)
	{
		return $this->call_method( 'public' , 'poi','tips','?poi_id='.$poi_id.'page='.$page.'&count='.$count );
	}
	
	function tipsupdate($id,$text)
	{
		$this->postdata[] = 'id='.$id;
		$this->postdata[] = 'text='.urlencode($text);
		return $this->call_method( 'public' , 'poi', 'tipsupdate'  );
	}
	
	function checkin($id)
	{
		$this->postdata[] = 'id='.$id;
		return $this->call_method( 'public' , 'poi', 'checkin'  );
	}
	
	function call_method( $classify,$method , $action , $args = '' ) 
	{
		
		curl_setopt( $this->curl , CURLOPT_POSTFIELDS , join( '&' , $this->postdata ) );
		
		$url = $this->base .$classify.'/'. $method . '/' . $action . '.json' . $args ;
		
		
		
		$header_array = array();

        $header_array["FetchUrl"] = $url;
        $header_array['TimeStamp'] = date('Y-m-d H:i:s');
        //$header_array['AccessKey'] = $_SERVER['HTTP_ACCESSKEY'];
		$header_array['AccessKey'] = SAE_ACCESSKEY;

        $content="FetchUrl";

        $content.=$header_array["FetchUrl"];

        $content.="TimeStamp";

        $content.=$header_array['TimeStamp'];

        $content.="AccessKey";

        $content.=$header_array['AccessKey'];

        //$header_array['Signature'] = base64_encode(hash_hmac('sha256',$content, $_SERVER['HTTP_SECRETKEY'] ,true));
		$header_array['Signature'] = base64_encode(hash_hmac('sha256',$content, SAE_SECRETKEY ,true));
		
		$header_array2=array();
        foreach($header_array as $k => $v)
            array_push($header_array2,$k.': '.$v);

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header_array2 ); 
        curl_setopt($this->curl, CURLOPT_URL, SAE_FETCHURL_SERVICE_ADDRESS );
		
		$ret = curl_exec( $this->curl );
		
		// clean post data
		$this->postInit();
		
		return json_decode( $ret , true);
		
		/* $response=array();
		$header_callback=curl_getinfo( $this->curl );
		array_push($response,$header_callback);
		$json_response=json_decode( $ret , true);
		array_push($response,$json_response);
		return $response; */
		
		
	}
	
	function __destruct ()
	{
		curl_close($this->curl);
	}
	
	

	
	
	
	
	
	//function 
	
	
	

	
	
}


?>