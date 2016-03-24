<?php
load()->model('mc');

function imc_notice_fetch($str=''){
	global $_W;
	$sql = "SELECT * FROM ".tablename('imeepos_runner_settings')." WHERE uniacid = :uniacid";
	$params = array(':uniacid'=>$_W['uniacid']);
	
	$setting = pdo_fetch($sql,$params);
	$setting = iunserializer($setting['template_message']);
	
	return $setting[$str];
}
/*
 * 跑腿经验变动通知
 * TM00230	积分变动通知	IT科技	互联网|电子商务
 * */
function imc_notice_runner_credit_change($openid, $uid = 0, $num = 0, $url = '', $remark = '') {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	if(!$uid || !$num || empty($openid)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$user = imc_fetch_member($uid);
	$time = date('Y-m-d H:i');
	if(empty($url)) {
		$url = murl('mc/bond/credits', array('credittype' => 'credit2'), true, true);
	}
	$templateid = imc_notice_fetch('credit');
	if($_W['account']['level'] == 4 && !empty($templateid)) {
		$data = array(
			'first' => array(
				'value' => "新增跑腿积分{$num},当前跑腿积分{$user['credit_runner']}",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $user['nickname'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => $time,
				'color' => '#ff510'
			),
			'keyword3' => array(
				'value' => $num,
				'color' => '#ff510'
			),
			'keyword4' => array(
				'value' => $user['credit_runner'],
				'color' => '#ff510'
			),
			'keyword5' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, trim($templateid), $data, $url);
	} else {
		$info = "跑腿积分变动通知\n";
		$info .= "新增跑腿积分{$num},当前跑腿积分{$user['credit_runner']}\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}

/*
 * 跑腿红包变动通知
 * TM00230	积分变动通知	IT科技	互联网|电子商务
 * */
function imc_notice_runner_red_credit_change($openid, $uid = 0, $num = 0, $url = '', $remark = '') {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	if(!$uid || !$num || empty($openid)) {
		return error(-1, '参数错误');
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$user = imc_fetch_member($uid);
	$time = date('Y-m-d H:i');
	if(empty($url)) {
		$url = murl('mc/bond/credits', array('credittype' => 'credit2'), true, true);
	}
	$templateid = imc_notice_fetch('credit');
	if($_W['account']['level'] == 4 && !empty($templateid)) {
		$data = array(
			'first' => array(
				'value' => "新增红包{$num},当前跑腿积分{$user['credit_red']}",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $user['nickname'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => $time,
				'color' => '#ff510'
			),
			'keyword3' => array(
				'value' => $num,
				'color' => '#ff510'
			),
			'keyword4' => array(
				'value' => $user['credit_red'],
				'color' => '#ff510'
			),
			'keyword5' => array(
				'value' => "{$remark}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, trim($templateid), $data, $url);
	} else {
		$info = "跑腿红包变动通知\n";
		$info .= "新增跑腿红包{$num}元,当前跑腿红包{$user['credit_runner']}\n";
		$info .= !empty($remark) ? "备注：{$remark}\n\n" : '';
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}

function imc_notice_task_recive($openid,$task = array(),$url) {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}
	$time = date('Y-m-d H:i',time() + 7*24*60*60);
	
	$templateid = imc_notice_fetch('new');
	if($_W['account']['level'] == 4 && !empty($templateid)) {
		$data = array(
			'first' => array(
				'value' => "您发布的任务被{$recive['nickname']}抢单",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $task['desc'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => '任务接单',
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, trim($templateid), $data, $url);
	} else {
		$info = "抢单提醒\n";
		$info .= "任务简介：{$task['desc']}\n";
		$info .= "通知类型：任务被抢\n";
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}

function imc_notice_task_finish($openid,$task = array(),$url) {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}
	$time = date('Y-m-d H:i',time() + 7*24*60*60);
	
	$templateid = imc_notice_fetch('new');
	if($_W['account']['level'] == 4 && !empty($templateid)) {
		$data = array(
			'first' => array(
				'value' => "任务完成提醒",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $task['desc'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => '任务完成提醒',
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, trim($templateid), $data, $url);
	} else {
		$info = "任务完成提醒\n";
		$info .= "任务简介：{$task['desc']}\n";
		$info .= "通知类型：任务完成提醒\n";
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}

function imc_notice_task_check($openid,$task = array(),$url) {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}
	$time = date('Y-m-d H:i',time() + 7*24*60*60);
	
	$templateid = imc_notice_fetch('new');
	if($_W['account']['level'] == 4 && !empty($templateid)) {
		$data = array(
			'first' => array(
				'value' => "接单者身份核实成功",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $task['desc'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => '身份核实',
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, trim($templateid), $data, $url);
	} else {
		$info = "身份核实提醒\n";
		$info .= "任务简介：{$task['desc']}\n";
		$info .= "通知类型：接单者身份核实成功\n";
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}

function imc_notice_task_post_success($openid,$task = array(),$url) {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}
	$time = date('Y-m-d H:i',time() + 7*24*60*60);
	
	$templateid = imc_notice_fetch('new');
	if($_W['account']['level'] == 4 && !empty($templateid)) {
		$data = array(
			'first' => array(
				'value' => "恭喜您的任务发布成功",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $task['desc'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => $task['ctitle'],
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, trim($templateid), $data, $url);
	} else {
		$info = "任务发布成功提醒\n";
		$info .= "任务简介：{$task['desc']}\n";
		$info .= "所属类目：{$task['ctitle']}\n";
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}

function imc_notice_task_new($openid,$task = array(),$url) {
	global $_W;
	if(!$uid) {
		$uid = $_W['member']['uid'];
	}
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}

	$time = date('Y-m-d H:i',time() + 7*24*60*60);
	
	$templateid = imc_notice_fetch('new');
	if($_W['account']['level'] == 4 && !empty($templateid)) {
		$data = array(
			'first' => array(
				'value' => "新任务提醒",
				'color' => '#ff510'
			),
			'keyword1' => array(
				'value' => $task['ctitle'],
				'color' => '#ff510'
			),
			'keyword2' => array(
				'value' => $task['fee'],
				'color' => '#ff510'
			),
			'keyword3' => array(
				'value' => $time,
				'color' => '#ff510'
			),
			'keyword4' => array(
				'value' => $task['peoplelimit'].'人',
				'color' => '#ff510'
			),
			'keyword5' => array(
				'value' => "{$task['desc']}" ,
				'color' => '#ff510'
			),
		);
		$status = $acc->sendTplNotice($openid, trim($templateid), $data, $url);
	} else {
		$info = "新任务提醒\n";
		$info .= "任务简介：{$task['desc']}\n";
		$info .= "所属类目：{$task['ctitle']}\n";
		$info .= "悬赏金额：{$task['fee']}\n";
		$info .= "有效时间：".$time."\n";
		$info .= "需求数量：".$task['peoplelimit']."人\n";
		$info .= "<a href='{$url}'>点击查看详情</a>";
		$custom = array(
			'msgtype' => 'text',
			'text' => array('content' => urlencode($info)),
			'touser' => $openid,
		);
		$status = $acc->sendCustomNotice($custom);
	}
	return $status;
}
/*
 * mc_notice_custom_text
 * */
 function imc_notice_custom_text($info, $openid = ''){
 	global $_W;
	$acc = mc_notice_init();
	if(is_error($acc)) {
		return error(-1, $acc['message']);
	}
	$openid = trim($openid);
	if(empty($openid)) {
		$openid = trim($_W['openid']);
	}
	if(empty($openid)) {
		return error(-1, '粉丝openid错误');
	}
	$custom = array(
		'msgtype' => 'text',
		'text' => array('content' => urlencode($info)),
		'touser' => $openid,
	);
	$status = $acc->sendCustomNotice($custom);
	return $status;
 }
/*
 * 获取会员，不存在返回false，存在返回会员
 */
function imc_fetch_member($uid = 0,$fields = array()){
	global $_W;
	load()->model('mc');
	if(empty($uid)){
		$uid = $_W['openid'];
	}
	$uid = mc_openid2uid($uid);
	if(empty($uid)){
		return false;
	}
	if(empty($fields)){
		$field = '*';
	}else{
		$field = '`' . implode('`,`', $fields) . '`';
	}
	$sql = "SELECT $field FROM ".tablename('imeepos_runner_member')." WHERE uniacid = :uniacid AND uid = :uid";
	$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid);
	$member = pdo_fetch($sql,$params);
	if(empty($member)){
		$member = array();
	}
	
	$sql = "SELECT $field FROM ".tablename('imeepos_runner_member_profile')." WHERE uniacid = :uniacid AND uid = :uid";
	$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid);
	$profile = pdo_fetch($sql,$params);
	if(!empty($profile)){
		$member = array_merge($member,$profile);
	}
	
	$user = mc_fetch($uid,array('avatar','nickname','credit2','resideprovince','residecity','gender'));
	if(!empty($user)){
		$member = array_merge($member,$user);
	}
	
	if($user['gender'] == 1){
		$member['gender'] = '男';
	}
	if($user['gender'] == 2){
		$member['gender'] = '女';
	}
	if($user['gender'] == 0){
		$member['gender'] = '未知';
	}
	
	if(empty($member)){
		return false;
	}else{
		return $member;
	}
}
/*
 * 获取跑腿员，不存在返回false，存在返回会员
 */
function imc_fetch_runner($uid = 0,$fields = array()){
	global $_W;
	load()->model('mc');
	$uid = mc_openid2uid($uid);
	if(empty($uid)){
		return false;
	}
	if(empty($fields)){
		$field = '*';
	}else{
		$field = '`' . implode('`,`', $fields) . '`';
	}
	$sql = "SELECT $field FROM ".tablename('imeepos_runner_runner')." WHERE uniacid = :uniacid AND uid = :uid";
	$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid);
	$member = pdo_fetch($sql,$params);
	
	if(empty($member)){
		return false;
	}else{
		return true;
	}
}