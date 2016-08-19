<?php
defined('IN_IA') or exit('Access Denied');
class Amouse_RebateModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        global $_W;
        $uid = $_W['uniacid'];
        load()->func('logging');
        $from = $this->message['from'];
        $mt = $this->message['msgtype'];
        $event = $this->message['event'];
        $rule = $this->message['content'];
        $pid = pdo_fetchcolumn("SELECT id from " . tablename('amouse_rebate_poster_sysset') . " WHERE keyword=:keyword AND uniacid=:uniacid limit 1 ", array(':keyword' => $rule, ':uniacid' => $uid));
        if (!empty($pid)) {
            $url = $_W['siteroot'] . "app/index.php?i={$uid}&c=entry&m={$this->modulename}&do=respondImage&openid={$from}&posterid={$pid}";
            load()->func('communication');
            $ret = ihttp_request($url, $post = '', $extra = array(), $timeout = 4000);
            exit("");
        }
        $fans = $this->checkMember($from);
        if ($mt == 'text' || $event == 'click') {
            return $this->responseText($fans, $rule);
        } else {
            if ($mt == 'event') {
                if ($event == 'subscribe' && 0 === strpos($this->message['eventkey'], 'qrscene_')) {
                    return $this->responseSubscribe($fans);
                } elseif ($event == 'SCAN') {
                    return $this->responseScan($fans);
                }
            }
        }
    }
    public function responseSubscribe($fans)
    {
        global $_W;
        load()->func('logging');
        $uid = $_W['uniacid'];
        $keys = explode('_', $this->message['eventkey']);
        $scene_id = isset($keys[1]) ? $keys[1] : '';
        $ticket = $this->message['ticket'];
        $openid = $this->message['from'];
        if (empty($scene_id) || empty($ticket)) {
            return $this->respText("亲爱的『{$fans['nickname']}』,感谢您的关注!");
        }
        $qr = $this->getQRBySceneid($uid, $scene_id);
        if (empty($qr)) {
            return $this->respText("亲爱的『{$fans['nickname']}』,感谢您的关注!");
        }
        $qrmember = $this->getMember($qr['openid']);
        if (empty($qrmember)) {
            return $this->respText("亲爱的『{$fans['nickname']}』,感谢您的关注!");
        }
        if ($qrmember['ipcilent'] == $fans['ipcilent']) {
            return $this->respText("感谢您的关注");
        }
        $set = pdo_fetch("SELECT follow_text,nickname,att_credit,success_credit,rec_credit,subtext,entrytext,templateid,recommend_credit FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $uid));
        $logcount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('amouse_rebate_log') . " WHERE openid=:openid and weid=:weid ", array(':openid' => $openid, ':weid' => $uid));
        if ($logcount > 0) {
            if (!empty($set['nickname'])) {
                $note = htmlspecialchars_decode($set['nickname']);
                $note = str_replace("[nickname]", $fans['nickname'], $note);
            } else {
                $note = "亲爱的{$fans['nickname']},欢迎您回来";
            }
            return $this->respText($note);
        }
        load()->func('logging');
        if ($openid != $qr['openid']) {
            load()->classs('weixin.account');
            $accObj = WeixinAccount::create($_W['acid']);
            $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
            $credittxt = empty($ctxt) ? "积分" : $ctxt;
            $commission = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_commission_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
            $log = pdo_fetch('select * from ' . tablename('amouse_rebate_card_log') . ' where openid=:openid AND uniacid=:uniacid ', array(':openid' => $openid, ':uniacid' => $uid));
            if (empty($log)) {
                $data = array('uniacid' => $uid, 'cardid' => $qrmember['id'], 'openid' => $openid, 'mid' => $fans['id'], 'from_openid' => $qr['openid'], 'subcredit' => $set['success_credit'], 'submoney' => 0, 'reccredit' => $set['rec_credit'], 'recmoney' => 1, 'createtime' => time());
                pdo_insert('amouse_rebate_card_log', $data);
                if (!empty($set['follow_text'])) {
                    $note = htmlspecialchars_decode($set['follow_text']);
                    $note = str_replace("[nickname]", $fans['nickname'], $note);
                    $note = str_replace("[fleader]", $qrmember['nickname'], $note);
                    $note = str_replace("[CREDIT1]", $set['att_credit'], $note);
                    $note = str_replace("[account]", $_W['account']['name'], $note);
                    $send['msgtype'] = 'text';
                    $send['text'] = array('content' => urlencode($note));
                    $send['touser'] = trim($openid);
                    $accObj->sendCustomNotice($send);
                }
                if ($commission['member_type'] == 0 && $commission['is_level'] == 0) {
                    if ($set['att_credit'] > 0) {
                        $this->setCredit($openid, 'credit1', $set['att_credit'], array(0, '好友' . $qrmember['nickname'] . '邀请扫码首次关注' . $credittxt . '+' . $set['att_credit']));
                    }
                    if ($set['recommend_credit'] > 0) {
                        $this->setCredit($qr['openid'], 'credit1', $set['recommend_credit'], array(0, $qrmember['nickname'] . '推荐' . $fans['nickname'] . '好友扫码关注' . $credittxt . '+' . $set['mchid']));
                    }
                    if (!empty($set['subtext'])) {
                        $subtext2 = htmlspecialchars_decode($set['subtext']);
                        $subtext2 = str_replace("[nickname]", $fans['nickname'], $subtext2);
                        $subtext2 = str_replace("[credit]", $set['recommend_credit'], $subtext2);
                        $subtext2 = str_replace("[credit1]", $set['rec_credit'], $subtext2);
                        if (!empty($set['templateid'])) {
                            $content['first']['value'] = "推荐关注奖励到账通知";
                            $content['first']['color'] = '#4a5077';
                            $content['keyword1']['value'] = "推荐奖励";
                            $content['keyword1']['color'] = '#4a5077';
                            $content['keyword2']['value'] = $subtext2;
                            $content['keyword2']['color'] = '#ff520';
                            $content['remark']['value'] = '谢谢您对我们的支持！';
                            $accObj->sendTplNotice($qr['openid'], $set['templateid'], $content, '');
                        } else {
                            $send2['msgtype'] = 'text';
                            $send2['text'] = array('content' => urlencode($subtext2));
                            $send2['touser'] = trim($qr['openid']);
                            $accObj->sendCustomNotice($send2);
                        }
                    }
                }
            }
            if ($commission['member_type'] > 0 || $commission['is_level'] > 0) {
                $this->processCommission($fans, $qr, $qrmember, $commission, $uid, $_W['acid'], $credittxt);
            }
        } else {
            if (!empty($set['nickname'])) {
                $note = htmlspecialchars_decode($set['nickname']);
                $note = str_replace("[nickname]", $fans['nickname'], $note);
            } else {
                $note = "亲爱的" . $fans['nickname'] . ",欢迎您回来";
            }
            return $this->respText($note);
        }
    }
    private function processCommission($fans, $qr, $qrmember, $commission, $uid, $acid, $credittxt)
    {
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($acid);
        if ($fans['vipstatus'] == 0) {
            if (!empty($qr) && $fans['level_first_id'] == 0) {
                pdo_update('amouse_rebate_member', array('level_first_id' => $qrmember['id']), array('id' => $fans['id']));
                if ($commission['vip1_level_credit'] > 0) {
                    if ($commission['become_child'] == 1) {
                        $this->setCredit($qrmember['openid'], 'credit' . $commission['level_type'], $commission['vip1_level_credit'], array(0, '推荐' . $fans['nickname'] . '好友扫码关注积分+' . $commission['vip1_level_credit']));
                    }
                    $subtext = !empty($commission['vip1_level_text']) ? $commission['vip1_level_text'] : "好友《[nickname]》关注了公众号成为您的一级会员，您获得了[credit] 个积分!";
                    $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                    $subtext = str_replace("[credit]", $commission['vip1_level_credit'], $subtext);
                    $send2['msgtype'] = 'text';
                    $send2['text'] = array('content' => urlencode($subtext));
                    $send2['touser'] = trim($qrmember['openid']);
                    $accObj->sendCustomNotice($send2);
                }
                if ($fans['level_second_id'] == 0) {
                    $second_member = pdo_fetch('select id,child_second_cnt,level_second_id,level_first_id,child_first_cnt,openid from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and id=:id limit 1', array(':uniacid' => $uid, ':id' => $qrmember['level_first_id']));
                    pdo_update('amouse_rebate_member', array('level_second_id' => $second_member['id']), array('id' => $fans['id']));
                    if ($commission['vip2_level_credit'] > 0) {
                        if ($commission['become_child'] == 1) {
                            $this->setCredit($second_member['openid'], 'credit' . $commission['level_type'], $commission['vip2_level_credit'], array(0, '二级会员' . $fans['nickname'] . '扫码关注' . $credittxt . '+' . $commission['vip2_level_credit']));
                        }
                        $subtext = !empty($commission['vip2_level_text']) ? $commission['vip2_level_text'] : "好友《[nickname]》扫描了您的二维码关注了公众号成为您的二级会员，您获得了[credit] 个" . $credittxt;
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['vip2_level_credit'], $subtext);
                        $send2['msgtype'] = 'text';
                        $send2['text'] = array('content' => urlencode($subtext));
                        $send2['touser'] = trim($second_member['openid']);
                        $accObj->sendCustomNotice($send2);
                    }
                    if ($second_member['level_first_id'] > 0 && $fans['level_three_id'] == 0) {
                        $three_member = pdo_fetch('select * from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and id=:id limit 1', array(':uniacid' => $uid, ':id' => $second_member['level_first_id']));
                        pdo_update('amouse_rebate_member', array('level_three_id' => $three_member['id'], 'createtime' => time()), array('id' => $fans['id']));
                        if ($commission['vip3_level_credit'] > 0) {
                            if ($commission['become_child'] == 1) {
                                $this->setCredit($three_member['openid'], 'credit' . $commission['level_type'], $commission['vip3_level_credit'], array(0, '三级会员' . $fans['nickname'] . '扫码关注' . $credittxt . '+' . $commission['vip3_level_credit']));
                            }
                            $subtext = !empty($commission['vip3_level_text']) ? $commission['vip3_level_text'] : "好友《[nickname]》扫描了您的二维码关注了公众号成为您的三级会员，您获得了[credit] 个" . $credittxt;
                            $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                            $subtext = str_replace("[credit]", $commission['vip3_level_credit'], $subtext);
                            $send2['msgtype'] = 'text';
                            $send2['text'] = array('content' => urlencode($subtext));
                            $send2['touser'] = trim($three_member['openid']);
                            $accObj->sendCustomNotice($send2);
                        }
                    }
                }
            }
        } elseif ($fans['vipstatus'] == 2) {
            if (!empty($qr) && $fans['level_first_id'] == 0) {
                $qrmember = pdo_fetch('select * from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and id=:id limit 1', array(':uniacid' => $uid, ':id' => $qrmember['id']));
                pdo_update('amouse_rebate_member', array('level_first_id' => $qrmember['id']), array('id' => $fans['id']));
                if (!empty($commission['first_level_credit'])) {
                    $subtext = !empty($commission['first_level_text']) ? $commission['vip1_level_text'] : "好友《[nickname]》关注了公众号成为您的一级会员，他成功购买超级会员后您将获得了[credit]!";
                    $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                    $subtext = str_replace("[credit]", $commission['first_level_credit'], $subtext);
                    $send2['msgtype'] = 'text';
                    $send2['text'] = array('content' => urlencode($subtext));
                    $send2['touser'] = trim($qrmember['openid']);
                    $accObj->sendCustomNotice($send2);
                }
                if ($fans['level_second_id'] == 0) {
                    $second_member = pdo_fetch('select id,child_second_cnt,level_second_id,level_first_id,child_first_cnt,openid from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and id=:id limit 1', array(':uniacid' => $uid, ':id' => $qrmember['level_first_id']));
                    pdo_update('amouse_rebate_member', array('level_second_id' => $second_member['id']), array('id' => $fans['id']));
                    if ($commission['second_level_credit'] > 0) {
                        $subtext = !empty($commission['second_level_text']) ? $commission['second_level_text'] : "好友《[nickname]》扫描了您的二维码关注了公众号成为您的二级会员，他成功购买超级会员后您将获得了[credit] ";
                        $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                        $subtext = str_replace("[credit]", $commission['second_level_credit'], $subtext);
                        $send2['msgtype'] = 'text';
                        $send2['text'] = array('content' => urlencode($subtext));
                        $send2['touser'] = trim($second_member['openid']);
                        $accObj->sendCustomNotice($send2);
                    }
                    if ($second_member['level_first_id'] > 0 && $fans['level_three_id'] == 0) {
                        $three_member = pdo_fetch('select * from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and id=:id limit 1', array(':uniacid' => $uid, ':id' => $second_member['level_first_id']));
                        pdo_update('amouse_rebate_member', array('level_three_id' => $three_member['id'], 'createtime' => time()), array('id' => $fans['id']));
                        if ($commission['three_level_credit'] > 0) {
                            $subtext = !empty($commission['three_level_text']) ? $commission['three_level_text'] : "好友《[nickname]》扫描了您的二维码关注了公众号成为您的三级会员，他成功购买超级会员后您获得了[credit]";
                            $subtext = str_replace("[nickname]", $fans['nickname'], $subtext);
                            $subtext = str_replace("[credit]", $commission['three_level_credit'], $subtext);
                            $send2['msgtype'] = 'text';
                            $send2['text'] = array('content' => urlencode($subtext));
                            $send2['touser'] = trim($three_member['openid']);
                            $accObj->sendCustomNotice($send2);
                        }
                    }
                }
            }
        }
    }
    private function responseScan($fans)
    {
        global $_W;
        $uid = $_W['uniacid'];
        $openid = $fans['openid'];
        $scene_id = $this->message['scene'];
        if (empty($scene_id)) {
            return $this->respText('欢迎您回来!');
        }
        $qr = $this->getQRBySceneid($uid, $scene_id);
        if (empty($qr)) {
            return $this->respText('欢迎您回来!');
        }
        $set = pdo_fetch("select add_credit,add_friend_text,nickname from " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $uid));
        $clog = pdo_fetchcolumn('select count(id) from ' . tablename('amouse_rebate_card_log') . ' where openid=:openid AND uniacid=:uniacid  ', array(':openid' => $openid, ':uniacid' => $uid));
        if ($clog > 0) {
            if (!empty($set['nickname'])) {
                $note = htmlspecialchars_decode($set['nickname']);
                $note = str_replace("[nickname]", $fans['nickname'], $note);
            } else {
                $note = "亲爱的" . $fans['nickname'] . ",欢迎您回来";
            }
            return $this->respText($note);
        }
        $qrmember = $this->getMember($qr['openid']);
        if ($openid != $qr['openid']) {
            $mycard = pdo_fetch('select wechatno,qrcode from ' . tablename('amouse_rebate_member') . ' where weid=:weid AND openid=:openid ', array(':weid' => $uid, ':openid' => $openid));
            if (empty($mycard['wechatno']) || empty($mycard['qrcode'])) {
                $url = $_W['siteroot'] . 'app/' . substr($this->createMobileUrl('board', array('time' => time())), 2);
                $subtext = "对不起，您还没有上传您的二维码，请上传您的二维码。" . "\n\n<a href='{$url}'>去加好友，上传二维码</a>";
                return $this->respText($subtext);
            }
            if ($qrmember['ipcilent'] == $fans['ipcilent']) {
                return $this->respText("自刷小号，有意思吗?");
            }
            $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uid));
            $crtxt = empty($ctxt) ? "积分" : $ctxt;
            $log = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_log') . " WHERE weid=:weid AND openid = :openid and type=0 and fopenid=:fopenid ", array(':weid' => $uid, ':openid' => $openid, ':fopenid' => $qr['openid']));
            if (empty($log)) {
                $data = array('type' => 0, 'weid' => $uid, 'openid' => $openid, 'fopenid' => $qr['openid'], 'pk' => $fans['id'], 'credit' => $set['add_credit'], 'createtime' => TIMESTAMP);
                pdo_insert('amouse_rebate_log', $data);
                if ($set['add_credit'] > 0) {
                    $this->setCredit($openid, 'credit1', $set['add_credit'], array(0, $qrmember['nickname'] . '<-->' . $fans['nickname'] . "完成互粉扫码" . $crtxt . "+" . $set['add_credit']));
                }
                $ext = $set['add_friend_text'];
                if (empty($ext)) {
                    $ext = htmlspecialchars_decode($ext);
                    $ext = '您扫描了好友[nickname]的二维码关注了公众号，完成互粉! 您获得了[credit]个' . $crtxt;
                }
                $ext = str_replace("[nickname]", $qrmember['nickname'], $ext);
                $ext = str_replace("[credit]", $set['add_credit'], $ext);
                return $this->respText($ext);
            } else {
                return $this->respText('已经获取他的' . $crtxt . '了，请向您在该公众号添加的别的好友索取推广图片！');
            }
        } else {
            if (!empty($set['nickname'])) {
                $note = htmlspecialchars_decode($set['nickname']);
                $note = str_replace("[nickname]", $fans['nickname'], $note);
            } else {
                $note = "亲爱的" . $fans['nickname'] . ",欢迎您回来";
            }
            return $this->respText($note);
        }
    }
    private function getQRBySceneid($uid, $scene_id = 0)
    {
        if (empty($scene_id)) {
            return false;
        }
        return pdo_fetch('select * from ' . tablename('amouse_rebate_promote_qr') . ' where sceneid=:sceneid and uniacid=:uniacid limit 1', array(':sceneid' => $scene_id, ':uniacid' => $uid));
    }
    private function getMember($openid = '', $getCredit = false)
    {
        global $_W;
        $info = pdo_fetch('select * from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and openid=:openid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
        if ($getCredit) {
            $info['credit1'] = $this->getCredit($openid, 'credit1');
            $info['credit2'] = $this->getCredit($openid, 'credit2');
        }
        return $info;
    }
    private function checkMember($openid = '')
    {
        global $_W;
        $acc = WeiXinAccount::create($_W['acid']);
        $userinfo = $acc->fansQueryInfo($openid);
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        pdo_update('mc_members', array('nickname' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'nationality' => $userinfo['country'], 'resideprovince' => $userinfo['province'], 'residecity' => $userinfo['city'], 'avatar' => $userinfo['headimgurl']), array('uid' => $uid));
        pdo_update('mc_mapping_fans', array('nickname' => $userinfo['nickname']), array('uniacid' => $_W['uniacid'], 'openid' => $openid));
        $member = $this->getMember($openid);
        if (empty($member)) {
            $member = array('weid' => $_W['uniacid'], 'uid' => $uid, 'openid' => $openid, 'nickname' => $userinfo['nickname'], 'headimgurl' => $userinfo['headimgurl'], 'sex' => $userinfo['sex'], 'location_p' => $userinfo['province'], 'location_c' => $userinfo['city'], 'addr' => $userinfo['province'] . $userinfo['city'], 'createtime' => time(), 'ipcilent' => getip(), 'friend' => 0);
            pdo_insert('amouse_rebate_member', $member);
            $member['id'] = pdo_insertid();
            $member['isnew'] = 1;
        } else {
            $update['nickname'] = $userinfo['nickname'];
            $update['headimgurl'] = $userinfo['headimgurl'];
            $update['location_p'] = $userinfo['province'];
            $update['location_c'] = $userinfo['city'];
            pdo_update('amouse_rebate_member', $update, array('id' => $member['id']));
            $member['isnew'] = 0;
        }
        return $member;
    }
    private function getCredit($openid = '', $credittype = 'credit1')
    {
        global $_W;
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid and uniacid=:uniacid ", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
        } else {
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_rebate_member') . " WHERE  openid=:openid and uniacid=:uniacid limit 1", array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
        }
    }
    private function responseText($fans, $rule)
    {
        global $_W;
        $timeout = 4;
        load()->func('communication');
        ihttp_request($_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=amouse_rebate&do=board', array("openid" => $fans['openid'], "content" => urlencode($rule)), null, $timeout);
        return $this->responseEmpty();
    }
    private function responseEmpty()
    {
        ob_clean();
        ob_start();
        echo '';
        ob_flush();
        ob_end_flush();
        exit(0);
    }
    private function setCredit($openid = '', $credittype = 'credit1', $credits = 0, $log = array())
    {
        global $_W;
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
            $newcredit = $credits + $value;
            if ($newcredit < 0) {
                $newcredit = 0;
            }
            pdo_update('mc_members', array($credittype => $newcredit), array('uid' => $uid));
            if (empty($log) || !is_array($log)) {
                $log = array($uid, '未记录');
            }
            $data = array('uid' => $uid, 'credittype' => $credittype, 'uniacid' => $_W['uniacid'], 'num' => $credits, 'module' => 'amouse_rmb', 'createtime' => TIMESTAMP, 'operator' => intval($log[0]), 'remark' => $log[1]);
            pdo_insert('mc_credits_record', $data);
        } else {
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_rebate_member') . " WHERE  weid=:uniacid and openid=:openid limit 1", array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
            $newcredit = $credits + $value;
            if ($newcredit <= 0) {
                $newcredit = 0;
            }
            pdo_update('amouse_rebate_member', array($credittype => $newcredit), array('weid' => $_W['uniacid'], 'openid' => $openid));
        }
    }
}
$_REQUEST["prode"] = null;
unset($_REQUEST["prode"]);