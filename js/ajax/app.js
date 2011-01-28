/**
 * @author Administrator
 */
var sinaApp={
	userInfo:{
		
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
		gui.showTip('载入中．．．');
		$.post("ajax/friends_timeline.php",arg,function(data,textStatus){
			container.append(data);
			gui.hideTip();
			gui.sinaEventLoaded=true;
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});
		
	},
	moreComments:function(id,page){
		this.getCommentList(id,page);
	},
	addFavourite:function(id){
		 var arg={};
		 arg.id=id;
		 gui.showTip('正在收藏．．．')
		$.post("ajax/add_to_favorites.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('收藏成功!',500);
				$("#comments-"+id).hide();
			}else {
				gui.showTip('收藏失败',500);
			}
		});
	},
	
	sendDirectMessage:function(msg,name){
		var arg={};
		arg.screen_name=name;
		arg.text=msg;
		
		gui.showTip('发送私信中．．．');
		$.post("ajax/send_direct_messages.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('发送成功!',500);
				gui.hideSend();
			}else {
				gui.showTip('发送失败',1500);
			}
		});
	},
	sendMessage:function(status){
		var arg={};
		arg.status=status;
		gui.showTip('发送中．．．')
		$.post("ajax/update.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('发送成功!',500);
				gui.hideSend();
			}else {
				gui.showTip('发送失败',500);
			}
		});
	},
	sendComment:function(id){
		var content=$('#comment-content-'+id).val();
		
		var arg={};
		arg.id=id;
		if(content=='')return;
		arg.status=content;

		gui.showTip('评论发送中....');		
		$.post("ajax/send_comment.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('评论成功!',500);
				$("#comments-"+id).hide();
			}else {
				gui.showTip('评论失败',500);
			}
		});
	},
	sendRetweet:function(id){
		//var content=$('#retweet-content-'+id).val();
		var arg={};
		arg.id=id;
		arg.status=$('#retweet-content-'+id).val();
		gui.showTip('发送中....');
		$.post("ajax/repost.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.showTip('发送成功!',500);
				$("#retweet-"+id).hide();
			}else {
				gui.showTip('发送失败',1500);
			}
		});
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
		$("#user-events").show();
		$("#user-following").hide();
		$("#user-followers").hide();
	},
	getUserTimeline:function(maxid){
		//
		var arg={};
		//sinaApp.userInfo.id=id;
		arg.screen_name=sinaApp.userInfo.name;
		if (maxid) {
			arg.max_id = maxid;
		}
		else {//如果不带Max参数表示第一次打开,所以要清空
			$("#user-events-content").empty();
		} 
		gui.showTip('载入中...');		
		
		$.post("ajax/user_timeline.php",arg,function(data,textStatus){
			$("#user-events-content").append(data);	
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',1500);	
			}
		});
	},
	getUserFollowing:function(cursor){
		var arg={
			screen_name:sinaApp.userInfo.name,
			count:20
		}
		if(cursor)
			arg.cursor=cursor;
		else	$("#user-following").empty();
		gui.showTip('载入中...');
		$.post("ajax/friends.php",arg,function(data,textStatus){
			$("#morefollowing").remove();
			$("#user-following").append(data);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',1500);	
			}
		});
	},
	getUserFollowers:function(cursor){
		var arg={
			screen_name:sinaApp.userInfo.name,
			count:20
		}
		if(cursor)
			arg.cursor=cursor;
		else $("#user-followers").empty();
		gui.showTip('载入中...');
		$.post("ajax/followers.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',1500);	
			}
			$("#morefollowers").remove();
			$("#user-followers").append(data);
		});
	},
	moreUserEvents:function(){
		if(gui.kkUserInfoLoaded){
			kk.moreUserEvents(false);
			return;
		}
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
	getCommentList:function(id,page,count){
		var arg={};
		arg.id=id;
		arg.count=20;
		if(page)arg.page=page;
		else page=1;
		gui.showTip('正在载入评论...');
		$.post("ajax/comments_list.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',1500);	
			}
			//$("#moreComments-"+id).remove();
			$("#comment-list-"+id).empty();
			$("#comment-list-"+id).append(data);
			//bug:因为评论在不断刷新，评论的页数也在变化，造成上一条和下一条重复．
		});
	},
	moreFollowers:function(cursor){
		this.getUserFollowers(cursor);
	},
	moreFollowing:function(cursor){
		this.getUserFollowing(cursor);
	}

}
var kk={
	hideLoginWin:function(){
		$('#kk_login_window').hide();
		gui.hideMask();
	},
	loginCallback:null,
	showLoginWin:function(){
		gui.showMask();
		$('#kk_login_window').show();		
	},
	// 弹出登录窗口的登录事件
	startLogin:function(){
		var un=$('#kk_un').val();
		var pw=$('#kk_pw').val();
		
		var arg={
			username:un,
			password:pw
		};
		$.post("kk_login_action.php",arg,function(data,textStatus){
			if(data=='True'){
				kk.hideLoginWin();
				kk.logined=true;
				kk.loginCallback(true);
			}else {
				kk.logined=false;
				alert('登录失败');
			}
		});		
	},
	logined:false,
	login:function(callback){
		this.loginCallback=callback;
		this.showLoginWin();
	},
	//当前打开的用户
	userInfo:{
		id:'',
		name:''
	},
	notLoginString:'Not login kaikai!',
	currentEventPage:1,
	/**
	 * 
	 * @param Boolean clear 是否清空原有的Events
	 */
	moreEvents:function(clear){
		var container=$('#kkEvents-content');
		if (clear) {//如果为True则清空
			container.empty();
			this.currentEventPage=1;
		}
		var arg={
			page:this.currentEventPage
		};
		this.currentEventPage++;
		gui.showTip('载入中．．．');
		$.post("ajax/kk_friends_timeline.php",arg,function(data,textStatus){
			gui.hideTip();
			if(data==kk.notLoginString){
				kk.login(kk.moreEvents);return;
			}
			container.append(data);
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});
	},
	userEventPage:1,
	friendsPage:1,
	followersPage:1,
	//用户动态
	moreUserEvents:function(clear){
		var container=$('#user-events-content');
		if (clear) {//如果为True则清空
			container.empty();
			this.userEventPage=1;
		}
		var arg={
			username:kk.userInfo.name,
			page:this.userEventPage
		};
		this.userEventPage++;
		gui.showTip('载入中．．．');
		$.post("ajax/kk_user_timeline.php",arg,function(data,textStatus){

			container.append(data);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});
	},
	//我关注的
	moreFriends:function(clear){
		var container=$('#user-following');
		if (clear) {//如果为True则清空
			container.empty();
			container.html("<div onclick='kk.moreFriends()' class='more-button' id='morefollowing'>更多好友</div>");
			this.friendsPage=1;
		}
		var arg={
			id:kk.userInfo.id,
			page:this.friendsPage
		};
		this.friendsPage++;
		gui.showTip('载入中．．．');
		$.post("ajax/kk_friends.php",arg,function(data,textStatus){
			$(data).insertBefore("#morefollowing");
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});
		
	},
	//关注我的.
	moreFollowers:function(clear){
		var container=$('#user-followers');
		if (clear) {//如果为True则清空
			container.empty();
			container.html("<div onclick='kk.moreFollowers()' class='more-button' id='morefollowers'>更多粉丝</div>");
			this.followersPage=1;
		}
		var arg={
			id:kk.userInfo.id,
			page:this.followersPage
		};
		this.followersPage++;
		gui.showTip('载入中．．．');
		$.post("ajax/kk_followers.php",arg,function(data,textStatus){
			$(data).insertBefore("#morefollowers");
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});
	},
	//当前用户的City
	cityNamePY:"guangzhou",
	//汉字
	cityName:"广州",
	lat:23.1,
	lon:111.2,
	checkinPage:1,
	lastQuery:'',
	moreCheckin:function(clear){
		var container=$('#checkin-panel-content');
		var arg;
		if(clear){
			this.checkinPage=1;
			this.lastQuery=$('#checkin-query').val();
			container.empty();
			container.html('<div id="more-checkin" onclick="kk.moreCheckin(false)" class="more-button">更多地点</div>');
		}
		arg={
			lat:this.lat,
			lon:this.lon,
			page:this.checkinPage
		};
		if(this.lastQuery!=''){
			arg.query=this.lastQuery;
		}
		this.checkinPage++;
		gui.showTip('载入中．．．');
		$.post("ajax/kk_search.php",arg,function(data,textStatus){
			gui.hideTip();
			if(data==kk.notLoginString){
				kk.login(kk.moreCheckin);return;
			}
			$(data).insertBefore("#more-checkin");
			
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});
	},
	getWeather:function(){	
		var arg={
			city:this.cityName
		}
		$.post("ajax/weather.php",arg,function(data,textStatus){
			$('#weather-box').empty().append(data);
		});		
	},
	city:function(){

	}
	
}
var douban={
	eventsPage:1,
	moreEvents:function(clear){
		var container=$('#acti');
		if(clear){
			container.empty();
			container.html('<div id="more-acti" onclick="douban.moreEvents(false);" class="more-button">更多活动</div>');
			this.eventsPage=1;
		}
		var morebtn=$('#more-acti');
		//alert(kk.cityNamePY);
		var arg={
			city:kk.cityNamePY,
			page:this.eventsPage
		};
		//arg.city=kk.cityNamePY;
		this.eventsPage++;
		gui.showTip('载入中...');
		$.post("ajax/db_event.php",arg,function(data,textStatus){
			gui.hideTip();
			$(data).insertBefore(morebtn);
		});
	},
	share:function(event,url){
		
		
	}
};
var lashou={
	groupBuyPage:1,
	moreGroupBuy:function(clear){
		var container=$('#group-buy');
		if(clear){
			container.empty();
			this.groupBuyPage=1;
		}
		var arg={
			city:kk.cityName
		}
		this.groupBuyPage++;
		$.post("ajax/tuangou.php",arg,function(data,textStatus){
			gui.hideTip();
			container.append(data);
		});		
	}
}
