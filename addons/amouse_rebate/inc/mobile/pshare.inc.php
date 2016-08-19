<?php
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
global $_W, $_GPC;

$weid=$_W['uniacid'];
$cid = $_GPC['pk'];
$pk = pdecode($cid);
$pk = intval($pk);
if($pk>0){
    $fans = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid = $weid AND id=$pk ");
    if(empty($fans)){
       // message("个人名片不存在");
        $this->returnMessage('个人名片不存在');
    }
    $cid=$fans['openid'];
    $promote_qr = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_rmb_promote_qr')." WHERE uniacid =$weid  and memberid='{$fans['id']}' and openid='{$cid}'");
    if($promote_qr){
        $qrcode = tomedia($promote_qr['qr_img']);
    }else{
        $url = $_W['siteroot'].'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=amouse_rmb&do=board';
       // message("获取个人推广图片出问题了，请向您的好友重新获取。",$url,'error');
        $this->returnMessage('获取个人推广图片出问题了，请向您的好友重新获取。', $url, 'error');
    }
    $custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
    $credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
    $shareurl= $_W['siteroot']."app/".substr($this->createMobileUrl('pshare',array('pk'=>pencode($fans['id'])),true), 2);
    $shareimg =empty($set['share_icon']) ? toimage($fans['headimgurl']) : toimage($set['share_icon']);
    $sharetitle= str_replace('[nickname]', $fans['nickname'], $set['share_title']);
    $sharedesc = empty($set['share_desc']) ? $_W['account']['name'].'是一个新出的快速爆粉平台，微商必备神器。' : str_replace("\r\n", " ", $set['share_desc']);
    $sharedesc= str_replace('[nickname]', $fans['nickname'], $sharedesc);
    include $this->template('poster_share');
}else{
    $this->returnMessage('你要访问的名片不存在');
}

