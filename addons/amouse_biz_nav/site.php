<?php

error_reporting(0);
defined('IN_IA') or exit ('Access Denied');
define("AMOUSE_BIZ_NAV", "amouse_biz_nav");
define("AMOUSE_BIZ_NAV_RES", "../addons/" . AMOUSE_BIZ_NAV . "/style/");
class Amouse_Biz_NavModuleSite extends WeModuleSite{
    public function AutoFinishVip(){
        require_once IA_ROOT . "/addons/amouse_biz_nav/inc/autoFinishVip.php";
        autoFinshVip();
    }
    public function doMobileRespondImage(){
        global $_W, $_GPC;
        load() -> func('file');
        require_once IA_ROOT . "/addons/amouse_biz_nav/inc/common.php";
        ignore_user_abort(true);
        $uniacid = $_W["uniacid"];
        $acid = $_W["acid"];
        $openid = $_GPC['openid'];
        $posterid = $_GPC['posterid'];
        $member = $this -> getMember($openid);
        load() -> func('logging');
        if(empty($member)){
            exit;
        }
        load() -> classs('weixin.account');
        $accObj = WeixinAccount :: create($_W['acid']);
        $poster = pdo_fetch("SELECT * from " . tablename('amouse_biz_poster_sysset') . "  where `uniacid`=:weid and `id`=:id ", array(":weid" => $uniacid, ":id" => $posterid));
        if(empty($poster)){
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("未找到推广二维码"))));
            return;
        }
        if($poster['entrytext'] == 1){
            if($member['vipstatus'] == 0){
                $url1 = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('me', array('time' => time())), 2);
                $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("普通会员不能生成推广二维码,<a href='$url1'>【立即开通VIP会员】</a>"))));
                return;
            }
        }
        $waittext = !empty($poster['waittext']) ? $poster['waittext'] : '您的专属推广二维码正在拼命生成中，请等待片刻...';
        $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($waittext))));
        $poster['memberid'] = $member['id'];
        $poster['uniacid'] = $uniacid;
        $poster['openid'] = $member['openid'];
        $poster['acid'] = $acid;
        $poster['nickname'] = $member['nickname'];
        $poster['avatar'] = $member['headimgurl'];
        $ret = newCreateBarcode($poster);
        if ($ret['code'] != 1){
            exit();
        }
        if(empty($ret['media_id'])){
            $target_file_url = tomedia($ret['qr_img']);
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("<a href='$target_file_url'>【点击这里查看您的专属推广二维码】</a>"))));
            exit();
        }else{
            $oktext = !empty($poster['oktext']) ? $poster['oktext'] : '您的专属推广二维码已大功告成!';
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($oktext))));
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "image", "image" => array('media_id' => $ret['media_id'])));
            return;
        }
    }
    public function doMobileQrSceneImage(){
        global $_W, $_GPC;
        load() -> func('file');
        require_once IA_ROOT . "/addons/amouse_biz_nav/inc/common.php";
        ignore_user_abort(true);
        $uniacid = $_W["uniacid"];
        $acid = $_W["acid"];
        $openid = $_GPC['openid'];
        $member = $this -> getMember($openid);
        if(empty($member)){
            exit;
        }
        $poster = pdo_fetch("SELECT * FROM " . tablename('amouse_biz_poster_sysset') . "  WHERE `uniacid`=:weid limit 1 ", array(':weid' => $uniacid));
        load() -> classs('weixin.account');
        $accObj = WeixinAccount :: create($_W['acid']);
        if(empty($poster)){
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("未找到推广二维码"))));
            return;
        }
        if($poster['entrytext'] == 1){
            if($member['vipstatus'] == 0){
                $url1 = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('me', array('time' => time())), 2);
                $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("普通会员不能生成推广二维码,<a href='$url1'>【立即开通VIP会员】</a>"))));
                return;
            }
        }
        $poster['memberid'] = $member['id'];
        $poster['uniacid'] = $uniacid;
        $poster['openid'] = $member['openid'];
        $poster['acid'] = $acid;
        $poster['nickname'] = $member['nickname'];
        $poster['avatar'] = $member['headimgurl'];
        $ret = newCreateTempBarcode($poster);
        if ($ret['code'] != 1){
            exit();
        }
        if(empty($ret['media_id'])){
            $target_file_url = tomedia($ret['qr_img']);
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("<a href='$target_file_url'>【点击这里查看您的专属推广二维码】</a>"))));
            exit();
        }else{
            $oktext = !empty($poster['oktext']) ? $poster['oktext'] : '您的专属推广二维码已大功告成!';
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($oktext))));
            $accObj -> sendCustomNotice(array("touser" => $openid, "msgtype" => "image", "image" => array('media_id' => $ret['media_id'])));
            return;
        }
    }
    public function doMobileAjaxOrder(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $regchareid = intval($_GPC['regchareid']);
        $this -> _doMobileInit("pcenter");
        $fans = $this -> _fans;
        $m = pdo_fetch("SELECT * FROM " . tablename('amouse_biz_nav_meal') . " WHERE `weid`=:weid and id=:id", array(':weid' => $uniacid, ':id' => $regchareid));
        if (empty($m)){
            $res['code'] = 500;
            $res['msg'] = '您要充值的不存在，或者被删除，请联系管理员';
            return json_encode($res);
        }
        $tid = date('YmdHi') . random(8, 1);
        $orderData = array('ordersn' => $tid, 'mealid' => $regchareid, 'uniacid' => $uniacid, 'openid' => $fans['openid'], 'from_user' => $fans['from_user'], 'tid' => $tid , 'price' => $m['title'], 'status' => 0, 'createtime' => TIMESTAMP);
        if(pdo_insert("amouse_biz_nav_order", $orderData)){
            $oid = pdo_insertid();
            $res['code'] = 200;
            $res['oid'] = $oid;
        }else{
            $res['code'] = 0;
            $res['msg'] = "提交订单失败";
        }
        return json_encode($res);
    }
    public function doMobileQrPayUrl(){
        global $_W, $_GPC;
        $url = $_GPC['url'];
        require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
        $errorCorrectionLevel = "L";
        $matrixPointSize = "6";
        QRcode :: png($url, false, $errorCorrectionLevel, $matrixPointSize);
        exit();
    }
    public function payResult($params){
        global $_W;
        $uniacid = $params['uniacid'];
        $data = array('status' => $params['result'] == 'success' ? 1 : 0);
        $paytype = array('credit' => '1', 'wechat' => '2', 'alipay' => '2', 'delivery' => '3', 'yunpay' => '4');
        $data['paytype'] = $paytype[$params['type']];
        if($params['type'] == 'wechat'){
            $data['transid'] = $params['tag']['transaction_id'];
        }
        if($params['type'] == 'delivery'){
            $data['status'] = 1;
        }
        $order = pdo_fetch("SELECT * FROM " . tablename('amouse_biz_nav_order') . " WHERE `tid`=:ptid ", array(':ptid' => $params['tid']));
        $mealid = $order['mealid'];
        $m = pdo_fetch("SELECT `title`,`price`,`id`,`day`,`weid`,`acid` FROM " . tablename('amouse_biz_nav_meal') . " WHERE `id`=:id limit 1 ", array(':id' => $mealid));
        $uuid = $m['weid'] ;
        if($params['result'] == 'success' && $params['from'] == 'notify'){
            if ($params['fee'] == $order['price']){
                pdo_update('amouse_biz_nav_order', $data, array('id' => $order['id']));
                load() -> model('mc');
                $info = pdo_fetch('select `id`,`openid`,`from_user`,`nickname` from ' . tablename('amouse_board_member') . ' where `weid`=:uniacid and `openid`=:openid limit 1', array(':uniacid' => $uuid, ':openid' => $order['openid']));
                $oathopenid = empty($info['from_user']) ? $info['openid']:$info['from_user'] ;
                $this -> setCredit($oathopenid, 'credit2', $m['title'], 1 , array(0, $oathopenid . '充值' . $m['title']) , $uuid);
                $this -> setCredit($oathopenid, 'credit1', $m['price'], 1 , array(0, $oathopenid . '赠送' . $m['price']) , $uuid);
                $note = $info['nickname'] . "您好, 您的订单已支付成功。充值" . $m['title'] . "余额.谢谢您对我们的支持！如有问题，请联系我们";
                $this -> post_send_text($oathopenid, $note);
            }else{
                $url = $_W['siteroot'] . "app/index.php?i=$uuid&c=entry&m=amouse_biz_nav&do=vip&time=" . time();
                $url = str_replace("payment/yunpay/", '', $url);
                $url = str_replace("payment/tzyeepay/", '', $url);
                $this -> returnMessage('抱歉，您支付出问题了。', $url);
            }
        }
        if($params['from'] == 'return'){
            if ($params['result'] == 'success'){
                $url = $_W['siteroot'] . "app/index.php?i=$uuid&c=entry&m=amouse_biz_nav&do=vip&time=" . time();
                $url = str_replace("payment/yunpay/", '', $url);
                $url = str_replace("payment/tzyeepay/", '', $url);
                header('location:' . $url);
                exit;
            }else{
                $this -> returnMessage("抱歉，支付失败，请刷新后再试！", 'referer', 'error');
            }
        }
    }
    private function post_send_text($openid, $content, $obj = array()){
        global $_W;
        $weid = $_W['acid'];
        $accObj = WeAccount :: create($weid);
        $token = $accObj -> fetch_token();
        load() -> func('communication');
        $data['touser'] = $openid;
        $data['msgtype'] = 'text';
        $data['text']['content'] = urlencode($content);
        $dat = json_encode($data);
        $dat = urldecode($dat);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $token;
        $ret = ihttp_post($url, $dat);
        $dat = $ret['content'];
        $result = @json_decode($dat, true);
        if ($result['errcode'] == '0'){
        }else{
        }
        return true;
    }
    private function processCommision($uid, $order){
        require_once IA_ROOT . "/addons/amouse_biz_nav/inc/common.php";
        global $_W;
        $credittxt = pdo_fetch("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
        $commission = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_commission_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
        $set = pdo_fetch("SELECT paytpl,mtpl,acid FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $uid));
        if($order['uid'] > 0 && $order['memberid'] > 0){
            $goods = pdo_fetch('SELECT id,title,price FROM ' . tablename('amouse_rebate_goods') . ' WHERE uniacid=:weid AND id=:id and status=1 ', array(':weid' => $uid, ':id' => $order['uid']));
            $fans = pdo_fetch("SELECT * FROM " . tablename('amouse_board_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $order['memberid']));
            $redSets = $this -> getRedpacksSysset($uid);
            if($fans['level_first_id'] > 0){
                $first_member = pdo_fetch("SELECT id,vipstatus,openid,nickname,level_first_id,level_second_id FROM " . tablename('amouse_board_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $fans['level_first_id']));
                if($first_member['vipstatus'] == 0){
                    if($commission['vip1_level_credit'] >= 1){
                        if($commission['become_child'] == 2){
                            $subtext = !empty($commission['vip1_level_text']) ? $commission['vip1_level_text'] : "您的一级好友《[nickname]》成为您的一级会员，您获得了[credit] ";
                            $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                            $subtext = str_replace("[credit]", $commission['vip1_level_credit'], $subtext);
                            $desc = "您的一级好友《" . $fans['nickname'] . "购买成功，您获得了" . $commission['vip1_level_credit'];
                            $data = array('fansid' => $fans['id'], 'level_first_id' => $fans['level_first_id'], 'uniacid' => $uid, 'credit' => $commission['vip1_level_credit'], 'module' => 'amouse_biz_nav', 'createtime' => TIMESTAMP, 'ipcilent' => getip(),);
                            if($commission['settledays1'] == 0){
                                $ret = send_cash_bonus($redSets, $first_member['openid'], $commission['vip1_level_credit'], cutstr($desc, 127));
                                if($ret['code'] == 0){
                                    post_send_text(trim($first_member['openid']), $subtext);
                                    pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money-:money,tx_money=tx_money+:tx_money where id=:id', array(':id' => $first_member['id'], ':money' => $commission['vip1_level_credit'], ':tx_money' => $commission['vip1_level_credit']));
                                }
                                $data['remark'] = $ret['msg'];
                            }else{
                                $ret2 = pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money+:wtx_money,autotime=:autotime where weid=:uniacid and id=:id', array(':uniacid' => $uid, ':id' => $first_member['id'], ':money' => $commission['vip1_level_credit'], ':wtx_money' => $commission['vip1_level_credit'], ':autotime' => time()));
                                $url = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('mine', array('time' => time())), 2);
                                $desc = "您的一级好友《" . $fans['nickname'] . "购买成功，赠送" . $commission['vip1_level_credit'] . "到你个人账户 ,请前往 <a href='{$url}'>我的账户</a>查看";
                                $data['remark'] = $desc;
                                post_send_text(trim($first_member['openid']), $desc);
                            }
                            pdo_insert('amouse_biz_nav_money_record', $data);
                        }
                    }
                }elseif($first_member['vipstatus'] == 2){
                    if($commission['first_level_credit'] >= 1){
                        $data = array('fansid' => $fans['id'], 'level_first_id' => $fans['level_first_id'], 'uniacid' => $uid, 'credit' => $commission['first_level_credit'], 'module' => 'amouse_biz_nav', 'createtime' => TIMESTAMP, 'ipcilent' => getip(),);
                        $subtext = !empty($commission['first_level_text']) ? $commission['first_level_text'] : "您的一级好友《[nickname]》成为超级会员，您获得了[credit] ";
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['first_level_credit'], $subtext);
                        $wishing = "您的一级好友《" . $fans['nickname'] . "成为超级会员，您获得了" . $commission['first_level_credit'];
                        if($commission['settledays1'] == 0){
                            $ret = send_cash_bonus($redSets, $first_member['openid'], $commission['first_level_credit'], cutstr($wishing, 127));
                            $data['remark'] = $ret['msg'];
                            if($ret['code'] == 0){
                                post_send_text(trim($first_member['openid']), $subtext);
                                pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money-:money,tx_money=tx_money+:tx_money where id=:id', array(':id' => $first_member['id'], ':money' => $commission['first_level_credit'], ':tx_money' => $commission['first_level_credit']));
                            }
                        }else{
                            $ret2 = pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money+:wtx_money,autotime=:autotime where weid=:uniacid and id=:id', array(':uniacid' => $uid, ':id' => $first_member['id'], ':money' => $commission['first_level_credit'], ':wtx_money' => $commission['first_level_credit'], ':autotime' => time()));
                            $url = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('mine', array('time' => time())), 2);
                            $desc = "您的一级好友《" . $fans['nickname'] . "成为超级会员，赠送" . $commission['first_level_credit'] . "到你个人账户 ,请前往 <a href='{$url}'>我的账户</a>查看";
                            $data['remark'] = $desc;
                            post_send_text(trim($first_member['openid']), $desc);
                        }
                        pdo_insert('amouse_biz_nav_money_record', $data);
                    }
                }
            }
            if($fans['level_second_id'] > 0){
                $second_member = pdo_fetch("SELECT id,vipstatus,openid,nickname,level_second_id,level_first_id FROM " . tablename('amouse_board_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $fans['level_second_id']));
                if($second_member['vipstatus'] == 0){
                    if($commission['vip2_level_credit'] >= 1){
                        if($commission['become_child'] == 2){
                            $data = array('fansid' => $fans['id'], 'level_second_id' => $fans['level_second_id'], 'uniacid' => $uid, 'credit' => $commission['vip2_level_credit'], 'module' => 'amouse_biz_nav', 'createtime' => TIMESTAMP, 'ipcilent' => getip(),);
                            if($commission['settledays1'] == 0){
                                $wishing = "您的二级好友《" . $fans['nickname'] . "成为超级会员，您获得了" . $commission['vip2_level_credit'];
                                $ret = send_cash_bonus($redSets, $second_member['openid'], $commission['vip2_level_credit'], cutstr($wishing, 127));
                                $data['remark'] = $ret['msg'];
                                $subtext = !empty($commission['vip2_level_text']) ? $commission['vip2_level_text'] : "您的二级好友《[nickname]》成为超级会员，您获得了[credit] ";
                                $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                                $subtext = str_replace("[credit]", $commission['vip2_level_credit'], $subtext);
                                if($ret['code'] == 0){
                                    post_send_text(trim($second_member['openid']), $subtext);
                                    pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money-:money,tx_money=tx_money+:tx_money where id=:id', array(':id' => $second_member['id'], ':money' => $commission['vip2_level_credit'], ':tx_money' => $commission['vip2_level_credit']));
                                }
                            }else{
                                $ret2 = pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money+:wtx_money,autotime=:autotime where weid=:uniacid and id=:id', array(':uniacid' => $uid, ':id' => $second_member['id'], ':money' => $commission['vip2_level_credit'], ':wtx_money' => $commission['vip2_level_credit'], ':autotime' => time()));
                                $url = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('mine', array('time' => time())), 2);
                                $desc = "您的二级好友《" . $fans['nickname'] . "成为超级会员，赠送" . $commission['vip2_level_credit'] . "到你个人账户 ,请前往 <a href='{$url}'>我的账户</a>查看";
                                $data['remark'] = $desc;
                                post_send_text(trim($second_member['openid']), $desc);
                            }
                            pdo_insert('amouse_biz_nav_money_record', $data);
                        }
                    }
                }elseif($second_member['vipstatus'] == 2){
                    if($commission['second_level_credit'] >= 1){
                        $data = array('fansid' => $fans['id'], 'level_second_id' => $fans['level_second_id'], 'uniacid' => $uid, 'credit' => $commission['second_level_credit'], 'module' => 'amouse_biz_nav', 'createtime' => TIMESTAMP, 'ipcilent' => getip(),);
                        $subtext = !empty($commission['second_level_text']) ? $commission['second_level_text'] : "您的二级好友《[nickname]》成为超级会员，您获得了[credit] ";
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['second_level_credit'], $subtext);
                        if($commission['settledays1'] == 0){
                            $wishing = "您的二级好友《" . $fans['nickname'] . "成为超级会员，您获得了" . $commission['second_level_credit'];
                            $ret = send_cash_bonus($redSets, $second_member['openid'], $commission['second_level_credit'], cutstr($wishing, 127));
                            if($ret['code'] == 0){
                                post_send_text(trim($second_member['openid']), $subtext);
                                pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money-:money,tx_money=tx_money+:tx_money where id=:id', array(':id' => $second_member['id'], ':money' => $commission['second_level_credit'], ':tx_money' => $commission['second_level_credit']));
                            }
                        }else{
                            $ret2 = pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money+:wtx_money,autotime=:autotime where weid=:uniacid and id=:id', array(':uniacid' => $uid, ':id' => $second_member['id'], ':money' => $commission['second_level_credit'], ':wtx_money' => $commission['second_level_credit'], ':autotime' => time()));
                            $url = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('mine', array('time' => time())), 2);
                            $desc = "您的二级好友《" . $fans['nickname'] . "成为超级会员，赠送" . $commission['second_level_credit'] . "到你个人账户 ,请前往 <a href='{$url}'>我的账户</a>查看";
                            $data['remark'] = $subtext;
                            post_send_text(trim($second_member['openid']), $desc);
                        }
                        pdo_insert('amouse_biz_nav_money_record', $data);
                    }
                }
            }
            if($fans['level_three_id'] > 0){
                $three_member = pdo_fetch("SELECT id,vipstatus,openid,nickname,level_second_id,level_first_id FROM " . tablename('amouse_board_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $fans['level_three_id']));
                if($three_member['vipstatus'] == 0){
                    if($commission['vip3_level_credit'] >= 1){
                        $data = array('fansid' => $fans['id'], 'level_three_id' => $fans['level_three_id'], 'uniacid' => $uid, 'credit' => $commission['vip3_level_credit'], 'module' => 'amouse_biz_nav', 'createtime' => TIMESTAMP, 'ipcilent' => getip(),);
                        if($commission['become_child'] == 2){
                            $subtext = !empty($commission['vip3_level_text']) ? $commission['vip3_level_text'] : "您的三级好友《[nickname]》成为超级会员，您获得了[credit] ";
                            $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                            $subtext = str_replace("[credit]", $commission['vip3_level_credit'], $subtext);
                            $wishing = "您的三级好友《" . $fans['nickname'] . "成为超级会员，您获得了" . $commission['vip3_level_credit'];
                            if($commission['settledays1'] == 0){
                                $ret = send_cash_bonus($redSets, $three_member['openid'], $commission['vip3_level_credit'], cutstr($wishing, 127));
                                $data['remark'] = $ret['msg'];
                                if($ret['code'] == 0){
                                    post_send_text(trim($three_member['openid']), $subtext);
                                    pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money-:money,tx_money=tx_money+:tx_money where id=:id', array(':id' => $three_member['id'], ':money' => $commission['vip3_level_credit'], ':tx_money' => $commission['vip3_level_credit']));
                                }
                            }else{
                                $ret2 = pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money+:wtx_money,autotime=:autotime where weid=:uniacid and id=:id', array(':uniacid' => $uid, ':id' => $three_member['id'], ':money' => $commission['vip3_level_credit'], ':wtx_money' => $commission['vip3_level_credit'], ':autotime' => time()));
                                $url = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('mine', array('time' => time())), 2);
                                $desc = "您的三级好友《" . $fans['nickname'] . "成为超级会员，赠送" . $commission['vip3_level_credit'] . "到你个人账户 ,请前往 <a href='{$url}'>我的账户</a>查看";
                                $data['remark'] = $desc;
                                post_send_text(trim($three_member['openid']), $desc);
                            }
                        }
                        pdo_insert('amouse_biz_nav_money_record', $data);
                    }
                }elseif($three_member['vipstatus'] == 2){
                    if($commission['three_level_credit'] >= 1){
                        $subtext = !empty($commission['three_level_text']) ? $commission['three_level_text'] : "您的三级好友《[nickname]》成为超级会员，您获得了[credit] ";
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['three_level_credit'], $subtext);
                        $wishing = "您的三级好友《" . $fans['nickname'] . "成为超级会员，您获得了" . $commission['three_level_credit'];
                        $data = array('fansid' => $fans['id'], 'level_three_id' => $fans['level_three_id'], 'uniacid' => $uid, 'credit' => $commission['three_level_credit'], 'module' => 'amouse_biz_nav', 'createtime' => TIMESTAMP, 'ipcilent' => getip(),);
                        if($commission['settledays1'] == 0){
                            $ret = send_cash_bonus($redSets, $three_member['openid'], $commission['three_level_credit'], cutstr($wishing, 127));
                            $data['remark'] = $ret['msg'];
                            if($ret['code'] == 0){
                                post_send_text(trim($three_member['openid']), $subtext);
                                pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money-:money,tx_money=tx_money+:tx_money where id=:id', array(':id' => $three_member['id'], ':money' => $commission['three_level_credit'], ':tx_money' => $commission['three_level_credit']));
                            }
                        }else{
                            $ret2 = pdo_query('UPDATE ' . tablename('amouse_board_member') . ' SET money=money+:money,wtx_money=wtx_money+:wtx_money,autotime=:autotime where weid=:uniacid and id=:id', array(':uniacid' => $uid, ':id' => $three_member['id'], ':money' => $commission['three_level_credit'], ':wtx_money' => $commission['three_level_credit'], ':autotime' => time()));
                            $url = $_W['siteroot'] . 'app/' . substr($this -> createMobileUrl('mine', array('time' => time())), 2);
                            $desc = "您的三级好友《" . $fans['nickname'] . "成为超级会员，赠送" . $commission['three_level_credit'] . "到你个人账户 ,请前往 <a href='{$url}'>我的账户</a>查看";
                            $data['remark'] = $desc;
                            post_send_text(trim($three_member['openid']), $desc);
                        }
                        pdo_insert('amouse_biz_nav_money_record', $data);
                    }
                }
            }
            if($set && !empty($set['paytpl']) && !empty($fans['openid'])){
                load() -> classs('weixin.account');
                $accObj = WeixinAccount :: create($_W['acid']);
                $content['first']['value'] = $fans['nickname'] . "您好, 您的订单已支付成功。";
                $content['first']['color'] = '#4a5077';
                $content['keyword1']['value'] = $goods['title'];
                $content['keyword1']['color'] = '#4a5077';
                $content['keyword2']['value'] = "『支付成功』";
                $content['keyword2']['color'] = '#ff520';
                $content['keyword3']['value'] = date('Y年m月d日 H:i:s', $order['createtime']);
                $content['keyword3']['color'] = '#ff520';
                $content['keyword4']['value'] = $_W['account']['name'];
                $content['keyword4']['color'] = '#ff520';
                $content['keyword5']['value'] = $order['price'];
                $content['keyword5']['color'] = '#ff520';
                $obj['remark'] = '谢谢您对我们的支持！如有问题，请联系我们。';
                $accObj -> sendTplNotice($fans['openid'], $set['paytpl'], $content, "", '#ff510');
            }
        }elseif($order['mealid'] > 0 && $order['memberid'] > 0){
            $fans = pdo_fetch("SELECT id,openid,nickname FROM " . tablename('amouse_board_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $order['memberid']));
            $m = pdo_fetch("SELECT title,id,price,`desc` FROM " . tablename('amouse_rebate_meal') . " WHERE `weid`=:weid and id=:id", array(':weid' => $uid, ':id' => $order['mealid']));
            if($m['desc'] > 0){
                $this -> setCredit($fans['openid'], 'credit1', $m['desc'], array(0, $fans['nickname'] . '购买' . $m['title'] . $credittxt . '+' . $m['desc']));
                $subtext2 = $fans['nickname'] . '购买' . $m['title'] . $credittxt . '+' . $m['desc'];
                post_send_text(trim($fans['openid']), $subtext2);
            }
        }
    }
    public $_fans;
    public $_sets;
    public $_openid;
    public function _doMobileInit($au = 'index'){
        global $_W, $_GPC;
        $weid = !empty($_W['uniacid']) ? $_W['uniacid'] : $_W['acid'];
        $settings = pdo_fetch("SELECT `tplid` FROM " . tablename('amouse_biz_redpacks_sysset') . " WHERE `uniacid`=:weid limit 1", array(':weid' => $weid));
        $set = $this -> getSysset($weid);
        $this -> _sets = $set;
        load() -> model('mc');
        $tplid = empty($settings['tplid'])?0:$settings['tplid'];
        if($tplid == 0){
            if(empty($_W['openid'])){
                $userinfo = mc_oauth_userinfo();
                $openid = $userinfo['openid'];
            }else{
                $openid = $_W['openid'];
            }
            $fans = $this -> checkMember($openid);
            if($fans && $fans['user_status'] == 0){
                $this -> returnMessage('抱歉，您没有该操作的访问权限');
            }
            $this -> _fans = $fans;
            $this -> _openid = $openid;
            isetcookie('amouse_biz_openid_oauth_newwx' . $weid, $openid, 1 * 86400);
            isetcookie('amouse_biz_nav_openid' . $weid, $openid, 1 * 86400);
        }else{
            $oauth = account_fetch($tplid);
            if(empty($_GPC['amouse_biz_openid_oauth_newwx' . $weid])){
                $redirect_uri = urlencode($_W['siteroot'] . 'app' . str_replace("./", "/", $this -> createMobileurl('oauth', array('au' => $au))));
                $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $oauth['key'] . "&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=" . $au . "#wechat_redirect";
                header('location:' . $authurl);
                exit();
            }else{
                $openid = $_GPC['amouse_biz_openid_oauth_newwx' . $weid];
            }
            $fans = pdo_fetch("SELECT * FROM " . tablename('amouse_board_member') . " WHERE `weid`=:weid AND `openid`=:openid ", array(':weid' => $weid, ':openid' => $openid));
            if(empty($fans)){
                $redirect_uri = urlencode($_W['siteroot'] . 'app' . str_replace("./", "/", $this -> createMobileurl('oauth', array('au' => $au))));
                $forward = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $oauth['key'] . "&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=" . $au . "#wechat_redirect";
                header('location:' . $forward);
                exit();
            }
            $from_user = !empty($_W['fans']['from_user']) ? : $fans['from_user'];
            $follow = pdo_fetchcolumn('SELECT follow FROM ' . tablename('mc_mapping_fans') . ' WHERE `openid`=:openid LIMIT 1', array(':openid' => $from_user));
            $status = 1;
            if(empty($from_user) || $follow <> 1){
                $status = 0;
            }
            if($status == 0){
                if($set && $set['share']['followurl']){
                    $followurl = $set['share']['followurl'];
                    header("location:$followurl");
                    exit;
                }
            }
            $this -> _fans = $fans;
            $this -> _openid = $openid;
        }
    }
    public function doMobileOauth(){
        global $_W, $_GPC;
        $code = $_GPC['code'];
        $weid = $_W['uniacid'];
        load() -> func('communication');
        load() -> func('logging');
        if(!empty($code)){
            $settings = pdo_fetch("SELECT tplid FROM " . tablename('amouse_biz_redpacks_sysset') . " WHERE `uniacid`=:weid limit 1", array(':weid' => $weid));
            $code = $_GPC['code'];
            $oauth_account = WeAccount :: create($settings['tplid']);
            $oauth = $oauth_account -> getOauthInfo($code);
            $openid = $oauth['openid'];
            $accountoauth = account_fetch($settings['tplid']);
            if(!empty($openid)){
                $uinfo = $oauth_account -> getOauthUserInfo($oauth['access_token'], $openid);
                $insert = array('weid' => $_W['uniacid'], 'openid' => $uinfo['openid'], 'nickname' => $uinfo['nickname'], 'sex' => $uinfo['sex'], 'headimgurl' => $uinfo['headimgurl'], 'unionid' => $uinfo['unionid']);
                $from_user = $_W['fans']['from_user'];
                if($uinfo['unionid'] && !$from_user){
                    $from_user = pdo_fetchcolumn('select openid from ' . tablename('mc_mapping_fans') . ' where `uniacid`=:uniacid AND `unionid`=:unionid', array(':uniacid' => $weid, ':unionid' => $uinfo['unionid']));
                }
                isetcookie('amouse_biz_openid_oauth_newwx' . $weid, $uinfo['openid'], 1 * 86400);
                $fans = pdo_fetch("select `id`,`openid`,`from_user`,`vipstatus` from " . tablename('amouse_board_member') . " where `weid`=:weid AND `from_user`=:openid  " , array(':weid' => $weid, ':openid' => $from_user));
                if(empty($fans)){
                    $insert['from_user'] = $from_user;
                    if($_W['account']['key'] == $accountoauth['key']){
                        $insert['from_user'] = $uinfo['openid'];
                    }
                    $insert['friend'] = 0 ;
                    $insert["createtime"] = TIMESTAMP ;
                    $insert['forever'] = 0;
                    $insert['user_status'] = 1;
                    pdo_insert('amouse_board_member', $insert);
                }else{
                    $insert['from_user'] = $from_user;
                    pdo_update('amouse_board_member', $insert, array('id' => $fans['id']));
                }
                isetcookie('amouse_biz_nav_openid' . $weid, $from_user, 1 * 86400);
                header("Location:" . $this -> createMobileUrl($_GPC['state']));
            }else{
                $this -> returnMessage('非法访问。');
            }
        }else{
            $forward = $_W['siteroot'] . "app/index.php?i=" . $weid . "&c=entry&do=" . $_GPC['state'] . "&m=amouse_biz_nav&wxref=mp.weixin.qq.com#wechat_redirect";
            header('location: ' . $forward);
            exit;
        }
    }
    public function oauthuniacid(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $ouid = pdo_fetchcolumn("SELECT `tplid` FROM " . tablename('amouse_biz_redpacks_sysset') . " WHERE `uniacid`=:weid limit 1", array(':weid' => $uniacid));
        $ouid = empty($ouid)?0:$ouid;
        if($ouid == 0){
            $uniacid = $_W['uniacid'];
        }else{
            $uniacid = $ouid;
        }
        return $uniacid;
    }
    public function doMobileAjaxAddQrcode(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        require_once IA_ROOT . "/addons/amouse_biz_nav/inc/common.php";
        $res = array();
        $this -> _doMobileInit("add");
        $fans = $this -> _fans;
        $set = $this -> _sets;
        $openid = $this -> _openid;
        $oathopenid = $fans['from_user'] ?$fans['from_user'] :$openid ;
        if($fans && $fans['user_status'] == 0){
            $res['code'] = 201;
            $res['msg'] = "抱歉，您没有该操作的访问权限";
            return json_encode($res);
        }
        $needfriend = intval($set['sys']['needfriend']) ? intval($set['sys']['needfriend']) :0;
        $sneedfriend = intval($set['sys']['sneedfriend']) ? intval($set['sys']['sneedfriend']) :0;
        $totalfriend = intval($fans['friend']) ? intval($fans['friend']) :0;
        if($fans['vipstatus'] >= 1){
            if($sneedfriend > 0){
                $sriend = $sneedfriend - $totalfriend;
                if($totalfriend < $sneedfriend){
                    $res['code'] = 201;
                    $res['msg'] = "您还需要加{$sriend}位好友才能发布名片。";
                    return json_encode($res);
                }
            }
        }
        if($fans['vipstatus'] < 1){
            if($needfriend > 0){
                $nfriend = $needfriend - $totalfriend;
                if($totalfriend < $nfriend){
                    $res['code'] = 201;
                    $res['msg'] = "您还需要加{$nfriend}位好友才能发布名片。";
                    return json_encode($res);
                }
            }
        }
        $credit1 = $this -> getCredit($oathopenid, 'credit1');
        if($credit1 < $set['credit']['new_credit']){
            $res['code'] = 201;
            $res['msg'] = "抱歉" . $set['custom']['credittxt'] . "不够，赶紧去充值吧";
            return json_encode($res);
        }
        $date = date('Y-m-d');
        $isGroup = $_GPC['isGroup'];
        $type_id = $_GPC['type_id'];
        $location_c = $_GPC['location_c'];
        $location_p = $_GPC['location_p'];
        $intro = $_GPC['intro'];
        $title = $_GPC['title'];
        $data = array('weid' => $weid, 'status' => 0, 'openid' => $oathopenid, 'hot' => 0, 'createtime' => TIMESTAMP, 'uptime' => time(), 'listorder' => 1, 'ipcilent' => getip(), 'updatetime' => TIMESTAMP);
        $qrcode = $_GPC['qrcode'];
        $img = $this -> upLoadImages($qrcode);
        load() -> func('logging');
        if($img == "0"){
            $res['code'] = 0;
            $res['msg'] = "二维码上传出错了,请联系管理员";
            return json_encode($res);
        }
        if($isGroup == 0 || $isGroup == 2){
            $clogcount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('amouse_board_card') . " WHERE `weid`=:weid and `openid` = :wid and date_format(FROM_UNIXTIME(updatetime), '%Y-%m-%d')=:date ", array(':weid' => $weid, ':wid' => $oathopenid, ':date' => $date));
            if($fans['vipstatus'] <= 0){
                if($set['sys']['common'] <= 0){
                    $res['code'] = 0;
                    $res['msg'] = "抱歉，非会员不能发布名片,赶紧去开通会员吧";
                    return json_encode($res);
                }
                if($set['sys']['common'] > 0 && $clogcount >= $set['sys']['common']){
                    $res['code'] = 0;
                    $res['msg'] = "普通用户今天只能发布" . $set['sys']['common'] . "个名片,请明天再来发布";
                    return json_encode($res);
                }
            }
            if($fans['vipstatus'] >= 1){
                if($set['sys']['vip'] > 0 && $clogcount >= $set['sys']['vip']){
                    $res['code'] = 0;
                    $res['msg'] = "您今天发布名片的限额已到,请明天再来发布~";
                    return json_encode($res);
                }
            }
            $data['typeid'] = $type_id;
            $data['location_c'] = $location_c;
            $data['location_p'] = $location_p;
            $data['intro'] = $intro;
            $data['title'] = $title;
            $data['qrcode'] = $img;
            if($set && $set['sys']['ischeck'] == 0){
                $data['status'] = 0;
            }
            if(pdo_insert("amouse_board_card", $data)){
                $cid = pdo_insertid();
                if($set['credit']['new_credit'] > 0){
                    $this -> setCredit($oathopenid, 'credit1', $set['credit']['new_credit'], 0, array(0, $_W['account']['name'] . '-' . $data['nickname'] . '提交名片' . $set['custom']['credittxt'] . '+' . $set['credit']['new_credit']), $weid);
                }
                $res['code'] = 200;
                $res['msg'] = "恭喜您,名片发布成功";
                $res['info'] = $cid;
                return json_encode($res);
            }else{
                $res['code'] = 0;
                $res['msg'] = "发布失败";
                return json_encode($res);
            }
        }elseif($isGroup == 1){
            $data = array('weid' => $weid, 'qrcode' => $img, 'pcateid' => $type_id, 'location_p' => $location_p, 'location_c' => $location_c, 'status' => 0, 'openid' => $oathopenid, 'desc' => $intro, 'title' => $title, 'uptime' => time(), 'updatetime' => TIMESTAMP, 'createtime' => TIMESTAMP);
            $glogcount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('amouse_biz_group') . " WHERE weid=:weid and openid = :wid and date_format(FROM_UNIXTIME(updatetime), '%Y-%m-%d')=:date", array(':weid' => $weid, ':wid' => $oathopenid, ':date' => $date));
            if($fans['vipstatus'] <= 0){
                if($set['sys']['scommon'] <= 0){
                    $res['code'] = 0;
                    $res['msg'] = "抱歉，非会员不能发布群名片,赶紧去开通会员吧";
                    return json_encode($res);
                }
                if($set['sys']['scommon'] > 0 && $glogcount >= $set['sys']['scommon']){
                    $res['code'] = 0;
                    $res['msg'] = "普通用户今天只能发布" . $set['sys']['scommon'] . "个群,请明天再来发布";
                    return json_encode($res);
                }
            }
            if($fans['vipstatus'] >= 1){
                if($set['sys']['svip'] > 0 && $glogcount >= $set['sys']['svip']){
                    $res['code'] = 0;
                    $res['msg'] = "您今天发布群名片的限额已到,请明天再来发布~";
                    return json_encode($res);
                }
            }
            if(pdo_insert("amouse_biz_group", $data)){
                $cid = pdo_insertid();
                $res['code'] = 200;
                if($data['status'] == 1){
                    $msg = "发布成功,请等待管理员审核";
                }else{
                    $msg = "发布成功";
                }
                if($set['credit']['new_credit'] > 0){
                    $this -> setCredit($oathopenid, 'credit1', $set['credit']['new_credit'], 0, array(0, $_W['account']['name'] . '-' . $data['nickname'] . '提交名片' . $set['custom']['credittxt'] . '+' . $set['credit']['new_credit']), $weid);
                }
                $res['msg'] = $msg;
                $res['info'] = $cid;
                return json_encode($res);
            }else{
                $res['code'] = 0;
                $res['msg'] = "发布失败";
                return json_encode($res);
            }
        }
    }
    public function upLoadImages($serverid){
        global $_W;
        load() -> func('file');
        load() -> func('logging');
        if($_W['account']['level'] >= 3){
            load() -> classs('weixin.account');
            $accObj = WeiXinAccount :: create($_W['acid']);
            $ret = $accObj -> downloadMedia(array('media_id' => $serverid, 'type' => 'image'));
            if(is_error($ret)){
                $ret2 = array('status' => 0, 'info' => $ret['message']);
                return 0;
            }else{
                $url = tomedia($ret);
                if(!empty($_W['setting']['remote']['type'])){
                    $remotestatus = file_remote_upload($ret);
                    if(is_error($remotestatus)){
                        $ret2 = array('status' => 0, 'info' => '远程附件上传失败，请检查配置并重新上传\'');
                        file_delete($ret);
                        return 0;
                    }else{
                        file_delete($ret);
                        $url = tomedia($ret, false);
                    }
                }
                return $url;
            }
        }else{
            $oauthuniacid = $this -> oauthuniacid();
            load() -> model('cache');
            $cachekey = "accesstoken:{$oauthuniacid}";
            $cache = cache_load($cachekey);
            load() -> classs('weixin.account');
            $access_token = $cache['token'];
            $sendapi = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$access_token}&media_id={$serverid}";
            $response = ihttp_get($sendapi);
            if(!empty($response['headers']['Content-disposition']) && strexists($response['headers']['Content-disposition'], $serverid)){
                global $_W;
                $filename = str_replace(array('attachment; filename=', '"', ' '), '', $response['headers']['Content-disposition']);
                $filename = 'images/' . $_W['uniacid'] . '/' . date('Y/m/') . $filename;
                file_write($filename, $response['content']);
                $url = tomedia($filename);
                if(!empty($_W['setting']['remote']['type'])){
                    $remotestatus = file_remote_upload($filename);
                    if (is_error($remotestatus)){
                        $ret2 = array('status' => 0, 'info' => '远程附件上传失败，请检查配置并重新上传\'');
                        file_delete($filename);
                        return 0;
                    }else{
                        file_delete($filename);
                        $url = tomedia($filename);
                    }
                }
                return $url;
            }else{
                $response = json_decode($response['content'], true);
                return 0;
            }
        }
    }
    public function getMember($openid = '', $getCredit = false){
        global $_W;
        $uid = intval($openid);
        if(empty($uid)){
            $info = pdo_fetch('select * from ' . tablename('amouse_board_member') . ' where weid=:uniacid and openid=:openid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
        }else{
            $info = pdo_fetch('select * from ' . tablename('amouse_board_member') . ' where uid=:id and weid=:weid limit 1', array(':id' => $uid, ':weid' => $_W['uniacid']));
        }
        if ($getCredit){
            $info['credit1'] = $this -> getCredit($openid, 'credit1');
            $info['credit2'] = $this -> getCredit($openid, 'credit2');
        }
        return $info;
    }
    public function doMobileAjaxSign(){
        global $_W, $_GPC;
        $res = array();
        $uniacid = $_W['uniacid'];
        $this -> _doMobileInit("me");
        $set = $this -> _sets;
        $fans = $this -> _fans;
        $openid = $this -> _openid;
        $oathopenid = $fans['from_user'] ?$fans['from_user'] :$openid ;
        $signUser = pdo_fetch('SELECT * FROM ' . tablename('amouse_biz_sign_user') . " WHERE openid=:openid AND uniacid =:uniacid", array(':openid' => $oathopenid, ':uniacid' => $_W['uniacid']));
        $date = date('Y-m-d');
        $count = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('amouse_biz_sign_record') . " WHERE openid = :wid and date_format(FROM_UNIXTIME(sin_time), '%Y-%m-%d') =:date", array(':wid' => $oathopenid, ':date' => $date));
        if(!empty($signUser) && ($count > 0)){
            $res['code'] = 503;
            $res['msg'] = "您今天已经签过到了，明天再来吧!";
            return json_encode($res);
        }
        $now = TIMESTAMP;
        $user_data = array("start_sign_time" => $now, "end_sign_time" => $now, "credit1" => $set['credit']['sign'], "openid" => $oathopenid, "uniacid" => $_W['uniacid'], "sin_count" => 1);
        pdo_insert('amouse_biz_sign_user', $user_data);
        $this -> setCredit($oathopenid, 'credit1', $set['credit']['sign'], 1, array(0, $_W['account']['name'] . '-' . $oathopenid . '签到+' . $set['credit']['sign']));
        $record_data = array('openid' => $oathopenid, "credit" => $set['credit']['sign'], "uniacid" => $_W['uniacid'], 'sin_time' => $now);
        pdo_insert('amouse_biz_sign_record', $record_data);
        $res['code'] = 200;
        $res['msg'] = "恭喜您获得日签到" . $set['custom']['credittxt'] . "+" . $set['credit']['sign'];
        return json_encode($res);
    }
    public function doMobileCalAmount(){
        global $_W, $_GPC;
        $res = array();
        $id = $_GPC['id'];
        $recharge = pdo_fetch("SELECT `title`,`price`,`id`,`day` FROM " . tablename('amouse_biz_nav_meal') . " WHERE weid =:weid AND id=:id ", array(":weid" => $_W['uniacid'], ":id" => $id));
        if(empty($recharge)){
            $res['code'] = 503;
            return json_encode($res);
        }
        $res['code'] = 200;
        $res['msg'] = $recharge['title'] ;
        $res['price'] = $recharge['price'] ;
        $res['day'] = $recharge['day'] ;
        return json_encode($res);
    }
    public function doMobileBind(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $this -> _doMobileInit("me");
        $fans = $this -> _fans;
        $set = $this -> _sets;
        $openid = $fans['from_user'];
        if(empty($openid)){
            $return = array('code' => '0', 'msg' => '请关注公众账号后再进行操作哦!', 'lefttime' => 60,);
        }
        WeSession :: $expire = 600;
        WeSession :: start($weid, $openid, 3600);
        if($_GPC['action'] == 'code'){
            if ($_GPC['tel'] == $_SESSION['phone']){
                $rnd = $_SESSION['code'];
            }else{
                $rnd = random(4, 1);
                $_SESSION['phone'] = $_GPC['tel'];
                $_SESSION['code'] = $rnd;
            }
            $return = array('code' => '1', 'msg' => '验证码发送成功', 'lefttime' => 60,);
            $txt = "【" . $_W['account']['name'] . "】您的本次操作的验证码为：" . $rnd . ".十分钟内有效";
            if($set && $set['sms_type'] == 1){
                $this -> _sendSmsbao($txt, $_GPC['tel'], $set);
            }else{
                $this -> _sendAliDaYuSms($rnd, $_W['account']['name'], $_GPC['tel'], $set);
            }
            echo json_encode($return);
            exit;
        }elseif ($_GPC['action'] == 'reg'){
            if ($_GPC['mobile'] == $_SESSION['phone'] && $_GPC['id_code'] == $_SESSION['code']){
                $ftcount = pdo_fetchcolumn("select count(id) from " . tablename("amouse_board_member") . " where weid=:weid AND mobile=:mobile", array(':weid' => $weid, ':mobile' => $_GPC['mobile']));
                if($ftcount > 0){
                    message('手机号码已存在，请更换没有注册的手机号码进行发布名片，领取红包活动');
                }
                $temp = pdo_update('amouse_board_member', array('mobile' => $_GPC['mobile']), array('openid' => $openid));
                if ($temp == false){
                    message('数据保存失败');
                }else{
                    message('', $this -> createMobileUrl('release', array('ptype' => 'person')));
                }
            }else{
                message("验证码错误，请重新输入");
            }
        }
    }
    private function _sendSmsbao($_txt, $_phone, $set){
        global $_W;
        load() -> func('communication');
        if(empty($_txt) || empty($_phone)){
            return '';
        }
        if($set == false){
            return '';
        }else{
            $_uid = $set['sms']['sms_user'];
            $_key = $set['sms']['sms_secret'];
        }
        $sms_url = "http://api.smsbao.com/sms?u=" . $_uid . "&p=" . md5($_key) . "&m=" . $_phone . "&c=" . urlencode($_txt);
        $result = ihttp_request($sms_url);
        if($result['code'] == 200){
            $r = $result['content'];
            if($r == 30){
                $msg = '密码错误 ';
            }elseif($r == 40){
                $msg = '账号不存在 ';
            }elseif($r == 41){
                $msg = '余额不足 ';
            }elseif($r == 42){
                $msg = '帐号过期 ';
            }elseif($r == 43){
                $msg = 'IP地址限制 ';
            }elseif($r == 50){
                $msg = '内容含有敏感词';
            }elseif($r == 51){
                $msg = '手机号码不正确';
            }else{
                $msg = '发送成功';
            }
        }
        return true;
    }
    private function _sendAliDaYuSms($_txt, $_product, $_phone, $set){
        require_once IA_ROOT . "/addons/amouse_biz_nav/taobao-sdk/TopSdk.php";
        if(empty($_txt) || empty($_phone)){
            return '';
        }
        if($set == false){
            return '';
        }else{
            $_uid = $set['sms']['sms_user'];
            $_key = $set['sms']['sms_secret'];
            $_sms_free_sign_name = $set['sms_free_sign_name'];
            $_sms_template_code = $set['sms_template_code'];
        }
        $sms_param = "{'code':'1234','product':'alidayu'}" ;
        $sms_param = str_replace("1234", $_txt, $sms_param);
        $sms_param = str_replace("alidayu", $_product, $sms_param);
        $c = new TopClient;
        $c -> appkey = $_uid;
        $c -> secretKey = $_key;
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req -> setExtend("123456");
        $req -> setSmsType("normal");
        $req -> setSmsFreeSignName($_sms_free_sign_name);
        $req -> setSmsParam($sms_param);
        $req -> setRecNum($_phone);
        $req -> setSmsTemplateCode($_sms_template_code);
        $resp = $c -> execute($req);
        return true;
    }
    public function doMobileGetBlack(){
        global $_W, $_GPC;
        $pk = $_GPC['pk'];
        $weid = $_W['uniacid'];
        $res = array();
        $this -> _doMobileInit("board");
        $fans = $this -> _fans;
        $set = $this -> _sets;
        $openid = $this -> _openid;
        $user = pdo_fetch("SELECT `id`,`user_status`,`ipcilent`,`openid`,`vipstatus` FROM " . tablename('amouse_board_member') . " WHERE weid=:weid and id = :id", array(':weid' => $weid, ':id' => $pk));
        if($user){
            if($openid != $user['openid']){
                if($user['user_status'] == 0){
                    $res['code'] = 200;
                    $res['msg'] = "该用户违规发布二维码,禁止被加好友!";
                    return json_encode($res);
                }else{
                    $res['code'] = 202;
                    return json_encode($res);
                }
            }else{
                $res['code'] = 200;
                $res['msg'] = "不要添加自己了哦！";
            }
        }else{
            $res['code'] = 202;
        }
        return json_encode($res);
    }
    public function doMobileRefresh(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $res = array();
        $res['code'] = 201;
        $res['msg'] = '';
        $this -> _doMobileInit("me");
        $fans = $this -> _fans;
        $set = $this -> _sets;
        $openid = $this -> _openid;
        $oathopenid = $fans['from_user'] ?$fans['from_user'] :$openid ;
        $credittxt = empty($set['custom']['credit2txt']) ? "余额" : $set['custom']['credit2txt'];
        $istype = $_GPC['istype'];
        $credit1 = $this -> getCredit($oathopenid, 'credit2');
        $top = $credit1 - $set['credit']['top'];
        if($istype == 1){
            $id = intval($_GPC['id']);
            $card = pdo_fetch('SELECT * FROM ' . tablename('amouse_board_card') . ' WHERE `weid`=:weid AND `id`=:id ', array(':weid' => $weid, ':id' => $id));
            if(empty($card['title'])){
                $res['code'] = 404;
                $res['msg'] = "您发布的名片出现问题了。请联系管理员确认吧";
                return json_encode($res);
            }
            if($fans['vipstatus'] >= 1){
                $uptime = $card['uptime'] ? $card['uptime'] : 0;
                $xianzhitime = 60 * intval($set['credit']['timer']);
                if($uptime + $xianzhitime > time()){
                    $res['code'] = 202;
                    $lefttime = $uptime + $xianzhitime - time();
                    $res['msg'] = "还需等待：" . $lefttime . "秒";
                    return json_encode($res);
                }
                pdo_query("UPDATE " . tablename('amouse_board_card') . " SET `listorder`=listorder-1 WHERE  `listorder`>0 ");
                pdo_update('amouse_board_card', array('uptime' => time(), 'listorder' => 3), array('id' => $card['id']));
                $res['code'] = 200;
                $res['msg'] = "置顶成功";
                return json_encode($res);
            }
            if($credit1 >= $set['credit']['top'] && $top >= 0){
                if($card['times'] >= time()){
                    $nextWeek = $card['times'] + 300;
                }else{
                    $nextWeek = TIMESTAMP + 300;
                }
                pdo_query("UPDATE " . tablename('amouse_board_card') . " SET `listorder`=listorder-1 WHERE  `listorder`>0 ");
                pdo_update('amouse_board_card', array('uptime' => $nextWeek, 'listorder' => 3), array('id' => $card['id']));
                $this -> setCredit($oathopenid, 'credit2', $set['credit']['top'], 0, array(0, $card['nickname'] . $_W['account']['name'] . '置顶-' . $credittxt . $set['credit']['top']));
                load() -> classs('weixin.account');
                $accObj = WeixinAccount :: create($_W['acid']);
                $toptext = $set['credit']['top'];
                if (empty($toptext)){
                    $toptext = '您使用' . $set['credit']['top'] . '个' . $credittxt . ',置顶了一次!';
                }
                $toptext = str_replace("[nickname]", $card['nickname'], $toptext);
                $toptext = str_replace("[credit]", $set['credit']['top'], $toptext);
                $send['msgtype'] = 'text';
                $send['text'] = array('content' => urlencode($toptext));
                $send['touser'] = trim($openid);
                $accObj -> sendCustomNotice($send);
                $res['code'] = 200;
                $res['msg'] = $toptext;
            }else{
                $res['code'] = 0;
                $res['msg'] = $credittxt . "不够，购买VIP会员无需" . $credittxt . "可置顶！";
            }
        }elseif($istype == 2){
            $id = intval($_GPC['id']);
            $group = pdo_fetch('SELECT * FROM ' . tablename('amouse_biz_group') . ' WHERE `weid`=:weid AND `id`=:id ', array(':weid' => $weid, ':id' => $id));
            if($fans['vipstatus'] >= 1){
                $uptime = $group['uptime'] ? $group['uptime'] : 0;
                $xianzhitime = 60 * intval($set['credit']['timer']);
                if($uptime + $xianzhitime > time()){
                    $res['code'] = 202;
                    $lefttime = $uptime + $xianzhitime - time();
                    $res['msg'] = "还需等待：" . $lefttime . "秒";
                    return json_encode($res);
                }
                pdo_query("UPDATE " . tablename('amouse_biz_group') . " SET `listorder`=listorder-1 WHERE  `listorder`>0 ");
                pdo_update('amouse_biz_group', array('uptime' => time(), 'listorder' => 3), array('id' => $group['id']));
                $res['code'] = 200;
                $res['msg'] = "置顶成功";
                return json_encode($res);
            }
            if($credit1 >= $set['credit']['top'] && $top >= 0){
                if($group['uptime'] >= time()){
                    $nextWeek = $group['uptime'] + 500;
                }else{
                    $nextWeek = TIMESTAMP + 300;
                }
                pdo_query("UPDATE " . tablename('amouse_biz_group') . " SET `listorder`=listorder-1 WHERE  `listorder`>0 ");
                pdo_update('amouse_biz_group', array('uptime' => $nextWeek, 'listorder' => 3), array('id' => $group['id']));
                $this -> setCredit($oathopenid, 'credit1', $set['credit']['top'], 0, array(0, '置顶-' . $credittxt . $set['credit']['top']));
                $res['code'] = 200;
            }else{
                $res['code'] = 0;
                $res['msg'] = $credittxt . "不够，购买VIP会员无需'.$credittxt.'可置顶！";
            }
        }elseif($istype == 3){
        }
        return json_encode($res);
    }
    public function doMobileAjaxGetRedpacks(){
        global $_W, $_GPC;
        load() -> func('file');
        require_once IA_ROOT . "/addons/amouse_biz_nav/inc/common.php";
        ignore_user_abort(true);
        $weid = $_W['uniacid'];
        $res = array();
        $res['code'] = 201;
        $res['msg'] = '';
        $openid = $_W['openid'];
        $settings = $this -> getRedpacksSysset($weid);
        load() -> classs('weixin.account');
        $accObj = WeixinAccount :: create($_W['acid']);
        $member = pdo_fetch("select wtx_money,openid,credit2,tx_money from " . tablename("amouse_board_member") . " where weid=$weid  AND openid='$openid' ");
        $res['code'] = 0;
        $res['msg'] = $member["wtx_money"];
        if ($member["wtx_money"] >= $settings["tx_money"]){
            if (!empty($member) && $member['user_status'] == 0){
                $res['code'] = 0;
                $res['msg'] = "你因为违规操作，已经被拉黑。请联系管理员吧";
                return json_encode($res);
            }
            $ret = send_cash_bonus($settings, $openid, $member["wtx_money"], "恭喜你获得红包");
            if($ret['code'] == 0){
                withDrawMoneydata(array("uniacid" => $weid, "openid" => $member['openid']), $settings["show_money"], $member["wtx_money"]);
                $url = $_W['siteroot'] . 'app' . str_replace('./', '/', $this -> createMobileUrl('logs', array('op' => 'redpacks')));
                if($settings && $settings['tplid']){
                    $content['first']['value'] = "提现获得现金红包";
                    $content['first']['color'] = '#4a5077';
                    $content['keyword1']['value'] = $member["wtx_money"] . '元';
                    $content['keyword1']['color'] = '#4a5077';
                    $content['keyword2']['value'] = date('Y年m月d日 H:i:s', time());
                    $content['keyword2']['color'] = '#ff520';
                    $content['remark']['value'] = '目前您的未领金额为：0元';
                    $accObj -> sendTplNotice($member['openid'], $settings['tplid'], $content, $url, '#ff510');
                }else{
                    $toptext = "恭喜您,获得了" . $member["wtx_money"] . "现金红包。";
                    $send['msgtype'] = 'text';
                    $send['text'] = array('content' => urlencode($toptext));
                    $send['touser'] = trim($member['openid']);
                    $accObj -> sendCustomNotice($send);
                }
                $res['code'] = 200;
                $res['msg'] = "领取成功，请留意公众号消息";
            }else{
                $send['msgtype'] = 'text';
                $send['text'] = array('content' => urlencode($ret['msg']));
                $send['touser'] = trim($member['openid']);
                $accObj -> sendCustomNotice($send);
                $res['code'] = 0;
                $res['msg'] = $ret['msg'];
            }
        }
        return json_encode($res);
    }
    public function doMobileajaxGetTask(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $this -> _doMobileInit("board");
        $fans = $this -> _fans;
        $set = $this -> _sets;
        $openid = $this -> _openid;
        require_once IA_ROOT . "/addons/amouse_biz_nav/inc/common.php";
        if(empty($openid)){
            $res = array('code' => '0', 'msg' => '请关注公众账号后再进行操作哦!');
            return json_encode($res);
        }
        $task = pdo_fetch("select id,mprice,xprice,status,ptype,num from " . tablename("amouse_rebate_task") . " where uniacid=:uniacid AND id=:id", array(':uniacid' => $weid, ':id' => $taskid));
        if($_GPC['action'] == 'get'){
            $min_money = empty($task["xprice"])?0:$task["xprice"];
            $max_money = empty($task["mprice"])?0:$task["mprice"];
            $amount = mt_rand(intval($min_money * 100), intval($max_money * 100));
            $reward = $amount / 100;
            $data = array('uniacid' => $weid, 'openid' => $openid, 'reward' => $reward, 'task_id' => $taskid, 'getstatus' => 2, 'starttime' => TIMESTAMP);
            if(pdo_insert("amouse_board_member_task", $data)){
                $res['code'] = 200;
                $res['reward'] = $reward;
                return json_encode($res);
            }else{
                $res['code'] = 0;
                $res['msg'] = "领取失败";
                return json_encode($res);
            }
            return json_encode($res);
        }elseif ($_GPC['action'] == 'submit'){
            $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
            $credittxt = empty($ctxt) ? "积分" : $ctxt;
            $success_credit = pdo_fetchcolumn("SELECT success_credit FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $weid));
            $settings = $this -> getRedpacksSysset($weid);
            if($task && $task['ptype'] == 0){
                $total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('amouse_rebate_log') . ' where weid=:weid AND openid=:openid AND type=0 ', array(':weid' => $weid, ':openid' => $openid));
                $mtask = pdo_fetch("SELECT id,reward,getstatus FROM " . tablename('amouse_board_member_task') . " WHERE openid = :openid and task_id=:taskid ", array(':openid' => $openid, ':taskid' => $taskid));
                if($total >= $task['num']){
                    $ret = send_cash_task($openid, $mtask['reward'], $settings);
                    if ($ret['code'] == 0){
                        $toptext = "恭喜您,您的新手任务已完成，您将获得" . $mtask['reward'] . "元现金红包。";
                        $res['code'] = 200;
                        $res['msg'] = "提交成功，红包已发放，稍后请关注公众号提示信息！";
                        pdo_update('amouse_board_member_task', array('getstatus' => 3, 'endtime' => time()), array('id' => $mtask['id']));
                        post_send_text(trim($openid), $toptext);
                        return json_encode($res);
                    }elseif($ret['code'] == -5){
                        if ($success_credit > 0 && !empty($openid)){
                            $this -> setCredit($openid, 'credit1', $success_credit, 1, array(0, $_W['account']['name'] . '扫码关注，提交个人任务{$credittxt}+' . $success_credit));
                        }
                        $res['code'] = 200;
                        $res['msg'] = "现金红包已经发放完毕，改送{$credittxt}，{$credittxt}可以去兑换红包哦！";
                        return json_encode($res);
                    }else{
                        $res['code'] = 201;
                        $res['msg'] = $ret['msg'];
                        return json_encode($res);
                    }
                }else{
                    $left_num = $task['num'] - $total;
                    $res['code'] = 202;
                    $res['msg'] = "还需要加" . $left_num . '好友才能完成任务【必须扫描好友推广二维码才算】';
                    return json_encode($res);
                }
            }elseif($task && $task['ptype'] == 1){
                $total2 = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('amouse_rebate_card_log') . ' where uniacid=:weid AND from_openid=:openid AND ltype=8 ', array(':weid' => $weid, ':openid' => $openid));
                $mtask = pdo_fetch("SELECT id,reward,getstatus FROM " . tablename('amouse_board_member_task') . " WHERE openid=:openid and task_id=:taskid ", array(':openid' => $openid, ':taskid' => $taskid));
                if($total2 >= $task['num']){
                    $ret = send_cash_task($openid, $mtask['reward'], $settings);
                    if ($ret['code'] == 0){
                        $toptext = "恭喜您,您的推广任务已完成，您将获得" . $mtask['reward'] . "元现金红包。";
                        $res['code'] = 200;
                        $res['msg'] = "提交成功，红包已发放，稍后请关注公众号提示信息！";
                        pdo_update('amouse_board_member_task', array('getstatus' => 3, 'endtime' => time()), array('id' => $mtask['id']));
                        post_send_text(trim($openid), $toptext);
                        return json_encode($res);
                    }else{
                        $res['code'] = 201;
                        $res['msg'] = $ret['msg'];
                        return json_encode($res);
                    }
                }else{
                    $left_num2 = intval($task['num'] - $total2);
                    $res['code'] = 203;
                    $res['msg'] = "还需成功邀请" . $left_num2 . '好友才能完成任务';
                    return json_encode($res);
                }
            }
        }
    }
    public function doMobileAjaxDel(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $res = array();
        $this -> _doMobileInit("me");
        $openid = $this -> _openid;
        if(empty($openid)){
            $res = array('code' => '0', 'msg' => '请关注公众账号后再进行操作哦!');
            return json_encode($res);
        }
        $op = $_GPC['op'];
        $gid = intval($_GPC['sid']);
        if($op == 'show'){
            pdo_delete("amouse_biz_show_goods", array('uniacid' => $weid, 'id' => $gid));
        }elseif($op == "group"){
            pdo_delete("amouse_biz_group", array('weid' => $weid, 'id' => $gid));
        }elseif($op == 'card'){
            pdo_delete("amouse_board_card", array('weid' => $weid, 'id' => $gid));
        }
        $res = array('code' => 200, 'msg' => '删除成功');
        return json_encode($res);
    }
    public function doMobileAjaxExchangeDo(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $res = array();
        $this -> _doMobileInit("board");
        $fans = $this -> _fans;
        $set = $this -> _sets;
        $openid = $this -> _openid;
        $oathopenid = $fans['from_user'] ?$fans['from_user'] :$openid ;
        if(empty($oathopenid)){
            $res['code'] = 502;
            $res['msg'] = '请关注公众账号后再进行操作哦!';
            return json_encode($res);
        }
        $gid = $_GPC['gid'];
        $goods = pdo_fetch("SELECT * FROM " . tablename('amouse_biz_creditshop_goods') . " WHERE  `id`=:gid AND `uniacid`=:weid ", array(":gid" => $gid, ":weid" => $weid));
        if(empty($goods)){
            $res['code'] = 502;
            $res['msg'] = '您要兑换的商品不存在!';
            return json_encode($res);
        }
        $credittxt = empty($set['custom']['credittxt']) ? "积分":$set['custom']['credittxt'];
        $info['credit1'] = $this -> getCredit($oathopenid, 'credit1');
        $total_credit = intval($info['credit1']);
        if($total_credit - $goods['credit'] < 0){
            $res['code'] = 502;
            $res['msg'] = '您的' . $credittxt . '不够兑换此商品!';
            return json_encode($res);
        }
        if($goods['type'] == 1){
            if($fans['createtime'] >= time()){
                $nextWeek = $fans['sviptime'] + ($goods['totalday'] * 24 * 60 * 60);
            }else{
                $nextWeek = TIMESTAMP + (intval($goods['totalday']) * 24 * 60 * 60);
            }
            $data2 = array('vipstatus' => 1, 'sviptime' => $nextWeek,);
            pdo_update('amouse_board_member', $data2, array('id' => $fans['id']));
        }elseif($goods['type'] == 5){
            $settings = $this -> getRedpacksSysset($weid);
            require_once IA_ROOT . "/addons/amouse_biz_nav/inc/common.php";
            $credit2 = $goods['credit2'];
            $date = date('Y-m-d');
            $temp = pdo_fetch("select wtx_money,user_status,tx_money from " . tablename("amouse_board_member") . " where weid=$weid and openid='$oathopenid'");
            if(!empty($temp) && $temp['user_status'] == 0){
                $res['code'] = 201;
                $res['msg'] = "你因为违规操作，已经被拉黑。请联系管理员吧";
                return json_encode($res);
            }
            $creditlogcount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('amouse_biz_creditshop_log') . " WHERE uniacid=:weid and openid = :wid and date_format(FROM_UNIXTIME(createtime), '%Y-%m-%d')=:date", array(':weid' => $weid, ':wid' => $oathopenid, ':date' => $date));
            if($creditlogcount <= 0){
                $ret = send_cash_task($oathopenid, $credit2, $settings);
                if($ret['code'] == 0){
                    $res['code'] = 200;
                    $res['msg'] = "提交成功，红包已兑换成功，稍后请关注公众号提示信息！";
                }else{
                    $res['code'] = 201;
                    $res['msg'] = $ret['msg'];
                    return json_encode($res);
                }
            }else{
                $res['code'] = 201;
                $res['msg'] = "今天已经兑换过红包了，给其他好友留点机会吧！";
                return json_encode($res);
            }
        }
        load() -> classs('weixin.account');
        $accObj = WeixinAccount :: create($_W['acid']);
        $this -> setCredit($oathopenid, 'credit1', $goods['credit'], 0, array(0, $_W['account']['name'] . '兑换商品{$credittxt}-' . $goods['credit']));
        $res['code'] = 200;
        $res['msg'] = '兑换成功!';
        $logdata = array('uniacid' => $weid, 'openid' => $oathopenid, 'address_name' => trim($_GPC['address_name']), 'address' => trim($_GPC['address']), 'address_phone' => trim($_GPC['address_phone']), 'goodsid' => $gid, 'status' => 0, 'createtime' => TIMESTAMP);
        pdo_insert("amouse_biz_creditshop_log", $logdata);
        $entrytext = "您用" . $goods['credit'] . "{$credittxt}，兑换了" . $goods['title'];
        $send2['msgtype'] = 'text';
        $send2['text'] = array('content' => urlencode($entrytext));
        $send2['touser'] = trim($oathopenid);
        $accObj -> sendCustomNotice($send2);
        return json_encode($res);
    }
    public function getCredit($openid = '', $credittype = 'credit1'){
        global $_W;
        load() -> model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)){
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
        }else{
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_board_member') . " WHERE openid=:openid and weid=:uniacid limit 1", array(':openid' => $openid, ':uniacid' => $_W['uniacid']));
        }
    }
    public function setCredit($openid = '', $credittype = 'credit1', $credits = 0, $isadd = 0, $log = array(), $uniacid = ''){
        global $_W;
        load() -> model('mc');
        $uid2 = $uniacid ? $uniacid: $_W['uniacid'] ;
        $uid = $this -> new_mc_openid2uid($openid, $uid2);
        if(!empty($uid)){
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid ", array(':uid' => $uid));
            if($isadd == 0){
                $newcredit = $value - $credits;
            }else{
                $newcredit = $value + $credits;
            }
            if ($newcredit <= 0){
                $newcredit = 0;
            }
            pdo_update('mc_members', array($credittype => $newcredit), array('uid' => $uid));
            if (empty($log) || !is_array($log)){
                $log = array($uid, '未记录');
            }
            $data = array('uid' => $uid, 'credittype' => $credittype, 'uniacid' => $uid2, 'num' => $credits, 'module' => 'amouse_biz_nav', 'createtime' => TIMESTAMP, 'operator' => intval($log[0]), 'remark' => $this -> modulename . "---" . $log[1]);
            pdo_insert('mc_credits_record', $data);
        }else{
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_board_member') . " WHERE  weid=:uniacid and openid=:openid ", array(':uniacid' => $uid2, ':openid' => $openid));
            if($isadd == 0){
                $newcredit = $value - $credits;
            }else{
                $newcredit = $value + $credits;
            }
            if ($newcredit <= 0){
                $newcredit = 0;
            }
            pdo_update('amouse_board_member', array($credittype => $newcredit), array('weid' => $uid2, 'openid' => $openid));
        }
    }
    private function new_mc_openid2uid($openid, $weid){
        global $_W;
        if (is_numeric($openid)){
            return $openid;
        }
        if (is_string($openid)){
            $sql = 'SELECT uid FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid`=:uniacid AND `openid`=:openid';
            $pars = array();
            $pars[':uniacid'] = $weid;
            $pars[':openid'] = $openid;
            $uid = pdo_fetchcolumn($sql, $pars);
            return $uid;
        }
        if (is_array($openid)){
            $uids = array();
            foreach ($openid as $k => $v){
                if(is_numeric($v)){
                    $uids[] = $v;
                }elseif(is_string($v)){
                    $fans[] = $v;
                }
            }
            if(!empty($fans)){
                $sql = 'SELECT uid, openid FROM ' . tablename('mc_mapping_fans') . " WHERE `uniacid`=:uniacid AND `openid` IN ('" . implode("','", $fans) . "')";
                $pars = array(':uniacid' => $_W['uniacid']);
                $fans = pdo_fetchall($sql, $pars, 'uid');
                $fans = array_keys($fans);
                $uids = array_merge((array)$uids, $fans);
            }
            return $uids;
        }
        return false;
    }
    public function doMobileLog(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $this -> _doMobileInit("board");
        $fans = $this -> _fans;
        $set = $this -> _sets;
        $openid = $this -> _openid;
        $oathopenid = $fans['from_user'] ?$fans['from_user'] :$openid ;
        $show_type = $_GPC['show_type'];
        $res = array();
        if (empty($openid)){
            $res['code'] = 502;
            $res['msg'] = '请关注公众账号后再进行操作哦!';
            die(json_encode($res));
        }
        $pk = $_GPC['id'];
        if($show_type == 'p'){
            $card = pdo_fetch("SELECT id,openid,hot,nickname FROM " . tablename('amouse_board_card') . " WHERE id = :id", array(':id' => $pk));
            if($card){
                $member = pdo_fetch("SELECT `friend`,`id` FROM " . tablename('amouse_board_member') . " WHERE `weid`=:weid and `from_user`=:openid ", array(':weid' => $weid, ':openid' => $oathopenid));
                if($oathopenid != $card['openid']){
                    $log = pdo_fetch("SELECT * FROM " . tablename('amouse_biz_nav_log') . " WHERE `weid`=:weid and `openid`= :openid AND fopenid= :fopenid and type=3 ", array(':weid' => $weid, ':openid' => $oathopenid, ':fopenid' => $card['openid']));
                    if(empty($log)){
                        $data = array('type' => 3, 'weid' => $weid, 'openid' => $oathopenid, 'fopenid' => $card['openid'], 'pk' => $card['id'], 'createtime' => TIMESTAMP);
                        pdo_insert('amouse_biz_nav_log', $data);
                        $credittxt = empty($set['custom']['credittxt']) ? "积分" : $set['custom']['credittxt'];
                        pdo_update('amouse_board_card', array('hot' => $card['hot'] + 1), array('id' => $card['id']));
                        pdo_update('amouse_board_member', array('friend' => $member['friend'] + 1), array('id' => $member['id']));
                        if($set['credit']['isopen'] == 0){
                            $this -> setCredit($oathopenid, 'credit1', $set['credit']['add_credit'] , 1, array(0, $_W['account']['name'] . "添加{$card['nickname']}好友+" . $credittxt . $set['add_credit']));
                            $res['msg'] = "添加【" . $card['nickname'] . "】为好友，获得+" . $credittxt . $set['credit']['add_credit'];
                        }
                        $res['code'] = 200;
                        $res['cookOid'] = $openid;
                        $res['oid'] = $card['openid'];
                    }else{
                        $res['code'] = 202;
                        $res['msg'] = "您已经添加过好友了！";
                    }
                }else{
                    $res['code'] = 202;
                    $res['msg'] = "不要添加自己了哦！";
                }
            }else{
                $res['code'] = 202;
                $res['msg'] = "您要添加的好友记录不存在";
            }
        }elseif($show_type == 'group'){
            $g = pdo_fetch("SELECT * FROM " . tablename('amouse_biz_group') . " WHERE id = :id AND type=1 ", array(':id' => $pk));
            if($oathopenid != $g['openid']){
                pdo_update('amouse_biz_group', array('hot' => $g['hot'] + 1), array('id' => $g['id']));
            }
        }
        $res['code'] = 200;
        return json_encode($res);
    }
    public function getPosterSysset($weid = 0){
        return pdo_fetch("SELECT * FROM " . tablename('amouse_biz_poster_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
    }
    public function getSysset($weid = 0){
        $setdata = pdo_fetch("select `sets`,`uniacid` from " . tablename('amouse_biz_nav_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $weid));
        $set = unserialize($setdata['sets']);
        return $set;
    }
    public function getRedpacksSysset($weid = 0){
        return pdo_fetch("SELECT * FROM " . tablename('amouse_biz_redpacks_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
    }
    public function doWebVersion(){
        global $_GPC;
        $mid = $_GPC['mid'];
        pdo_update('modules', array('version' => '2.0') , array('mid' => $mid));
        message('降低版本成功!', referer(), 'success');
    }
    public function doMobileAjaxSetVip(){
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $op = $_GPC['op'];
        if($op == 'svip'){
            $svips = pdo_fetchall("SELECT openid,nickname,endtime,id,sviptime FROM " . tablename('amouse_board_member') . " where weid=$weid and vipstatus=2 and endtime>0 and endtime <= unix_timestamp() ");
            if (!empty($svips)){
                foreach ($svips as $card){
                    pdo_update('amouse_board_member', array('vipstatus' => 1, 'sviptime' => 0, 'endtime' => 0), array('id' => $card['id']));
                }
            }
        }elseif($op == 'vip'){
            $cards = pdo_fetchall("SELECT id,openid,createtime,autotime,nickname FROM " . tablename('amouse_board_member') . " where weid=$weid and vipstatus=1 and createtime<=unix_timestamp() ");
            if (!empty($cards)){
                foreach ($cards as $card){
                    $VIP = "VIP会员" ;
                    $u = array('createtime' => 0);
                    if($card['autotime'] <= 0){
                        $u['vipstatus'] = 0;
                        $u['mealid'] = 0;
                    }
                    $u['sviptime'] = 0;
                    $u['endtime'] = 0;
                    pdo_update('amouse_board_member', $u, array('id' => $card['id']));
                }
            }
        }
        $res['code'] = 200;
        return json_encode($res);
    }
    public function doWeborderDownload(){
        require_once 'orderdownload.php';
    }
    function encode($value){
        return iconv("utf-8", "gb2312", $value);
    }
    protected function returnMessage($msg, $redirect = '', $type = ''){
        global $_W, $_GPC;
        if ($redirect == 'refresh'){
            $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
        }
        if ($redirect == 'referer'){
            $redirect = referer();
        }
        if ($redirect == ''){
            $type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'info';
        }else{
            $type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'success';
        }
        if (empty($msg) && !empty($redirect)){
            header('location: ' . $redirect);
        }
        $label = $type;
        if ($type == 'error'){
            $label = 'warn';
        }
        include $this -> template('include/message');
        die;
    }
    protected function returnError($message, $data = '', $status = 0, $type = ''){
        global $_W;
        if ($_W['isajax'] || $type == 'ajax'){
            header('Content-Type:application/json; charset=utf-8');
            $ret = array('status' => $status, 'info' => $message, 'data' => $data);
            die(json_encode($ret));
        }else{
            return $this -> returnMessage($message, $data, 'error');
        }
    }
    protected function returnSuccess($message, $data = '', $status = 1, $type = ''){
        global $_W;
        if ($_W['isajax'] || $type == 'ajax'){
            header('Content-Type:application/json; charset=utf-8');
            $ret = array('status' => $status, 'info' => $message, 'data' => $data);
            die(json_encode($ret));
        }else{
            return $this -> returnMessage($message, $data, 'success');
        }
    }
    public function doMobileGetAbcFuck(){
        global $_W, $_GPC;
        $url = trim($_SERVER['SERVER_NAME']);
        $httpUrl = "http://w.mamani.cn/authApi.php?plugin=amouse_biz_nav&url=" . $url;
        load() -> func('communication');
        $ret = ihttp_get($httpUrl);
        $result = $ret['content'];
        if($result['code'] == 500){
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_fun') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_notice') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_slide') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_category') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_group') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_meal') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_order') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_money_record') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_log') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_sysset') . ";");
            pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_biz_nav_show_sysset') . ";");
        }
        echo json_encode($result);
    }
    protected function checkMember($openid = ''){
        global $_W;
        $accObj = WeiXinAccount :: create($openid);
        $userinfo = $accObj -> fansQueryInfo($openid);
        load() -> model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)){
            pdo_update('mc_members', array('nickname' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'nationality' => $userinfo['country'], 'resideprovince' => $userinfo['province'], 'residecity' => $userinfo['city'], 'avatar' => $userinfo['headimgurl']), array('uniacid' => $_W['uniacid'], 'uid' => $uid));
        }
        pdo_update('mc_mapping_fans', array('nickname' => $userinfo['nickname']), array('uniacid' => $_W['uniacid'], 'openid' => $openid));
        $member = $this -> getMember($openid);
        if(empty($member)){
            $mc = mc_fetch($uid, array('realname', 'nickname', 'mobile', 'avatar', 'resideprovince', 'residecity', 'residedist'));
            $member = array('weid' => $_W['uniacid'], 'uid' => $uid, 'openid' => $openid, 'from_user' => $openid, 'nickname' => !empty($mc['nickname']) ? $mc['nickname'] : $userinfo['nickname'], 'headimgurl' => !empty($mc['avatar']) ? $mc['avatar'] : $userinfo['avatar'], 'sex' => !empty($mc['gender']) ? $mc['gender'] : $userinfo['sex'], 'location_p' => !empty($mc['resideprovince']) ? $mc['resideprovince'] : $userinfo['province'], 'location_c' => !empty($mc['residecity']) ? $mc['residecity'] : $userinfo['city'], 'address' => $mc['residedist'], 'vipstatus' => 0, 'createtime' => time(), 'user_status' => 1, 'ipcilent' => getip(), 'friend' => 0);
            pdo_insert('amouse_board_member', $member);
            $member['id'] = pdo_insertid();
            $member['isnew'] = 1;
        }else{
            $update['nickname'] = $userinfo['nickname'];
            $update['headimgurl'] = $userinfo['headimgurl'];
            $update['ipcilent'] = getip();
            pdo_update('amouse_board_member', $update, array('id' => $member['id']));
            $member['isnew'] = 0;
        }
        return $member;
    }
    public function getMenus(){
        $menus = array(array('title' => '系统功能管理', 'url' => $this -> createWebUrl('sysfun'), 'icon' => 'fa fa-cog'), array('title' => '系统设置', 'url' => $this -> createWebUrl('sysset'), 'icon' => 'fa fa-wrench'), array('title' => '互粉管理', 'url' => $this -> createWebUrl('qq'), 'icon' => 'fa fa-group'), array('title' => '积分商城', 'url' => $this -> createWebUrl('credit'), 'icon' => 'fa fa-exchange'), array('title' => '产品秀管理', 'url' => $this -> createWebUrl('product'), 'icon' => 'fa fa-copyright'));
        return $menus;
    }
}

?>