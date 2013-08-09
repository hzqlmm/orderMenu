<?php include cls_resolve::on_resolve('/admin\/header')?>
<style>
.me_div1{float:left;width:500px}
.me_div1 li{line-height:25px;float:left;width:500px;padding-bottom:10px}
.me_div2{float:left;clear:both}
</style>
<script>
//保存时交验规则
admin.rule['save'] =[];
//店铺选择回调函数
function shop1_callback(o) {
	if("id" in o) kj.obj("#id_ads_shop_id").value=o.id;
	if("name" in o) kj.obj("#id_ads_shop").innerHTML = o.name;
	kj.hide("#windivshop_id_windiv");
}

</script>
<div class="pMenu" id="id_pMenu">
	<li class="sel">基本信息</li>
</div>
<div class="pMain" id="id_main">
<table class='pEditTable'>
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<?php if($version_info['module']=='meal_mall'){?>
<tr>
	<td class="pTabColName">指定店铺：</td><td class="pTabColVal">
		<input type="hidden" name="ads_shop_id" value="<?php echo $editinfo['ads_shop_id'];?>" id="id_ads_shop_id">
		<div class="more1" onmouseover="kj.windiv({'id':'shop_id_windiv','fid':this,'src':'common.php?app=meal&app_act=shop1&url_mode=1'});" id="id_ads_shop" onmouseout="kj.hide('#windivshop_id_windiv');"><?php if(empty($editinfo["ads_shop_id"])){?>选择<?php } else { ?><?php echo $editinfo["shop_name"];?><?php }?></div>
	</td>
	</tr>
<?php }?>
<tr>
	<td class="pTabColName">类&nbsp;&nbsp;型：</td>
	<td class="pTabColVal">
		<select name="ads_type" onchange="thisjs.ontype(this.selectedIndex);" id="id_ads_type">
		<?php foreach($arr_type as $item=>$key){ ?>
			<option value="<?php echo $key;?>"<?php if($key==$editinfo['ads_type']){?> selected<?php }?>><?php echo $item;?></option>
		<?php }?>
		</select>
	</td></tr>
<tr>
	<td class="pTabColName">状&nbsp;&nbsp;态：</td>
	<td class="pTabColVal">
		<select name="ads_state">
		<?php foreach($arr_state as $item=>$key){ ?>
			<option value="<?php echo $key;?>"<?php if($key==$editinfo['ads_state']){?> selected<?php }?>><?php echo $item;?></option>
		<?php }?>
		</select>
	</td></tr>
<tr>
	<td class="pTabColName">标&nbsp;&nbsp;题：</td><td class="pTabColVal"><input type="text" name="ads_title" value="<?php echo $editinfo['ads_title'];?>" class='pTxt1 pTxtL300'></td></tr>
<tr>
	<td class="pTabColName">开放时间：</td><td class="pTabColVal"><input type="text" name="ads_starttime" value="<?php echo $editinfo['ads_starttime'];?>" class='pTxt1 pTxtL150' onfocus="new Calendar().show(this);">&nbsp;&nbsp;<input type="text" name="ads_endtime" value="<?php echo $editinfo['ads_endtime'];?>" class='pTxt1 pTxtL150' onfocus="new Calendar().show(this);"></td>
	</tr>
</table>
<table class='pEditTable' style="margin-top:0px;display:none">
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<tr>
	<td class="pTabColName">图片：</td><td class="pTabColVal"><input type="input" name="pic_url" id="id_pic_url" value="<?php echo $editinfo['fields']['pic_url'];?>" class='pTxt1 pTxtL300'>&nbsp;<a href="javascript:kj.dialog({id:'dialog_attatch',title:'选择图片',url:'common.php?app=other&app_act=attatch&url_objid=id_pic_url',w:600,showbtnhide:false,top:0,type:'iframe'});">选择</a><br><iframe name="frm_pic_url" src="common.php?app=other&app_act=upload&objid=id_pic_url" width="300px" height="30px" frameborder=0 scrolling="no"></iframe></td>
	</tr>
