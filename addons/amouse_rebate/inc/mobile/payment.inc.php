<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 12/7/15
 * Time: 8:03 下午
 */
global $_GPC, $_W;
$weid= $_W['uniacid'];
/*if ($_W['container'] != 'wechat') {
    message('应用目前仅支持在微信中访问！', $this->createMobileUrl('vip'), 'error');
}*/
$orderid= intval($_GPC['orderid']);
if ($orderid <= 0) {
    $this->returnMessage('支付订单有问题！',$this->createMobileUrl('vip'), 'error');
}
$order= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_order')." WHERE `uniacid` = :uniacid and id=:id ", array(':uniacid'=>$weid,':id'=>$orderid));
if(intval($order['price'])<1){
    message('支付订单不能小于1元！', $this->createMobileUrl('vip'), 'error');
}
$m = pdo_fetch("SELECT title,price FROM ".tablename('amouse_rebate_meal')." WHERE `weid`=:weid and id=:id", array(':weid'=>$weid, ':id'=>$order['mealid']));
if ($order['status'] != '0') {
    $this->returnMessage('抱歉，您的订单已经付款或是被关闭，请重新进入付款！',$this->createMobileUrl('board'), 'error');
}
$sql="SELECT title,price FROM ".tablename('amouse_rebate_goods')." WHERE `uniacid`=:weid and id=:id ";
$goods=pdo_fetch($sql, array(':weid'=>$weid,':id'=>$order['uid']));

if(checksubmit('codsubmit')) {
    pdo_update('amouse_rebate_order', array('status' => '1', 'paytype' => '3'), array('id' => $orderid));
    $this->returnMessage('订单提交成功，请您收到货时付款！',$this->createMobileUrl('board'), 'success');
}
if(checksubmit()) {
    if ($order['paytype'] == 1 && $_W['fans']['credit2'] < $order['price']) {
        $forward = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=pay&m=recharge&wxref=mp.weixin.qq.com#wechat_redirect";
        $this->returnMessage('抱歉，您帐户的余额不够支付该订单，请充值！',$forward, 'error');
    }
    if ($order['price'] == '0') {
        $this->payResult(array('tid' => $orderid, 'from' => 'return', 'type' => 'credit2'));
        exit;
    }
}
$params['tid'] = $orderid;
$params['user'] = $_W['fans']['from_user'];
$params['fee'] = $order['price'];
$params['title'] = empty($m['title'])?$goods['title']:$m['title'];
$params['ordersn'] = $order['ordersn'];
$params['virtual'] = $order['goodstype'] == 2 ? true : false;
$this->pay($params);