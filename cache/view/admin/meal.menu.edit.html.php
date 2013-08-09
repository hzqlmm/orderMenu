<?php include cls_resolve::on_resolve('/admin\/header')?>
<script>
//保存时效验规则
admin.rule['save'] =[
];
function upload_callback(info){
	var obj = kj.json(info);
	if('url' in obj) {
		kj.obj("#id_menu_pic").value=obj.url;
		kj.obj("#id_img_menu_pic").src = kj.url_view(obj.url);
	}
	if('url_small' in obj) {
		kj.obj("#id_menu_pic_small").value = obj.url_small;
		kj.obj("#id_img_menu_pic_small").src = kj.url_view(obj.url_small);
	}
}
function upload_callback_small(info){
	var obj = kj.json(info);
	if('url' in obj) {
		kj.obj("#id_menu_pic_small").value = obj.url;
		kj.obj("#id_img_menu_pic_small").src = kj.url_view(obj.url);
	}
}
function attatch_callback(o) {
	if('objid' in o) {
		if(o.objid == 'id_menu_pic') {
			kj.obj("#id_img_menu_pic").src = kj.url_view(kj.obj("#id_menu_pic").value);
		} else {
			kj.obj("#id_img_menu_pic_small").src = kj.url_view(kj.obj("#id_menu_pic_small").value);
		}
	}
	kj.dialog.close("#windialog_attatch");
}

</script>
<div class="pMenu" id="id_pMenu">
	<li class="sel" onclick="admin.edittabel(0);">基本信息</li>
	<li onclick="admin.edittabel(1);">时间设置</li>
</div>
<div class="pMain" id="id_main">
<table class='pEditTable'>
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<tr>
	<td class="pTabColName">类 型：</td>
	<td class="pTabColVal">
		<select name="menu_type">
		<?php foreach($arr_menu_type as $item=>$key){ ?>
			<option value="<?php echo $key;?>"<?php if($key==$editinfo['menu_type']){?> selected<?php }?>><?php echo $item;?></option>
		<?php }?>
		</select>
	</td></tr>
<tr>
	<td class="pTabColName">状 态：</td>
	<td class="pTabColVal">
		<select name="menu_state">
		<?php foreach($arr_state as $item=>$key){ ?>
			<option value="<?php echo $key;?>"<?php if($key==$editinfo['menu_state']){?> selected<?php }?>><?php echo $item;?></option>
		<?php }?>
		</select>
	</td></tr>
<tr>
	<td class="pTabColName">所属组：</td>
	<td class="pTabColVal">
		<?php echo $editinfo["html_group"];?>
	</td></tr>
<tr>
	<td class="pTabColName">名称：</td><td class="pTabColVal"><input type="input" name="menu_title" value="<?php echo $editinfo['menu_title'];?>" class='pTxt1 pTxtL150'></td>
	</tr>
<tr>
	<td class="pTabColName">主料：</td><td class="pTabColVal"><input type="input" name="menu_intro" value="<?php echo $editinfo['menu_intro'];?>" class='pTxt1 pTxtL150'></td>
	</tr>
<tr>
	<td class="pTabColName">数量：</td><td class="pTabColVal"><input type="input" name="menu_num" value="<?php echo $editinfo['menu_num'];?>" class='pTxt1 pTxtL150'></td>
	</tr>
<tr>
	<td class="pTabColName">价格：</td><td class="pTabColVal"><input type="input" name="menu_price" value="<?php echo $editinfo['menu_price'];?>" class='pTxt1 pTxtL60'> 元</td></tr>
<tr>
	<td class="pTabColName">图片：</td><td class="pTabColVal"><span style="float:left"><input type="input" name="menu_pic" id="id_menu_pic" value="<?php echo $editinfo['menu_pic'];?>" class='pTxt1 pTxtL150'>&nbsp;<a href="javascript:kj.dialog({id:'dialog_attatch',title:'选择图片',url:'common.php?app=other&app_act=attatch&url_objid=id_menu_pic',w:400,showbtnhide:false,top:0,type:'iframe'});">选择</a><br><iframe name="frm_article_pic_big" src="common.php?app=other&app_act=upload&small=1" width="300px" height="30px" frameborder=0 scrolling="no"></iframe></span><span style="float:left;margin-left:5px"><img src="<?php echo fun_get::html_url($editinfo['menu_pic']);?>" width="60px" height="60px" id="id_img_menu_pic" onclick="kj.pic.preview(this.src);"onerror="this.src='/webcss/common/images/no_pic.jpg'"></span></td>
	</tr>
<tr>
	<td class="pTabColName">小图：</td><td class="pTabColVal"><span style="float:left"><input type="input" name="menu_pic_small" id="id_menu_pic_small" value="<?php echo $editinfo['menu_pic_small'];?>" class='pTxt1 pTxtL150'>&nbsp;<a href="javascript:kj.dialog({id:'dialog_attatch',title:'选择图片',url:'common.php?app=other&app_act=attatch&url_objid=id_menu_pic_small',w:400,showbtnhide:false,top:0,type:'iframe'});">选择</a><br><iframe name="frm_article_pic" src="common.php?app=other&app_act=upload&callback=upload_callback_samll" width="300px" height="30px" frameborder=0 scrolling="no"></iframe></span><span style="float:left;margin-left:5px"><img src="<?php echo fun_get::html_url($editinfo['menu_pic']);?>" width="60px" height="60px" id="id_img_menu_pic_small" onclick="kj.pic.preview(this.src);"onerror="this.src='/webcss/common/images/no_pic.jpg'"></span></td>
	</tr>
