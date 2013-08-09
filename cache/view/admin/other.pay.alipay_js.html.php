<?php include cls_resolve::on_resolve('/admin\/header')?>
<input type="hidden" name="payname" value="<?php echo fun_get::get('payname');?>">
<div class="pMenu" id="id_pMenu">
	<li class="sel" onclick="admin.edittabel(0);">账号信息</li>
</div>
<div class="pMain" id="id_main">
<table class='pEditTable'>
<tr class='pTabTitRow'><td class='pTabTitCol' colspan="2"></td></tr>
<tr>
	<td class="pTabColName">支付方式名称：</td>
	<td class="pTabColVal"><input type="text" name="title" value="<?php echo $edit_info['title'];?>" class='pTxt1 pTxtL150'></td></tr>
<tr>
	<td class="pTabColName">交易货币类型：</td>
	<td class="pTabColVal">人民币(￥)</td></tr>
<tr>
	<td class="pTabColName">支付宝账户：</td>
	<td class="pTabColVal"><input type="text" name="email" value="<?php echo $edit_info['email'];?>" class='pTxt1 pTxtL150'></td></tr>
<tr>
	<td class="pTabColName">合作者身份(parterID)：</td>
	<td class="pTabColVal"><input type="text" name="parterid" value="<?php echo $edit_info['parterid'];?>" class='pTxt1 pTxtL150'></td></tr>
<tr>
	<td class="pTabColName">交易安全效验码：</td>
	<td class="pTabColVal"><input type="text" name="key" value="<?php echo $edit_info['key'];?>" class='pTxt1 pTxtL300'></td></tr>
<tr>
	<td class="pTabColName">支付手续费设计：</td>
	<td class="pTabColVal"><label><input type="radio" onclick="thisjs.feetype(0);" name="feetype" value="0" checked>按比例收费</label>&nbsp;&nbsp;<label><input type="radio" onclick="thisjs.feetype(1);" name="feetype" value="1"<?php if($edit_info['feetype'] == 1){?> checked<?php }?>>固定费用</label>
	<br><br>
	<span id="id_feetype_name0"<?php if($edit_info['feetype'] == 1){?> style='display:none'<?php }?>>金额：</span>
	<span id="id_feetype_name1"<?php if($edit_info['feetype'] != 1){?> style='display:none'<?php }?>>费率：</span>
	<input type="text" name="feeval" value="<?php echo $edit_info['feeval'];?>" class='pTxt1 pTxtL60'>
	<span id="id_feetype_beta0"<?php if($edit_info['feetype'] == 1){?> style='display:none'<?php }?>>&nbsp;&nbsp;说明：顾客每笔订单需要支付的手续费；</span>
	<span id="id_feetype_beta1"<?php if($edit_info['feetype'] != 1){?> style='display:none'<?php }?>>%&nbsp;&nbsp;说明：顾客将支付订单总金额乘以此费率作为手续费；</span>
	</td></tr>
<tr>
	<td class="pTabColName">接口状态：</td>
	<td class="pTabColVal"><select name="state"><option value="1">启用</option><option value="0"<?php if(empty($edit_info['state'])){?> selected<?php }?>>关闭</option></select></td></tr>

</table>
<!--label 1 end-->
</div>
<div class="pFootAct" id="id_pFootAct">
	<li>
	<input type="button" name="dosubmit" value="保存" onclick="admin.frm_ajax('save');" class="pBtn">
	</li>
</div>
<script>
var thisjs = new function() {
	this.feetype = function(val) {
		if(val == 0) {
			kj.show("#id_feetype_name0");
			kj.hide("#id_feetype_name1");
			kj.show("#id_feetype_beta0");
			kj.hide("#id_feetype_beta1");
		} else {
			kj.hide("#id_feetype_name0");
			kj.show("#id_feetype_name1");
			kj.hide("#id_feetype_beta0");
			kj.show("#id_feetype_beta1");
		}
	}
}
</script>
<?php include cls_resolve::on_resolve('/admin\/footer')?>