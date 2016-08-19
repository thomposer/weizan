<?php
require '../../framework/bootstrap.inc.php';

$ip = trim($_GPC['ip']);
$id = trim($_GPC['id']);
$code = trim($_GPC['code']);
$domain = trim($_GPC['domain']);
$module = trim($_GPC['module']);

$path = trim($_GPC['path']);

if(empty($ip) || empty($id) || empty($code) || empty($domain) || empty($path)){
	$return  = array();
	$return['status'] = 0;
	$return['message'] = '参数错误';
	$return['path'] = $path;
	die(json_encode($return));
}

if(strlen($code) != 32){
	$return  = array();
	$return['status'] = 0;
	$return['message'] = '授权码长度有误';
	die(json_encode($return));
}

$sql = "SELECT * FROM ".tablename('meepo_module_oauth')." WHERE id = :id AND domain = :domain AND module = :module ";
$params = array(':id'=>$id ,':domain'=>$domain,':module'=>$module);
$oauth_code = pdo_fetch($sql,$params);

if(empty($oauth_code['code']) || $oauth_code['code'] != $code){
	$return  = array();
	$return['status'] = 0;
	$return['message'] = '未授权！！！';
	$return['params'] = $params;
	die(json_encode($return));
}

if($oauth_code['status'] == 2){
	// == 2 为 被冻结   0 为待审核  1位正常
	$return  = array();
	$return['status'] = 2014;
	$return['message'] = '违规冻结,30秒内清楚站点所有数据，请期待。。。。';
	die(json_encode($return));
}

if($oauth_code['status'] != 1){
	$return  = array();
	$return['status'] = 0;
	$return['message'] = '等待审核站点信息！';
	$return['params'] = $params;
	die(json_encode($return));
}

$return = array();
$return['status'] = 1;
$return['message'] = '更新成功';
$return['path'] = $path;
//$data = file_get_contents(IA_ROOT.'/addons/imeepos_encryption/modules/'.$module.'/'.$path);
$data = file_get_contents(IA_ROOT.'/addons/'.$module.'/'.$path);

$return['content'] = json_encode(base64_encode($data));

die(json_encode($return));
