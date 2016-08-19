<?php
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url = trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename, $url);
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
global $_W, $_GPC;

if (empty($_W['openid'])) {
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
} else {
    $openid = $_W['openid'];
}
$acid = $_W["acid"];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'default';

$weid = $_W['uniacid'];
load()->func('file');
$fans = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_member') . " WHERE weid =$weid AND openid='$openid' ");
if (empty($fans)) {
    $url = $_W['siteroot'] . 'app/' . substr($this->createMobileUrl('release', array('ptype' => 'person')), 2);
    header('location:' . $url);
}

$promote_qr = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_promote_qr') . " WHERE uniacid=$weid and openid='{$openid}'");
if ($promote_qr) {
    $qrcode = tomedia($promote_qr['qr_img']);
} else {
    $poster['memberid'] = $fans['id'];
    $poster['uniacid'] = $weid;
    $poster['openid'] = $openid;
    $poster['nickname'] = $fans['nickname'];
    $poster['avatar'] = $fans['headimgurl'];
    load()->func('logging');
    $poster['acid'] = $acid;
    $poster = $this->getPosterSysset($weid);

    $ret = createBarcode($poster);
    if ($ret['code'] != 1) {
        message($ret['msg']);
    }
    $qrcode = tomedia($ret['msg']);
}

$shareurl = $_W['siteroot'] . "app/" . substr($this->createMobileUrl('link', array(), true), 2);
$shareimg = empty($set['share_icon']) ? toimage($fans['headimgurl']) : toimage($set['share_icon']);
$sharetitle = str_replace('[nickname]', $fans['nickname'], $set['share_title']);
$sharedesc = empty($set['share_desc']) ? $_W['account']['name'] . '是一个新出的快速爆粉平台，微商必备神器。' : str_replace("\r\n", " ", $set['share_desc']);
$sharedesc = str_replace('[nickname]', $fans['nickname'], $sharedesc);

include $this->template('rmb/getimg');




