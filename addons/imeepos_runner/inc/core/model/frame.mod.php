<?php

function _calc_current_frames3(&$frames) {
	global $controller, $action,$plugin,$code,$act;
	if(!empty($frames) && is_array($frames)) {
		foreach($frames as &$frame) {
			if(empty($frame['items'])) continue;
			foreach($frame['items'] as &$fr) {
				$query = parse_url($fr['url'], PHP_URL_QUERY);
				parse_str($query, $urls);
				if(defined('ACTIVE_FRAME_URL')) {
					$query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
					parse_str($query, $get);
				} else {
					$get = $_GET;
					$get['c'] = $controller;
					$get['a'] = $action;
					$get['plugin'] = $plugin;
					$get['code'] = $code;
				}
				if(!empty($do)) {
					$get['do'] = $do;
				}
				$diff = array_diff_assoc($urls, $get);
				if(empty($diff)) {
					$fr['active'] = ' active';
				}
			}
		}
	}
}
function _calc_current_frames2(&$frames) {
	global $_W,$_GPC,$frames;
	if(!empty($frames) && is_array($frames)) {
		foreach($frames as &$frame) {
			if(!empty($frame['items'])){
				foreach($frame['items'] as &$fr) {
					$query = parse_url($fr['url'], PHP_URL_QUERY);
					parse_str($query, $urls);
					if(defined('ACTIVE_FRAME_URL')) {
						$query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
						parse_str($query, $get);
					} else {
						$get = $_GET;
					}
					if(!empty($_GPC['a'])) {
						$get['a'] = $_GPC['a'];
					}
					if(!empty($_GPC['c'])) {
						$get['c'] = $_GPC['c'];
					}
					if(!empty($_GPC['do'])) {
						$get['do'] = $_GPC['do'];
					}
					if(!empty($_GPC['plugin'])) {
						$get['plugin'] = $_GPC['plugin'];
					}
					if(!empty($_GPC['code'])) {
						$get['code'] = $_GPC['code'];
					}
					if(!empty($_GPC['state'])) {
						$get['state'] = $_GPC['state'];
					}
					if(!empty($_GPC['op'])) {
						$get['op'] = $_GPC['op'];
					}
					if(!empty($_GPC['m'])) {
						$get['m'] = $_GPC['m'];
					}
					$diff = array_diff_assoc($urls, $get);
					if(empty($diff)) {
						$fr['active'] = 'active';
					}
				}
			}
		}
	}
}

function getTopNav($name){
	global $_W;
	$navs = array();

	$nav = array();
	$nav['name'] = 'meepo_logistics';
	$nav['append_title'] = '';
	$nav['title'] = '小明跑腿';
	$navs[] = $nav;
	return $navs;
}

function getModuleFrames($name){
	global $_W;
	$frames = array();

	$frames['index']['title'] = '概述';
	$frames['index']['icon'] = 'fa fa-home';
	$frames['index']['items'] = array();
	$frames['index']['items']['index']['url'] = url('site/entry/index/',array('m'=>$name));
	$frames['index']['items']['index']['title'] = '概述';
	$frames['index']['items']['index']['actions'] = array();
	$frames['index']['items']['index']['active'] = '';
	

	if(pdo_tableexists('meepo_common_menu') && pdo_tableexists('meepo_common_menu_items')){
		$sql = "SELECT * FROM ".tablename('meepo_common_menu')." WHERE module = :module";
		$params = array(':module'=>$name);
		$menus = pdo_fetchall($sql,$params);
		if(!empty($menus)){
			foreach ($menus as $menu){
				$frames[$menu['code']]['title'] = $menu['title'];
				$frames[$menu['code']]['icon'] = $menu['icon'];
				$sql = "SELECT * FROM ".tablename('meepo_common_menu_items')." WHERE menuid = :menuid";
				$params = array(':menuid'=>$menu['id']);
				$items = pdo_fetchall($sql,$params);
				$frames[$menu['code']]['items'] = array();
				foreach ($items as $item){
					$frames[$menu['code']]['items'][$item['code']]['url'] = url('site/entry/doplugin/',array('m'=>$name,'code'=>$item['code'],'plugin'=>$menu['code']));
					$frames[$menu['code']]['items'][$item['code']]['title'] = $item['title'];
					$frames[$menu['code']]['items'][$item['code']]['actions'] = array();
					$frames[$menu['code']]['items'][$item['code']]['active'] = '';
				}
			}
		}
	}

	if($_W['role'] == 'founder'){

		$frames['sys']['title'] = '站长特权';
		$frames['sys']['icon'] = 'fa fa-user';
		$frames['sys']['items'] = array();

		$frames['sys']['items']['plugin']['url'] = url('site/entry/plugin/',array('m'=>$name));
		$frames['sys']['items']['plugin']['title'] = '插件管理';
		$frames['sys']['items']['plugin']['actions'] = array();
		$frames['sys']['items']['plugin']['active'] = '';

		$frames['sys']['items']['cloud']['url'] = url('site/entry/cloud/',array('m'=>$name));
		$frames['sys']['items']['cloud']['title'] = '云服务';
		$frames['sys']['items']['cloud']['actions'] = array();
		$frames['sys']['items']['cloud']['active'] = '';
	}
	return $frames;
}
