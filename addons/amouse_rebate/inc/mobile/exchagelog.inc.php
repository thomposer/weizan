<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/10/15
 * Time: 12:42 下午
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'exchagelog';
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$openid=$_W['fans']['from_user'];
$set= $this->getSysset($weid);

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
 
$logs=pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_creditshop_log')." WHERE uniacid =$weid AND openid='$openid' ORDER BY createtime DESC,id DESC");
$orders = array();
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
if($custom_set['credittxt']){
    $credittxt= $custom_set['credittxt'];
}else{
    $credittxt= '积分';
}
foreach ($logs as &$item) {
    $goods= pdo_fetch('SELECT * FROM '.tablename('amouse_rebate_creditshop_goods')." WHERE id=:gid ", array(':gid' => $item['goodsid']));
    $item['title'] =$goods['title'];
    $item['credit'] = $goods['credit'];
    if($goods['type']==0){
        $item['desc']="使用".$goods['credit'].$credittxt."，兑换了".$goods['title'];
    }elseif($goods['type']==1){
        $item['desc']="使用".$goods['credit'].$credittxt."，置顶了个人名片一次";
    }
    $orders[] = $item;
}
unset($item);
include $this->template('exchage_logs');



