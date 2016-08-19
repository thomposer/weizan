<?php

global $_W, $_GPC;
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
$weid=$_W['uniacid'];
if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}

$set= $this->getSysset($weid); 
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($credittxt['credittxt']) ? "积分" : $credittxt['credittxt'];

$fans=$this->checkMember($openid);
if($fans && $fans['user_status']==0){
    $this->returnMessage('抱歉，您没有该操作的访问权限');
}
if($fans['vipstatus']==2){
    $url = $_W['siteroot'] . 'app/' . substr($this->createMobileUrl('board', array('ptype' => 'person')), 2);
    header('location:' . $url);

}else{
    $goods=pdo_fetch('select id,title,thumb_url,thumb,price from '.tablename('amouse_rebate_goods').' where uniacid=:weid AND isdefault=1 and status=1 ',array(':weid'=>$weid));
    $piclist = unserialize($goods['thumb_url']);
    $info['credit1'] = $this->getCredit($openid, 'credit1');
    $top_credit=intval($info['credit1']- $set['top_credit']);
    $top_credit2=intval($set['top_credit']-$info['credit1']);
    $needfriend =$set['needfriend']-$fans['friend'];//还需要加多少好友
    $credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
    $vip = $fans['vipstatus']<=0 ? 0 : $fans['vipstatus'];
    include $this->template('mall/index');
}
