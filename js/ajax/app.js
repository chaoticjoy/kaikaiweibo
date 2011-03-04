/**
 * @author Administrator
 */
var sinaApp={
	userInfo:{
		
	},
	personalComments:function(page){
		var container=document.getElementById('personal-page-content');
		var arg={page:page};
		if(container.childNodes.length>0){
			container.removeChild(container.lastElementChild);
			var div =document.createElement('div');
			div.innerHTML='<div onclick="sinaApp.personalComments('+ ++page+')" class="more-button">更多</div>';
			container.appendChild(div);
		}else{
			container.innerHTML='<div onclick="sinaApp.personalComments(2)" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/comments_to_me.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});			
	},
	personalMentions:function(){
		
		var container=document.getElementById('personal-page-content');
		var arg={}
		if(container.childNodes.length>0){	
			var id=container.lastElementChild.previousElementSibling.id;
			id=id.substring('sina-user-'.length,id.length);
			arg.max_id=id;
			
		}else{
			container.innerHTML='<div onclick="sinaApp.personalMentions()" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/mentions.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});		
			
	},
	personalDms:function(){
		var container=document.getElementById('personal-page-content');
		var arg={}
		if(container.childNodes.length>0){	
			var id=container.lastElementChild.previousElementSibling.id;
			id=id.substring('sina-dms-'.length,id.length);
			arg.max_id=id;
			
		}else{
			container.innerHTML='<div onclick="sinaApp.personalDms()" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/direct_messages.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});		
				
	},
	personalFollowing:function(cursor){
		
		var container=document.getElementById('personal-page-content');
		var arg={cursor:cursor,count:20};
		if(container.childNodes.length>0){
			container.removeChild(container.lastElementChild);
			var div =document.createElement('div');
			div.innerHTML='<div onclick="sinaApp.personalFollowing('+ (cursor+20) +')" class="more-button">更多</div>';
			container.appendChild(div);
		}else{
			container.innerHTML='<div onclick="sinaApp.personalFollowing(20)" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/friends.php",arg,function(data,textStatus){			
			//因为在约定接口时,返回了多一个Button,粉丝接口一样
			$(data).insertBefore(container.lastElementChild);
			container.removeChild(container.lastElementChild.previousElementSibling);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});	
	},
	personalFollowers:function(cursor){
		
		var container=document.getElementById('personal-page-content');
		var arg={cursor:cursor,count:20};
		if(container.childNodes.length>0){
			container.removeChild(container.lastElementChild);
			var div =document.createElement('div');
			div.innerHTML='<div onclick="sinaApp.personalFollowers('+ (cursor+20) +')" class="more-button">更多</div>';
			container.appendChild(div);
		}else{
			container.innerHTML='<div onclick="sinaApp.personalFollowers(20)" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/followers.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			container.removeChild(container.lastElementChild.previousElementSibling);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});		
	},
	personalEvent:function(){
		var container=document.getElementById('personal-page-content');
		var arg={}
		if(container.childNodes.length>0){	
			var id=container.lastElementChild.previousElementSibling.id;
			id=id.substring('sina-user-'.length,id.length);
			arg.max_id=id;
			
		}else{
			container.innerHTML='<div onclick="sinaApp.personalEvent()" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/user_timeline.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});		
		
	},
	personalFav:function(page){
		var container=document.getElementById('personal-page-content');
		var arg={page:page};
		if(container.childNodes.length>0){
			container.removeChild(container.lastElementChild);
			var div =document.createElement('div');
			div.innerHTML='<div onclick="sinaApp.personalFav('+ ++page+')" class="more-button">更多</div>';
			container.appendChild(div);
		}else{
			container.innerHTML='<div onclick="sinaApp.personalFav(2)" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/favorites.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});	
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
	//个人页面的回复
	sendReply:function(id,text){
		var arg={};
		arg.id=id;	
		arg.status=text;	
		gui.showTip('评论发送中....');		
		$.post("ajax/send_comment.php",arg,function(data,textStatus){
			gui.hideTip();
			if(textStatus=='success'){
				gui.hideSend();
				gui.showTip('评论成功!',500);
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
	getUserInfo:function(){ 
		var arg={};
		if(sinaApp.userInfo.name!='')
			arg.screen_name=sinaApp.userInfo.name;
		$.post("ajax/userinfo.php",arg,function(data,textStatus){
			$("#user-panel-header").empty()//清空后插入
			.append(data);	
		});
	},
	getUserTimeline:function(maxid){
		var arg={};
		if(sinaApp.userInfo.name!='')
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
			var temp=$("#comment-list-"+id)
			temp.empty();
			$("#comment-list-"+id).append(data);
			//bug:因为评论在不断刷新，评论的页数也在变化，造成上一条和下一条重复．
			scrollToElement(temp[0],-100);

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
	lon:113.1,
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
			if(data.length==0){
				container.html('<div id="more-checkin" class="no-found">没找到地点</div>');
			}else
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

	},
	checkin:function(content,id){
		var arg={
			id:id
		}
		gui.showTip('正在签到...');
		if(content){
			gui.showTip('正在发布贴士...');
			arg.text=content;
			$.post("ajax/kk_tipsupdate.php",arg,function(data,textStatus){
				gui.hideTip();
				$('#checkin-'+id).hide();
			});
		}
		$.post("ajax/kk_checkin.php",arg,function(data,textStatus){
			gui.hideTip();
			$('#checkin-'+id).hide();
		});	
	
	},
	personalFriends:function(page){

		var id=getCookie('kk_id');
		if(!id){
			//未登录
			kk.login(kk.personalFriends);
			return;
		}
		
		var container=document.getElementById('personal-page-content');
		var arg={page:page,id:id};
		if(container.childNodes.length>0){
			container.removeChild(container.lastElementChild);
			var div =document.createElement('div');
			div.innerHTML='<div onclick="kk.personalFriends('+ ++page+')" class="more-button">更多</div>';
			container.appendChild(div);
		}else{
			container.innerHTML='<div onclick="kk.personalFriends(2)" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/kk_friends.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});			
	},
	personalFollowers:function(page){
		var id=getCookie('kk_id');
		if(!id){
			//未登录
			kk.login(kk.personalFollowers);
			return;
		}
		var container=document.getElementById('personal-page-content');
		var arg={page:page,id:id};
		if(container.childNodes.length>0){
			container.removeChild(container.lastElementChild);
			var div =document.createElement('div');
			div.innerHTML='<div onclick="kk.personalFollowers('+ ++page+')" class="more-button">更多</div>';
			container.appendChild(div);
		}else{
			container.innerHTML='<div onclick="kk.personalFollowers(2)" class="more-button">更多</div>';
		}
		gui.showTip('载入中．．．');
		$.post("ajax/kk_followers.php",arg,function(data,textStatus){
			$(data).insertBefore(container.lastElementChild);
			gui.hideTip();
			if(textStatus!='success'){
				gui.showTip('载入失败，请重新载入',500);
			}
		});			
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
			if(data.length==0){
				container.html('<div class="no-found">没有活动</div>');
			}
			else
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
			container.empty();
			if(data.length==0){
				container.html('<div class="no-found">没有团购</div>');
			}else{
				container.append(data);
			}
		});		
	}
}

function getCookie(cookie_name){
    var allcookies = document.cookie;
    var cookie_pos = allcookies.indexOf(cookie_name);
    // 如果找到了索引，就代表cookie存在，
    // 反之，就说明不存在。
    if (cookie_pos != -1) {
        // 把cookie_pos放在值的开始，只要给值加1即可。
        cookie_pos += cookie_name.length + 1;   
        var cookie_end = allcookies.indexOf(";", cookie_pos);
        if (cookie_end == -1) {
            cookie_end = allcookies.length;
        }
        var value = unescape(allcookies.substring(cookie_pos, cookie_end));
    }
    return value;
}
/**
 * 
 * @param {Object} node  要滚到的HTML节点
 * @param {Object} ex  额外多滚一点的值
 */
function scrollToElement(node,ex){
	if(!node)return;
	if(ex==undefined)ex=0;
	var top=getElementTop(node)+ex;
	document.body.scrollTop=top;
	document.documentElement.scrollTop=top;
}
function getElementTop(node){
	var top=0;
	while(node.offsetParent){
		top+=node.offsetTop;
		node=node.offsetParent;
	}
	return top;
}
