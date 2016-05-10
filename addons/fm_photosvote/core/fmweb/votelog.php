<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
$afrom_user = $_GPC['afrom_user'];
		$tfrom_user = $_GPC['tfrom_user'];
		load()->model('mc');
		$where = "";
		$keyword = $_GPC['keyword'];
		if (!empty($keyword)){
			$where .= " AND nickname LIKE '%{$keyword}%'";				
			$where .= " OR ip LIKE '%{$keyword}%'";	
			$where .= " OR from_user LIKE '%{$keyword}%'";	
			$t = pdo_fetchall("SELECT from_user FROM ".tablename($this->table_users)." WHERE rid = :rid and nickname LIKE '%{$keyword}%' '.$uni.'", array(':rid' => $rid));
			foreach ($t as $row) {
				$where .= " OR tfrom_user LIKE '%{$row['from_user']}%'";
			}
		}
		if (!empty($_GPC['isdel'])) {
			if ($_GPC['isdel'] == -1) {
				$isdel = 0;
			}else{
				$isdel = 1;
			}
			$where .= "AND is_del =".$isdel;
		}
		$now = time();
		$starttime = empty($_GPC['time']['start']) ?  strtotime(date("Y-m-d H:i", $now - 2592000)) : strtotime($_GPC['time']['start']);
		$endtime = empty($_GPC['time']['end']) ?  strtotime(date("Y-m-d H:i", $now + 86400)) : strtotime($_GPC['time']['end']);
		if (!empty($starttime) && !empty($endtime)) {
			$where .= " AND createtime >= " . $starttime; 
			$where .= " AND createtime < " . $endtime; 
		}

		if (!empty($tfrom_user)){
		$where .= " AND `tfrom_user` = '{$tfrom_user}'";		
		}
		if (!empty($afrom_user)){
			$where .= " AND `afrom_user` = '{$afrom_user}'";		
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 15;

		
		$votelogs = pdo_fetchall('SELECT * FROM '.tablename($this->table_log).' WHERE `rid` = '.$rid.' '.$where.$uni.'   order by `createtime` desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize);
		
		
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE `rid` = '.$rid.' '.$where.$uni.'  order by `createtime` desc ');
		$pager = pagination($total, $pindex, $psize);
		include $this->template('web/votelog');
