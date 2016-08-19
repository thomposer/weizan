<?php
error_reporting(0);
defined('IN_IA') or exit('Access Denied');
define("AMOUSE_REBATE", "amouse_rebate");
define("AMOUSE_REBATE_RES", "../addons/" . AMOUSE_REBATE . "/style/");
class Amouse_RebateModuleSite extends WeModuleSite
{
    public function doMobileRespondImage()
    {
        global $_W, $_GPC;
        load()->func('file');
        require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
        ignore_user_abort(true);
        $uniacid = $_W["uniacid"];
        $acid = $_W["acid"];
        $openid = $_GPC['openid'];
        $posterid = $_GPC['posterid'];
        $member = $this->getMember($openid);
        if (empty($member)) {
            exit;
        }
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($_W['acid']);
        $poster = pdo_fetch("SELECT * from " . tablename('amouse_rebate_poster_sysset') . "  where uniacid={$uniacid} and id={$posterid}");
        if (empty($poster)) {
            $accObj->sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("未找到推广二维码"))));
            return;
        }
        $waittext = !empty($poster['waittext']) ? $poster['waittext'] : '您的专属推广二维码正在拼命生成中，请等待片刻...';
        $accObj->sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($waittext))));
        $poster['memberid'] = $member['id'];
        $poster['uniacid'] = $uniacid;
        $poster['openid'] = $member['openid'];
        $poster['acid'] = $acid;
        $poster['nickname'] = $member['nickname'];
        $poster['avatar'] = $member['headimgurl'];
        $ret = newCreateBarcode($poster);
        if ($ret['code'] != 1) {
            exit;
        }
        if (empty($ret['media_id'])) {
            $target_file_url = tomedia($ret['qr_img']);
            $accObj->sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode("<a href='{$target_file_url}'>【点击这里查看您的专属推广二维码】</a>"))));
            exit;
        } else {
            $oktext = !empty($poster['oktext']) ? $poster['oktext'] : '您的专属推广二维码已大功告成!';
            $accObj->sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($oktext))));
            $accObj->sendCustomNotice(array("touser" => $openid, "msgtype" => "image", "image" => array('media_id' => $ret['media_id'])));
            return;
        }
    }
    public function doMobileAjaxOrder()
    {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        if ($_W['container'] != 'wechat') {
            $res['code'] = 500;
            $res['msg'] = '应用目前仅支持在微信中访问';
            return json_encode($res);
        }
        $mid = $_GPC['meal_id'];
        $openid = $_W['fans']['from_user'];
        $m = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_meal') . " WHERE `weid`=:weid and id=:id", array(':weid' => $uniacid, ':id' => $mid));
        if (empty($m)) {
            $res['code'] = 500;
            $res['msg'] = '您要购买的套餐不存在，或者被删除，请联系管理员';
            return json_encode($res);
        }
        $member = pdo_fetch("SELECT id,nickname,wechatno,vipstatus FROM " . tablename('amouse_rebate_member') . " WHERE `weid`=:weid and openid=:openid ", array(':weid' => $uniacid, ':openid' => $openid));
        $orderno = date('YmdHis') . random(4, 1);
        $orderData = array('ordersn' => $orderno, 'mealid' => $mid, 'uniacid' => $uniacid, 'openid' => $openid, 'nickname' => $member['nickname'], 'memberid' => $member['id'], 'price' => intval($m['price']), 'status' => 0, 'createtime' => TIMESTAMP);
        if (pdo_insert("amouse_rebate_order", $orderData)) {
            $oid = pdo_insertid();
            $res['code'] = 200;
            $res['oid'] = $oid;
        } else {
            $res['code'] = 0;
            $res['msg'] = "提交订单失败";
        }
        return json_encode($res);
    }
    public function doMobileAjaxBuyOrder()
    {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        if ($_W['container'] != 'wechat') {
            $res['code'] = 500;
            $res['msg'] = '应用目前仅支持在微信中访问';
            return json_encode($res);
        }
        $openid = $_W['openid'];
        $username = $_GPC['username'];
        $moblie = $_GPC['moblie'];
        $gid = $_GPC['gid'];
        $buynum = intval($_GPC['buynum']);
        $location_p = $_GPC['location_p'];
        $location_c = $_GPC['location_c'];
        $location_d = $_GPC['location_d'];
        $address = $_GPC['address'];
        $member = pdo_fetch("SELECT id,nickname,wechatno,vipstatus FROM " . tablename('amouse_rebate_member') . " WHERE `weid`=:weid and openid=:openid ", array(':weid' => $uniacid, ':openid' => $openid));
        $goods = pdo_fetch("SELECT price FROM " . tablename('amouse_rebate_goods') . " WHERE `uniacid`=:weid and id=:gid ", array(':weid' => $uniacid, ':gid' => $gid));
        if (empty($goods)) {
            $res['code'] = 0;
            $res['msg'] = "购买商品出错了,请联系管理员";
            return json_encode($res);
        }
        $price = $goods['price'] * $buynum;
        $orderno = date('YmdHis') . random(4, 1);
        $orderData = array('ordersn' => $orderno, 'uniacid' => $uniacid, 'openid' => $openid, 'nickname' => $member['nickname'], 'memberid' => $member['id'], 'uid' => $gid, 'province' => $location_p, 'city' => $location_c, 'dist' => $location_d, 'address' => $address, 'mobile' => $moblie, 'username' => $username, 'price' => $price, 'num' => $buynum, 'status' => 0, 'createtime' => TIMESTAMP);
        if (pdo_insert("amouse_rebate_order", $orderData)) {
            $oid = pdo_insertid();
            $res['code'] = 200;
            $res['oid'] = $oid;
            return json_encode($res);
        } else {
            $res['code'] = 0;
            $res['msg'] = "提交订单失败";
            return json_encode($res);
        }
    }
    public function payResult($params)
    {
        global $_W;
        $uniacid = $params['uniacid'];
        $data = array('status' => $params['result'] == 'success' ? 1 : 0);
        $paytype = array('credit' => '1', 'wechat' => '2', 'alipay' => '2', 'delivery' => '3', 'yunpay' => '4');
        $data['paytype'] = $paytype[$params['type']];
        if ($params['type'] == 'wechat') {
            $data['transid'] = $params['tag']['transaction_id'];
        }
        if ($params['type'] == 'delivery') {
            $data['status'] = 1;
        }
        $order = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_order') . " WHERE `uniacid` = :uniacid and id=:id ", array(':uniacid' => $uniacid, ':id' => $params['tid']));
        if ($params['fee'] != $order['price']) {
            $url = $_W['siteroot'] . 'app/' . substr($this->createMobileUrl('board', array('op' => 'step1', 'time' => time())), 2);
            $url = str_replace("payment/yunpay/", '', $url);
            $this->returnMessage('抱歉，您支付出问题了。', $url);
        }
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            pdo_update('amouse_rebate_order', $data, array('id' => $params['tid']));
            pdo_update('amouse_rebate_member', array('vipstatus' => 2), array('weid' => $uniacid, 'id' => $order['memberid']));
            $this->processCommision($uniacid, $order);
        }
        if ($params['from'] == 'return') {
            if ($params['result'] == 'success') {
                $url = $_W['siteroot'] . 'app/' . substr($this->createMobileUrl('board', array('op' => 'step1', 'time' => time())), 2);
                $url = str_replace("payment/yunpay/", '', $url);
                header('location:' . $url);
                exit;
            } else {
                $this->returnMessage('支付失败。', '../../app/' . $this->createMobileUrl('board', array('op' => 'step1', 'time' => time())), 'error');
            }
        }
    }
    private function processCommision($uid, $order)
    {
        require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
        global $_W;
        $credittxt = pdo_fetch("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
        $commission = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_commission_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
        $set = pdo_fetch("SELECT paytpl,mtpl,acid FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $uid));
        $goods = pdo_fetch('select id,title,price from ' . tablename('amouse_rebate_goods') . ' where uniacid=:weid AND id=:id and status=1 ', array(':weid' => $uid, ':id' => $order['uid']));
        if ($order['uid'] > 0 && $order['memberid'] > 0) {
            $fans = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $order['memberid']));
            $redSets = $this->getRedpacksSysset($uid);
            if ($fans['level_three_id'] > 0) {
                $three_member = pdo_fetch("SELECT id,vipstatus,openid,nickname,level_second_id,level_first_id FROM " . tablename('amouse_rebate_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $fans['level_three_id']));
                if ($three_member['vipstatus'] == 0) {
                    if ($commission['vip3_level_credit'] >= 1) {
                        if ($commission['become_child'] == 2) {
                            $subtext = !empty($commission['vip3_level_text']) ? $commission['vip3_level_text'] : "您的三级好友《[nickname]》成为超级会员，您获得了[credit] ";
                            $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                            $subtext = str_replace("[credit]", $commission['vip3_level_credit'], $subtext);
                            post_send_text(trim($three_member['openid']), $subtext);
                            send_cash_bonus($redSets, $three_member['openid'], $commission['vip3_level_credit'], $subtext);
                        }
                    }
                } elseif ($three_member['vipstatus'] == 2) {
                    if ($commission['three_level_credit'] >= 1) {
                        $subtext = !empty($commission['three_level_text']) ? $commission['three_level_text'] : "您的三级好友《[nickname]》成为超级会员，您获得了[credit] ";
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['three_level_credit'], $subtext);
                        post_send_text(trim($three_member['openid']), $subtext);
                        if ($redSets['is_open_money'] == 0) {
                            send_cash_bonus($redSets, $three_member['openid'], $commission['three_level_credit'], $subtext);
                        }
                    }
                }
            }
            if ($fans['level_second_id'] > 0) {
                $second_member = pdo_fetch("SELECT id,vipstatus,openid,nickname,level_second_id,level_first_id FROM " . tablename('amouse_rebate_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $fans['level_second_id']));
                if ($second_member['vipstatus'] == 0) {
                    if ($commission['vip2_level_credit'] >= 1) {
                        if ($commission['become_child'] == 2) {
                            $subtext = !empty($commission['vip2_level_text']) ? $commission['vip2_level_text'] : "您的二级好友《[nickname]》成为超级会员，您获得了[credit] ";
                            $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                            $subtext = str_replace("[credit]", $commission['vip2_level_credit'], $subtext);
                            post_send_text(trim($second_member['openid']), $subtext);
                            if ($redSets['is_open_money'] == 0) {
                                send_cash_bonus($redSets, $second_member['openid'], $commission['vip2_level_credit'], $subtext);
                            }
                        }
                    }
                } elseif ($second_member['vipstatus'] == 2) {
                    if ($commission['second_level_credit'] >= 1) {
                        $subtext = !empty($commission['second_level_text']) ? $commission['second_level_text'] : "您的二级好友《[nickname]》成为超级会员，您获得了[credit] ";
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['second_level_credit'], $subtext);
                        post_send_text(trim($second_member['openid']), $subtext);
                        if ($redSets['is_open_money'] == 0) {
                            send_cash_bonus($redSets, $second_member['openid'], $commission['second_level_credit'], $subtext);
                        }
                    }
                }
            }
            if ($fans['level_first_id'] > 0) {
                $first_member = pdo_fetch("SELECT id,vipstatus,openid,nickname,level_first_id,level_second_id FROM " . tablename('amouse_rebate_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $fans['level_first_id']));
                if ($first_member['vipstatus'] == 0) {
                    if ($commission['vip1_level_credit'] >= 1) {
                        if ($commission['become_child'] == 2) {
                            $subtext = !empty($commission['vip1_level_text']) ? $commission['vip1_level_text'] : "您的二级好友《[nickname]》成为超级会员，您获得了[credit] ";
                            $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                            $subtext = str_replace("[credit]", $commission['vip1_level_credit'], $subtext);
                            post_send_text(trim($first_member['openid']), $subtext);
                            if ($redSets['is_open_money'] == 0) {
                                send_cash_bonus($redSets, $first_member['openid'], $commission['vip1_level_credit'], $subtext);
                            }
                        }
                    }
                } elseif ($first_member['vipstatus'] == 2) {
                    if ($commission['first_level_credit'] >= 1) {
                        $subtext = !empty($commission['first_level_text']) ? $commission['first_level_text'] : "您的一级好友《[nickname]》成为超级会员，您获得了[credit] ";
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['first_level_credit'], $subtext);
                        post_send_text(trim($first_member['openid']), $subtext);
                        if ($redSets['is_open_money'] == 0) {
                            send_cash_bonus($redSets, $first_member['openid'], $commission['first_level_credit'], $subtext);
                        }
                    }
                }
            }
            if ($set && !empty($set['paytpl']) && !empty($fans['openid'])) {
                $obj['firstvalue'] = $fans['nickname'] . "您好, 您的订单已支付成功。";
                $obj['keyword1'] = $goods['title'];
                $obj['keyword2'] = "『支付成功』";
                $obj['keyword3'] = date('Y年m月d日 H:i:s', $order['createtime']);
                $obj['keyword4'] = $_W['account']['name'];
                $obj['remark'] = '谢谢您对我们的支持！如有问题，请联系我们。';
                $obj['acid'] = $_W['acid'];
                send_template_message($fans['openid'], $set['paytpl'], $obj);
            } else {
                post_send_text(trim($fans['openid']), $fans['nickname'] . "您好, 您的订单已支付成功,购买套餐" . $goods['title'] . "。如有问题，请联系我们。");
            }
        } elseif ($order['mealid'] > 0 && $order['memberid'] > 0) {
            $fans = pdo_fetch("SELECT id,openid,nickname FROM " . tablename('amouse_rebate_member') . " WHERE weid =:weid AND id=:id ", array(':weid' => $uid, ':id' => $order['memberid']));
            $m = pdo_fetch("SELECT title,id,price,`desc` FROM " . tablename('amouse_rebate_meal') . " WHERE `weid`=:weid and id=:id", array(':weid' => $uid, ':id' => $order['mealid']));
            if ($m['desc'] > 0) {
                $this->setCredit($fans['openid'], 'credit1', $m['desc'], array(0, $fans['nickname'] . '购买' . $m['title'] . $credittxt . '+' . $m['desc']));
                $subtext2 = $fans['nickname'] . '购买' . $m['title'] . $credittxt . '+' . $m['desc'];
                post_send_text(trim($fans['openid']), $subtext2);
            }
        }
    }
    public function getMember($openid = '', $getCredit = false)
    {
        global $_W;
        $uid = intval($openid);
        if (empty($uid)) {
            $info = pdo_fetch('select id,openid,unionid,nickname,wechatno,sex,headimgurl,location_p,location_c,friend,hot,createtime,credit1,credit2,uid,user_status,mobile,address,vipstatus,level_first_id,level_second_id,level_three_id,status,qrcode  from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and openid=:openid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
        } else {
            $info = pdo_fetch('select id,openid,unionid,nickname,wechatno,sex,headimgurl,location_p,location_c,friend,hot,createtime,credit1,credit2,uid,user_status,mobile,address,vipstatus,level_first_id,level_second_id,level_three_id,status,qrcode from ' . tablename('amouse_rebate_member') . ' where uid=:id and weid=:weid limit 1', array(':id' => $uid, ':weid' => $_W['uniacid']));
        }
        if ($getCredit) {
            $info['credit1'] = $this->getCredit($openid, 'credit1');
            $info['credit2'] = $this->getCredit($openid, 'credit2');
        }
        return $info;
    }
    public function doMobileAjaxSign()
    {
        global $_W;
        $res = array();
        $openid = $_W['openid'];
        $signUser = pdo_fetch('SELECT * FROM ' . tablename('amouse_rebate_sign_user') . " WHERE openid=:openid AND uniacid =:uniacid", array(':openid' => $openid, ':uniacid' => $_W['uniacid']));
        $sign_crdit = pdo_fetchcolumn("SELECT sign_credit FROM" . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $_W['uniacid']));
        $date = date('Y-m-d');
        $count = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('amouse_rebate_sign_record') . " WHERE openid = :wid and date_format(FROM_UNIXTIME(sin_time), '%Y-%m-%d') =:date", array(':wid' => $openid, ':date' => $date));
        if (!empty($signUser) && $count > 0) {
            $res['code'] = 503;
            $res['msg'] = "您今天已经签过到了，明天再来吧!";
            return json_encode($res);
        }
        $now = TIMESTAMP;
        $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $_W['uniacid']));
        $crtxt = empty($ctxt) ? "积分" : $ctxt;
        $user_data = array("start_sign_time" => $now, "end_sign_time" => $now, "credit1" => $sign_crdit, "openid" => $openid, "uniacid" => $_W['uniacid'], "sin_count" => 1);
        pdo_insert('amouse_rebate_sign_user', $user_data);
        $this->setCredit($openid, 'credit1', $sign_crdit, 1, array(0, $_W['account']['name'] . '-' . $openid . '签到+' . $sign_crdit));
        $record_data = array('openid' => $openid, "credit" => $sign_crdit, 'sin_time' => $now);
        pdo_insert('amouse_rebate_sign_record', $record_data);
        $res['code'] = 200;
        $res['msg'] = "恭喜您获得日签到" . $crtxt . "+" . $sign_crdit;
        return json_encode($res);
    }
    public function doMobileBind()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $openid = $_W['fans']['from_user'];
        if (empty($openid)) {
            $return = array('code' => '0', 'msg' => '请关注公众账号后再进行操作哦!', 'lefttime' => 60);
        }
        $set = $this->getSysset($weid);
        WeSession::$expire = 600;
        WeSession::start($weid, $openid, 3600);
        if ($_GPC['action'] == 'code') {
            if ($_GPC['tel'] == $_SESSION['phone']) {
                $rnd = $_SESSION['code'];
            } else {
                $rnd = random(4, 1);
                $_SESSION['phone'] = $_GPC['tel'];
                $_SESSION['code'] = $rnd;
            }
            $return = array('code' => '1', 'msg' => '验证码发送成功', 'lefttime' => 60);
            $txt = "【" . $_W['account']['name'] . "】您的本次操作的验证码为：" . $rnd . ".十分钟内有效";
            if ($set && $set['sms_type'] == 1) {
                $this->_sendSmsbao($txt, $_GPC['tel']);
            } else {
                $this->_sendAliDaYuSms($rnd, $_W['account']['name'], $_GPC['tel'], $set);
            }
            echo json_encode($return);
            exit;
        } elseif ($_GPC['action'] == 'reg') {
            if ($_GPC['mobile'] == $_SESSION['phone'] && $_GPC['id_code'] == $_SESSION['code']) {
                $ftcount = pdo_fetchcolumn("select count(id) from " . tablename("amouse_rebate_member") . " where weid=:weid AND mobile=:mobile", array(':weid' => $weid, ':mobile' => $_GPC['mobile']));
                if ($ftcount > 0) {
                    message('手机号码已存在，请更换没有注册的手机号码进行发布名片，领取红包活动');
                }
                $temp = pdo_update('amouse_rebate_member', array('mobile' => $_GPC['mobile']), array('openid' => $openid));
                if ($temp == false) {
                    message('数据保存失败');
                } else {
                    message('', $this->createMobileUrl('release', array('ptype' => 'person')));
                }
            } else {
                message("验证码错误，请重新输入");
            }
        }
    }
    private function _sendSmsbao($_txt, $_phone)
    {
        global $_W;
        load()->func('communication');
        if (empty($_txt) || empty($_phone)) {
            return '';
        }
        $sms = pdo_fetch("SELECT sms_user,sms_secret FROM " . tablename('amouse_rebate_sysset') . " WHERE weid = :weid", array(':weid' => $_W['uniacid']));
        if ($sms == false) {
            return '';
        } else {
            $_uid = $sms['sms_user'];
            $_key = $sms['sms_secret'];
        }
        $sms_url = "http://api.smsbao.com/sms?u=" . $_uid . "&p=" . md5($_key) . "&m=" . $_phone . "&c=" . urlencode($_txt);
        $result = ihttp_request($sms_url);
        if ($result['code'] == 200) {
            $r = $result['content'];
            if ($r == 30) {
                $msg = '密码错误 ';
            } elseif ($r == 40) {
                $msg = '账号不存在 ';
            } elseif ($r == 41) {
                $msg = '余额不足 ';
            } elseif ($r == 42) {
                $msg = '帐号过期 ';
            } elseif ($r == 43) {
                $msg = 'IP地址限制 ';
            } elseif ($r == 50) {
                $msg = '内容含有敏感词';
            } elseif ($r == 51) {
                $msg = '手机号码不正确';
            } else {
                $msg = '发送成功';
            }
        }
        return true;
    }
    private function _sendAliDaYuSms($_txt, $_product, $_phone, $set)
    {
        require_once IA_ROOT . "/addons/amouse_rebate/taobao-sdk/TopSdk.php";
        if (empty($_txt) || empty($_phone)) {
            return '';
        }
        if ($set == false) {
            return '';
        } else {
            $_uid = $set['sms_user'];
            $_key = $set['sms_secret'];
            $_sms_free_sign_name = $set['sms_free_sign_name'];
            $_sms_template_code = $set['sms_template_code'];
        }
        $sms_param = "{'code':'1234','product':'alidayu'}";
        $sms_param = str_replace("1234", $_txt, $sms_param);
        $sms_param = str_replace("alidayu", $_product, $sms_param);
        $c = new TopClient();
        $c->appkey = $_uid;
        $c->secretKey = $_key;
        $req = new AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($_sms_free_sign_name);
        $req->setSmsParam($sms_param);
        $req->setRecNum($_phone);
        $req->setSmsTemplateCode($_sms_template_code);
        $resp = $c->execute($req);
        return true;
    }
    public function doMobileAjaxPerson()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
        $res = array();
        $set = $this->getSysset($weid);
        $openid = $_W['openid'];
        $fans = $this->checkMember($openid);
        if ($fans && $fans['user_status'] == 0) {
            $res['code'] = 201;
            $res['msg'] = "抱歉，您没有该操作的访问权限";
            return json_encode($res);
        }
        $needfriend = $set['needfriend'] - $fans['friend'];
        if ($fans['friend'] < $set['needfriend']) {
            $res['code'] = 201;
            $res['msg'] = "您还需要加{$needfriend}位好友才能发布名片。";
            return json_encode($res);
        }
        $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
        $crtxt = empty($ctxt) ? "积分" : $ctxt;
        if (empty($fans['wechatno'])) {
            $Ccount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('amouse_rebate_member') . " WHERE `weid`=:weid and wechatno=:wechatno ", array(':weid' => $weid, ':wechatno' => trim($_GPC['wechatno'])));
            if ($Ccount > 0) {
                $res['code'] = 0;
                $res['msg'] = "微信号已经存在，请填写正确的微信号";
                return json_encode($res);
            }
            $data2 = array('wechatno' => $_GPC['wechatno'], 'qrcode' => $_GPC['qrcode'], 'status' => 0, 'location_p' => $_GPC['location_p'], 'location_c' => $_GPC['location_c'], 'listorder' => 1, 'ipcilent' => getip(), 'times' => TIMESTAMP + 240, 'updatetime' => TIMESTAMP, 'intro' => $_GPC['intro']);
            if ($set && $set['ischeck'] == 0) {
                $data2['status'] = 1;
            }
            if (pdo_update("amouse_rebate_member", $data2, array('id' => $fans['id']))) {
                $res['message'] = $fans['id'];
                if ($set['new_credit'] > 0) {
                    $this->setCredit($openid, 'credit1', $set['new_credit'], 1, array(0, $data2['nickname'] . '提交名片' . $crtxt . '+' . $set['new_credit']));
                }
                $res['code'] = 200;
                $res['msg'] = "恭喜您,名片发布成功,获得" . $set['new_credit'] . $crtxt;
            } else {
                $res['code'] = 0;
                $res['msg'] = "名片发布失败";
            }
            return json_encode($res);
        } else {
            $Ucount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('amouse_rebate_member') . " WHERE `weid`=:weid and wechatno=:wechatno and id!=:cid ", array(':weid' => $weid, ':wechatno' => $_GPC['wechatno'], ':cid' => $fans['id']));
            if ($Ucount > 0) {
                $res['code'] = 0;
                $res['msg'] = "微信号已经存在，请填写正确的微信号";
                return json_encode($res);
            }
            $data2 = array('wechatno' => $_GPC['wechatno'], 'qrcode' => $_GPC['qrcode'], 'location_p' => $_GPC['location_p'], 'location_c' => $_GPC['location_c'], 'ipcilent' => getip(), 'times' => TIMESTAMP + 240, 'updatetime' => TIMESTAMP, 'intro' => $_GPC['intro']);
            if ($set && $set['ischeck'] == 0) {
                $data2['status'] = 1;
            }
            if (pdo_update("amouse_rebate_member", $data2, array('id' => $fans['id']))) {
                $res['code'] = 200;
                $res['message'] = $fans['id'];
                return json_encode($res);
            }
        }
    }
    public function doMobileLog()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $set = $this->getSysset($weid);
        $res = array();
        require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
        $openid = $_W['fans']['from_user'];
        if (empty($openid)) {
            $res['code'] = 502;
            $res['msg'] = '请关注公众账号后再进行操作哦!';
            die(json_encode($res));
        }
        $pk = $_GPC['pk'];
        $card = pdo_fetch("SELECT id,hot,openid,nickname,headimgurl,ipcilent FROM " . tablename('amouse_rebate_member') . " WHERE weid=:weid AND id=:id", array(':weid' => $weid, ':id' => $pk));
        if ($card) {
            if (getip() == $card['ipcilent']) {
                $res['code'] = 202;
                $res['cookOid'] = $openid;
                $res['msg'] = "添加好友异常";
            }
            if ($openid != $card['openid']) {
                $log = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_log') . " WHERE openid =:openid AND fopenid= :fopenid and type=1 ", array(':openid' => $openid, ':fopenid' => $card['openid']));
                if (empty($log)) {
                    $data = array('type' => 1, 'weid' => $weid, 'openid' => $openid, 'fopenid' => $card['openid'], 'pk' => $card['id'], 'credit' => $set['add_credit'], 'createtime' => TIMESTAMP);
                    pdo_insert('amouse_rebate_log', $data);
                    pdo_update('amouse_rebate_member', array('hot' => $card['hot'] + 1, 'friend' => $card['friend'] + 1), array('openid' => $openid));
                    $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
                    $crtxt = empty($ctxt) ? "积分" : $ctxt;
                    if ($set && $set['isopen'] == 0) {
                        $this->setCredit($openid, 'credit1', $set['add_credit'], 1, array(0, $_W['account']['name'] . "添加{$member['nickname']}好友+" . $crtxt . $set['add_credit']));
                        $res['code'] = 200;
                        $res['cookOid'] = $openid;
                        $res['oid'] = $card['openid'];
                        $res['msg'] = "添加【" . $card['nickname'] . "】为好友，获得+" . $crtxt . $set['add_credit'];
                    } else {
                        $res['code'] = 200;
                        $entrytext = "向【" . $card['nickname'] . "】索取推广图片，可获得" . $crtxt . "哦! <a href='" . $set['creditlink'] . "'>" . $crtxt . "说明</a>";
                        load()->classs('weixin.account');
                        $accObj = WeixinAccount::create($_W['acid']);
                        $send2['msgtype'] = 'text';
                        $send2['text'] = array('content' => urlencode($entrytext));
                        $send2['touser'] = trim($openid);
                        $accObj->sendCustomNotice($send2);
                        $res['msg'] = $entrytext;
                    }
                } else {
                    $res['code'] = 202;
                    $res['cookOid'] = $openid;
                    $res['msg'] = "您已经添加过此好友了！";
                }
            } else {
                $res['code'] = 202;
                $res['cookOid'] = $openid;
                $res['oid'] = $card['openid'];
                $res['msg'] = "不要添加自己了哦！";
            }
        } else {
            $res['code'] = 202;
            $res['cookOid'] = $openid;
            $res['msg'] = "您要添加的好友记录不存在";
        }
        return json_encode($res);
    }
    public function doMobileRefresh()
    {
        global $_W;
        $weid = $_W['uniacid'];
        $res = array();
        $res['code'] = 201;
        $res['msg'] = '';
        $openid = $_W['fans']['from_user'];
        $set = $this->getSysset($weid);
        $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
        $credittxt = empty($ctxt) ? "积分" : $ctxt;
        $card = pdo_fetch('select id,uptime,times,vipstatus,nickname,openid,wechatno from ' . tablename('amouse_rebate_member') . ' where weid=:weid AND openid=:openid ', array(':weid' => $weid, ':openid' => $openid));
        if (empty($card['wechatno'])) {
            $res['code'] = 404;
            $res['msg'] = "您发布的名片出现问题了。请联系管理员确认吧";
            return json_encode($res);
        }
        if ($card['vipstatus'] > 1) {
            $uptime = $card['uptime'] ? $card['uptime'] : 0;
            $xianzhitime = 60 * intval($set['timer']);
            if ($card['isauto'] == 0) {
                if ($uptime + $xianzhitime > time()) {
                    $res['code'] = 202;
                    $lefttime = $uptime + $xianzhitime - time();
                    $res['msg'] = "还需等待：" . $lefttime . "秒";
                    return json_encode($res);
                }
            }
            pdo_update('amouse_rebate_member', array('uptime' => time()), array('id' => $card['id']));
            $res['code'] = 200;
            $res['msg'] = "置顶成功";
            return json_encode($res);
        }
        $credit1 = $this->getCredit($openid, 'credit1');
        $top = $credit1 - $set['top_credit'];
        if ($credit1 >= $set['top_credit'] && $top >= 0) {
            if ($card['times'] >= time()) {
                $nextWeek = $card['times'] + 300;
            } else {
                $nextWeek = TIMESTAMP + 300;
            }
            pdo_update('amouse_rebate_member', array('listorder' => 1, 'times' => $nextWeek, 'uptime' => time()), array('id' => $card['id']));
            $this->setCredit($openid, 'credit1', $set['top_credit'], 0, array(0, $card['nickname'] . $_W['account']['name'] . '置顶-' . $ctxt . $set['top_credit']));
            load()->classs('weixin.account');
            $accObj = WeixinAccount::create($_W['acid']);
            $toptext = $set['top_text'];
            if (empty($toptext)) {
                $toptext = '您使用' . $set['top_credit'] . '个{$credittxt},置顶了一次!';
            }
            $toptext = str_replace("[nickname]", $card['nickname'], $toptext);
            $toptext = str_replace("[credit]", $set['top_credit'], $toptext);
            $send['msgtype'] = 'text';
            $send['text'] = array('content' => urlencode($toptext));
            $send['touser'] = trim($openid);
            $accObj->sendCustomNotice($send);
            $res['code'] = 200;
            $res['msg'] = $toptext;
        } else {
            $res['code'] = 0;
            $res['msg'] = $credittxt . "不够，购买VIP会员无需'.{$credittxt}.'可置顶！";
        }
        return json_encode($res);
    }
    public function doMobileAjaxVipExchange()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $res = array();
        $openid = $_GPC['amouse_rebate_openid' . $weid];
        if (empty($openid)) {
            $openid = $_W['fans']['from_user'];
        }
        if (empty($openid)) {
            $res['code'] = 502;
            $res['msg'] = '请关注公众账号后再进行操作哦!';
            die(json_encode($res));
        }
        $credittxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
        $credittxt = empty($credittxt) ? "积分" : $credittxt;
        $meal_id = $_GPC['meal_id'];
        $m = pdo_fetch("SELECT id,price,day,type FROM " . tablename('amouse_rebate_meal') . " WHERE `weid`=:weid and id=:id", array(':weid' => $weid, ':id' => $meal_id));
        if (empty($m)) {
            $res['code'] = 500;
            $res['msg'] = '您要兑换的产品不存在，或者被删除，请联系管理员';
            return json_encode($res);
        }
        $info['credit1'] = $this->getCredit($openid, 'credit1');
        $total_credit = intval($info['credit1']);
        if ($total_credit - intval($m['price']) < 0) {
            $res['code'] = 502;
            $res['msg'] = "您的" . $credittxt . "不足噢!";
            die(json_encode($res));
        }
        $card = pdo_fetch('select createtime,id,vipstatus,isauto,endtime,sviptime from ' . tablename('amouse_rebate_member') . ' where weid=:weid AND openid=:openid LIMIT 1', array(':weid' => $weid, ':openid' => $openid));
        $day = intval($m['day']);
        if ($m['type'] == 5) {
            if ($card['createtime'] >= time()) {
                $nextWeek = $card['createtime'] + $day * 24 * 60 * 60;
            } else {
                $nextWeek = TIMESTAMP + $day * 24 * 60 * 60;
            }
            $data = array();
            if ($card['vipstatus'] != 2) {
                $data['vipstatus'] = 1;
                $data['createtime'] = $nextWeek;
            }
            if ($card['isauto'] != 1) {
                $data['isauto'] = 0;
            }
            pdo_update('amouse_rebate_member', $data, array('id' => $card['id']));
        } elseif ($m['type'] == 7) {
            $data['vipstatus'] = 2;
            $timer = time();
            if ($card['vipstatus'] == 2) {
                $svipStartTime = $card['sviptime'];
                $svipEndTime = $card['endtime'] + $day * 60;
            } else {
                $svipStartTime = $timer;
                $svipEndTime = $svipStartTime + $day * 60;
            }
            $data['sviptime'] = $svipStartTime;
            $data['endtime'] = $svipEndTime;
            pdo_update('amouse_rebate_member', $data, array('id' => $card['id']));
        }
        $this->setCredit($openid, 'credit1', intval($m['price']), 0, array(0, $_W['account']['name'] . '兑换VIP-' . $credittxt . intval($m['price'])));
        $res['code'] = 200;
        $res['msg'] = '兑换成功!';
        return json_encode($res);
    }
    public function doMobileAjaxGetRedpacks()
    {
        global $_W, $_GPC;
        load()->func('file');
        require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
        ignore_user_abort(true);
        $weid = $_W['uniacid'];
        $res = array();
        $res['code'] = 201;
        $res['msg'] = '';
        $openid = $_W['openid'];
        $settings = $this->getRedpacksSysset($weid);
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($_W['acid']);
        $member = pdo_fetch("select wtx_money,openid,credit2,tx_money from " . tablename("amouse_rebate_member") . " where weid={$weid}  AND openid='{$openid}' ");
        $res['code'] = 0;
        $res['msg'] = $member["wtx_money"];
        if ($member["wtx_money"] >= $settings["tx_money"]) {
            if (!empty($member) && $member['user_status'] == 0) {
                $res['code'] = 0;
                $res['msg'] = "你因为违规操作，已经被拉黑。请联系管理员吧";
                return json_encode($res);
            }
            $ret = send_cash_bonus($settings, $openid, $member["wtx_money"], "恭喜你获得红包");
            if ($ret['code'] == 0) {
                withDrawMoneydata(array("uniacid" => $weid, "openid" => $member['openid']), $settings["show_money"], $member["wtx_money"]);
                $url = $_W['siteroot'] . 'app' . str_replace('./', '/', $this->createMobileUrl('logs', array('op' => 'redpacks')));
                if ($settings && $settings['tplid']) {
                    $content['first']['value'] = "提现获得现金红包";
                    $content['first']['color'] = '#4a5077';
                    $content['keyword1']['value'] = $member["wtx_money"] . '元';
                    $content['keyword1']['color'] = '#4a5077';
                    $content['keyword2']['value'] = date('Y年m月d日 H:i:s', time());
                    $content['keyword2']['color'] = '#ff520';
                    $content['remark']['value'] = '目前您的未领金额为：0元';
                    $accObj->sendTplNotice($member['openid'], $settings['tplid'], $content, $url, '#ff510');
                } else {
                    $toptext = "恭喜您,获得了" . $member["wtx_money"] . "现金红包。";
                    $send['msgtype'] = 'text';
                    $send['text'] = array('content' => urlencode($toptext));
                    $send['touser'] = trim($member['openid']);
                    $accObj->sendCustomNotice($send);
                }
                $res['code'] = 200;
                $res['msg'] = "领取成功，请留意公众号消息";
            } else {
                $send['msgtype'] = 'text';
                $send['text'] = array('content' => urlencode($ret['msg']));
                $send['touser'] = trim($member['openid']);
                $accObj->sendCustomNotice($send);
                $res['code'] = 0;
                $res['msg'] = $ret['msg'];
            }
        }
        return json_encode($res);
    }
    public function doMobileajaxGetTask()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $openid = $_GPC['amouse_rebate_openid' . $weid];
        $taskid = $_GPC['taskid'];
        if (empty($openid)) {
            $openid = $_W['fans']['from_user'];
        }
        require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
        if (empty($openid)) {
            $res = array('code' => '0', 'msg' => '请关注公众账号后再进行操作哦!');
            return json_encode($res);
        }
        $task = pdo_fetch("select id,mprice,xprice,status,ptype,num from " . tablename("amouse_rebate_task") . " where uniacid=:uniacid AND id=:id", array(':uniacid' => $weid, ':id' => $taskid));
        if ($_GPC['action'] == 'get') {
            $min_money = empty($task["xprice"]) ? 0 : $task["xprice"];
            $max_money = empty($task["mprice"]) ? 0 : $task["mprice"];
            $amount = mt_rand(intval($min_money * 100), intval($max_money * 100));
            $reward = $amount / 100;
            $data = array('uniacid' => $weid, 'openid' => $openid, 'reward' => $reward, 'task_id' => $taskid, 'getstatus' => 2, 'starttime' => TIMESTAMP);
            if (pdo_insert("amouse_rebate_member_task", $data)) {
                $res['code'] = 200;
                $res['reward'] = $reward;
                return json_encode($res);
            } else {
                $res['code'] = 0;
                $res['msg'] = "领取失败";
                return json_encode($res);
            }
            return json_encode($res);
        } elseif ($_GPC['action'] == 'submit') {
            $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
            $credittxt = empty($ctxt) ? "积分" : $ctxt;
            $success_credit = pdo_fetchcolumn("SELECT success_credit FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $weid));
            $settings = $this->getRedpacksSysset($weid);
            if ($task && $task['ptype'] == 0) {
                $total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('amouse_rebate_log') . ' where weid=:weid AND openid=:openid AND type=0 ', array(':weid' => $weid, ':openid' => $openid));
                $mtask = pdo_fetch("SELECT id,reward,getstatus FROM " . tablename('amouse_rebate_member_task') . " WHERE openid = :openid and task_id=:taskid ", array(':openid' => $openid, ':taskid' => $taskid));
                if ($total >= $task['num']) {
                    $ret = send_cash_task($openid, $mtask['reward'], $settings);
                    if ($ret['code'] == 0) {
                        $toptext = "恭喜您,您的新手任务已完成，您将获得" . $mtask['reward'] . "元现金红包。";
                        $res['code'] = 200;
                        $res['msg'] = "提交成功，红包已发放，稍后请关注公众号提示信息！";
                        pdo_update('amouse_rebate_member_task', array('getstatus' => 3, 'endtime' => time()), array('id' => $mtask['id']));
                        post_send_text(trim($openid), $toptext);
                        return json_encode($res);
                    } elseif ($ret['code'] == -5) {
                        if ($success_credit > 0 && !empty($openid)) {
                            $this->setCredit($openid, 'credit1', $success_credit, 1, array(0, $_W['account']['name'] . '扫码关注，提交个人任务{$credittxt}+' . $success_credit));
                        }
                        $res['code'] = 200;
                        $res['msg'] = "现金红包已经发放完毕，改送{$credittxt}，{$credittxt}可以去兑换红包哦！";
                        return json_encode($res);
                    } else {
                        $res['code'] = 201;
                        $res['msg'] = $ret['msg'];
                        return json_encode($res);
                    }
                } else {
                    $left_num = $task['num'] - $total;
                    $res['code'] = 202;
                    $res['msg'] = "还需要加" . $left_num . '好友才能完成任务【必须扫描好友推广二维码才算】';
                    return json_encode($res);
                }
            } elseif ($task && $task['ptype'] == 1) {
                $total2 = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('amouse_rebate_card_log') . ' where uniacid=:weid AND from_openid=:openid AND ltype=8 ', array(':weid' => $weid, ':openid' => $openid));
                $mtask = pdo_fetch("SELECT id,reward,getstatus FROM " . tablename('amouse_rebate_member_task') . " WHERE openid=:openid and task_id=:taskid ", array(':openid' => $openid, ':taskid' => $taskid));
                if ($total2 >= $task['num']) {
                    $ret = send_cash_task($openid, $mtask['reward'], $settings);
                    if ($ret['code'] == 0) {
                        $toptext = "恭喜您,您的推广任务已完成，您将获得" . $mtask['reward'] . "元现金红包。";
                        $res['code'] = 200;
                        $res['msg'] = "提交成功，红包已发放，稍后请关注公众号提示信息！";
                        pdo_update('amouse_rebate_member_task', array('getstatus' => 3, 'endtime' => time()), array('id' => $mtask['id']));
                        post_send_text(trim($openid), $toptext);
                        return json_encode($res);
                    } else {
                        $res['code'] = 201;
                        $res['msg'] = $ret['msg'];
                        return json_encode($res);
                    }
                } else {
                    $left_num2 = intval($task['num'] - $total2);
                    $res['code'] = 203;
                    $res['msg'] = "还需成功邀请" . $left_num2 . '好友才能完成任务';
                    return json_encode($res);
                }
            }
        }
    }
    public function doMobileBianmin()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $set = pdo_fetch("SELECT copyright FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $weid));
        include $this->template('bianmin');
    }
    public function doMobileAjaxExchangeDo()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $res = array();
        $openid = $_W['fans']['from_user'];
        if (empty($openid)) {
            $res['code'] = 502;
            $res['msg'] = '请关注公众账号后再进行操作哦!';
            die(json_encode($res));
        }
        $gid = $_GPC['gid'];
        $goods = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_creditshop_goods') . " WHERE  id={$gid} AND uniacid={$weid} ");
        if (empty($goods)) {
            $res['code'] = 502;
            $res['msg'] = '您要兑换的商品不存在!';
            die(json_encode($res));
        }
        $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uniacid));
        $credittxt = empty($ctxt) ? "积分" : $ctxt;
        $info['credit1'] = $this->getCredit($openid, 'credit1');
        $total_credit = intval($info['credit1']);
        if ($total_credit - $goods['credit'] < 0) {
            $res['code'] = 502;
            $res['msg'] = '您的' . $credittxt . '不够兑换此商品!';
            die(json_encode($res));
        }
        $data2 = array('uniacid' => $weid, 'openid' => $openid, 'address_name' => trim($_GPC['address_name']), 'address' => trim($_GPC['address']), 'address_phone' => trim($_GPC['address_phone']), 'goodsid' => $gid, 'status' => 0, 'createtime' => TIMESTAMP);
        $card = pdo_fetch('select id,vipstatus,createtime,sviptime,endtime from ' . tablename('amouse_rebate_member') . ' where weid=:weid AND openid=:openid LIMIT 1', array(':weid' => $weid, ':openid' => $openid));
        if ($goods['type'] == 1) {
            if ($card['createtime'] >= time()) {
                $nextWeek = $card['createtime'] + $goods['totalday'] * 24 * 60 * 60;
            } else {
                $nextWeek = TIMESTAMP + intval($goods['totalday']) * 24 * 60 * 60;
            }
            $data = array();
            if ($card['vipstatus'] != 2) {
                $data['vipstatus'] = 1;
                $data['createtime'] = $nextWeek;
            }
            $data['uptime'] = time();
            pdo_update('amouse_rebate_member', $data, array('id' => $card['id']));
        } elseif ($goods['type'] == 4) {
            $day = $goods['totalday'];
            $data['vipstatus'] = 2;
            $timer = time();
            if ($card['vipstatus'] == 2) {
                $svipStartTime = $card['sviptime'];
                $svipEndTime = $card['endtime'] + $day * 60;
            } else {
                $svipStartTime = $timer;
                $svipEndTime = $svipStartTime + $day * 60;
            }
            $data['sviptime'] = $svipStartTime;
            $data['endtime'] = $svipEndTime;
            pdo_update('amouse_rebate_member', $data, array('id' => $card['id']));
        } elseif ($goods['type'] == 5) {
            $settings = $this->getRedpacksSysset($weid);
            require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
            $credit2 = $goods['credit2'];
            $date = date('Y-m-d');
            $temp = pdo_fetch("select wtx_money,user_status,tx_money from " . tablename("amouse_rebate_member") . " where weid={$weid} and openid='{$openid}'");
            if (!empty($temp) && $temp['user_status'] == 0) {
                $res['code'] = 201;
                $res['msg'] = "你因为违规操作，已经被拉黑。请联系管理员吧";
                return json_encode($res);
            }
            $creditlogcount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('amouse_rebate_creditshop_log') . " WHERE uniacid=:weid and openid = :wid and date_format(FROM_UNIXTIME(createtime), '%Y-%m-%d')=:date", array(':weid' => $weid, ':wid' => $openid, ':date' => $date));
            if ($creditlogcount <= 0) {
                $ret = send_cash_task($openid, $credit2, $settings);
                if ($ret['code'] == 0) {
                    $res['code'] = 200;
                    $res['msg'] = "提交成功，红包已兑换成功，稍后请关注公众号提示信息！";
                } else {
                    $res['code'] = 201;
                    $res['msg'] = $ret['msg'];
                    return json_encode($res);
                }
            } else {
                $res['code'] = 201;
                $res['msg'] = "今天已经兑换过红包了，给其他好友留点机会吧！";
                return json_encode($res);
            }
        }
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($_W['acid']);
        $this->setCredit($openid, 'credit1', $goods['credit'], 0, array(0, $_W['account']['name'] . '兑换商品{$credittxt}-' . $goods['credit']));
        $res['code'] = 200;
        $res['msg'] = '兑换成功!';
        pdo_insert("amouse_rebate_creditshop_log", $data2);
        $entrytext = "您用" . $goods['credit'] . "{$credittxt}，兑换了" . $goods['title'];
        $send2['msgtype'] = 'text';
        $send2['text'] = array('content' => urlencode($entrytext));
        $send2['touser'] = trim($openid);
        $accObj->sendCustomNotice($send2);
        return json_encode($res);
    }
    public function getCredit($openid = '', $credittype = 'credit1')
    {
        global $_W;
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
        } else {
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_rebate_member') . " WHERE openid=:openid and weid=:uniacid limit 1", array(':openid' => $openid, ':uniacid' => $_W['uniacid']));
        }
    }
    public function setCredit($openid = '', $credittype = 'credit1', $credits = 0, $isadd = 0, $log = array())
    {
        global $_W;
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
            if ($isadd == 0) {
                $newcredit = $value - $credits;
            } else {
                $newcredit = $value + $credits;
            }
            if ($newcredit <= 0) {
                $newcredit = 0;
            }
            pdo_update('mc_members', array($credittype => $newcredit), array('uid' => $uid));
            if (empty($log) || !is_array($log)) {
                $log = array($uid, '未记录');
            }
            $data = array('uid' => $uid, 'credittype' => $credittype, 'uniacid' => $_W['uniacid'], 'num' => $credits, 'module' => 'amouse_rebate', 'createtime' => TIMESTAMP, 'operator' => intval($log[0]), 'remark' => $log[1]);
            pdo_insert('mc_credits_record', $data);
        } else {
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_rebate_member') . " WHERE  weid=:uniacid and openid=:openid limit 1", array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
            if ($isadd == 0) {
                $newcredit = $value - $credits;
            } else {
                $newcredit = $value + $credits;
            }
            if ($newcredit <= 0) {
                $newcredit = 0;
            }
            pdo_update('amouse_rebate_member', array($credittype => $newcredit), array('weid' => $_W['uniacid'], 'openid' => $openid));
        }
    }
    public function doMobileImgupload()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        load()->func('file');
        mkdirs("../attachment/images/" . date("Y/m/d"));
        $destination_folder = "../attachment/images/" . date("Y/m/d") . "/";
        if (!file_exists($destination_folder)) {
            mkdir($destination_folder);
        }
        if (!empty($_GPC["mediaId"])) {
            $destination = $this->getMediaImg($_GPC["mediaId"], $destination_folder);
        } else {
            $result['success'] = 1;
            return json_encode($result);
        }
        $result['picid'] = $destination;
        $result['success'] = 0;
        return json_encode($result);
    }
    private function getMediaImg($serverId, $savePath)
    {
        global $_W;
        load()->func('communication');
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($_W['acid']);
        $access_token = $accObj->fetch_token();
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$access_token}&media_id={$serverId}";
        $resp = ihttp_request($url);
        if (is_error($resp)) {
            return $savePath;
        }
        if ($resp['headers']['Content-Type'] == "image/png") {
            $ftype = "png";
        } else {
            if ($resp['headers']['Content-Type'] == "image/jpg") {
                $ftype = "jpg";
            } else {
                if ($resp['headers']['Content-Type'] == "image/jpeg") {
                    $ftype = "jpeg";
                } else {
                    return $savePath;
                }
            }
        }
        $savePath = $savePath . time() . rand(1, 1000) . "." . $ftype;
        $local_file = @fopen($savePath, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $resp['content'])) {
                fclose($local_file);
            }
        }
        return $savePath;
    }
    public function getPosterSysset($weid = 0)
    {
        return pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_poster_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
    }
    public function getSysset($weid = 0)
    {
        return pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $weid));
    }
    public function getRedpacksSysset($weid = 0)
    {
        return pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_redpacks_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $weid));
    }
    public function doWebVersion()
    {
        global $_W, $_GPC;
        $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $mid = $_GPC['mid'];
        pdo_update('modules', array('version' => '1.0'), array('mid' => $mid));
        message('降低版本成功!', referer(), 'success');
    }
    public function doMobileAjaxSetVip()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $op = $_GPC['op'];
        if ($op == 'svip') {
            $svips = pdo_fetchall("SELECT openid,nickname,endtime,id,sviptime FROM " . tablename('amouse_rebate_member') . " where weid={$weid} and vipstatus=2 and endtime>0 and endtime <= unix_timestamp() ");
            if (!empty($svips)) {
                foreach ($svips as $card) {
                    pdo_update('amouse_rebate_member', array('vipstatus' => 1, 'sviptime' => 0, 'endtime' => 0), array('id' => $card['id']));
                }
            }
        } elseif ($op == 'vip') {
            $cards = pdo_fetchall("SELECT id,openid,createtime,autotime,nickname FROM " . tablename('amouse_rebate_member') . " where weid={$weid} and vipstatus=1 and createtime<=unix_timestamp() ");
            if (!empty($cards)) {
                foreach ($cards as $card) {
                    $VIP = "VIP会员";
                    $u = array('createtime' => 0);
                    if ($card['autotime'] <= 0) {
                        $u['vipstatus'] = 0;
                        $u['mealid'] = 0;
                    }
                    $u['sviptime'] = 0;
                    $u['endtime'] = 0;
                    pdo_update('amouse_rebate_member', $u, array('id' => $card['id']));
                }
            }
        }
        $res['code'] = 200;
        return json_encode($res);
    }
    public function doWebAjaxUpdateTop()
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $id = $_GPC['id'];
        $day = $_GPC['day'];
        $isrand = pdo_fetchcolumn("SELECT isrand FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $weid));
        $res = array();
        if (empty($id)) {
            $res['code'] = 0;
            $res['msg'] = "置顶失败";
            return json_encode($res);
        } else {
            $card = pdo_fetch('select * from ' . tablename('amouse_rebate_member') . ' where id=:id ', array(':id' => $id));
            $data = array('vipstatus' => $card['vipstatus']);
            $type = $card['vipstatus'];
            if ($type == 0) {
                $nextWeek = TIMESTAMP + $day * 24 * 60 * 60;
                $data['createtime'] = $nextWeek;
                $data['vipstatus'] = 1;
                $data['uptime'] = TIMESTAMP;
                pdo_update('amouse_rebate_member', $data, array('id' => $id));
            } elseif ($type == 2) {
                $maxvip = pdo_fetchcolumn('select max(endtime) from ' . tablename('amouse_rebate_member') . ' where weid=:weid AND vipstatus=2 and (sviptime>0 OR endtime>0) ', array(':weid' => $weid));
                $timer = time();
                if ($isrand == 0) {
                    $svipStartTime = $card['sviptime'];
                    $svipEndTime = $card['endtime'] + $day * 60;
                } else {
                    if ($maxvip > 0 && $maxvip >= $timer) {
                        $svipStartTime = $maxvip + $day * 60;
                        $svipStartTime = $maxvip;
                        $svipEndTime = $svipStartTime + $day * 60;
                        $svipEndTime = $svipStartTime + $day * 60;
                    } else {
                        $svipStartTime = $card['sviptime'] == 0 ? $timer : $card['sviptime'];
                        $svipEndTime = $svipStartTime + $day * 60;
                    }
                }
                $data['sviptime'] = $svipStartTime;
                $data['endtime'] = $svipEndTime;
                $data['uptime'] = time();
                pdo_update('amouse_rebate_member', $data, array('id' => $id));
            } else {
                pdo_update('amouse_rebate_member', array('uptime' => time()), array('id' => $id));
            }
            $res['code'] = 200;
            $res['msg'] = "置顶成功" . $id;
            return json_encode($res);
        }
    }
    public function doWeborderDownload()
    {
        require_once 'orderdownload.php';
    }
    function encode($value)
    {
        return iconv("utf-8", "gb2312", $value);
    }
    protected function generate_password($length = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    protected function returnMessage($msg, $redirect = '', $type = '')
    {
        global $_W, $_GPC;
        if ($redirect == 'refresh') {
            $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
        }
        if ($redirect == 'referer') {
            $redirect = referer();
        }
        if ($redirect == '') {
            $type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'info';
        } else {
            $type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'success';
        }
        if (empty($msg) && !empty($redirect)) {
            header('location: ' . $redirect);
        }
        $label = $type;
        if ($type == 'error') {
            $label = 'warn';
        }
        include $this->template('message');
        die;
    }
    protected function checkMember($openid = '')
    {
        global $_W;
        $accObj = WeiXinAccount::create($_W['oauth_account']);
        $userinfo = $accObj->fansQueryInfo($_SESSION['oauth_openid']);
        load()->model('mc');
        var_dump($userinfo);
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            pdo_update('mc_members', array('nickname' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'nationality' => $userinfo['country'], 'resideprovince' => $userinfo['province'], 'residecity' => $userinfo['city'], 'avatar' => $userinfo['headimgurl']), array('uniacid' => $_W['uniacid'], 'uid' => $uid));
        }
        pdo_update('mc_mapping_fans', array('nickname' => $userinfo['nickname']), array('uniacid' => $_W['uniacid'], 'openid' => $openid));
        $member = $this->getMember($openid);
        if (empty($member)) {
            $mc = mc_fetch($uid, array('realname', 'nickname', 'mobile', 'avatar', 'resideprovince', 'residecity', 'residedist'));
            $member = array('weid' => $_W['uniacid'], 'uid' => $uid, 'openid' => $openid, 'nickname' => !empty($mc['nickname']) ? $mc['nickname'] : $userinfo['nickname'], 'headimgurl' => !empty($mc['avatar']) ? $mc['avatar'] : $userinfo['avatar'], 'sex' => !empty($mc['gender']) ? $mc['gender'] : $userinfo['sex'], 'location_p' => !empty($mc['resideprovince']) ? $mc['resideprovince'] : $userinfo['province'], 'location_c' => !empty($mc['residecity']) ? $mc['residecity'] : $userinfo['city'], 'address' => $mc['residedist'], 'createtime' => time(), 'user_status' => 1, 'ipcilent' => getip(), 'friend' => 0);
            pdo_insert('amouse_rebate_member', $member);
            $member['id'] = pdo_insertid();
            $member['isnew'] = 1;
        } else {
            $update['nickname'] = $userinfo['nickname'];
            $update['headimgurl'] = $userinfo['headimgurl'];
            $update['ipcilent'] = getip();
            pdo_update('amouse_rebate_member', $update, array('id' => $member['id']));
            $member['isnew'] = 0;
        }
        return $member;
    }
}
$_SESSION["wode"] = null;
unset($_SESSION["wode"]);