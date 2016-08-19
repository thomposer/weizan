<?php 
global $_W,$_GPC;
$_share = $this->_share;
$template = $this->getTemplate(true);
if($_W['container'] == 'wechat'){
	M('member')->update();
}
$share = array();

$runner = array('tasks','runner','runner_money','index');

M('recive');

$setting = M('setting')->getValue('v_set');
$limit_runner_look = intval($setting['limit_runner_look']);
if($limit_runner_look == 1){
	$do = $_GPC['do'];
	if(in_array($do,$runner)){
		$member = M('member')->getInfo($_W['openid']);
		if(empty($member['isrunner'])){
			$message = '对不起，您没有相应权限，请前往认证审核！';
			$url = $this->createMobileUrl(v);
			include $this->template('error');
			exit();
		}
	}
}