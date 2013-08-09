<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo cls_config::get("site_title","sys");?></title>
<meta name="keywords" content="<?php echo cls_config::get("keywords","sys");?>"/>
<meta name="description" content="<?php echo cls_config::get("description","sys");?>"/>
<link rel="stylesheet" type="text/css" href="/webcss/common/images/common.css"/>
<link rel="stylesheet" type="text/css" href="/webcss/common/images/expand.css"/>
<link rel="stylesheet" type="text/css" href="/webcss/default/images/css.css"/>
<script src="<?php echo cls_config::get("dirpath","base");?>/common.php?app=sys&app_act=web.config&app_ajax=1"></script>
<script src="/webcss/common/js/kj.js"></script>
<script src="/webcss/common/js/kj.page.js"></script>
<script src="/webcss/common/js/kj.dialog.js"></script>
<script src="/webcss/common/js/kj.ajax.js"></script>
<style>
body{background:#fff}
</style>
</head>
<body style="overflow-x:hidden">
<div class="myvip">
	<div class="info">尊敬的会员：<font class="txt_orangeB"><?php echo $this_login_user->uname;?></font> ，您当前预付款为：<font class="txt_redB">￥<?php echo $arr_list["repayment"];?></font><br>充值金额：<input type="text" name="payval" value="" class="pTxt1 pTxtL150" id="id_payval">&nbsp;&nbsp;<input type="button" name="btn_pay" value="立即充值" class="button2" onclick="thisjs.show_paymethod()"></div>
	<div class="tit">
		<span style="width:150px;">时间</span>
		<span style="width:100px;">存入(元)</span>
		<span style="width:100px;">消耗(元)</span>
		<span style="width:100px;">账户余额(元)</span>
		<span style="width:230px;">详情</span>
	</div>
	<?php $repayment=0;?>
	<?php foreach($arr_list["list"] as $item){ ?>
	<div class="list">
		<span class="x1"><?php echo $item["repayment_addtime"];?></span>
		<span class="x2"><?php if($item["repayment_val"]>0){?>+<?php echo $item["repayment_val"];?><?php }?></span>
		<span class="x3"><?php if($item["repayment_val"]<0){?><?php echo $item["repayment_val"];?><?php }?></span>
		<span class="x5"><?php echo $arr_list["repayment"]-$repayment;?></span>
		<span class="x6"><?php echo $item["beta"];?></span>
		<?php $repayment+=$item["repayment_val"];?>
   </div>
	<?php }?>
</div>
<div class="pPage" id="id_pPage" style="margin-top:20px">
<?php echo $arr_list['pagebtns'];?>
</div>
<div id="id_paymethod_box" style="display:none">
	<div style="float:left;padding:10px 0px 0px 10px;line-height:30px">
		<?php foreach($arr_pay as $item => $key){ ?>
			<?php if(!empty($key['state'])){?>
				<label><input type="radio" name="paymethod" value="<?php echo $item;?>"><?php echo $key['fields']['title'];?></label><br>
			<?php }?>
		<?php }?><br><br>
		<input type="button" name="btn_state_ok" value="确认支付" onclick="thisjs.pay();" class="btn_bg3">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="btn_state_cancel" value="取消" onclick="kj.dialog.close('#winpaymethod_box');" class="btn_bg3">
	</div>
</div>
<script>
var thisjs = new function() {
	//显示支付方式选择框
	this.show_paymethod = function() {
		var obj = kj.obj('#id_paymethod_box');
		if(obj) {
			this.state_html = obj.innerHTML;
			kj.remove(obj);
		}
		kj.dialog({'html':this.state_html,'id':'paymethod_box','type':'html','title':'选择支付方式','w':300,'showbtnmax':false});
	}
	//跳转支付
	this.pay = function() {
		var val = kj.obj("#id_payval").value;
		var obj = kj.obj(":paymethod");
		var pay_method = '';
		for(var i = 0 ; i < obj.length ; i++) {
			if(obj[i].checked) {
				pay_method = obj[i].value;
				break;
			}
		}
		if(pay_method == '') {
			alert("请选择支付方式");
			return;
		}
		window.open("?app=member&app_act=repayment_pay&val=" + val + "&pay_method=" + pay_method, "_blank");
	}
}
</script>
</body>
</html>