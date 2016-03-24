<?php

/*
 * 模板函数
 * */

function taskList($params) {
	global $_W;
	$_GPC = $params;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE uniacid = :uniacid AND status = :status ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
	$params = array(':uniacid' => $_W['uniacid'], ':status' => 1);
	$list = pdo_fetchall($sql, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('imeepos_runner_tasks') . " WHERE uniacid = :uniacid AND status = :status", $params);
	$lists = array();
	foreach ($list as $li) {
		$user = mc_fetch($li['uid'], array('avatar', 'nickname'));
		$l['avatar'] = tomedia($user['avatar']);
		$l['nickname'] = $user['nickname'];
		$l['uid'] = $li['uid'];
		$l['id'] = $li['id'];
		$l['desc'] = trim($li['desc']);
		$l['fee'] = $li['fee'];

		$sql = "SELECT title FROM " . tablename('imeepos_runner_class') . " WHERE id = :id";
		$params = array(':id' => $li['cid']);
		$class = pdo_fetch($sql, $params);
		$l['ctitle'] = !empty($class['title']) ? $class['title'] : '普通任务';

		$l['endaddress'] = $li['endaddress'];
		$l['endlat'] = $li['endlat'];
		$l['endlng'] = $li['endlng'];
		$l['startaddress'] = $li['startaddress'];
		$l['startlat'] = $li['startlng'];
		$l['startlng'] = $li['startlng'];

		$l['link'] = murl('entry', array('m' => 'imeepos_runner', 'do' => 'task', 'act' => 'detail', 'id' => $li['id']));
		$lists[] = $l;
	}
	unset($l);
	unset($list);
	return $lists;
}

function shopList($params) {
	global $_W;
	$_GPC = $params;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$sql = "SELECT * FROM " . tablename('imeepos_runner_shop') . " WHERE uniacid = :uniacid ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
	$params = array(':uniacid' => $_W['uniacid']);
	$list = pdo_fetchall($sql, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('imeepos_runner_shop') . " WHERE uniacid = :uniacid ", $params);
	$lists = array();

	foreach ($list as $li) {
		$l['id'] = $li['id'];
		$l['title'] = $li['title'];
		$l['desc'] = trim($li['desc']);
		$l['image'] = tomedia($li['icon']);

		if (empty($l['image'])) {
			$l['image'] = tomedia($li['image']);
		}

		$l['link'] = murl('entry', array('m' => 'imeepos_runner', 'do' => 'shop', 'act' => 'detail', 'id' => $li['id']));
		$lists[] = $l;
	}

	unset($l);
	unset($list);
	return $lists;
}

function recives($params) {
	global $_W;
	$_GPC = $params;

}

function messages($params) {

}
