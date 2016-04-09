<?php 
global $_W,$_GPC;
$act = trim($_GPC['act']);
$act = !empty($act)?$act:'list';

if(!pdo_fieldexists('imeepos_runner3_member','status')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `status` tinyint(4) DEFAULT '1'";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_member','nickname')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `nickname` varchar(64) DEFAULT ''";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_member','uid')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `uid` int(11) DEFAULT '0'";
	pdo_query($sql);
}

if($act == 'list'){
	$sql = "SELECT * FROM ".tablename('imeepos_runner3_member')." WHERE uniacid = :uniacid ";
	$params = array(':uniacid'=>$_W['uniacid']);
	$list = pdo_fetchall($sql,$params);

	foreach ($list as &$li){
		if($li['status'] == 0){
			$li['statustitle'] = '待审核';
			$li['status_label'] = 'label-danger';
		}else{
			$li['statustitle'] = '审核通过';
			$li['status_label'] = 'label-info';
		}
		
		if($li['isrunner'] == 0){
			$li['isrunnertitle'] = '否';
			$li['isrunner_label'] = 'label-danger';
		}else{
			$li['isrunnertitle'] = '是';
			$li['isrunner_label'] = 'label-info';
		}
	}
}

if($act == 'add'){
	$data = array();
	$input = $_GPC['__input'];
	$data['status'] = intval($input['status']);
	$data['isrunner'] = intval($input['isrunner']);
	
	if(!empty($input['id'])){
		pdo_update('imeepos_runner3_member',$data,array('id'=>$input['id']));
	}
	die();
}

if($act == 'delete'){
	$id = intval($_GPC['id']);
	pdo_delete('imeepos_runner3_member',array('id'=>$id));
	die();
}

include $this->template('web/task/v');
