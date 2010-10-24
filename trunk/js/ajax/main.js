/**
 * @author Administrator
 */
var toggle=1;
var kkwb={//kaikai weibo
	history:[],
	currentPanel:0,//
	currentBtn:'#events-btn',
	panels:["#events-panel","#checkin-panel","#city-panel","#user-panel"],
	
	onClickPostBtn:function(){
		//设置遮罩的高宽为当前文档的高宽,开启遮罩,弹出编辑框
		var docHeight=$(document).height(); 
		var docWidth=$(document).width();
		$("#mask").width(docWidth)
				  .height(docHeight)
				  .show();
		$("#send").show();
	},
	//tid target panel's id;need to add a '#' before ids. buttonid 
	changePanel:function(tid,bid){
		if(tid==this.currentPanel)return;
		
		var speed=200;
		var docw=$(document).width();
		var cpanel =$(this.panels[this.currentPanel]);
		var tpanel = $(this.panels[tid]);
		//cpanel.css('z-index', '2');//当前的在上
		//tpanel.css('z-index', '1');//目标在下
		
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
