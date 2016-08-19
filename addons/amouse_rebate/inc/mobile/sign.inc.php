<?php
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);
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
$signUser=pdo_fetch('SELECT * FROM '.tablename('amouse_rebate_sign_user')." WHERE openid=:openid AND uniacid =:uniacid", array(':openid' =>$openid,':uniacid'=>$_W['uniacid']));
if (!empty($signUser)) {
    $begintime = date('Y-m-d' . '00:00:00', $signUser['start_sign_time']);
    $endtime = date('Y-m-d' . '23:59:59', $signUser['end_sign_time']);
    $beginSinTimeStamp = strtotime($begintime);
    $endSinTimeStamp = strtotime($endtime);
    $offsertDays = ceil(abs($beginSinTimeStamp - $endSinTimeStamp) / 86400);
    $total_continuous = $offsertDays;
    $date=date('Y-m-d');
    $todaySignCount=pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('amouse_rebate_sign_record')." WHERE openid = :wid and date_format(FROM_UNIXTIME(sin_time), '%Y-%m-%d') =:date", array(':wid'=>$openid, ':date'=>$date));
    if ($todaySignCount == 0) {//今天还没有签到
        $is_valid_checkin = 1;
    } else {
        $is_valid_checkin = 0;
    }
}else{
    $user_serial_day = 0;
    $is_valid_checkin = 1;//
    $total_continuous = 0;
}
include $this->template('sign');