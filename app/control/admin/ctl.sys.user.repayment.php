<?php
/* 
 * 
 * 
 * 
 */

class ctl_sys_user_repayment extends mod_sys_user_repayment {

	//默认浏览页
	function act_default() {
		//分页列表
		$this->arr_list = $this->get_pagelist();
		return $this->get_view(); //显示页面
	}
}