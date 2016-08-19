<?php
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
global $_W, $_GPC;

$cid = $_GPC['pk'];
$pk = pdecode($cid);
$pk = intval($pk);
$acid = $_W["acid"];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'default';
/*if ($_W['container'] != 'wechat') {
    return $this->returnError('应用目前仅支持在微信中访问', '', 'error');
}*/
if($pk>0){
    $weid=$_W['uniacid'];
    load()->func('file');
    $fans = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid = $weid AND id=$pk ");
    if(empty($fans)) {
        $url =$_W['siteroot'] . 'app/' . substr($this->createMobileUrl('release',array('ptype'=>'person')), 2);
        header('location:'.$url);
    }
    $poster = $this->getPosterSysset($weid);
    $set= $this->getSysset($weid);
    $custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
    $credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
    $set['needfriend']=is_null($set['needfriend']) ? 0:$set['needfriend'] ;

    $openid= $fans['openid'] ;
    $promote_qr = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_promote_qr')." WHERE uniacid =$weid  and memberid=$pk and openid='{$openid}'");
    if($promote_qr){
        $qrcode = tomedia($promote_qr['qr_img']);
    }else{
        $poster['memberid'] = $fans['id'];
        $poster['uniacid'] = $weid;
        $poster['openid'] = $openid;
        $poster['nickname'] = $fans['nickname'];
        $poster['avatar'] = $fans['headimgurl'];
        load()->func('logging');
        $poster['acid'] = $acid;
        $ret = createBarcode($poster);
        if ($ret['code'] != 1) {
            message($ret['msg']);
        }
        $qrcode = tomedia($ret['msg']);
    }

    $shareurl= $_W['siteroot']."app/".substr($this->createMobileUrl('pshare',array('pk'=>pencode($fans['id']),'op'=>'Invite'),true), 2);
    $shareimg =empty($set['share_icon']) ? toimage($fans['headimgurl']) : toimage($set['share_icon']);
    $sharetitle= str_replace('[nickname]', $fans['nickname'], $set['share_title']);
    $sharedesc = empty($set['share_desc']) ? $_W['account']['name'].'是一个新出的快速爆粉平台，微商必备神器。' : str_replace("\r\n", " ", $set['share_desc']);
    $sharedesc= str_replace('[nickname]', $fans['nickname'], $sharedesc);
    if($op=='Invite'){
        include $this->template('rmb/getimg');
    }else{
        include $this->template('poster');
    }
}



