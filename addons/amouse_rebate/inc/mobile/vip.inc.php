<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * qq: 214983937
 * Time: 8:32 下午
 */
global $_W, $_GPC;
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
$credittxt= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'step2';
$op2 = !empty($_GPC['op2']) ? $_GPC['op2'] : 'buy';
$credittxt = empty($credittxt['credittxt']) ? "积分" : $credittxt['credittxt'];

$fans=$this->checkMember($openid);
if($fans && $fans['user_status']==0){
    $this->returnMessage('抱歉，您没有该操作的访问权限');
}
$info['credit1'] = $this->getCredit($openid, 'credit1');
$needfriend =$set['needfriend']-$fans['friend'];//还需要加多少好友
$list = pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_meal')." WHERE weid = $weid ORDER BY id desc " );
include $this->template('rmb/recharge_vip');

