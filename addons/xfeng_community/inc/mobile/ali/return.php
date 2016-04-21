<?php
error_reporting(0);
define('IN_MOBILE', true);
if(empty($_GET['out_trade_no'])) {
	exit('request failed.');
}
require '../../framework/bootstrap.inc.php';
load()->app('common');
load()->app('template');
$_W['uniacid'] = $_W['weid'] = $_GET['body'];
$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniontid`=:uniontid';
$params = array();
$params[':uniontid'] = $_GET['out_trade_no'];
$log = pdo_fetch($sql, $params);
$order = pdo_fetch("SELECT * FROM".tablename('xcommunity_shopping_order')."WHERE ordersn=:ordersn",array(':ordersn' => $log['tid']));
pdo_update('xcommunity_propertyfree', array('status' => 1), array('id' => $order['pid']));
$d = array(
		'uniacid' => $_W['uniacid'],
		'regionid' => $order['regionid'],
		'pid' => $order['protimeid'],
		'ordersn' => $log['tid'],
		'cost' => $log['fee'],
		'status' => 1,
		'createtime' => TIMESTAMP,
		'realname' => $order['realname'],
		'mobile' => $order['mobile'],
	);
pdo_insert('xcommunity_propertyfree_order',$d);
//更新会员积分
load()->model('mc');
// $result = mc_credit_fetch($order['uid']);
$credit = $log['fee']/1;
if ($credit < 1) {
	$credit1 = 0.00;
}else{
	$credit1 = $credit;
}
mc_credit_update($order['uid'], 'credit1', $credit1, array('0' => $order['uid'], '缴纳物业费赠送'));
$url ="http://weixin.yuandu5.com/app/index.php?i={$_W['uniacid']}&c=entry&do=home&m=xfeng_community";
message('临时跳转',$url,'success');
// if($_GET['is_success'] == 'T' && $_GET['trade_status'] == 'TRADE_FINISHED') {

// 	$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniontid`=:uniontid';
// 	$params = array();
// 	$params[':uniontid'] = $_GET['out_trade_no'];
// 	$log = pdo_fetch($sql, $params);
// 	print_r($log);exit();
// 	if(!empty($log)) {
// 		if(!$log['status']) {
// 			$record = array();
// 			$record['status'] = $log['status'] = '1';
// 			pdo_update('core_paylog', $record, array('plid' => $log['plid']));
// 			if($log['is_usecard'] == 1 && $log['card_type'] == 1 &&  !empty($log['encrypt_code']) && $log['acid']) {
// 				load()->classs('coupon');
// 				$acc = new coupon($log['acid']);
// 				$codearr['encrypt_code'] = $log['encrypt_code'];
// 				$codearr['module'] = $log['module'];
// 				$codearr['card_id'] = $log['card_id'];
// 				$acc->PayConsumeCode($codearr);
// 			}
// 			if($log['is_usecard'] == 1 && $log['card_type'] == 2) {
// 				$now = time();
// 				$log['card_id'] = intval($log['card_id']);
// 				$iscard = pdo_fetchcolumn('SELECT iscard FROM ' . tablename('modules') . ' WHERE name = :name', array(':name' => $log['module']));
// 				$condition = '';
// 				if($iscard == 1) {
// 					$condition = " AND grantmodule = '{$log['module']}'";
// 				}
// 				pdo_query('UPDATE ' . tablename('activity_coupon_record') . " SET status = 2, usetime = {$now}, usemodule = '{$log['module']}' WHERE uniacid = :aid AND couponid = :cid AND uid = :uid AND status = 1 {$condition} LIMIT 1", array(':aid' => $_W['uniacid'], ':uid' => $log['openid'], ':cid' => $log['card_id']));
// 			}
// 		}
// 		$site = WeUtility::createModuleSite($log['module']);
// 		if(!is_error($site)) {
// 			$method = 'payResult';
// 			if (method_exists($site, $method)) {
// 				$ret = array();
// 				$ret['weid'] = $log['weid'];
// 				$ret['uniacid'] = $log['uniacid'];
// 				$ret['result'] = $log['status'] == '1' ? 'success' : 'failed';
// 				$ret['type'] = $log['type'];
// 				$ret['from'] = 'return';
// 				$ret['tid'] = $log['tid'];
// 				$ret['uniontid'] = $log['uniontid'];
// 				$ret['user'] = $log['openid'];
// 				$ret['fee'] = $log['fee'];
// 				$ret['is_usecard'] = $log['is_usecard'];
// 				$ret['card_type'] = $log['card_type'];
// 				$ret['card_fee'] = $log['card_fee'];
// 				$ret['card_id'] = $log['card_id'];
// 				exit($site->$method($ret));
// 			}
// 		}
// 	}
// }
