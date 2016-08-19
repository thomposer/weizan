<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/11/15
 * Time: 8:32 下午
 */

require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);

global $_W, $_GPC;
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
$weid=$_W['uniacid'];
$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;

$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
$op=!empty($_GPC['op']) ? $_GPC['op'] : "me"; 
if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}
//$fans=$this->checkMember($openid);
if($fans && $fans['user_status']==0){
    $this->returnMessage('抱歉，您没有该操作的访问权限');
}
$fans['needfriend']= trim($fans['friend']) ? trim($fans['friend']) :0;
$needfriend=$set['needfriend'] - $fans['friend'];

$top_credit =intval($this->getCredit($fans['openid'], 'credit1'));
$shareurl= $_W['siteroot']."app/".substr($this->createMobileUrl('share',array('pk'=>pencode($fans['id']),'type'=>1),true), 2);
$shareimg =empty($set['share_icon']) ? toimage($fans['headimgurl']) : toimage($set['share_icon']);
$sharetitle= str_replace('[nickname]', $fans['nickname'], $set['share_title']);
$sharedesc = empty($set['share_desc']) ? $_W['account']['name'].'是一个新出的快速爆粉平台，微商必备神器。' : str_replace("\r\n", " ", $set['share_desc']);
$sharedesc= str_replace('[nickname]', $fans['nickname'], $sharedesc);
include $this->template('rmb/me');
