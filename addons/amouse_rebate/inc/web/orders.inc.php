<?php
/**
 * User: cofan

 * * QQ : 136670
 * Date: 7/21/15
 * Time: 09:47
 */

require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);

global $_W, $_GPC;
$weid=$_W['uniacid'];
load()->func('tpl');
$op= !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op == 'display') { //列表显示

    $starttime= empty($_GPC['date']['start']) ? strtotime('-2 month') : strtotime($_GPC['date']['start']);
    $endtime= empty($_GPC['date']['end']) ? TIMESTAMP : strtotime($_GPC['date']['end']) + 86399*2;
    $pindex= max(1, intval($_GPC['page']));
    $psize= 20;

    $condition= " WHERE uniacid=:weid AND createtime>=:starttime AND createtime<=:endtime";
    $params= array(':weid' => $weid, ':starttime' => $starttime, ':endtime' => $endtime);

    $status = $_GPC['status'];
    if ($status != '') {
        $condition .= " AND status = '" . intval($status) . "'";
    }
    if(!empty($_GPC['keyword'])) {
        $condition .= ' AND ( nickname LIKE :keyword or ordersn LIKE :keyword ) ';
        $params[':keyword'] = '%' . trim($_GPC['keyword']) . '%';
    }
    if(!empty($status)) {
        $condition .= " AND status = :status";
        $params[':status']= intval($status);
    }

    $list= pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_order').$condition." ORDER BY status DESC, createtime DESC LIMIT ".($pindex -1) * $psize.','.$psize, $params);
    $total= pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('amouse_rebate_order').$condition, $params);
    $pager= pagination($total, $pindex, $psize);
    $orders = array();
    foreach ($list as &$item) {
        $atitle= pdo_fetchcolumn('SELECT title FROM '.tablename('amouse_rebate_meal')." WHERE weid=$weid and id=:id ", array(':id' => $item['mealid']));
        $gtitle= pdo_fetchcolumn('SELECT title FROM '.tablename('amouse_rebate_goods')." WHERE uniacid =$weid and id=:id ", array(':id' => $item['uid']));
        $item['btitle'] =$btitle;
        $item['atitle']=empty($atitle)?$gtitle:$atitle;
        $orders[] = $item;
    }
    unset($item);
    include $this->template('web/order');
}elseif($op == 'detail') {

    $id= intval($_GPC['id']);
    $item= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_order')." WHERE id = :id", array(':id' => $id));
    if(empty($item)) {
        message("抱歉，订单不存在!", referer(), "error");
    }
    if($item['mealid']>0){
        $meal= pdo_fetch('SELECT * FROM '.tablename('amouse_rebate_meal')." WHERE id=:id  ", array(':id' => $item['mealid']));
    }
    if($item['uid']>0){
        $goods= pdo_fetch('SELECT title,price FROM '.tablename('amouse_rebate_goods')." WHERE uniacid =$weid and id=:id ", array(':id' => $item['uid']));
    }
    if(checksubmit('finish')) {
        pdo_update('amouse_rebate_order', array('status' => 1), array('id' => $id));
        message('订单操作成功！', $this->createWebUrl('orders', array('op' => 'display')), 'success');
    }

    if(checksubmit('cancelpay')) {
        pdo_update('amouse_rebate_order', array('status' => 0), array('id' => $id));
        message('取消订单付款操作成功！', $this->createWebUrl('orders', array('op' => 'display')), 'success');
    }
    if(checksubmit('close')) {
        pdo_update('amouse_rebate_order', array('status' => -1), array('id' => $id));
        message('订单关闭操作成功！', $this->createWebUrl('orders', array('op' => 'display')), 'success');
    }
    include $this->template('web/order');
}elseif($op == 'del') { //删除
    if(isset($_GPC['delete'])) {
        $ids= implode(",", $_GPC['delete']);
        $sqls= "delete from  ".tablename('amouse_rebate_order')."  where id in(".$ids.")";
        pdo_query($sqls);
        message('删除成功！', referer(), 'success');
    }
    $id= intval($_GPC['id']);
    $temp= pdo_delete("amouse_rebate_order", array("uniacid" => $_W['uniacid'], 'id' => $id));
    message('删除数据成功！', $this->createWebUrl('orders', array('op' => 'display')), 'success');

}elseif($op=='confirmsend'){
    $id      = intval($_GPC['id']);
    $item= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_order')." WHERE id = :id and uniacid=:uniacid ", array(':id' => $id,':uniacid' => $_W['uniacid']));
    if(empty($item)) {
        message("抱歉，订单不存在!", referer(), "error");
    }
    if ($item['status'] != 1) {
        message('订单未付款，无法发货！');
    }
    if (empty($_GPC['expresssn'])) {
        message('请输入快递单号！');
    }
    if (!empty($item['transid'])) {
        changeWechatSend($item['ordersn'], 1);
    }
    pdo_update('amouse_rebate_order', array(
        'status' => 2,
       // 'remark' => trim($_GPC['remark']),
        'express' => trim($_GPC['express']),
        'expresscom' => trim($_GPC['expresscom']),
        'expresssn' => trim($_GPC['expresssn']),
        'sendtime' => time()
    ), array(
        'id' => $item['id'],
        'uniacid' => $_W['uniacid']
    ));
    $goods= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_goods')." WHERE id = :id and uniacid=:uniacid ", array(':id' => $item['uid'],':uniacid' => $_W['uniacid']));
    $set= $this->getSysset($weid);
    sendTemplateMsg($set,$item,$goods);
    //$url = $_GPC['op'] == 'detail' ? : referer();
    message('发货操作成功！', $this->createWebUrl('orders', array('op' => 'detail','id'=>$id)), 'success');
    include $this->template('web/order');
}


