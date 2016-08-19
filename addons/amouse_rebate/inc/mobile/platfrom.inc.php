<?php
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
global $_W, $_GPC;
$cid = $_GPC['gid'];
$weid=$_W['uniacid'];
$set= $this->getSysset($weid);

if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}
$fans = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid = $weid AND openid='$openid' ");
include $this->template('mall/introduce');



