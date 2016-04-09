<?php
global $_W,$_GPC;

$table = "imeepos_runner3_setting";
$code = 'card_set';

//pdo_delete($table);

$sql = "SELECT * FROM ".tablename($table)." WHERE uniacid = :uniacid AND code = :code";
$params = array(':uniacid'=>$_W['uniacid'],':code'=>$code);
$setting = pdo_fetch($sql,$params);

$item = iunserializer($setting['value']);
$settings = $item;

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

include $this->template('web/template/card_set');