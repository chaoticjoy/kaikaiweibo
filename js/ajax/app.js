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
		if(clear)//如果为True则清空
			container.empty();
		var sc=document.getElementById('sinaEvents-content');
		
		
		var lastchild=sc.lastChild;
		while(lastchild&&lastchild.nodeType!=1){
			lastchild=lastchild.previousSibling;
		}
		var maxid=null;//默认是没有最大ID，当有子节点时才会有最大ID
		if(lastchild){//如果有最后一个节点
			maxid=lastchild.id;
			maxid=maxid.split('-')[2];
		}
		var arg={};
		if(maxid)
			arg.max_id=maxid; 
		
		$.post("ajax/friends_timeline.php",arg,function(data,textStatus){
			container.append(data);
		});
		
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
	},
	getUserInfo:function(name){
		this.user=name;//标记当前用户信息正在显示的用户名
		var arg={};
		if(name)
			arg.screen_name=name;
		$.post("ajax/userinfo.php",arg,function(data,textStatus){
			$("#user-panel-header").empty()//清空后插入
			.append(data);	
		});
		//插入后载入动态
		this.getUserTimeline();
	},
	getUserTimeline:function(maxid){
		//
		var arg={};
		arg.screen_name=this.user;
		if (maxid) {
			arg.max_id = maxid;
		}
		else {//如果不带Max参数表示第一次打开,所以要清空
			$("#user-events-content").empty();
		}

		$.post("ajax/user_timeline.php",arg,function(data,textStatus){
			$("#user-events-content").append(data);	
		});
	},
	getUserFollowing:function(){
		
	},
	getUserFollowers:function(){
		
	}

}
var kkApp={
	
}
