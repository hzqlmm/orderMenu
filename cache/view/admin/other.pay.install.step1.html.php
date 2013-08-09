<?php include cls_resolve::on_resolve('/admin\/header')?>
<style>
.me_div{float:left;width:90%;margin-top:20px}
.me_div li{float:left;padding:8px 0px 5px 20px;clear:both;}
.me_div .x_tit{font-weight:bold}
.me_div1{float:left;width:90%;margin-top:20px}
.me_div1 li{float:left;padding:8px 0px 5px 20px;clear:both}
.me_div1 .x_tit{font-weight:bold}
.me_div2{float:left;width:90%}
.me_div2 li{float:left;padding:8px 0px 5px 67px;clear:both;color:#888888}
.me_div2 .x_sel{background:url(/webcss/admin/images/arrow.gif) no-repeat 55px 12px}
.me_div2 .x_sel1{color:#000000}
</style>
<div class="pMain" id="id_main">
<?php if($user_info['grade']['val']<$pay_info['grade']){?>
	当前授权级别:<?php echo $user_info['grade']['name'];?>，无法安装组件，提升级别
<?php } else { ?>
	<div class="me_div" id="id_down">
	<li class="x_tit">第一步，下载组件</li>
	<li>方法一：<a href="javascript:thisjs.down()" style="color:#004499">在线安装</a> <span class="pBeta">(推荐)</span></li>
	<li>方法二：<a href="<?php echo $down_url;?>" style="color:#004499" target="_blank">下载到本地</a>  <span class="pBeta">(需要解压按说明操作)</span></li>
	<?php if($package == true){?>
		<li style="color:#ff0000;"><h1>发现已经存在安装包，<a href="javascript:thisjs.install();" style="color:#004499">点击进入安装</a></h1></li>
	<?php } else if($package_zip == true) { ?>
		<li style="color:#0000ff;"><h1>发现已经存在压缩安装包，<a href="javascript:thisjs.install();" style="color:#004499">点击解压</a></h1></li>
	<?php }?>
	</div>
	<div id="id_downing" style="display:none" style="width:100%">
		<div class="me_div1">
		<li class="x_tit" style="text-align:left;font-weight:200;font-size:14px">正在下载(<span id="id_downing_txt"></span>)<br><br>如果长时间没反应，请<a href="javascript:thisjs.backdown();" style="color:#ff8800">返回手动下载</a></li>
		</div>
	</div>
	<div id="id_install" style="display:none" style="width:100%">
		<div class="me_div1">
		<li class="x_tit">第二步，安装组件</li>
		</div>
		<div class="me_div2" id="id_step">
		</div>
	</div>
<?php }?>
</div>
<script>
var thisjs = new function() {
	this.steps = [];
	this.step = 0;
	this.downstop = true;
	this.downtimer = function() {
		if(this.downstop) return;
		var val = kj.toint(kj.obj("#id_downing_txt").innerHTML)-1;
		if(val<0) return;
		kj.obj("#id_downing_txt").innerHTML = val;
		setTimeout("thisjs.downtimer()",1000);
	}
	this.backdown = function() {
		kj.hide("#id_downing");
		kj.show("#id_down");
		this.downstop = true;
	}
	this.down = function() {
		kj.show("#id_downing");
		kj.hide("#id_down");
		kj.obj("#id_downing_txt").innerHTML = 90;
		this.downstop = false;
		this.downtimer();
		kj.ajax.get("<?php echo fun_get::url(array('app_act'=>'down'));?>&zipname=<?php echo $pay_info['zipname'];?>",function(data){
			this.downstop = true;
			var obj_data = kj.json(data);
			if(obj_data.isnull) {
				alert("下载失败");
			} else {
				if('code' in obj_data && obj_data.code=='0') {
					thisjs.install();
				} else {
					if('msg' in obj_data) {
						alert(obj_data.msg);
					} else {
						alert("下载失败");
					}
				}
			}
		});
	}
	this.install = function() {
		kj.hide("#id_down");
		kj.hide("#id_downing");
		kj.show("#id_install");
		kj.ajax.get("<?php echo fun_get::url(array('app_act'=>'install_steps'));?>",function(data){
			var obj_data = kj.json(data);
			if(obj_data.isnull) {
				alert("安装失败");
			} else {
				if('code' in obj_data && obj_data.code=='0') {
					var html = '';
					thisjs.steps = [];
					for(var i=0;i<obj_data.steps.length;i++){
						html += "<li id='id_step_" + i + "'>" + obj_data.steps[i].name + "</li>";
						thisjs.steps[thisjs.steps.length] = obj_data.steps[i];
					}
					kj.obj("#id_step").innerHTML = html;
					thisjs.start();
				} else {
					if('msg' in obj_data) {
						alert(obj_data.msg);
					} else {
						alert("下载失败");
					}
				}
			}
		});
	}

	this.start = function() {
		kj.delClassName("#id_step li" , "x_sel");
		if(this.step>=this.steps.length) {
			kj.obj("#id_step").innerHTML = kj.obj("#id_step").innerHTML + "<li style='color:#ff8800'>安装完成</li>";
			kj.alert.show("安装完成" , function(){parent.thisjs.refresh();});
			return;
		}
		var arr = kj.obj("#id_step li");
		kj.addClassName(arr[this.step] , 'x_sel');
		if( 'cfg' in this.steps[this.step] && this.steps[this.step].cfg != '') {
			var title = arr[this.step].innerHTML;
			kj.obj("#id_step_"+this.step).innerHTML += "<span class='xx_next'>&nbsp;&nbsp;<a href=\"javascript:kj.remove('#id_step_" + this.step + " .xx_next');thisjs.step++;thisjs.start();\" style='color:#ff0000'>跳过</a></span>";
			parent.thisjs.dialog({'title':title,'url':this.steps[this.step].cfg,'w':600,'showbtnhide':false,'showbtnmax':false,'type':'iframe','notoolbar':'1'},function(){
				thisjs.step++;
				thisjs.start();
			});
		} else {
			kj.ajax.get("<?php echo fun_get::url(array('app_act'=>'install'));?>&step=" + this.step , function(data){
				var obj_data = kj.json(data);
				if(obj_data.isnull) {
					alert("安装失败");
				} else {
					if('code' in obj_data && obj_data.code=='0') {
						kj.addClassName("#id_step_" + thisjs.step, 'x_sel1');
						thisjs.step++;
						thisjs.start();
					} else {
						if('msg' in obj_data) {
							alert(obj_data.msg);
						} else {
							alert("安装失败");
						}
					}
				}
			});
		}
	}
}
</script>
<?php include cls_resolve::on_resolve('/admin\/footer')?>