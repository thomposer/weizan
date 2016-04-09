<?php 
global $_W,$_GPC;

$table = "imeepos_runner3_setting";
$code = 'divider_set';

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

if(empty($item['start_fee'])){
	$item['start_fee'] = '';
}
if(empty($item['start_km'])){
	$item['start_km'] = '';
}
if(empty($item['start_kg'])){
	$item['start_kg'] = '';
}

if(empty($item['start_time'])){
	$item['start_time'] = '';
}
if(empty($item['end_time'])){
	$item['end_time'] = '';
}
if(empty($item['time_fee'])){
	$item['time_fee'] = '';
}

if(empty($item['limit_km_km'])){
	$item['limit_km_km'] = '';
}
if(empty($item['limit_km_fee'])){
	$item['limit_km_fee'] = '';
}
if(empty($item['limit_kg_kg'])){
	$item['limit_kg_kg'] = '';
}
if(empty($item['limit_kg_fee'])){
	$item['limit_kg_fee'] = '';
}
if(empty($item['limit_fee_num'])){
	$item['limit_fee_num'] = '';
}
if(empty($item['limit_fee_fee'])){
	$item['limit_fee_fee'] = '';
}

include $this->template('web/template/divider_set');