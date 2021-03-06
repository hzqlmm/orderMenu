<?php include cls_resolve::on_resolve('/admin\/header')?>
<style>
table,td,tr{padding:0px;margin:0px}
.me_table{}
.me_toolbar{float:left;border-top:1px #C7D8EA solid;height:30px;width:100%}
.me_menu{position:absolute;background:#4CB1EF;color:#fff;padding:5px 2px 5px 2px;overflow:hidden}
.me_menu li{width:100%;float:left;padding:8px 0px 5px 0px;cursor:pointer}
.me_menu .x_sel{background:#fff;color:#000}
</style>
<script>
var me_init_height=0;
var me_url = '';
var me_menu_module = '';
//系统加载后，初始事件
kj.onload(function(){
	thisjs.module_num = kj.obj("#id_y_li li").length;
	kj.w("#id_y_li",thisjs.module_num*93);
	//控制头部菜单样式开始
	kj.handler("#id_y_li li","mouseover",function(){
		if(this.className == "" ) this.className = "z_sel";
		var obj = kj.obj("input",this);
		var v = obj[0].value;
		var objdraw = kj.obj("#id_draw_" + v);
		if(objdraw) {
			var offset = kj.offset(this);
			var top = offset.top;
			var left = offset.left;
			var w = kj.w(this)-3;
			var h = kj.h(this);
			objdraw.style.top = (top+h)+"px";;
			objdraw.style.left = left+"px";;
			objdraw.style.width = w+"px";;
			kj.show(objdraw);
		}
	});
	kj.handler("#id_y_li li","mouseout",function(){
		if(this.className == "z_sel" ) this.className = "";
		var obj = kj.obj("input",this);
		var v = obj[0].value;
		kj.hide("#id_draw_" + v);
	});
	//鼠标移动效果
	kj.handler("#id_left li","mouseover",function(){
		if( this.className.indexOf("x_sel") < 0 ) {
			kj.addClassName(this,"x_selx");
		}
	});
	kj.handler("#id_left li","mouseout",function(){
		if( this.className.indexOf("x_sel") >= 0 ) kj.delClassName(this,"x_selx");
	});
	//结束
	//初次打开显示模块
	//显示默认模块
	var arr = kj.url_toarray(window.location.href , '#');
	var ii = 0;
	if('param' in arr && 'app_menu_module' in arr['param']) {
		var arr_module = kj.obj('#id_y_li input');
		for(var i = 0 ; i < arr_module.length ; i++) {
			if(arr_module[i].value == arr['param']['app_menu_module']) {
				var arr_x = arr['pval'].split('&app_menu_module');
				me_url = arr_x[0];
				ii = i;break;
			}
		}
	}
	kj.event( kj.obj("#id_y_li li")[ii] , "click" );
	<?php if($hide_left){?>
	thisjs.hide_left(1);
	<?php }?>
	me_resize();
	<?php if(empty($hide_guide) && $this_limit->chk_act("guide",'index','index')){?>
		thisjs.klkkdj_open('开店向导','app_act=guide&app=service');
	<?php }?>
});
//浏览器改变大小时调整大小
kj.onresize(function() {
	me_resize();
});
function me_resize(){
	var lng_w=document.documentElement.clientWidth;
	if(lng_w<900) lng_w=900;
	var w = kj.w("#id_table_left");
	kj.w('#id_frame_main',lng_w-w);
	kj.w('.me_table',lng_w);
	if(lng_w-560<kj.w('#id_y_li')) {
		kj.delClassName("#id_info_div","x_info");
		kj.addClassName("#id_info_div","x_info2");
		kj.set("#id_menu_div" , "style.paddingTop" , "0px");
		kj.w("#id_menu_div" , lng_w-140);
	} else {
		kj.delClassName("#id_info_div","x_info2");
		kj.addClassName("#id_info_div","x_info");
		kj.w("#id_menu_div" , lng_w-560);
		kj.set("#id_menu_div" , "style.paddingTop" , "27px");
	}
	me_init_height = document.documentElement.clientHeight - 105;
	//控制页面自适应高度
	kj.h("#id_left" , me_init_height+40 );
	kj.h("#id_frame_main" , me_init_height+40 );
	kj.set("#id_open_win","style.top",(me_init_height+75)+"px");
	if(kj.agent(true) == 'MSIE6.0') kj.w("#id_open_win",document.documentElement.clientWidth);
	var idocumentElement = kj.obj("#id_frame_main").contentWindow;
	if(idocumentElement && 'inc_resize' in idocumentElement) idocumentElement.inc_resize();
}
function show_edit(obj) {
	obj.type='iframe';
	obj.top=0;
	if(!('h' in obj)) obj.h=document.documentElement.clientHeight-33;
	obj.showbtnhide=true;
	open_win_add(obj);
	kj.dialog(obj);
}
function open_win_add(o){
	var id="open_win_"+o.id;
	var obj_li=kj.obj('#'+id);
	if(obj_li) return;
	var obj_li=document.createElement("li");
	obj_li.id = id;
	obj_li.innerHTML = o.title;
	var str_id = o.id;
	kj.handler(obj_li,"click",function(){
		kj.dialog.show("#win"+str_id);
	});
	kj.obj("#id_open_win").appendChild(obj_li);
}
//重写 dialog show 与 close 函数 
var me_dialog_close=kj.dialog.close;
kj.dialog.close=function(msgid){
	me_dialog_close(msgid);
	var str_id=msgid.substr(4);
	kj.remove("#open_win_"+str_id);
	if(kj.dialog.index<1){
		//还原工具栏
		kj.set("#id_open_win","style.display","none");
		kj.h("#id_frame_main" , me_init_height+40 );
		//兼容非主流浏览器iframe resize事件
		var idocumentElement = kj.obj("#id_frame_main").contentWindow;
		if(idocumentElement && 'inc_resize' in idocumentElement) idocumentElement.inc_resize();
	}
}
var me_dialog_hide=kj.dialog.hide;
kj.dialog.hide=function(msgid){
	var id="#open_win_"+kj.obj(msgid).id.substr(3);
	kj.set(id,'className','');
	me_dialog_hide(msgid);
}
var me_dialog_show=kj.dialog.show;
kj.dialog.show=function(msgid){
	var obj = kj.dialog.objs['#'+kj.obj(msgid).id];
	if('type' in obj && obj.type=='iframe' && !('notoolbar' in obj) ) {
		me_dialog_show(msgid);
		//工具栏高亮
		kj.set('#id_open_win li','className','');
		var id="#open_win_"+kj.obj(msgid).id.substr(3);
		kj.obj(id).className = 'x_sel';
		if(kj.dialog.showindex>0){
			//固定工具栏
			kj.set("#id_open_win","style.display","");
			kj.h("#id_frame_main" , me_init_height+10 );
			//兼容非主流浏览器iframe resize事件
			var idocumentElement = kj.obj("#id_frame_main").contentWindow;
			if(idocumentElement && 'inc_resize' in idocumentElement) idocumentElement.inc_resize();
		}
	} else {
		me_dialog_show(msgid);
	}
}
function setval(s){
	kj.obj("#id_val").value=s;
}
</script>
<script src="/webcss/common/js/kj.pic.js"></script>
<table class="me_table" id="id_table" cellpadding=0 cellspacing=0><tr><td>
<div class="header">
	<div class="x_logo" id="id_login_div"><a href="<?php echo cls_config::get("dirpath","base");?>/" target="_blank"><img src="/webcss/admin/images/logo.png"></a><br>订&nbsp;&nbsp;&nbsp;&nbsp;餐</div>
	<div class="x_info a_1" id="id_info_div">
		<li>
		<?php if($this_limit->chk_act("help",'index','index')){?>
		<span style="float:left"><img src="/webcss/admin/images/pic_1.gif"></span>
		<span style="float:left">&nbsp;<a href="javascript:thisjs.klkkdj_open('帮助中心','app_act=help&app=service');">帮助中心</a>&nbsp;&nbsp;</span>
		<?php }?>
		<?php if($this_limit->chk_act("guide",'index','index')){?>
		<span style="float:left"><img src="/webcss/admin/images/pic_2.gif"></span><span style="float:left">&nbsp;<a href="javascript:thisjs.klkkdj_open('开店向导','app_act=guide&app=service');">开店向导</a>&nbsp;&nbsp;</span>
		<?php }?>
		<?php if($this_limit->chk_act("msg",'index','index')){?>
		<span style="float:left"><img src="/webcss/admin/images/pic_3.gif"></span><span style="float:left">&nbsp;<a href="javascript:thisjs.klkkdj_open('意见反馈','app_act=msg&app=service');">意见反馈</a>&nbsp;&nbsp;</span>
		<?php }?>
		<span style="float:left"><label><input type="checkbox" name="hide_left" value="1" style="margin:0px;padding:0px" id="id_hide_left" onclick="thisjs.hide_left(this.checked);"<?php if($hide_left){?> checked<?php }?>>&nbsp;隐藏左栏</label></span>
		</li>
		<li>
		<a href="<?php echo cls_config::get("dirpath","base");?>/" target="_blank">网站首页</a>&nbsp;&nbsp;
		<?php if($this_limit->chk_act("call",'index','index')){?>
		<a href="<?php echo cls_config::get("dirpath","base");?>/common.php?app_module=meal&app=call" target="_blank">来单显示</a>&nbsp;&nbsp;
		<?php }?>
		<?php if($this_limit->chk_act("clear_cache",'common','sys')){?>
		<a href="javascript:thisjs.cache_show();">更新缓存</a>&nbsp;&nbsp;
		<?php }?>
		当前用户：<font color="#ff8800"><?php echo $user->uname;?></font><?php if($this_limit->chk_app('common' , 'sys') && $this_limit->chk_act('update_pwd' , 'common' , 'sys')){?> <a href="javascript:thisjs.update_pwd_show();" style="color:#ffffff">(修改密码)</a><?php }?>&nbsp;
		<a href="http://localhost/common.php?app=sys&app_act=login.out" style="color:#ffffff" target="_top">退出系统</a>
		</li>
	</div>
	<div class="x_menu" id="id_menu_div">
		<div class="y_li" id="id_y_li">
		<?php if($this_limit->chk_act("main",'index','index')){?>
			<li class="z_selx a_1" id="id_main_menu_iframe_main" onclick="thisjs.y_li_click('iframe_main');"><input type='hidden' value="iframe_main">桌面</li>
		<?php }?>
		<?php foreach($arr_menu as $item => $key){ ?>
			<li <?php if($item==$app_module){?> class="z_selx a_1"<?php }?> id="id_main_menu_<?php echo $item;?>" onclick="thisjs.y_li_click('<?php echo $item;?>');"><input type="hidden" value="<?php echo $item;?>"><?php echo $item;?></li>
		<?php }?>
		</div>
	</div>
</div>
</td></tr>
<tr><td valign="top" align="left">
	<table style="width:100%;height:100%" cellpadding=0 cellspacing=0 border=0>
	<tr><td class="left" valign="top" id="id_table_left">
		<div class="x_li" id="id_left" valign="top">
		<?php foreach($arr_menu as $item => $key){ ?>
			<div id="id_left_<?php echo $item;?>" style="display:none">
			<?php for($i=0;$i<count($key);$i++){ ?>
			<li id='id_left_<?php echo $item;?>_<?php echo $i;?>' onclick="thisjs.menu_click('id_left_<?php echo $item;?>_<?php echo $i;?>' , '<?php echo $item;?>');"><input type='hidden' value='<?php echo $key[$i]['url'];?>'><?php echo $key[$i]['name'];?></li>
			<?php }?>
			</div>
		<?php }?>
		</div>
	</td><td id="id_table_main" valign="top" align="right">
		<div style="float:right;">
			<iframe src="" width="100%" height="0px" frameborder=0 id="id_frame_main" name="frame_main"></iframe>
		</div>
		<div class="win_toolbar" id="id_open_win" style="display:none"></div>
	</td></tr>
	</table>
</td></tr>
</table>
<div id="id_cache_clear_html" style="display:none">
	<div style="float:left;padding:10px 0px 0px 10px">
	<label><input type="checkbox" name="cache_clear[]" value="1" checked>&nbsp;模板缓存</label><br>
	<label><input type="checkbox" name="cache_clear[]" value="2" checked>&nbsp;数据缓存</label><br>
	<label><input type="checkbox" name="cache_clear[]" value="3" checked>&nbsp;配置缓存</label><br>
	<label><input type="checkbox" name="cache_clear[]" value="4" checked>&nbsp;过期日志</label><br>
	<label><input type="checkbox" name="cache_clear[]" value="5" checked>&nbsp;过期备份</label><br><br>
	<input type="button" name="dosubmit" value="更新" onclick="thisjs.cache_clear();" class="pBtn">
	</div>
</div>
<div id="id_update_pwd_html" style="display:none">
	<div style="float:left;padding:10px 0px 0px 10px;line-height:30px">
	<span style="float:left;width:80px;text-align:right;padding-right:5px;height:30px">原 密 码：</span><span style="float:left;width:150px;height:30px"><input type="password" name="oldpwd" value="" class='pTxt1 pTxtL150' id="id_oldpwd"></span>
	<span style="float:left;width:80px;text-align:right;padding-right:5px;height:30px">新 密 码：</span><span style="float:left;width:150px;height:30px"><input type="password" name="newpwd" value="" class='pTxt1 pTxtL150' id="id_newpwd"></span>
	<span style="float:left;width:80px;text-align:right;padding-right:5px;height:30px">再输一次：</span><span style="float:left;width:150px;height:30px"><input type="password" name="newpwd2" value="" class='pTxt1 pTxtL150' id="id_newpwd2"></span>
	<span style="float:left;width:80px;text-align:right;padding-right:5px;height:30px">&nbsp;</span><span style="float:left;width:150px;height:30px"><input type="button" name="dosubmit" value="修改" onclick="thisjs.update_pwd();" class="pBtn"></span>
	</div>
</div>
<?php foreach($arr_menu as $item => $key){ ?>
	<div id="id_draw_<?php echo $item;?>" style="display:none" class="me_menu" onmouseover="thisjs.menu_over('<?php echo $item;?>')" onmouseout="thisjs.menu_out('<?php echo $item;?>');">
	<?php for($i=0;$i<count($key);$i++){ ?>
	<li onmouseover="this.className='x_sel';" onmouseout="this.className='';" onclick="thisjs.menu_click('id_left_<?php echo $item;?>_<?php echo $i;?>' , '<?php echo $item;?>' , '<?php echo $key[$i]['url'];?>');"><?php echo $key[$i]['name'];?></li>
	<?php }?>
	</div>
<?php }?>

<script src="/webcss/common/js/kj.progress.js"></script>
<script>
var thisjs = new function() {
	this.model_num = 0;
	this.cache_html = '';
	this.update_pwd_html = '';
	this.cache_type = [];
	this.menu_over = function(val) {
		kj.show("#id_draw_"+val);
		var obj = kj.obj("#id_main_menu_" + val);
		if(obj && obj.className == '') obj.className = 'z_sel';
	}
	this.menu_out = function(val) {
		kj.hide("#id_draw_"+val);
		var obj = kj.obj("#id_main_menu_" + val);
		if(obj && obj.className == 'z_sel') obj.className = '';
	}
	this.menu_click = function(id,menu_module,v) {
		kj.delClassName("#id_left li","x_sel");
		if(!v) {
			var obj = kj.obj("input","#"+id);
			v = obj[0].value;
		}
		//是否切换当前模块
		var ii = 0;
		if(me_menu_module != menu_module) {
			thisjs.y_li_click(menu_module,true);
		}
		kj.addClassName("#"+id , 'x_sel');
		kj.obj("#id_frame_main").src=v;
		v = v.replace('?' , '#') + "&app_menu_module=" + me_menu_module;

		window.open(v,'_self');
	}
	this.y_li_click = function(v , noopen) {
		kj.delClassName("#id_y_li li","x_sel z_selx a_1");
		kj.obj("#id_main_menu_"+v).className = "z_selx a_1";
		me_menu_module = v;
		if(v == 'iframe_main') {
			//主页
			kj.w("#id_table_left" , "0px");
			kj.hide("#id_table_left");
			kj.obj("#id_frame_main").src = "?app=index&app_act=main";
			me_resize();
			window.open("#app_menu_module=iframe_main",'_self');
			return;
		}
		if(kj.obj('#id_table_left').style.display=='none' && !kj.obj('#id_hide_left').checked) {
			kj.w("#id_table_left" , 126);//kj.w("#id_table_left")<50)
			kj.show("#id_table_left");
			me_resize();
		}
		kj.hide("#id_left div");
		kj.show("#id_left_"+v);
		//显示默认页面
		var ii = 0;
		var x;
		if(me_url != '') {
			var arr = kj.obj("#id_left_"+v+" input");
			me_url="?" + me_url;
			for(var i = 0 ; i < arr.length ; i++) {
				if(arr[i].value == me_url ) {
					ii = i;
					break;
				}
			}
			me_url = '';
		}
		//触发下级菜单点击事件
		if(!noopen) thisjs.menu_click('id_left_'+v+'_'+ii , v);
	}
	//显示更新缓存对话框
	this.cache_show = function() {
		var obj = kj.obj('#id_cache_clear_html');
		if(obj) {
			this.cache_html = obj.innerHTML;
			kj.remove(obj);
		}
		kj.dialog({'html':this.cache_html,'id':'cache_clear','type':'html','title':'更新缓存','w':300,'h':200,'showbtnmax':false});
	}
	this.cache_clear = function() {
		var o = kj.obj(":cache_clear[]");
		var arr = [];
		for(i = 0 ; i < o.length ; i++) {
			if(o[i].checked) arr[arr.length] = o[i].value;
		}
		this.cache_type = arr;
		kj.dialog.close("#wincache_clear");
		kj.progress.show1.open({id:'cache_clear',title:'正在清除',size:this.cache_type.length,w:500});
		this.cache_clear_go();
	}
	this.cache_clear_go = function() {
		if(this.cache_type.length<1) {
			kj.progress.show1.close('cache_clear');
			kj.alert.show("清除完成");
			return;
		}
		var type = this.cache_type[0];
		this.cache_type.removeat(0);
		kj.ajax("?app_module=sys&app=common&app_act=clear_cache&type=" + type , function(data){
			kj.progress.show1.step('cache_clear');
			thisjs.cache_clear_go();
		});
	}
	//显示修改密码窗口
	this.update_pwd_show = function() {
		var obj = kj.obj('#id_update_pwd_html');
		if(obj) {
			this.update_pwd_html = obj.innerHTML;
			kj.remove(obj);
		}
		kj.dialog({'html':this.update_pwd_html,'id':'update_pwd','type':'html','title':'修改密码','w':300,'h':200,'showbtnmax':false});
	}
	//修改密码
	this.update_pwd = function() {
		var oldpwd = kj.obj("#id_oldpwd");
		var newpwd = kj.obj("#id_newpwd");
		var newpwd2 = kj.obj("#id_newpwd2");
		if(!oldpwd.value) {
			alert('请输入原密码');
			oldpwd.focus();
			return;
		}
		if(!newpwd.value) {
			alert('请输入新密码');
			newpwd.focus();
			return;
		}
		if(newpwd.value==oldpwd.value) {
			alert('新密码与原密码相同');
			newpwd.focus();
			return;
		}
		if(!newpwd2.value) {
			alert('请再次输入新密码');
			newpwd2.focus();
			return;
		}
		if(newpwd.value!=newpwd2.value) {
			alert('两次输入密码不一致');
			newpwd2.focus();
			return;
		}
		kj.ajax("?app_module=sys&app=common&app_act=update_pwd&oldpwd=" + oldpwd.value + "&newpwd=" + newpwd.value , function(data) {
			var obj = kj.json(data);
			if('isnull' in obj) {
				alert("修改密码失败");return;
			}
			if(obj.code=='0') {
				kj.dialog.close("#winupdate_pwd");
				kj.alert.show('修改密码成功');
			} else {
				if('msg' in obj) {
					alert(obj.msg);
				} else {
					alert("修改密码失败");
				}
			}
		});
	}
	//生成官网链接字符串
	this.get_klkkdj_url = function(url) {
		url = kj.urlencode("<?php echo $klkkdj_url;?>" , url);
		return url;
	}
	this.klkkdj_open = function(title,url) {
		url = this.get_klkkdj_url(url);
		kj.dialog({'id':'update','title':title,'url':url,'w':600,'showbtnhide':false,'showbtnmax':false,'type':'iframe','notoolbar':'1'});
	}

	this.hide_left = function(val) {
		if(val) {
			val = 1 ;
			if(me_menu_module!="iframe_main") {
				kj.w("#id_table_left" , 0);
				kj.hide("#id_table_left");
				me_resize()
			};
		} else {
			val = 0;
			if(me_menu_module!="iframe_main") {
				kj.w("#id_table_left" , 126);
				kj.show("#id_table_left");
				me_resize()
			};
		}
		
		kj.ajax.get("common.php?app=config&app_module=user&dir=<?php echo $app_dir;?>&app_act=save_var&var=admin.hide.left&val=" + val , function(data){
		});
	}
	this.reload = function() {
		location.reload(true);
	}

}
</script>
<?php include cls_resolve::on_resolve('/admin\/footer')?>