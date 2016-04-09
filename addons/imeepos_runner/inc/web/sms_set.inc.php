<?php 
global $_W,$_GPC;

$table = "imeepos_runner3_setting";
$code = 'sms_set';

//pdo_delete($table);

$sql = "SELECT * FROM ".tablename($table)." WHERE uniacid = :uniacid AND code = :code";
$params = array(':uniacid'=>$_W['uniacid'],':code'=>$code);
$setting = pdo_fetch($sql,$params);

$item = iunserializer($setting['value']);
$ali_sms = $item;

if($_W['ispost']){

	$data = array();
	$data['uniacid'] = $_W['uniacid'];
	$data['code'] = $code;
	$data['value'] = iserializer($_POST);
	if(empty($setting)){
		pdo_insert($table,$data);
	}else{
		pdo_update($table,$data,array('id'=>$setting['id']));
	}

	message('提交成功',referer(),success);
}


if(!isset($ali_sms['appkey'])){
	$ali_sms['appkey'] = '';
}
if(!isset($ali_sms['appsecret'])){
	$ali_sms['appsecret'] = '';
}
if(!isset($ali_sms['signname'])){
	$ali_sms['signname'] = '';
}
if(!isset($ali_sms['moban_num'])){
	$ali_sms['moban_num'] = '';
}
include $this->template('web/template/sms_set');