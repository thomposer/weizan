<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/10/15
 * Time: 12:42 下午
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}
$set= $this->getSysset($weid);
$credittxt= pdo_fetchcolumn("SELECT credittxt FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = !empty($credittxt) ?$credittxt: '积分';
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'point';
if($op=='point'){
    $uid = mc_openid2uid($openid);
    $credits = pdo_fetchall("SELECT * FROM " . tablename('mc_credits_record')." WHERE `uid` = :uid and module='amouse_rmb' order by createtime desc limit 0,20 ", array(':uid' => $uid));
    include $this->template('credit_record');
}elseif($op=='orders'){
    $list = pdo_fetchall("SELECT * FROM " . tablename('amouse_rebate_order')." WHERE `uniacid`=:weid and `openid` = :uid  order by createtime desc limit 0,20 ", array(':weid'=>$weid,':uid' =>$openid));
    $orders = array();
    foreach ($list as &$item) {
        $meals= pdo_fetch('SELECT * FROM '.tablename('amouse_rebate_meal')." WHERE id=:mealid ", array(':mealid' => $item['mealid']));
        $item['title'] =$meals['title'];

        $orders[] = $item;
    }
    unset($item);

    include $this->template('orders_record');

}elseif($op=='redpacks'){ //红包
    $type=array('0'=> '关注','1'=>'邀请关注','2'=>'取消关注','3'=>'提现');

    $wtx_money=pdo_fetchcolumn("select wtx_money from ".tablename('amouse_rebate_member')." where openid=:openid and weid=:weid",array(':openid'=>$openid, ':weid'=>$weid));


    $tx_money= pdo_fetchcolumn("SELECT tx_money FROM ".tablename('amouse_rebate_redpacks_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));

    include $this->template('redpacks_record');
}elseif($op=='record'){
    $signs= pdo_fetchall("select * from " . tablename('amouse_rebate_sign_record') . " where openid=:uid  order by sin_time  desc limit 0,20  ", array(":uid" => $openid));
    include $this->template('rmb/sign_record');
}





