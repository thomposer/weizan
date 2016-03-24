<?php
global $_W,$_GPC;

mload()->model('imc');

$acts = array('quhuo','shouhuo');
$input = $_GPC['__input'];

$act = trim($input['act']);
$task_uid = intval($input['task_uid']);
$task_id = intval($input['task_id']);

if(empty($task_id)){
	$data = array();
	$data['code'] = -1;
	$data['message'] = '订单数据错误，请重新生成二维码！';
	die(json_encode($data));
}

if(empty($task_uid)){
	$data = array();
	$data['code'] = -1;
	$data['message'] = '发布任务人信息有误，请重新生成二维码！';
	die(json_encode($data));
}
if($this->isMe()){}
if(empty($_W['member']['uid'])){
	$data = array();
	$data['code'] = -1;
	$data['message'] = '登陆失效';
	die(json_encode($data));
}

$sql = "SELECT * FROM ".tablename('imeepos_runner_tasks')." WHERE id = :id";
$params = array(':id'=>$task_id);
$task = pdo_fetch($sql,$params);

if(empty($task)){
	$data = array();
	$data['code'] = -1;
	$data['message'] = '任务不存在或已删除！';
	die(json_encode($data));
}


$sql = "SELECT * FROM ".tablename('imeepos_runner_tasks_recive')." WHERE taskid = :taskid AND from_uid = :uid";
$params = array(':taskid'=>$task_id,':uid'=>$_W['member']['uid']);
$recive = pdo_fetch($sql,$params);

if(empty($recive)){
	$data = array();
	$data['code'] = -1;
	$data['message'] = '接单人信息不存在或已删除！';
	die(json_encode($data));
}

if($act == 'quhuo'){
	//更新订单状态，更新任务状态
	pdo_update('imeepos_runner_tasks_recive',array('status'=>1),array('id'=>$recive['id']));
	$url = $_W['siteroot'].'/app/'.$this->createMobileUrl('index');
	imc_notice_task_check($task['openid'], $task, $url);
	$data = array();
	$data['code'] = -1;
	$data['message'] = '身份核实成功！';
	die(json_encode($data));
}

if($act == 'shouhuo'){
	//更新订单状态，更新任务状态
	pdo_update('imeepos_runner_tasks_recive',array('status'=>2),array('id'=>$recive['id']));
	$url = $_W['siteroot'].'/app/'.$this->createMobileUrl('index');
	imc_notice_task_finish($task['openid'], $task, $url);
	$data = array();
	$data['code'] = -1;
	$data['message'] = '提交完成任务操作成功！';
	die(json_encode($data));
}


$data = array();
$data['code'] = -1;
$data['message'] = '未知错误！';
die(json_encode($data));