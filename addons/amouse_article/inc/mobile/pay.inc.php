<?php

define('IN_MOBILE', true);
global $_W, $_GPC;
$tys = array('wechat', 'native');
$ty = trim($_GPC['ty']);
$ty = in_array($ty, $tys) ? $ty : 'wechat';
if ($ty == 'native') {
    error_reporting(0);
    $order = pdo_fetch('SELECT * FROM ' . tablename('fineness_admire') . ' WHERE tid = :ptid  ', array(':ptid' => $_GPC['ordertoken']));
    require_once IA_ROOT . '/addons/amouse_article/lib/WxPayApi.php';
    require_once IA_ROOT . '/addons/amouse_article/lib/WxPay.NativePay.php';
    $url = $_W['siteroot'] . 'payment/wechat/notify.php';
    $fee = $order['fee'];
    $setting = uni_setting($_W['uniacid'], array('payment'));
    $orderid = $setting['payment']['wechat']['mchid'] . date('YmdHis');
    $tid = date('YmdHi') . random(8, 1);
    $notify = new NativePay();
    $input = new WxPayUnifiedOrder();
    $input->SetAppid($_W['account']['key']);
    $input->SetMch_id($setting['payment']['wechat']['mchid']);
    $input->SetBody('赞赏');
    $input->SetAttach($_W['uniacid']);
    $input->SetOut_trade_no($orderid);
    $input->SetTotal_fee($fee * 100);
    $input->SetTime_start(date('YmdHis'));
    $input->SetTime_expire(date('YmdHis', time() + 600));
    $input->SetGoods_tag('赞赏');
    $input->SetNotify_url($url);
    $input->SetTrade_type('NATIVE');
    $input->SetProduct_id($order['tid']);
    $result = $notify->GetPayUrl($input, $setting['payment']['wechat']['apikey']);
    $url2 = $result['code_url'];
    if ($result['return_code'] == 'FAIL') {
        print_r($order);
        exit;
    } else {
        $record = array();
        $record['uniacid'] = $_W['uniacid'];
        $record['openid'] = $order['openid'];
        $record['module'] = 'amouse_article';
        $record['type'] = 'wechat';
        $record['tid'] = $tid;
        $record['uniontid'] = $orderid;
        $record['fee'] = $fee;
        $record['status'] = '0';
        $record['is_usecard'] = 0;
        $record['card_id'] = 0;
        $record['encrypt_code'] = '';
        $record['acid'] = $_W['acid'];
        if (pdo_insert('core_paylog', $record)) {
            $plid = pdo_insertid();
            $order['tid'] = $tid;
            $order['plid'] = $plid;
            unset($order['id']);
            if (pdo_insert('fineness_admire', $order)) {
                $_W['page']['sitename'] = '微信扫码支付';
                include $this->template('nativepay');
            }
        }
    }
    exit;
}
if ($ty == 'wechat') {
    $sl = $_GPC['ps'];
    $params = @json_decode(base64_decode($sl), true);
    if ($_GPC['done'] == '1') {
        $sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `plid`=:plid';
        $pars = array();
        $pars[':plid'] = $params['tid'];
        $log = pdo_fetch($sql, $pars);
        if (!empty($log) && !empty($log['status'])) {
            if (!empty($log['tag'])) {
                $tag = iunserializer($log['tag']);
                $log['uid'] = $tag['uid'];
            }
            $site = WeUtility::createModuleSite($log['module']);
            if (!is_error($site)) {
                $method = 'payResult';
                if (method_exists($site, $method)) {
                    $ret = array();
                    $ret['weid'] = $log['uniacid'];
                    $ret['uniacid'] = $log['uniacid'];
                    $ret['result'] = 'success';
                    $ret['type'] = $log['type'];
                    $ret['from'] = 'return';
                    $ret['tid'] = $log['tid'];
                    $ret['uniontid'] = $log['uniontid'];
                    $ret['user'] = $log['openid'];
                    $ret['fee'] = $log['fee'];
                    $ret['tag'] = $tag;
                    $ret['is_usecard'] = $log['is_usecard'];
                    $ret['card_type'] = $log['card_type'];
                    $ret['card_fee'] = $log['card_fee'];
                    $ret['card_id'] = $log['card_id'];
                    exit($site->$method($ret));
                }
            }
        }
    }
    $sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `plid`=:plid';
    $log = pdo_fetch($sql, array(':plid' => $params['tid']));
    if (!empty($log) && $log['status'] != '0') {
        exit('这个订单已经支付成功, 不需要重复支付.');
    }
    $auth = sha1($sl . $log['uniacid'] . $_W['config']['setting']['authkey']);
    if ($auth != $_GPC['auth']) {
        exit('参数传输错误.');
    }
    load()->model('payment');
    $_W['uniacid'] = intval($log['uniacid']);
    $_W['openid'] = intval($log['openid']);
    $setting = uni_setting($_W['uniacid'], array('payment'));
    if (!is_array($setting['payment'])) {
        exit('没有设定支付参数.');
    }
    $wechat = $setting['payment']['wechat'];
    $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
    $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
    $wechat['appid'] = $row['key'];
    $wechat['secret'] = $row['secret'];
    $params = array('tid' => $log['tid'], 'fee' => $log['card_fee'], 'user' => $log['openid'], 'title' => urldecode($params['title']), 'uniontid' => $log['uniontid'],);
    $wOpt = wechat_build($params, $wechat);
    if (is_error($wOpt)) {
        if ($wOpt['message'] == 'invalid out_trade_no' || $wOpt['message'] == 'OUT_TRADE_NO_USED') {
            $id = date('YmdH');
            pdo_update('core_paylog', array('plid' => $id), array('plid' => $log['plid']));
            pdo_query('ALTER TABLE ' . tablename('core_paylog') . ' auto_increment = ' . ($id + 1) . ';');
            message('抱歉，发起支付失败，系统已经修复此问题，请重新尝试支付。');
        }
        message("抱歉，发起支付失败，具体原因为：“{$wOpt['errno']}:{$wOpt['message']}”。请及时联系站点管理员。");
        exit;
    }
} ?>

<script type="text/javascript">
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.invoke('getBrandWCPayRequest', {
            'appId': '<?php  echo $wOpt['appId'];?>',
            'timeStamp': '<?php  echo $wOpt['timeStamp'];?>',
            'nonceStr': '<?php  echo $wOpt['nonceStr'];?>',
            'package': '<?php  echo $wOpt['package'];?>',
            'signType': '<?php  echo $wOpt['signType'];?>',
            'paySign': '<?php  echo $wOpt['paySign'];?>'
        }, function (res) {
            if (res.err_msg == 'get_brand_wcpay_request:ok') {
                location.search += '&done=1';
            } else {
                window.location.href = "../app/index.php?c=entry&do=pay&m=amouse_article&i=<?php  echo $_W['uniacid'];?>&ty=native&ordertoken=<?php  echo $params['tid'];?>";
            }
        });
    }, false);
</script>