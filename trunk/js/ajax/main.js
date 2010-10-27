/**
 * @author Administrator
 */
var toggle=1;
var gui={//kaikai weibo
	history:[[0,"#events-btn"]],
	currentHistory:0,///当前历史的Index
	currentPanel:0,//
	currentBtn:'#events-btn',
	panels:["#events-panel","#checkin-panel","#city-panel","#user-panel"],
	
	//组件，
	components:{},
	
	init:function(){
		this.components.mask=$("#mask");
		this.components.image=$("#image");
	},
	
	showMask:function(){
		//alert($(document).height()+" "+$(document).width());
		this.components.mask.width($(document).width())
				  .height($(document).height())
				  .show();
	},
	hideMask:function(){
		this.components.mask.hide();
	},
	
	onClickPostBtn:function(){
		//开启遮罩,弹出编辑框
		this.showMask();
		$("#send").show();
	},
	//tid target panel's id;need to add a '#' before ids. buttonid 
	changePanel:function(tid,bid,history){
		if(tid==this.currentPanel)return;
		
		if (history == undefined) {//不是进行历史操作
			$("#back").show();
			while((this.history.length-1)>this.currentHistory){
				this.history.pop();
			}
			this.history.push([tid, bid]);
			this.currentHistory = this.history.length - 1;
		}
		//alert("c"+this.currentHistory);

		var speed=200;
		var docw=$(document).width();
		var cpanel =$(this.panels[this.currentPanel]);
		var tpanel = $(this.panels[tid]);

		//判断向左还是向右滑
		var moveoption={};
		if(tid>this.currentPanel){
			moveoption={
				right:""+ docw + 'px',
				left:'-'+ docw + 'px'
			}
			tpanel.css('left',docw+'px').css('right','-'+docw+'px');
		}else{
			moveoption={
				right:"-"+ docw + 'px',
				left:''+ docw + 'px'
			}
			tpanel.css('left',-docw+'px').css('right',+docw+'px');
		}
		//结束
		tpanel.show();
		
		cpanel.animate(moveoption, {
			duration:speed,
			complete:function(){
				cpanel.hide().css('right','0').css('left','0');
			}
		});//向左滑动一个屏幕宽度
		
		tpanel.animate({
			left:'0px',right:'0px'
		},speed);
		//
		
		//把按钮样式设置为on
		$(this.currentBtn).removeClass('on');
		$(bid).addClass('on');
		this.currentBtn=bid;
		this.currentPanel = tid;
	},
	
	
	onClickEventBtn:function(id){
		this.changePanel(0,'#events-btn');
	},
	onClickCheckinBtn:function(id){
		this.changePanel(1,'#checkin-btn');
	},
	onClickCityBtn:function(id){
		this.changePanel(2,'#city-btn');
	},
	onClickUserBtn:function(id){
		this.changePanel(3,'#user-btn');
	},
	//前进后退按钮
	back:function(){
		var h=this.currentHistory-1;
		//alert(h);
		if(h==0){
			$("#back").hide();
		}
		if(h<0)return;
		this.currentHistory--;
		$("#forward").show();
		this.changePanel(this.history[h][0],this.history[h][1],false);
	},
	forward:function(){
		var h=this.currentHistory+1;
		//alert(h);
		if(h==this.history.length-1){
			$("#forward").hide();
		}
		if(h>this.history.length)return;
		this.currentHistory++;
		$("#back").show();
		this.changePanel(this.history[h][0],this.history[h][1],false);
	},

	//查看评论,
	openComments:function(id){
		var commentContainer=$('#comments-'+id);
		if(commentContainer.css('display')=='none'){
			//加截评论内容
			
			//显示
			commentContainer.show();
		}else {
			commentContainer.hide();
		}
	},
	
	openRetweet:function(id){
		var retweetContainer=$('#retweet-'+id);
		if(retweetContainer.css('display')=='none'){
			retweetContainer.show();
		}else{
			retweetContainer.hide();
		}
	},
	reply:function(id,name){
		var contentArea=$('#comment-content-'+id);
		var content=contentArea.val();
		contentArea.val('回复:@'+name+' '+content);
		contentArea[0].focus();
	},
	openImage:function(event){
		this.showMask();
		var thumbnail=event.currentTarget.src;
		var original=thumbnail.replace('thumbnail','orignal');
		//---
	}
};

$(function(){
	gui.init();
	//隐藏前进后退箭头
	$("#back").hide();
	$("#forward").hide();
	//顶栏各个按钮
	$("#post-btn").click(function(){
		gui.onClickPostBtn();
	});
	$("#events-btn").click(function(){
		gui.onClickEventBtn();
	});
	$("#checkin-btn").click(function(){
		gui.onClickCheckinBtn();
	});
	$("#city-btn").click(function(){
		gui.onClickCityBtn();
	});
	$("#user-btn").click(function(){
		gui.onClickUserBtn();
	});
	
	//发布界面的关闭按钮
	$("#close-btn").click(function(){
		$("#send").hide();
		gui.hideMask();
	});
	//发布按钮
	$("#send-btn").click(function(){
		alert($("#send-content").val());
	});
	//初始化时只显示第一个Tab
	$("#tabpanel").css('position','relative');
	$("#tabpanel :first-child").show();
});
