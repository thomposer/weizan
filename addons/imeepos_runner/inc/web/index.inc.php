<?php
global $_W,$_GPC;

load()->model('mc');
$actions = array();
$tasktable = 'imeepos_runner_tasks';
if(!pdo_tableexists('imeepos_runner_feedback')){
	$act = trim($_GPC['act']);
	$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_feedback')." WHERE uniacid = :uniacid AND status = :status ";
	$params = array(':uniacid'=>$_W['uniacid'],':status'=>0);
	$feedbacknum = pdo_fetchcolumn($sql,$params);
	//跑腿认证待审核
	$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_runner')." WHERE uniacid = :uniacid AND status = :status ";
	$params = array(':uniacid'=>$_W['uniacid'],':status'=>0);
	$runnernum = pdo_fetchcolumn($sql,$params);
	//提现待审核
	$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_log')." WHERE uniacid = :uniacid AND status = :status ";
	$params = array(':uniacid'=>$_W['uniacid'],':status'=>0);
	$withdrawnum = pdo_fetchcolumn($sql,$params);
	//店铺待审核
	$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_shop')." WHERE uniacid = :uniacid AND status = :status ";
	$params = array(':uniacid'=>$_W['uniacid'],':status'=>0);
	$shopnum = pdo_fetchcolumn($sql,$params);
}
if(!pdo_tableexists('imeepos_runner_tasks')){
	//统计信息
	$day_num = !empty($settings['stat']['msg_maxday']) ? $settings['stat']['msg_maxday'] : 30;
	if($_W['ispost']) {
		$starttime = strtotime("-{$day_num} day");
		$endtime = time();
		$data_hit = pdo_fetchall("SELECT * FROM ".tablename($tasktable)." WHERE uniacid = :uniacid AND createtime >= :starttime AND createtime <= :endtime", array(':uniacid' => $_W['uniacid'], ':starttime' => $starttime, ':endtime' => $endtime));
	
		for($i = $day_num; $i >= 0; $i--){
			$key = date('m-d', strtotime('-' . $i . 'day'));
			$days[] = $key;
			$datasets[$key] = 0;
		}
	
		foreach($data_hit as $da) {
			$key1 = date('m-d', $da['createtime']);
			if(in_array($key1, $days)) {
				$datasets[$key1]++;
			}
		}
	
		$todaytimestamp = strtotime(date('Y-m-d'));
		$monthtimestamp = strtotime(date('Y-m'));
		$stat['month'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($tasktable)." WHERE uniacid = :uniacid AND createtime >= '$monthtimestamp'", array(':uniacid' => $_W['uniacid']));
		$stat['today'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($tasktable)." WHERE uniacid = :uniacid AND createtime >= '$todaytimestamp'", array(':uniacid' => $_W['uniacid']));
		$stat['rule'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($tasktable)." WHERE uniacid = :uniacid ", array(':uniacid' => $_W['uniacid']));
		$stat['m_name'] = $m_name;
	
		exit(json_encode(array('key' => $days, 'value' => array_values($datasets), 'stat' => $stat)));
	}
}

include $this->template('index');
