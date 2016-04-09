<?php
global $_W,$_GPC;
include MODULE_ROOT.'/inc/web/__init.php';
$id = 0;
//pdo_query("DROP table ".tablename('imeepos_runner_adv'));
if(!pdo_tableexists('imeepos_runner_adv')){
	$sql = "CREATE TABLE ".tablename('imeepos_runner_adv')." (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) unsigned NOT NULL,
	  `title` varchar(132) NOT NULL,
	  `link` varchar(132) NOT NULL,
	  `image` varchar(320) NOT NULL,
	  `status` tinyint(2) unsigned NOT NULL,
	  `openid` varchar(64) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

$table = 'imeepos_runner_adv';

$act = trim($_GPC['act']);
$act = !empty($act)?$act:'list';

if($act == 'list'){
	$sql = "SELECT * FROM ".tablename($table)." WHERE uniacid = :uniacid";
	$params = array(':uniacid'=>$_W['uniacid']);
	$list = pdo_fetchall($sql,$params);
	if(!empty($list)){
		foreach ($list as &$li){
			if($li['status'] == 0){
				$li['statustitle'] = '禁止';
				$li['status_label'] = 'label-danger';
			}else{
				$li['statustitle'] = '开启';
				$li['status_label'] = 'label-info';
			}
		}
	}
}

if($act == 'add'){
	$data = array();
	$post = $_GPC['__input'];
	$data = array();
	$data['status'] = $post['status'];
	$data['title'] = $post['title'];
	$data['image'] = tomedia($post['image']);
	$data['link'] = $post['link'];

	if(!empty($post['id'])){
		pdo_update($table,$data,array('id'=>$post['id']));
		$data['id'] = $post['id'];
	}else{
		$data['uniacid'] = $_W['uniacid'];
		pdo_insert($table,$data);
		$data['id'] = pdo_insertid();
	}
	die(json_encode(array('data'=>$data)));
}


if($act == 'delete'){
	$id = intval($_GPC['fid']);
	pdo_delete($table,array('id'=>$id));
}

include $this->template('web/adv_template');