<?php

require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
global $_W, $_GPC;
$weid=$_W['uniacid'];

$acid = $_W["acid"];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'default';

if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}
$fans = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid = $weid AND openid='$openid' ");
if($fans && $fans['user_status']==0){
    $this->returnMessage('抱歉，您没有该操作的访问权限');
}
$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
if($fans['vipstatus']==2){
    $url = $_W['siteroot'] . 'app/' . substr($this->createMobileUrl('vip', array('ptype' => 'person')), 2);
    header('location:' . $url);

}
if(!empty($cid)){
    $cid = $_GPC['gid'];
    $pk = pdecode($cid);
    $pk = intval($pk);
    $goods=pdo_fetch('select id,title,thumb_url,thumb,price from '.tablename('amouse_rebate_goods').' where uniacid=:weid AND id=:id and status=1 ',array(':weid'=>$weid,':id'=>$pk));
    if(empty($goods)) {
        $url =$_W['siteroot'] . 'app/' . substr($this->createMobileUrl('goods',array()), 2);
        header('location:'.$url);
    }
}else{
    $goods=pdo_fetch('select id,title,thumb_url,thumb,price from '.tablename('amouse_rebate_goods').' where uniacid=:weid AND isdefault=1 and status=1 ',array(':weid'=>$weid));
}
if($op=='default'){
    include $this->template('mall/buy');//mall/buy
}else{
    include $this->template('mall/detail');
}



