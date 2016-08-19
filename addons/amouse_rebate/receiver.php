<?php
defined('IN_IA') or exit('Access Denied');
class Amouse_rebateModuleReceiver extends WeModuleReceiver
{
    public function receive()
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $openid = $this->message['from'];
        load()->func('logging');
        if ($this->message['event'] == 'unsubscribe') {
            $member = $this->getMember($openid, $uniacid);
            logging_run("--------unsubscribe==" . $member['nickname']);
        }
        if ($this->message['event'] == 'subscribe' && empty($this->message['ticket'])) {
            $member2 = $this->checkMember($openid, $uniacid);
            $ctxt = pdo_fetchcolumn("SELECT credittxt FROM " . tablename('amouse_rebate_custom_sysset') . " WHERE uniacid=:weid limit 1", array(':weid' => $uniacid));
            $credittxt = empty($ctxt) ? "积分" : $ctxt;
            $set = pdo_fetch("SELECT normal_att_credit,normal_attention,att_credit,nickname FROM " . tablename('amouse_rebate_sysset') . " WHERE weid=:weid limit 1", array(':weid' => $uniacid));
            $log = pdo_fetch("SELECT * FROM " . tablename('amouse_rebate_log') . " WHERE openid = :openid and weid=:weid ", array(':openid' => $openid, ':weid' => $uniacid));
            if (empty($log)) {
                $data = array('type' => 5, 'weid' => $uniacid, 'openid' => $openid, 'credit' => $set['normal_att_credit'], 'createtime' => TIMESTAMP);
                pdo_insert('amouse_rebate_log', $data);
                if ($set['normal_att_credit'] > 0) {
                    $this->setCredit($openid, 'credit1', intval($set['normal_att_credit']), array(0, $_W['account']['name'] . $member['nickname'] . '首次关注' . $credittxt . '+' . $set['normal_att_credit']));
                }
                if (!empty($set['normal_attention'])) {
                    $note = htmlspecialchars_decode($set['normal_attention']);
                    $note = str_replace("[nickname]", $member2['nickname'], $note);
                    $note = str_replace("[account]", $_W['account']['name'], $note);
                    $note = str_replace("[credit]", intval($set['normal_att_credit']), $note);
                    $this->post_send_text($openid, $note);
                }
            } else {
                if (!empty($set['nickname'])) {
                    $note = htmlspecialchars_decode($set['nickname']);
                    $note = str_replace("[nickname]", $member2['nickname'], $note);
                    $this->post_send_text($openid, $note);
                }
            }
        }
    }
    private function setCredit($openid = '', $credittype = 'credit1', $credits = 0, $log = array())
    {
        global $_W;
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
            $newcredit = $value + $credits;
            if ($newcredit <= 0) {
                $newcredit = 0;
            }
            pdo_update('mc_members', array($credittype => $newcredit), array('uid' => $uid));
            if (empty($log) || !is_array($log)) {
                $log = array($uid, '未记录');
            }
            $data = array('uid' => $uid, 'credittype' => $credittype, 'uniacid' => $_W['uniacid'], 'num' => $credits, 'createtime' => TIMESTAMP, 'module' => 'amouse_rmb', 'operator' => intval($log[0]), 'remark' => $log[1]);
            pdo_insert('mc_credits_record', $data);
        } else {
            $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_rebate_member') . " WHERE  weid=:uniacid and openid=:openid limit 1", array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
            $newcredit = $value + $credits;
            if ($newcredit <= 0) {
                $newcredit = 0;
            }
            pdo_update('amouse_rebate_member', array($credittype => $newcredit), array('weid' => $_W['uniacid'], 'openid' => $openid));
        }
    }
    private function getCredit($openid = '', $credittype = 'credit1')
    {
        global $_W;
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
        } else {
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_rebate_member') . " WHERE  openid=:openid and uniacid=:uniacid limit 1", array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
        }
    }
    private function getMember($openid = '', $uid, $getCredit = false)
    {
        global $_W;
        $info = pdo_fetch('select * from ' . tablename('amouse_rebate_member') . ' where weid=:uniacid and openid=:openid limit 1', array(':uniacid' => $uid, ':openid' => $openid));
        if ($getCredit) {
            $info['credit1'] = $this->getCredit($openid, 'credit1');
            $info['credit2'] = $this->getCredit($openid, 'credit2');
        }
        return $info;
    }
    private function checkMember($openid = '', $uniacid)
    {
        global $_W;
        $acc = WeiXinAccount::create($_W['acid']);
        $userinfo = $acc->fansQueryInfo($openid);
        load()->model('mc');
        $uid = mc_openid2uid($openid);
        if (!empty($uid)) {
            pdo_update('mc_members', array('nickname' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'nationality' => $userinfo['country'], 'resideprovince' => $userinfo['province'], 'residecity' => $userinfo['city'], 'avatar' => $userinfo['headimgurl']), array('uid' => $uid));
        }
        pdo_update('mc_mapping_fans', array('nickname' => $userinfo['nickname']), array('uniacid' => $uniacid, 'openid' => $openid));
        $member = $this->getMember($openid, $uniacid);
        if (empty($member)) {
            $mc = mc_fetch($uid, array('realname', 'nickname', 'mobile', 'avatar', 'resideprovince', 'residecity', 'residedist'));
            $member = array('weid' => $uniacid, 'uid' => $uid, 'openid' => $openid, 'nickname' => !empty($mc['nickname']) ? $mc['nickname'] : $userinfo['nickname'], 'headimgurl' => !empty($mc['avatar']) ? $mc['avatar'] : $userinfo['avatar'], 'sex' => !empty($mc['gender']) ? $mc['gender'] : $userinfo['sex'], 'location_p' => !empty($mc['resideprovince']) ? $mc['resideprovince'] : $userinfo['province'], 'location_c' => !empty($mc['residecity']) ? $mc['residecity'] : $userinfo['city'], 'addr' => $mc['residedist'], 'user_status' => 1, 'createtime' => time(), 'ipcilent' => getip(), 'friend' => 0, 'hot' => 0);
            pdo_insert('amouse_rebate_member', $member);
            $member['id'] = pdo_insertid();
            $member['isnew'] = 1;
        } else {
            $update['nickname'] = $userinfo['nickname'];
            $update['headimgurl'] = $userinfo['headimgurl'];
            $update['location_p'] = $userinfo['province'];
            $update['location_c'] = $userinfo['city'];
            $member['ipcilent'] = getip();
            pdo_update('amouse_rebate_member', $update, array('id' => $member['id']));
            $member['isnew'] = 0;
        }
        return $member;
    }
    private function post_send_text($openid, $content, $obj = array())
    {
        global $_W;
        $weid = $_W['acid'];
        $accObj = WeAccount::create($weid);
        $token = $accObj->fetch_token();
        load()->func('communication');
        $data['touser'] = $openid;
        $data['msgtype'] = 'text';
        $data['text']['content'] = urlencode($content);
        $dat = json_encode($data);
        $dat = urldecode($dat);
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $token;
        $ret = ihttp_post($url, $dat);
        $dat = $ret['content'];
        $result = @json_decode($dat, true);
        if ($result['errcode'] == '0') {
        }
        return true;
    }
}
$_ENV["hahad"] = null;
unset($_ENV["hahad"]);