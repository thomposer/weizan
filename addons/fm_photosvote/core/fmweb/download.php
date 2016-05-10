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

	$reply = pdo_fetch("SELECT * FROM ".tablename($this->table_reply)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	$v = pdo_fetch("SELECT uni_all_users FROM ".tablename($this->table_reply_vote)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	if ($_GPC['uni_all_users'] != 1) {
		if ($uniacid != $_GPC['uniacid']) {
			$uni = " AND uniacid = ".$uniacid;
		}
	}
	$where = '';
	if ($_GPC['status'] == 1){
	    $where .= 'AND status=1';
	}else{
		 $where .= 'AND status=0';
	}
	$starttime = $_GPC['start_time'];
	$endtime = $_GPC['end_time'];
	$where .= " AND createtime >= " . $starttime; 
	$where .= " AND createtime < " . $endtime; 

	$list = pdo_fetchall('SELECT * FROM '.tablename($this->table_users).' WHERE rid =:rid  '.$where.' '.$uni.' ORDER BY `uid` DESC,`createtime` DESC ', array(':rid' => $rid));	


	$tableheader = array('用户ID','昵称','真实姓名', '真实票数', '虚拟票数', '真实人气', '虚拟人气', '分享数', '点赞', '评论', '活跃等级', '性别','分组', '手机号','微信号' ,'QQ号', '邮箱','地址' , '宣言', '简介','图片', '音乐', '视频', '状态', '报名付费状态', 'IP', '报名时间');
	$html .= "\xEF\xBB\xBF";
	foreach ($tableheader as $value) {
		$html .= $value . "\t ,";
	}
	$html .= "\n";
	foreach ($list as $mid => $value) {
		$sharenum = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename($this->table_data)." WHERE tfrom_user = :tfrom_user and rid = :rid", array(':tfrom_user' => $value['from_user'],':rid' => $rid));
		if ($value['sex'] == 2) {
			$sex = '女';
		}else{
			$sex = '男';
		}
		$tagname = $this->gettagname($value['tagid'],$value['tagpid'],$rid);
		if ($value['status'] == 1) {
			$status = '已审核';
		}else{
			$status = '未审核';
		}
		$remsg = $this->getcommentnum($rid, $uniacid, $value['from_user']);
		$level = intval($this->fmvipleavel($rid, $uniacid, $value['from_user']));
		if ($row['ordersn']) {
			$orderstatus = '已付费';
		}else{
			$orderstatus = '未付费';
		}
		$photosarr = pdo_fetchall('SELECT photos FROM '.tablename($this->table_users_picarr).' WHERE rid =:rid  AND from_user=:from_user ORDER BY `id` DESC', array(':rid' => $rid,':from_user' => $value['from_user']));

		//foreach ($photosarr as $key => $row) {
		//	$photos .= $row['photos'];
		//}
		$html .= $value['uid'] . "\t ,";
		$html .= $value['nickname'] . "\t ,";	
		$html .= $value['realname'] . "\t ,";	
		$html .= $value['photosnum'] . "\t ,";	
		$html .= $value['xnphotosnum'] . "\t ,";	
		$html .= $value['hits'] . "\t ,";
		$html .= $value['xnhits'] . "\t ,";	
		$html .= $sharenum . "\t ,";			
		$html .= $value['zans'] . "\t ,";			
		$html .= $remsg . "\t ,";		
		$html .= $level . "\t ,";
		$html .= $sex . "\t ,";	
		$html .= $tagname . "\t ,";	
		$html .= $value['mobile'] . "\t ,";	
		$html .= $value['weixin'] . "\t ,";	
		$html .= $value['qqhao'] . "\t ,";	
		$html .= $value['email'] . "\t ,";	
		$html .= $value['address'] . "\t ,";	
		$html .= $value['photoname'] . "\t ,";
		$html .= $value['description'] . "\t ,";
		$html .= $photosarr . "\t ,";
		$html .= tomedia($value['music']) . "\t ,";	
		$html .= tomedia($value['vedio']) . "\t ,";	
		$html .= $status . "\t ,";
		$html .= $orderstatus . "\t ,";
		$html .= $value['createip'] . "\t ,";	
		$html .= date('Y年m月d日 H:i:s',$value['createtime']) . "\t ,";	
		$html .= "\n";
	}
	$filename = $_GPC['title'].'_'.$rid.'_'.$pindex;

	
	header("Content-type:text/csv");
	header("Content-Disposition:attachment; filename=".$filename.".csv");
	
	echo $html;


