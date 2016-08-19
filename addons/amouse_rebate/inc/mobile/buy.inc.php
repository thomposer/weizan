<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/11/15
 * Time: 8:32 下午
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;

$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$op=!empty($_GPC['op']) ? $_GPC['op'] : "buy";
require_once IA_ROOT . "/addons/amouse_rebate/inc/authorization.php";

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
include $this->template('vip_2');