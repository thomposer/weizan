<?php
global $_W, $_GPC;
$weid=$_W['uniacid'];
$set = $this->getSysett($weid);

$op= $_GPC['op'] ? $_GPC['op'] : 'list';

$artid = intval($_GPC['artid']);

if($_W['ispost']) {

    $ty = $_GPC['ty'];

    $article=pdo_fetch('select * from '.tablename('fineness_article').' where weid=:weid AND id=:id',array(':weid'=>$uniacid,':id'=>$aid));
    if(empty($article)) {
        exit(json_encode(array('status' => '0', 'msg' => '您要赞赏的文章不存在')));
    }

    $uniacid = $this->oauthuniacid();

    $tid = date('YmdHi') . random(8, 1);
    $params = array('tid' => $tid, 'ordersn' => $tid,
        'title' => "赞赏".$article['title'],
        'fee' => $_GPC['price'], 'user' => $_W['member']['uid'],
        'module' => 'amouse_article');

    $moduels = uni_modules();
    if (empty($params) || !array_key_exists($params['module'], $moduels)) {
        exit(json_encode(array('status' => '0', 'msg' => '访问错误.')));
    }

    $setting = uni_setting($uniacid, 'payment');
    $pars = array();
    $pars[':uniacid'] = $uniacid;
    $pars[':module'] = $params['module'];
    $pars[':tid'] = $params['tid'];
    $log = pdo_fetch("SELECT * FROM " . tablename('core_paylog') . " WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid ", $pars);
    if (!empty($log) && $log['status'] != '0'){
        $out['status'] = 201;
        $out['msg'] = '请勿重新提交！';
        exit(json_encode($out));
    }
    if(empty($log)) {
        $moduleid = pdo_fetchcolumn('SELECT mid FROM ' . tablename('modules') . ' WHERE name = :name', array(':name' => $params['module']));
        $moduleid = empty($moduleid) ? '000000' : sprintf('%06d', $moduleid);
        $fee = $params['fee'];
        $record = array();
        $record['uniacid'] = $uniacid;
        $record['openid'] = $_W['member']['uid'];
        $record['module'] = $params['module'];
        $record['type'] = 'wechat';
        $record['tid'] = $params['tid'];
        $record['uniontid'] = date('YmdHis') . $moduleid . random(8, 1);
        $record['fee'] = $fee;
        $record['status'] = '0';
        $record['is_usecard'] = 0;
        $record['card_id'] = 0;
        $record['card_fee'] = $fee;
        $record['encrypt_code'] = '';
        $record['acid'] = $_W['acid'];
        if (pdo_insert('core_paylog', $record)) {
            $plid = pdo_insertid();
            $record['plid'] = $plid;
            $log = $record;
        } else {
            exit(json_encode(array('status' => '0', 'msg' => '操作失败，请刷新后再试！')));
        }
    }

    $ps = array();
    $ps['tid'] = $log['plid'];
    $ps['uniontid'] = $log['uniontid'];
    $ps['user'] = $_W['fans']['from_user'];
    $ps['fee'] = $log['card_fee'];
    $ps['title'] = $params['title'];

    if (!empty($plid)) {
        $tag = array();
        $tag['acid'] = $_W['acid'];
        $tag['uid'] = $_W['member']['uid'];
        pdo_update('core_paylog', array('openid' => $fans['openid'], 'tag' => iserializer($tag)), array('plid' => $plid));
    }
    load()->model('payment');
    load()->func('communication');
    $sl = base64_encode(json_encode($ps));
    $auth = sha1($sl . $uniacid . $_W['config']['setting']['authkey']);
    $orderno = date('YmdHis') . random(4, 1) ;

    $orderData=array('ordersn'=>$orderno,
        'aid'=>$artid,
        'uniacid'=>$_W['uniacid'],
        'openid' =>$openid,
        'tid' => $log['tid'],
        'plid' => $log['plid'],
        'thumb'=> $this->oauthuser['avatar'],
        'price'=>$_GPC['price'],'status'=>0,
        'createtime'=>TIMESTAMP);

    if(pdo_insert('fineness_admire', $orderData)){
        $params['tid'] = pdo_insertid();
        $out['status'] = 200;
        $out['orderid'] = $params['tid'];
        if ($_W['account']['level'] < 3) {
            $out['pay_url'] = "../app/index.php?c=entry&do=pay&m=amouse_article&i={$uniacid}&auth={$auth}&ps={$sl}&ty=wechat";
        } else {
            $out['pay_url'] = "../payment/wechat/pay.php?i={$uniacid}&auth={$auth}&ps={$sl}";
        }
        exit(json_encode($out));
    }else {
        exit(json_encode(array('status' => '0', 'msg' => '操作失败，请刷新后再试！')));
    }
    exit;

}else{

    $acid=$_W['acid'];
    $account = $uniaccount = array();
    $uniaccount = pdo_fetch("SELECT * FROM ".tablename('uni_account')." WHERE uniacid = :uniacid", array(':uniacid' => $weid));
    $acid = !empty($acid) ? $acid : $uniaccount['default_acid'];
    $account = account_fetch($acid);

    $detail = pdo_fetch("SELECT * FROM " . tablename('fineness_article') . " WHERE `id`=:id and weid=:weid", array(':id'=>$artid,':weid' => $weid));
    $set=  pdo_fetch("SELECT * FROM ".tablename('fineness_sysset')." WHERE weid=:weid limit 1", array(':weid' => $weid));
    $follow_url = $set['guanzhuUrl'];
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $need_openid = true;
    if ($_W['container'] != 'wechat') {
        if ($_GPC['do'] == 'admire') {
            $need_openid = false;
        }
    }
    $adsets= pdo_fetchall("SELECT * FROM ".tablename('fineness_admire_set')." WHERE aid =$artid ORDER BY displayorder ASC limit 0,6 ");
}
include $this->template('admire');






