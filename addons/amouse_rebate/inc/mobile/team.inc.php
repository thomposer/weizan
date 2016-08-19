<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/10/15
 * Time: 12:42 下午
 */
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 1;
$set= $this->getSysset($weid);
if(empty($_W['openid'])){
	load()->model('mc');
	$userinfo = mc_oauth_userinfo();
	$openid = $userinfo['openid'];
}else{
	$openid=$_W['openid'];
}

$fans=$this->checkMember($openid);
if($fans && $fans['user_status']==0){
	$this->returnMessage('抱歉，您没有该操作的访问权限');
}
$pindex = max(1, intval($_GPC['pageIndex']));
$psize = 10;
$start =($pindex - 1) * $psize;
if($op == 1){
	$condition = " WHERE weid =$weid  AND level_first_id=".$fans['id']." ";
}else if($op == 2){
	$condition = " WHERE weid =$weid  AND level_second_id=".$fans['id']." ";
}else{
	$condition = " WHERE weid =$weid  AND level_three_id=".$fans['id']." ";
}

$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('amouse_rebate_member')." $contain ");
$tpage= ceil($total / $psize);
$result = pdo_fetchall("SELECT * FROM " . tablename('amouse_rebate_member') . $condition . " ORDER BY createtime DESC LIMIT $start,$psize ");
$list = array();
foreach($result as $k=>$v) {
	if (strexists($v['headimgurl'], 'http://')||strexists($v['headimgurl'], 'https://')) {
		$headimgurl =$v['headimgurl'];
	} else {
		$headimgurl =tomedia($v['headimgurl']);
	}
	$v['createtime']=date("Y-n-j H:i:s", $v['createtime']);
	$v['head_img']=$headimgurl;
	$list[] = $v;
}
if(isset($_GPC['isajax']) && $_GPC['isajax']==1){
	$arr = array(
		'status' => 1,
		'total'=>$total,
		'gtotal'=>$tpage+1,
		'html' =>$list
	);
	echo json_encode($arr);
}else{
	include $this->template('rmb/team');
}





