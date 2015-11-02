<?php
/**
 * [WeiZan System] Copyright (c) 2014 WeiZan.Com
 * WeiZan is NOT a free software, it under the license terms, visited http://www.012wz.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
if(empty($_W['isfounder'])) {
	message('访问非法.');
}
$_W['page']['title'] = '云服务 - 管理应用商城 - 切换应用商城';
	load()->model('setting');
	if(checksubmit('submit')) {
		$data = array(
			'addons_url' => $_GPC['addons_url'],
			'c_url' => $_GPC['c_url'],
		);
		setting_save($data, 'addons');
		message('更新设置成功！', 'refresh');
	}

template('cloud/addons');

