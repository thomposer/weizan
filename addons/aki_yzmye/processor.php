<?php
include(IA_ROOT . '/addons/aki_yzmye/util/emoji.php');
defined('IN_IA') or exit('Access Denied');
class Aki_yzmyeModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        $content = $this->message['content'];
        global $_W, $_GPC;
        $openid = $_W['openid'];
        if (strlen($content) <= 2) {
            return $this->respText("对不起,验证码错误！");
        }
        $count = pdo_fetchcolumn("select count(*) from " . tablename("aki_yzmye_user") . " where uniacid = :uniacid and openid = :openid", array(
            ":uniacid" => $_W['uniacid'],
            ":openid" => $openid
        ));
        if ($count == 0) {
            $dat = array(
                'uniacid' => $_W['uniacid'],
                'openid' => $openid
            );
            pdo_insert('aki_yzmye_user', $dat);
        }
        $code    = substr($content, 2);
        $res     = pdo_fetch("select count(*) as count,id,yzmyeid,piciid,yue  from " . tablename("aki_yzmye_code") . " where uniacid = :uniacid and  code = :code and status = 1  and yzmyeid = 0", array(
            ':code' => $code,
            ':uniacid' => $_W['uniacid']
        ));
        $count   = $res['count'];
        $cid     = $res['id'];
        $piciid  = $res['piciid'];
        $yue     = $res['yue'];
        $yzmyeid = $res['yzmyeid'];
        $msg     = "";
        if ($count == 0) {
            $msg = "对不起,验证码错误！或者已经被使用";
        } else {
            $memberuid = $_W['member']['uid'];
            load()->model('mc');
            $yue1    = 0;
            $yue2    = 0;
            $result1 = mc_credit_fetch($memberuid);
            if (!empty($result1)) {
                $yue1 = $result1['credit2'];
            }
            $result  = mc_credit_update($memberuid, 'credit2', $yue);
            $result2 = mc_credit_fetch($memberuid);
            if (!empty($result2)) {
                $yue2 = $result2['credit2'];
            }
            if ($result) {
                pdo_update('aki_yzmye_code', array(
                    'status' => '2'
                ), array(
                    'id' => $cid
                ));
                pdo_query('update ' . tablename('aki_yzmye_codenum') . ' set usedcount = usedcount + 1 where id = :id', array(
                    'id' => $piciid
                ));
                $data = array(
                    'uid' => $memberuid,
                    'uniacid' => $_W['uniacid'],
                    'codeid' => $cid,
                    'piciid' => $piciid,
                    'openid' => $openid,
                    'yzmyeid' => 0,
                    'yue' => $yue,
                    'status' => '1',
                    'time' => time()
                );
                pdo_insert('aki_yzmye_sendlist', $data);
                $msg = "恭喜您获得" . $yue . "余额，当前余额由" . $yue1 . "变为" . $yue2;
            } else {
                $msg = "余额兑换失败！请稍后再试！";
            }
        }
        return $this->respText($msg);
    }
}
