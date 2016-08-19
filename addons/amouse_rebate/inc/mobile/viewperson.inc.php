<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/20/15
 * Time: 9:35 上午
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;

$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}
$pk=  $_GPC['pk'] ;
if(intval($pk)>0){
    $fans = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid = $weid AND id= :id",array(":id"=>$pk));
    $shareimg =empty($set['share_icon']) ? toimage($fans['headimgurl']) : toimage($set['share_icon']);
    $sharetitle= str_replace('[nickname]', $fans['nickname'], $set['share_title']);
    $sharedesc = empty($set['share_desc']) ? $_W['account']['name'].'是一个新出的快速爆粉平台，微商必备神器。' : str_replace("\r\n", " ", $set['share_desc']);
    $sharedesc= str_replace('[nickname]', $fans['nickname'], $sharedesc);
    include $this->template('rmb/view_person');
}else{
    $this->returnMessage('您的好友还没有上传二维码。！', $this->createMobileUrl('board',array('ptype'=>'person')), 'error');
}