function changeWechatSend($ordersn, $status, $msg = ''){
    global $_W;
    $paylog = pdo_fetch("SELECT plid, openid, tag FROM " . tablename('core_paylog') . " WHERE tid = '{$ordersn}' AND status = 1 AND type = 'wechat'");
    if (!empty($paylog['openid'])) {
        $paylog['tag'] = iunserializer($paylog['tag']);
        $acid          = $paylog['tag']['acid'];
        load()->model('account');
        $account = account_fetch($acid);
        $payment = uni_setting($account['uniacid'], 'payment');
        if ($payment['payment']['wechat']['version'] == '2') {
            return true;
        }
        $send   = array(
            'appid' => $account['key'],
            'openid' => $paylog['openid'],
            'transid' => $paylog['tag']['transaction_id'],
            'out_trade_no' => $paylog['plid'],
            'deliver_timestamp' => TIMESTAMP,
            'deliver_status' => $status,
            'deliver_msg' => $msg
        );
        $sign           = $send;
        $sign['appkey'] = $payment['payment']['wechat']['signkey'];
        ksort($sign);
        $string = '';
        foreach ($sign as $key => $v) {
            $key = strtolower($key);
            $string .= "{$key}={$v}&";
        }
        $send['app_signature'] = sha1(rtrim($string, '&'));
        $send['sign_method']   = 'sha1';
        $account               = WeAccount::create($acid);
        $response              = $account->changeOrderStatus($send);
        if (is_error($response)) {
            message($response['message']);
        }
    }
}

function sendTemplateMsg($set,$order,$goods){
    global $_W;
    
    $good = "" . $goods['title'] . '( ';
    $good .= ' 单价: ' . ($goods['price'] / $order['num']) . ' 数量: ' . $order['num'] . ' 总价: ' . $order['price'] . "); ";
    $msg = array(
        'first' => array(
            'value' => "您的宝贝已经发货！",
            "color" => "#4a5077"
        ),
        'keyword1' => array(
            'title' => '订单内容',
            'value' => "【" . $order['ordersn'] . "】" . $good,
            "color" => "#4a5077"
        ),
        'keyword2' => array(
            'title' => '物流服务',
            'value' => $order['expresscom'],
            "color" => "#4a5077"
        ),
        'keyword3' => array(
            'title' => '快递单号',
            'value' => $order['expresssn'],
            "color" => "#4a5077"
        ),
        'keyword4' => array(
            'title' => '收货信息',
            'value' => "地址: " . $order['province'] . ' ' . $order['city'] . ' ' . $order['dist'] . ' ' . $address['address'] . "收件人: " . $address['username'] . ' (' . $address['mobile'] . ') ',
            "color" => "#4a5077"
        ),
        'remark' => array(
            'value' => "\r\n我们正加速送到您的手上，请您耐心等候。",
            "color" => "#4a5077"
        )
    );
    load()->classs('weixin.account');
    $account= WeixinAccount::create($_W['acid']);
    $detailurl = $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'] . '&c=entry&m=amouse_rebate&do=order&op=detail&id=' . $order['id'];
    if(!empty($set['send'])) {
        $account->sendTplNotice($order['openid'],$set['send'], $msg, $detailurl);
    }else {
        /*$account->sendCustomNotice(array(
            "touser" => trim($order['openid']),
            "msgtype" => "text",
            "text" => array(
                'content' => urlencode($msg)
            )
        ));*/
    }
}

