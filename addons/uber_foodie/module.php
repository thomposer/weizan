<?php
/**
 * 吃货众生相
 */
defined('IN_IA') or exit('Access Denied');
class Uber_FoodieModule extends WeModule {
 
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		if(checksubmit()) {
			$dat = array(
                'guide_url' => $_GPC['guide_url'],
				'title' => $_GPC['title'],
				'cardid' => $_GPC['cardid'],
				);
			if (!$this->saveSettings($dat)) {
				message('保存参数设置失败','','error');
			} else {
				message('保存参数设置成功','','success');
			}
		}
		
		// 模板中需要用到 "tpl" 表单控件函数的话, 记得一定要调用此方法.
		load()->func('tpl');
		
		//这里来展示设置项表单
		include $this->template('settings');
	}

}