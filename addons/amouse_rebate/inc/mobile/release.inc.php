<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/16/15
 * Time: 10:22 下午
 */
/*require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);*/
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
global $_W, $_GPC;
$weid=$_W['uniacid'];

if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}

//$fans=$this->checkMember($openid);
$fans = $this->getMember($openid);
if($fans && $fans['user_status']==0){
    $this->returnMessage('抱歉，您没有该操作的访问权限');
}
$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];

if(empty($fans['wechatno'])){
    if($set && $set['sms_resgister']==1){//开启注册
        if(empty($fans['mobile'])){
            include $this->template('bind_mobile');
        }else{
            include $this->template('pub_person');
        }
    }else{
        include $this->template('pub_person');
    }
}else{
    include $this->template('pub_person');
}
