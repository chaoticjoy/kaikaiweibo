/**
 * @author Administrator
 */
var toggle=1;
var kkwb={//kaikai weibo
	history:[],
	currentPanel:'#events-panel',//当前Tab的ID
	currentBtn:'#events-btn',
	onClickPostBtn:function(){
		//设置遮罩的高宽为当前文档的高宽,开启遮罩,弹出编辑框
		var docHeight=$(document).height(); 
		var docWidth=$(document).width();
		$("#mask").width(docWidth)
				  .height(docHeight)
				  .show();
		$("#send").show();
	},
	changePanel:function(tid,bid){//tid target panel's id;need to add a '#' before ids
		if(tid==(this.currentPanel))return;
		var docw=$(document).width();
		var cpanel = $(this.currentPanel);
		var tpanel = $(tid);
		//cpanel.css('z-index', '2');//当前的在上
		//tpanel.css('z-index', '1');//目标在下
		tpanel.show();
		
		cpanel.animate({
			right:""+ docw + 'px',
			left:'-'+ docw + 'px'
		}, {
			duration:600,
			complete:function(){
				cpanel.hide().css('right','0').css('left','0');
			}
		});//向左滑动一个屏幕宽度
		tpanel.css('left',docw+'px').css('right','-'+docw+'px');
		tpanel.animate({
			left:'0px',right:'0px'
		},600);
		//
		this.currentPanel = tid;
		//把按钮样式设置为on
		$(this.currentBtn).removeClass('on');
		$(bid).addClass('on');
		this.currentBtn=bid;
	},
	onClickEventBtn:function(id){
		this.changePanel('#events-panel','#events-btn');
	},
	onClickCheckinBtn:function(id){
		this.changePanel('#checkin-panel','#checkin-btn');
	},
	onClickCityBtn:function(id){
		this.changePanel('#city-panel','#city-btn');
	},
	onClickUserBtn:function(id){
		this.changePanel('#user-panel','#user-btn');
	}
};

function onLoad(){
	//隐藏前进后退箭头
	$("#back").hide();
	$("#forward").hide();
	//顶栏各个按钮
	$("#post-btn").click(function(){
		kkwb.onClickPostBtn();
	});
	$("#events-btn").click(function(){
		kkwb.onClickEventBtn();
	});
	$("#checkin-btn").click(function(){
		kkwb.onClickCheckinBtn();
	});
	$("#city-btn").click(function(){
		kkwb.onClickCityBtn();
	});
	$("#user-btn").click(function(){
		kkwb.onClickUserBtn();
	});
	
	//发布界面的关闭按钮
	$("#close-btn").click(function(){
		$("#send").hide();
		$("#mask").hide();
	});
	//发布按钮
	$("#send-btn").click(function(){
		alert($("#send-content").val());
	});
	//初始化时只显示第一个Tab
	$("#tabpanel").css('position','relative');
	$("#tabpanel :first-child").show();
}
