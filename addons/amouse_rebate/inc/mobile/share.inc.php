<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/10/15
 * Time: 12:42 下午
 */
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);
global $_W, $_GPC;
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
$weid=$_W['uniacid'];
$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;

$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}
$fans=$this->checkMember($openid);
if($fans && $fans['user_status']==0){
    $this->returnMessage('抱歉，您没有该操作的访问权限');
}
$type = !empty($_GPC['type']) ? $_GPC['type'] : "1";
$cid = $_GPC['pk'];
$pk = pdecode($cid);
$pk = intval($pk);
if($pk<=0){
    header('location:'.$this->createMobileUrl('board'));
    exit();
}
$shareimg =empty($set['share_icon']) ? toimage($fans['headimgurl']) : toimage($set['share_icon']);
$sharetitle= str_replace('[nickname]', $fans['nickname'], $set['share_title']);
$sharedesc = empty($set['share_desc']) ? $_W['account']['name'].'是一个新出的快速爆粉平台，微商必备神器。' : str_replace("\r\n", " ", $set['share_desc']);
$sharedesc= str_replace('[nickname]', $fans['nickname'], $sharedesc);
switch ($type) {
    case 1:
        $card = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid = $weid AND id=$pk ");

        $cid = $card['openid'];
        load()->classs('weixin.account');
        $accObj= WeixinAccount::create($_W['acid']);
        if($custom_set['credittxt']){
            $credittxt= $custom_set['credittxt'];
        }else{
            $credittxt= '积分';
        }
        if($set['qrleft']=='0'){//添加好友名片是否扣除名片所有者的积分
            $openid=  $fans['openid'] ;
            $parent_openid =  $card['openid'];
            $log = pdo_fetch('select * from '.tablename('amouse_rebate_card_click_log').' where to_openid=:to_openid and from_openid=:from_openid and uniacid=:uniacid limit 1',
                array(
                    ':to_openid' => $openid,
                    ':from_openid' =>$parent_openid,
                    ':uniacid' => $weid
                ));
            if(empty($log)){
                if (intval($set['qrtop']) > 0) {

                    $log = array(
                        'uniacid' => $weid,
                        'to_openid' => $openid,//关注者OPENID
                        'from_openid' =>$parent_openid,//推广人OPENID
                        'clickcredit' => intval($set['qrtop']),
                        'createtime' => time()
                    );

                    pdo_insert('amouse_rebate_card_click_log', $log);

                    $this->setCredit($card['openid'], 'credit1', intval($set['qrtop']),0, array(0,$_W['account']['name'].'分享好友被好友点击名片扣除{$credittxt}-' .
                        $set['qrtop']));
                    $bgtext = $set['bg'];
                    if (empty($bgtext)) {

                        $bgtext=  "您的名片被".$fans['nickname']."点击了，扣除了您".intval($set['qrtop'])."个{$credittxt}，赶紧去赚{$credittxt}吧!"; /// [nickname] 为好友昵称 [credit] 奖励的积分
                    }
                    $bgtext = str_replace("[nickname]", $fans['nickname'], $bgtext);
                    $bgtext = str_replace("[credit]",intval($set['qrtop']), $bgtext);
                    $accObj= WeixinAccount::create($_W['acid']);
                    $send['msgtype'] = 'text';
                    $send['text'] = array('content' => urlencode($bgtext));
                    $send['touser'] = trim($cid);
                    $accObj->sendCustomNotice($send);// 扣除名片所有者
                }
            }
        }

        $credit1= $this->getCredit($cid, 'credit1');//被点击人的 积分
        if($credit1<=0){//如果积分为0 直接显示公众号二维码
            $acid=$_W['acid'];

            $account = $uniaccount = array();
            $uniaccount = pdo_fetch("SELECT * FROM ".tablename('uni_account')." WHERE uniacid = :uniacid", array(':uniacid' => $weid));
            $acid = !empty($acid) ? $acid : $uniaccount['default_acid'];
            $account = account_fetch($acid);

            include $this->template('mp_qrcode');
        }else{
            include $this->template('view_person');
        }

        break;
    case 2:

        $sql ="SELECT * FROM ".tablename('amouse_rebate_group_mp')." WHERE weid = $weid AND type=1 AND id=$pk ";
        $group = pdo_fetch($sql);
        if($group){
            $fans = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid= $weid AND openid='{$group['openid']}' ");

        }else{
            $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=me&m=amouse_rmb&openid=".$openid."&wxref=mp.weixin.qq.com#wechat_redirect";

            header('location:'.$forward);
            exit;
        }
        include $this->template('view_group');

        break;
    case 3:

        $sql ="SELECT * FROM ".tablename('amouse_rebate_group_mp')." WHERE weid = $weid AND type=1 AND id=$pk ";
        $group = pdo_fetch($sql);
        if($group){
            $fans = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid= $weid AND openid='{$group['openid']}' ");
            $card =  pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE weid= $weid AND wechatno='{$fans['wechatno']}' ");
            include $this->template('view_group');
        }else{
            $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=me&m=amouse_rmb&wxref=mp.weixin.qq.com#wechat_redirect";

            header('location:'.$forward);
            exit;
        }

        include $this->template('view_mp');
        break;
    default:
        include $this->template('person_list');

        break;

}