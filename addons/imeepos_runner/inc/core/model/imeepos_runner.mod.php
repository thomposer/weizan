<?php
function getSystemSetting(){
	global $_W;
	$default = array();
	$default['title'] = '小明跑腿';
	$default['tel'] = '666666';
	$default['logo'] = tomedia('../addons/imeepos_runner/icon.jpg');
	$default['iconloading_img'] = tomedia('../addons/imeepo_runner/plugin/page/view/mobile/img/splash_bg.png');
	
	$table = 'imeepos_runner_settings';
	$field = 'set';
	$sql = "SELECT `{$field}` FROM ".tablename($table)." WHERE `uniacid` = :uniacid ";
	
	$params = array(':uniacid'=>$_W['uniacid']);
	$item = pdo_fetch($sql,$params);
	
	$data = iunserializer($item[$field]);
	foreach ($default as $key=>$de){
		if(empty($data[$key])){
			$data[$key] = $de;
		}
	}
	return $data;
}


function getAdvs(){
	global $_W;
	$tablename = 'imeepos_runner_adv';
	$sql = "SELECT * FROM ".tablename($tablename)." WHERE uniacid = :uniacid AND isfull = :isfull AND status = :status AND starttime <= :starttime AND endtime >= :endtime";
	$params = array(':uniacid'=>$_W['uniacid'],':isfull'=>0,':status'=>1,':starttime'=>strtotime(date('Y-m-d',time())),':endtime'=>strtotime(date('Y-m-d',time())));
	$advs = pdo_fetchall($sql,$params);
	foreach ($advs as $adv){
		$adv['image'] = tomedia($adv['image']);
		$list[] = $adv;
	}
	return $list;
}

function getFullAdvs(){
	global $_W;
	$tablename = 'imeepos_runner_adv';
	$sql = "SELECT * FROM ".tablename($tablename)." WHERE uniacid = :uniacid AND isfull = :isfull AND status = :status AND starttime <= :starttime AND endtime >= :endtime";
	$params = array(':uniacid'=>$_W['uniacid'],':isfull'=>1,':status'=>1,':starttime'=>strtotime(date('Y-m-d',time())),':endtime'=>strtotime(date('Y-m-d',time())));
	$advs = pdo_fetchall($sql,$params);
	foreach ($advs as $adv){
		$adv['image'] = tomedia($adv['image']);
		$list[] = $adv;
	}
	return $list;
}

function getNavs(){
	global $_W;
	$tablename = 'imeepos_runner_nav';
	$sql = "SELECT * FROM ".tablename($tablename)." WHERE uniacid = :uniacid";
	$params = array(':uniacid'=>$_W['uniacid']);
	$advs = pdo_fetchall($sql,$params);
	foreach ($advs as $adv){
		$adv['icon'] = tomedia($adv['icon']);
		$list[] = $adv;
	}
	return $list;
}