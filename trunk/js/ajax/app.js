/**
 * @author Administrator
 */
var sinaApp={
	following:{
		page:0
	},
	follower:{
		page:0
	},
	user:'',
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
		sinaApp.user=name;//标记当前用户信息正在显示的用户名
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
		arg.screen_name=sinaApp.user;
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
	getUserFollowing:function(clear){
		if(clear){
			sinaApp.following.page=0;
			$("#user-following-content").empty();
		}
		sinaApp.following.page++;
		var arg={
			screen_name:sinaApp.user,
			count:20,
			page:sinaApp.following.page
		}
		$.post("ajax/friends.php",arg,function(data,textStatus){
			$("#user-following-content").append(data);
		});
	},
	getUserFollowers:function(clear){
		if(clear){
			sinaApp.follower.page=0;
			$("#user-followers-content").empty();
		}
		sinaApp.follower.page++;
		var arg={
			screen_name:sinaApp.user,
			count:20,
			page:sinaApp.follower.page
		}
		$.post("ajax/followers.php",arg,function(data,textStatus){
			$("#user-followers-content").append(data);	
		});
	},
	moreUserEvents:function(){
		var lastchild=document.getElementById("user-events-content").lastChild;
		while(lastchild&&lastchild.nodeType!=1){
			lastchild=lastchild.previousSibling;
		}
		if(lastchild){
			var maxid;
			maxid=lastchild.id;
			maxid=maxid.split('-')[2];
			this.getUserTimeline(maxid);
		}
		
	},
	moreFollowers:function(){
		this.getUserFollowers();
	},
	moreFollowing:function(){
		this.getUserFollowing();
	}

}
var kkApp={
	
}
