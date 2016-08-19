<?php
defined('IN_IA') or exit('Access Denied');
class Wyt_dayu_yzModuleSite extends WeModuleSite
{
    public function doMobileIndex()
    {
        global $_W, $_GPC;
        if (checksubmit('submit')) {
            $username = !empty($_GPC['username']) ? trim($_GPC['username']) : message('请填写手机号');
            $code     = !empty($_GPC['code']) ? trim($_GPC['code']) : message('请填写验证码');
            $name     = !empty($_GPC['name']) ? trim($_GPC['name']) : message('请填写真实姓名');
            $reurl    = !empty($_GPC['reurl']) ? trim($_GPC['reurl']) : message('非法提交');
            $rereurl  = base64_decode($reurl);
            load()->model('utility');
            if (!code_verify($_W['uniacid'], $username, $code)) {
                message('验证码错！', '', 'error');
            }
            $record = array(
                'mobile' => $username,
                'realname' => $name
            );
            load()->model('mc');
            if (!empty($_W['member']['uid'])) {
                $result = mc_update($_W['member']['uid'], $record);
                if ($result === false) {
                    message('更新资料失败！', '', 'error');
                } else {
                    message('更新资料成功返回原页面！', $rereurl, 'success');
                }
            }
        }
        include $this->template('login');
    }
    public function doMobileVerifycode()
    {
        global $_W, $_GPC;
        $_W['uniacid'] = intval($_GPC['uniacid']);
        $uniacid_arr   = pdo_fetch('SELECT * FROM ' . tablename('uni_account') . ' WHERE uniacid = :uniacid', array(
            ':uniacid' => $_W['uniacid']
        ));
        if (empty($uniacid_arr)) {
            exit('非法访问');
        }
        $receiver = trim($_GPC['receiver']);
        if ($receiver == '') {
            exit('请输入手机号');
        } elseif (preg_match(REGULAR_MOBILE, $receiver)) {
            $receiver_type = 'mobile';
        } else {
            exit('您输入的手机号格式错误');
        }
        $table = trim($_GPC['table']);
        if (!empty($table)) {
            $isexist = pdo_get($table, array(
                $receiver_type => $receiver,
                'uniacid' => $_W['uniacid']
            ));
            if (!empty($isexist)) {
                exit('手机已被注册');
            }
        }
        $sql = 'DELETE FROM ' . tablename('uni_verifycode') . ' WHERE `createtime`<' . (TIMESTAMP - 1800);
        pdo_query($sql);
        $sql               = 'SELECT * FROM ' . tablename('uni_verifycode') . ' WHERE `receiver`=:receiver AND `uniacid`=:uniacid';
        $pars              = array();
        $pars[':receiver'] = $receiver;
        $pars[':uniacid']  = $_W['uniacid'];
        $row               = pdo_fetch($sql, $pars);
        $record            = array();
        if (!empty($row)) {
            if ($row['total'] >= 5) {
                exit('您的操作过于频繁,请稍后再试');
            }
            $code            = $row['verifycode'];
            $record['total'] = $row['total'] + 1;
        } else {
            $code                 = random(6, true);
            $record['uniacid']    = $_W['uniacid'];
            $record['receiver']   = $receiver;
            $record['verifycode'] = $code;
            $record['total']      = 1;
            $record['createtime'] = TIMESTAMP;
        }
        if (!empty($row)) {
            pdo_update('uni_verifycode', $record, array(
                'id' => $row['id']
            ));
        } else {
            pdo_insert('uni_verifycode', $record);
        }
        load()->func('sms');
        $result = sms_dayusend($receiver, $code, $uniacid_arr['name'], 0);
        if (is_error($result)) {
            header('error: ' . urlencode($result['message']));
            exit($result['message']);
        }
        exit('success');
    }
}
