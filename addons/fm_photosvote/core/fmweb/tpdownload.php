<?php
/**
 * 女神来了导出
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 */
if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');
global $_GPC,$_W;
$rid= intval($_GPC['rid']);
$uniacid = $_W['uniacid'];
if(empty($rid)){
    message('抱歉，传递的参数错误！','', 'error');              
}
	$afrom_user = $_GPC['afrom_user'];
	$tfrom_user = $_GPC['tfrom_user'];
	$keyword = $_GPC['keyword'];

	if ($_GPC['uni_all_users'] != 1) {
		if ($uniacid != $_GPC['uniacid']) {
			$uni = " AND uniacid = ".$uniacid;
		}
	}

	$where = "";
	$starttime = $_GPC['start_time'];
	$endtime = $_GPC['end_time'];
	if (!empty($starttime) && !empty($endtime)) {
		$where .= " AND createtime >= " . $starttime; 
		$where .= " AND createtime < " . $endtime; 
	}
	if (!empty($keyword)){			
			$where .= " AND nickname LIKE '%{$keyword}%'";				
			$where .= " OR ip LIKE '%{$keyword}%'";	
			$t = pdo_fetchall("SELECT from_user FROM ".tablename($this->table_users)." WHERE uniacid = :uniacid and  rid = :rid and nickname LIKE '%{$keyword}%' ", array(':uniacid' => $uniacid, ':rid' => $rid));
			foreach ($t as $row) {
				$where .= " OR tfrom_user LIKE '%{$row['from_user']}%'";
			}
	}
	
	if (!empty($tfrom_user)){
	$where .= " AND `tfrom_user` = '{$tfrom_user}'";		
	}
	if (!empty($afrom_user)){
		$where .= " AND `afrom_user` = '{$afrom_user}'";		
	}
	
	$list = pdo_fetchall('SELECT * FROM '.tablename($this->table_log).' WHERE rid= :rid '.$where.$uni.'  ORDER BY `createtime` ASC', array(':rid' => $rid) );
	
if ($_GPC['type'] == 1) {	    
	$tableheader = array('ID', '投票人', '真实姓名','手机', '投票数', '投票是否付费', '投票来源' ,'被投票人','联系方式', '拉票人','投票IP','投票国家','投票城市','投票地区', '状态','封禁状态', '投票时间' );
	$html = "\xEF\xBB\xBF";
	foreach ($tableheader as $value) {
		$html .= $value . "\t ,";
	}
	$html .= "\n";
	foreach ($list as $mid => $value) {
		$fuser = $this->_getuser($value['rid'], $value['tfrom_user']);
		$auser = $this->_auser($value['rid'], $value['afrom_user']);
		$iparr = iunserializer($value['iparr']);
		if (!empty($value['realname'])){
			$username = $value['realname'];
		}elseif (!empty($value['nickname'])){
			$username = $value['nickname'];
		}else{
			$username = $value['from_user'];
		}
		if (!empty($value['ordersn'])){
			$votetype = '付费投票';
		}else{
			$votetype = '免费投票';
		}
		if ($value['is_del'] == 1){
			$status = '无效票（用户取消关注）';
		}else{
			$status = '正常';
		}
		if ($value['tptype'] == 1){
			$votefrom = '网页投票';
		}elseif ($value['tptype'] == 2){
			$votefrom = '会话界面';
		}elseif ($value['tptype'] == 3){
			$votefrom = '微信支付';
		}else{
			$votefrom = '其他';
		}

		if ($value['shuapiao'] == 1){
			$spstatus = '已封禁';
		}else{
			$spstatus = '未封禁';
		}
		$tpinfo = $this->gettpinfo($rid,$value['from_user']);
		if (is_array($iparr)) {
			$country = $iparr['country'];
			$province = $iparr['province'];
			$city = $iparr['city'];
		}
		$html .= $value['id'] . "\t ,";	
		$html .= $username . "\t ,";
		$html .= $tpinfo['realname'] . "\t ,";
		$html .= $tpinfo['mobile'] . "\t ,";
		$html .= $value['vote_times'] . ' 票' . "\t ,";
		$html .= $votetype . "\t ,";
		$html .= $votefrom . "\t ,";
		$html .= $fuser['nickname'] . "\t ,";
		$html .= $fuser['mobile'] . "\t ,";	
		$html .= $auser['nickname'] . "\t ,";
		$html .= $value['ip'] . "\t ,";	
		$html .= $country . "\t ,";	
		$html .= $province . "\t ,";	
		$html .= $city . "\t ,";	
		$html .= $status . "\t ,";	
		$html .= $spstatus . "\t ,";	
		$html .= date('Y-m-d H:i:s', $value['createtime']) . "\t ,";	
		$html .= "\n";
	}
	$html .= "\n";

	$now = date('Y-m-d H:i:s', time());
	if ($keyword) {
		$k = $keyword.' 的';
	}
	$filename =$k.'投票记录情况'.'_'.$rid.'_'.$now;

	header("Content-type:text/csv");
	header("Content-Disposition:attachment; filename=".$filename.".csv");

	echo $html;
	exit();

}else{

	$vote = pdo_fetchall("SELECT distinct(ip) FROM ".tablename($this->table_log)." WHERE rid = :rid ".$where.$uni."  ", array(':rid' => $rid));				
					
	$tvtotal = array();
	foreach ($vote as $v) {
		$total = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename($this->table_log)." WHERE rid= :rid AND ip = :ip ".$where.$uni."   order by `ip` desc ", array(':rid' => $rid, ':ip' => $v['ip']));
		$tvtotal[$v[ip]] .= $total;
	}
	arsort($tvtotal);
		$html .= '统计情况' . "\t ,";	
		$html .= '排行' . "\t ,";	
		$html .= '相同IP' . "\t ,";	
		$html .= '地区' . "\t ,";	
		$html .= '投票次数' . "\t ,";	
		$html .= "\n";
		$n = 0;
		
	foreach ($tvtotal as $mid => $t) {
		$ip = GetIpLookup($mid);
		$ip = $ip['country'].'  '.$ip['province'].'  '.$ip['city'].'  '.$ip['district'].'  '.$ip['ist'];
		$html .= '' . "\t ,";	
		$html .= $n +1 . "\t ,";	
		$html .= $mid . "\t ,";	
		$html .= $ip . "\t ,";	
		$html .= $t . '次' . "\t ,";	
		$html .= "\n";
		$n++;
	}


	$now = date('Y-m-d H:i:s', time());
	if ($keyword) {
		$k = $keyword.' 的';
	}
	$filename =$k.'投票ip统计情况'.'_'.$rid.'_'.$now;

	header("Content-type:text/csv");
	header("Content-Disposition:attachment; filename=".$filename.".csv");

	echo $html;
	exit();
}
