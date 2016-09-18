<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 12/7/15
 * Time: 8:03 下午
 */

global $_GPC, $_W;
$weid= $_W['uniacid'];
$orderid= intval($_GPC['orderid']);
if ($orderid <= 0) {
    $this->returnMessage('支付订单有问题！',$this->createMobileUrl('detail',array('id'=>$aid)), 'error');
}
$order= pdo_fetch("SELECT * FROM ".tablename('fineness_admire')." WHERE `weid` = :uniacid and id=:id ", array(':uniacid'=>$weid,':id'=>$orderid));
if ($order['status'] != '0') {
    $this->returnMessage('抱歉，您的订单已经付款或是被关闭，请重新进入付款！',$this->createMobileUrl('detail',array('id'=>$aid)), 'error');
}
if(checksubmit('codsubmit')) {
    pdo_update('fineness_admire', array('status' => '1'), array('id' => $orderid));
    $this->returnMessage('订单提交成功，请您收到货时付款！',$this->createMobileUrl('detail',array('id'=>$aid)), 'success');
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
$openid = $_W['fans']['from_user'];
if(empty($openid)){
    $openid = getip();
}
$params['user'] =$openid;
$params['fee'] = $order['price'];
$params['title'] ="赞赏";
$params['ordersn'] = $order['ordersn'];
$params['virtual'] = $order['goodstype'] == 2 ? true : false;
$this->pay($params);