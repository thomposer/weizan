<?php 
global $_W,$_GPC;

pdo_update('modules',array('isrulefields'=>1),array('name'=>'imeepos_runner'));
//pdo_update('modules',array('version'=>'7.1'),array('name'=>'imeepos_runner'));

$sql = "SELECT * FROM ".tablename('modules_bindings')." WHERE module = :module AND entry = :entry AND do = :do";
$params = array(':module'=>'imeepos_runner',':entry'=>'menu',':do'=>'plugin_list');
$item = pdo_fetch($sql,$params);

if(empty($item)){
	$data = array();
	$data['module'] = 'imeepos_runner';
	$data['entry'] = 'menu';
	$data['title'] = '插件管理';
	$data['do'] = 'plugin_list';
	$data['direct'] = 0;
	$data['displayorder'] = 0;
	
	pdo_insert('modules_bindings',$data);
}