<tr>
	<td class="pTabColName">宽&nbsp;&nbsp;度：</td><td class="pTabColVal"><input type="text" name="pic_w" value="<?php echo $editinfo['fields']['pic_w'];?>" class='pTxt1 pTxtL150'>&nbsp;&nbsp;<span class="pBeta">px</span></td></tr>
<tr>
	<td class="pTabColName">高&nbsp;&nbsp;度：</td><td class="pTabColVal"><input type="text" name="pic_h" value="<?php echo $editinfo['fields']['pic_h'];?>" class='pTxt1 pTxtL150'>&nbsp;&nbsp;<span class="pBeta">px</span></td></tr>
<tr>
	<td class="pTabColName">链&nbsp;&nbsp;接：</td><td class="pTabColVal"><input type="text" name="pic_link" value="<?php echo $editinfo['fields']['pic_link'];?>" class='pTxt1 pTxtL300'></td>
	</tr>
</table>
<table class='pEditTable' style="margin-top:0px;display:none">
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<tr>
	<td class="pTabColName">flash：</td><td class="pTabColVal"><input type="input" name="flash_url" id="id_flash_url" value="<?php echo $editinfo['fields']['flash_url'];?>" class='pTxt1 pTxtL300'>&nbsp;<a href="javascript:kj.dialog({id:'dialog_attatch',title:'选择图片',url:'common.php?app=other&app_act=attatch&url_objid=id_flash_url',w:600,showbtnhide:false,top:0,type:'iframe'});">选择</a><br><iframe name="frm_pic_url" src="common.php?app=other&app_act=upload&objid=id_flash_url" width="300px" height="30px" frameborder=0 scrolling="no"></iframe></td>
	</tr>
<tr>
	<td class="pTabColName">宽&nbsp;&nbsp;度：</td><td class="pTabColVal"><input type="text" name="flash_w" value="<?php echo $editinfo['fields']['flash_w'];?>" class='pTxt1 pTxtL150'>&nbsp;&nbsp;<span class="pBeta">px</span></td></tr>
<tr>
	<td class="pTabColName">高&nbsp;&nbsp;度：</td><td class="pTabColVal"><input type="text" name="flash_h" value="<?php echo $editinfo['fields']['flash_h'];?>" class='pTxt1 pTxtL150'>&nbsp;&nbsp;<span class="pBeta">px</span></td></tr>
<tr>
	<td class="pTabColName">链&nbsp;&nbsp;接：</td><td class="pTabColVal"><input type="text" name="flash_link" value="<?php echo $editinfo['fields']['flash_link'];?>" class='pTxt1 pTxtL300'>&nbsp;&nbsp;<span class="pBeta">为空则默认flash里的链接</span></td>
	</tr>
</table>
<table class='pEditTable' style="margin-top:0px;display:none">
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<tr>
	<td class="pTabColName">内容：</td><td class="pTabColVal"><textarea name="txt_cont" rows="10" cols="50"><?php echo $editinfo['fields']['txt_cont'];?></textarea>&nbsp;&nbsp;<span class="pBeta">支持html与js</span></td>
	</tr>
</table>
<table class='pEditTable' style="margin-top:0px;display:none">
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<tr>
	<td class="pTabColName">宽&nbsp;&nbsp;度：</td><td class="pTabColVal"><input type="text" name="slide1_w" value="<?php echo $editinfo['fields']['slide1_w'];?>" class='pTxt1 pTxtL150'>&nbsp;&nbsp;<span class="pBeta">px</span></td></tr>
<tr>
	<td class="pTabColName">高&nbsp;&nbsp;度：</td><td class="pTabColVal"><input type="text" name="slide1_h" value="<?php echo $editinfo['fields']['slide1_h'];?>" class='pTxt1 pTxtL150'>&nbsp;&nbsp;<span class="pBeta">px</span></td></tr>