<tr>
	<td class="pTabColName">排序：</td><td class="pTabColVal"><input type="input" name="menu_sort" value="<?php echo $editinfo['menu_sort'];?>" class='pTxt1 pTxtL150'></td>
	</tr>
</table>
<!--label 1 end-->
<table class='pEditTable' style='display:none'>
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<tr>
	<td class="pTabColName">提供模式：</td><td class="pTabColVal"><label><input type="radio" name="menu_mode" value="0" checked onclick="thisjs.mode(0);">每天</label>&nbsp;&nbsp;<label><input type="radio" name="menu_mode" value="1"<?php if($editinfo['menu_mode']==1){?> checked<?php }?> onclick="thisjs.mode(1);">按星期</label>&nbsp;&nbsp;<label><input type="radio" name="menu_mode" value="3"<?php if($editinfo['menu_mode']==3){?> checked<?php }?> onclick="thisjs.mode(3);">按日期</label>&nbsp;&nbsp;<label><input type="radio" name="menu_mode" value="2"<?php if($editinfo['menu_mode']==2){?> checked<?php }?> onclick="thisjs.mode(2);">自定义</label></td></tr>
<tr style="<?php if($editinfo['menu_mode']!=0){?> display:none<?php }?>" class="id_mode_0">
	<td class="pTabColName"></td><td class="pTabColVal"><span class="pBeta">即每天都提供此菜预订</span></td></tr>
<tr style="<?php if($editinfo['menu_mode']!=2){?> display:none<?php }?>" class="id_mode_2">
	<td class="pTabColName"></td><td class="pTabColVal"><span class="pBeta">在当日菜单自定义添加</span></td></tr>
<tr style="<?php if($editinfo['menu_mode']!=1){?> display:none<?php }?>" class="id_mode_1">
	<td class="pTabColName">按星期：</td><td class="pTabColVal"><label><input type="checkbox" name="menu_weekday[]" value="1"<?php if(in_array('1',$editinfo['weekday'])){?> checked<?php }?>>周一</label>&nbsp;&nbsp;<label><input type="checkbox" name="menu_weekday[]" value="2"<?php if(in_array('2',$editinfo['weekday'])){?> checked<?php }?>>周二</label>&nbsp;&nbsp;<label><input type="checkbox" name="menu_weekday[]" value="3"<?php if(in_array('3',$editinfo['weekday'])){?> checked<?php }?>>周三</label>&nbsp;&nbsp;<label><input type="checkbox" name="menu_weekday[]" value="4"<?php if(in_array('4',$editinfo['weekday'])){?> checked<?php }?>>周四</label>&nbsp;&nbsp;<label><input type="checkbox" name="menu_weekday[]" value="5"<?php if(in_array('5',$editinfo['weekday'])){?> checked<?php }?>>周五</label>&nbsp;&nbsp;<label><input type="checkbox" name="menu_weekday[]" value="6"<?php if(in_array('6',$editinfo['weekday'])){?> checked<?php }?>>周六</label>&nbsp;&nbsp;<label><input type="checkbox" name="menu_weekday[]" value="0"<?php if(in_array('0',$editinfo['weekday'])){?> checked<?php }?>>周天</label>&nbsp;&nbsp;</td></tr>
<tr style="<?php if($editinfo['menu_mode']!=1){?> display:none<?php }?>" class="id_mode_1">
	<td class="pTabColName">节假日：</td><td class="pTabColVal"><label><input type="checkbox" name="menu_holiday" value="1"<?php if($editinfo['menu_holiday']==1){?> checked<?php }?>></label></td></tr>
<tr style="<?php if($editinfo['menu_mode']!=3){?> display:none<?php }?>" class="id_mode_3">
	<td class="pTabColName">按日期：</td><td class="pTabColVal">
	<?php for($i=1;$i<32;$i++){ ?>
	<label><input type="checkbox" name="menu_date[]" value="<?php echo $i;?>"<?php if(in_array($i,$editinfo['date'])){?> checked<?php }?>><?php echo $i;?>号</label>&nbsp;&nbsp;
	<?php }?>
	</td></tr>
</table>
<!--label 2 end-->
</div>
<div class="pFootAct" id="id_pFootAct">
	<li>
	<input type="button" name="dosubmit" value="保存" onclick="admin.frm_ajax('save');" class="pBtn">
	</li>
</div>
<script>
var thisjs = new function() {
	this.mode = function(val) {
		switch(val) {
			case 0:
				kj.show(".id_mode_0");
				kj.hide(".id_mode_1");
				kj.hide(".id_mode_2");
				kj.hide(".id_mode_3");
				break;
			case 1:
				kj.hide(".id_mode_0");
				kj.show(".id_mode_1");
				kj.hide(".id_mode_3");
				kj.hide(".id_mode_2");
				break;
			case 2:
				kj.hide(".id_mode_0");
				kj.hide(".id_mode_1");
				kj.hide(".id_mode_3");
				kj.show(".id_mode_2");
				break;
			case 3:
				kj.hide(".id_mode_0");
				kj.hide(".id_mode_1");
				kj.hide(".id_mode_2");
				kj.show(".id_mode_3");
				break;
		}
	}
}
</script>
<?php include cls_resolve::on_resolve('/admin\/footer')?>