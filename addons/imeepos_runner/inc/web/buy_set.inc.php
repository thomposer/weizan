<?php 
global $_W,$_GPC;
$table = "imeepos_runner3_setting";
$code = 'buy_set';

//pdo_delete($table);

$sql = "SELECT * FROM ".tablename($table)." WHERE uniacid = :uniacid AND code = :code";
$params = array(':uniacid'=>$_W['uniacid'],':code'=>$code);
$setting = pdo_fetch($sql,$params);

$item = iunserializer($setting['value']);

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

if(empty($item['day_start_time'])){
	$item['day_start_time'] = '';
}
if(empty($item['day_end_time'])){
	$item['day_end_time'] = '';
}
if(empty($item['day_start'])){
	$item['day_start'] = '';
}
if(empty($item['day_min'])){
	$item['day_min'] = '';
}
if(empty($item['day_max'])){
	$item['day_max'] = '';
}

if(empty($item['night_start_time'])){
	$item['night_start_time'] = '';
}
if(empty($item['night_end_time'])){
	$item['night_end_time'] = '';
}
if(empty($item['night_start'])){
	$item['night_start'] = '';
}
if(empty($item['night_min'])){
	$item['night_min'] = '';
}
if(empty($item['night_max'])){
	$item['night_max'] = '';
}

include $this->template('web/template/buy_set');