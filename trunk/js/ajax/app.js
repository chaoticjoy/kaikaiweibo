/**
 * @author Administrator
 */
var sinaApp={
	
	/**
	 * 
	 * @param {boolean} clear  表示是否清楚SinaEvents里有所有元素
	 */
	moreEvents:function(clear){
		var container=$('#sinaEvents-content');
		
		container.load("ajax/friends_timeline.php",{count:20});
		
	},
	moreComments:function(id){
		
	},
	sendComment:function(id){
		var content=$('#comment-content-'+id).val();
		alert("评论:"+content);
	},
	sendRetweet:function(id){
		var content=$('#retweet-content-'+id).val();
		alert("转发:"+content);
	}
}
var kkApp={
	
}