<tr>
	<td class="pTabColName">图片列表：</td><td class="pTabColVal">
	<div class="me_div1" id="id_slide1">
	<li style="display:none">
	标题：<input type="input" name="slide1_txt[]" value="" class='pTxt1 pTxtL300'><br>
	链接：<input type="input" name="slide1_link[]" value="" class='pTxt1 pTxtL300'><br>
	图片：<input type="input" name="slide1_url[]" id="url_THISID" value="" class='pTxt1 pTxtL300'>&nbsp;<a href="javascript:kj.dialog({id:'dialog_attatch',title:'选择图片',url:'common.php?app=other&app_act=attatch&url_objid=url_THISID',w:600,showbtnhide:false,top:0,type:'iframe'});">选择</a>&nbsp;&nbsp;[<a href="javascript:kj.remove('#THISID');">删除</a>]<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<iframe name="frm_THISID" src="common.php?app=other&app_act=upload&objid=url_THISID" width="300px" height="30px" frameborder=0 scrolling="no"></iframe></li>
	<?php foreach($editinfo['fields']['slide1'] as $key=>$item){ ?>
	<li id="id_slide_<?php echo $key;?>">
	标题：<input type="input" name="slide1_txt[]" value="<?php echo $item['txt'];?>" class='pTxt1 pTxtL300'><br>
	链接：<input type="input" name="slide1_link[]" value="<?php echo $item['link'];?>" class='pTxt1 pTxtL300'><br>
	图片：<input type="input" name="slide1_url[]" id="id_slide1_<?php echo $key;?>" value="<?php echo $item['url'];?>" class='pTxt1 pTxtL300'>&nbsp;<a href="javascript:kj.dialog({id:'dialog_attatch',title:'选择图片',url:'common.php?app=other&app_act=attatch&url_objid=id_slide1_<?php echo $key;?>',w:600,showbtnhide:false,top:0,type:'iframe'});">选择</a>&nbsp;&nbsp;[<a href="javascript:kj.remove('#id_slide_<?php echo $key;?>');">删除</a>]<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<iframe name="frm_slide1_<?php echo $key;?>" src="common.php?app=other&app_act=upload&objid=id_slide1_<?php echo $key;?>" width="300px" height="30px" frameborder=0 scrolling="no"></iframe>	
	</li>
	<?php }?>
	</div>
	<div class="me_div2"><input type="button" name="btn_slide_add" value="添加" onclick="thisjs.slide1_add();"></div>
	</td>
	</tr>
</table>
</div>
<div class="pFootAct" id="id_pFootAct">
	<li>
	<input type="button" name="dosubmit" value="保存" onclick="admin.frm_ajax('save');" class="pBtn">
	</li>
</div>
<script>
var thisjs = new function() {
	this.ontype = function(id) {
		id++;
		var arr = kj.obj(".pEditTable");
		for(var i = 1 ; i < arr.length ; i++) {
			if(i != id && arr[i].style.display!='none') arr[i].style.display = 'none';
			if(i == id && arr[i].style.display == 'none') arr[i].style.display = '';
		}
	}
	this.slide1_add = function(){
		var arr = kj.obj("#id_slide1 li");
		if(!arr) return;
		if( !('length' in arr) || arr.length < 1 ) return;

		var obj_div = document.createElement("li");
		var str_id = "id" + Math.random();
		str_id = str_id.replace(/\./g, "");
		obj_div.id = str_id;
		obj_div.className = arr[0].className;
		obj_div.innerHTML = arr[0].innerHTML.replace(/THISID/g,obj_div.id);
		kj.obj("#id_slide1").appendChild(obj_div);
	}
}
kj.onload(function(){
	thisjs.ontype(kj.obj("#id_ads_type").selectedIndex);
});
function attatch_callback() {
	kj.dialog.close("#windialog_attatch");
}
</script>
<?php include cls_resolve::on_resolve('/admin\/footer')?>