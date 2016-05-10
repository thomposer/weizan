<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
$indexpx = intval($_GPC['indexpx']);
		$indexpxf = intval($_GPC['indexpxf']);
		if (empty($page)){$page = 1;}
		$where = '';
		$now = time();
		$starttime = empty($_GPC['time']['start']) ?  strtotime(date("Y-m-d H:i", $now - 2592000)) : strtotime($_GPC['time']['start']);
		$endtime = empty($_GPC['time']['end']) ?  strtotime(date("Y-m-d H:i", $now)) : strtotime($_GPC['time']['end']);
		if (!empty($starttime) && !empty($endtime)) {
			$where .= " AND createtime >= " . $starttime; 
			$where .= " AND createtime < " . $endtime; 
		}
		$tagid = $_GPC['category']['childid'];
		$tagpid = $_GPC['category']['parentid'];
		$tags = pdo_fetchall("SELECT * FROM ".tablename($this->table_tags)." WHERE rid = :rid ".$uni." ORDER BY id DESC", array(':rid' => $rid));
		$tagname = $this->gettagname($tagid,$tagpid,$rid);
		
		if (!empty($tagid)) {
			$where .= " AND tagid = '".$tagid."'";
		}elseif (!empty($tagpid)) {
			$where .= " AND tagpid = '".$tagpid."'";
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 15;
		$order = '';
		//0 按最新排序 1 按人气排序 3 按投票数排序
		if ($indexpx == '-1') {
			$order .= " `createtime` DESC";
		}elseif ($indexpx == '1') {
			$order .= " `hits` + `xnhits` DESC";
		}elseif ($indexpx == '2') {
			$order .= " `photosnum` + `xnphotosnum` DESC";
		}
		
		//0 按最新排序 1 按人气排序 3 按投票数排序  倒叙
		if ($indexpxf == '-1') {
			$order .= " `createtime` ASC";
		}elseif ($indexpxf == '1') {
			$order .= " `hits` + `xnhits` ASC";
		}elseif ($indexpxf == '2') {
			$order .= " `photosnum` + `xnphotosnum` ASC";
		}
		
		if (empty($indexpx) && empty($indexpxf)) {
			$order .= " `photosnum` + `xnphotosnum` DESC";
		}
		
		
		//取得用户列表
		$list_praise = pdo_fetchall('SELECT * FROM '.tablename($this->table_users).' WHERE rid= :rid '.$where.$uni.' order by '.$order.' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, array(':rid' => $rid) );
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_users).' WHERE rid= :rid '.$where.$uni.' ', array(':rid' => $rid));
		$pager = pagination($total, $pindex, $psize);
		include $this->template('web/rankinglist');
