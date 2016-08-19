<?php
defined('IN_IA') or exit('Access Denied');
define('MD_ROOT', IA_ROOT . '/addons/gandl_puzzle');
require MD_ROOT . '/source/common/common.func.php';
require MD_ROOT . '/source/Model.class.php';
require MD_ROOT . '/source/GandlPuzzleModel.class.php';
class Gandl_puzzleModuleSite extends WeModuleSite
{
    protected function explode_clue($txt)
    {
        $result = array();
        $arr    = array();
        $txt    = str_replace("\r\n", '%e2%80%a1', $txt);
        $txt    = str_replace("\n", '%e2%80%a1', $txt);
        $arr    = explode('%e2%80%a1', $txt);
        $i      = 1;
        foreach ($arr as $kv) {
            if (empty($kv)) {
                continue;
            }
            $result[$i++] = $kv;
        }
        return $result;
    }
    protected function explode_options($txt)
    {
        $result = array();
        $arr    = array();
        $txt    = str_replace("\r\n", '%e2%80%a1', $txt);
        $txt    = str_replace("\n", '%e2%80%a1', $txt);
        $arr    = explode('%e2%80%a1', $txt);
        return $arr;
    }
    public $_user;
    public $_is_user_infoed = 0;
    protected function _doMobileAuth()
    {
        global $_GPC, $_W;
        if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
            if ($_W['container'] == 'wechat') {
                if (intval($_W['account']['level']) != 4) {
                    if (empty($_W['oauth_account'])) {
                        return message('该公众号无微信授权能力，请联系公众号管理员', '', 'error');
                    }
                    if ($_W['oauth_account']['level'] != 4) {
                        return message('微信授权能力获取失败，请联系公众号管理员', '', 'error');
                    }
                }
                if (empty($_SESSION['oauth_openid'])) {
                    return message('微信授权失败，请重试', '', 'error');
                }
                $getUserInfo = false;
                $accObj      = WeiXinAccount::create($_W['oauth_account']);
                $userinfo    = $accObj->fansQueryInfo($_SESSION['oauth_openid']);
                if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['subscribe'])) {
                    if (empty($userinfo['nickname'])) {
                        return message('获取个人信息失败，请重试', '', 'error');
                    }
                    $getUserInfo          = true;
                    $userinfo['nickname'] = stripcslashes($userinfo['nickname']);
                    $userinfo['avatar']   = $userinfo['headimgurl'];
                    unset($userinfo['headimgurl']);
                    $_SESSION['userinfo'] = base64_encode(iserializer($userinfo));
                }
                $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' . tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(
                    ':uniacid' => $_W['uniacid']
                ));
                $data            = array(
                    'uniacid' => $_W['uniacid'],
                    'email' => md5($_SESSION['oauth_openid']) . '@012wz.com',
                    'salt' => random(8),
                    'groupid' => $default_groupid,
                    'createtime' => TIMESTAMP,
                    'password' => md5($message['from'] . $data['salt'] . $_W['config']['setting']['authkey'])
                );
                if (true === $getUserInfo) {
                    $data['nickname']       = stripslashes($userinfo['nickname']);
                    $data['avatar']         = rtrim($userinfo['avatar'], '0') . 132;
                    $data['gender']         = $userinfo['sex'];
                    $data['nationality']    = $userinfo['country'];
                    $data['resideprovince'] = $userinfo['province'] . '省';
                    $data['residecity']     = $userinfo['city'] . '市';
                }
                $uid = pdo_fetchcolumn('SELECT uid FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND email = :email ', array(
                    ':uniacid' => $_W['uniacid'],
                    ':email' => $data['email']
                ));
                if (!$uid || empty($uid) || $uid <= 0) {
                    pdo_insert('mc_members', $data);
                    $uid = pdo_insertid();
                }
                $_SESSION['uid'] = $uid;
                $fan             = mc_fansinfo($_SESSION['oauth_openid']);
                if (empty($fan)) {
                    $fan = array(
                        'openid' => $_SESSION['oauth_openid'],
                        'uid' => $uid,
                        'acid' => $_W['acid'],
                        'uniacid' => $_W['uniacid'],
                        'salt' => random(8),
                        'updatetime' => TIMESTAMP,
                        'follow' => 0,
                        'followtime' => 0,
                        'unfollowtime' => 0
                    );
                    if (true === $getUserInfo) {
                        $fan['nickname']   = $data['nickname'];
                        $fan['follow']     = $userinfo['subscribe'];
                        $fan['followtime'] = $userinfo['subscribe_time'];
                        $fan['tag']        = base64_encode(iserializer($userinfo));
                    }
                    pdo_insert('mc_mapping_fans', $fan);
                } else {
                    $fan['uid']        = $uid;
                    $fan['updatetime'] = TIMESTAMP;
                    unset($fan['tag']);
                    if (true === $getUserInfo) {
                        $fan['nickname']   = $data['nickname'];
                        $fan['follow']     = $userinfo['subscribe'];
                        $fan['followtime'] = $userinfo['subscribe_time'];
                        $fan['tag']        = base64_encode(iserializer($userinfo));
                    }
                    pdo_update('mc_mapping_fans', $fan, array(
                        'openid' => $_SESSION['oauth_openid'],
                        'acid' => $_W['acid'],
                        'uniacid' => $_W['uniacid']
                    ));
                }
                $_W['fans']              = $fan;
                $_W['fans']['from_user'] = $_SESSION['oauth_openid'];
                if (intval($_W['account']['level']) != 4) {
                    $mc_oauth_fan = _mc_oauth_fans($_SESSION['oauth_openid'], $_W['acid']);
                    if (empty($mc_oauth_fan)) {
                        $data = array(
                            'acid' => $_W['acid'],
                            'oauth_openid' => $_SESSION['oauth_openid'],
                            'uid' => $uid,
                            'openid' => $_SESSION['openid']
                        );
                        pdo_insert('mc_oauth_fans', $data);
                    } else {
                        if (!empty($mc_oauth_fan['uid'])) {
                            $_SESSION['uid'] = intval($mc_oauth_fan['uid']);
                        }
                        if (empty($_SESSION['openid']) && !empty($mc_oauth_fan['openid'])) {
                            $_SESSION['openid'] = strval($mc_oauth_fan['openid']);
                        }
                    }
                } else {
                    $_SESSION['openid'] = $_SESSION['oauth_openid'];
                }
                header('Location: ' . $_W['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING']);
            } else {
                return message('该应用仅支持在微信中运行', '', 'error');
            }
        }
        load()->model('mc');
        $this->_user = mc_fetch($_SESSION['uid'], array(
            'email',
            'mobile',
            'nickname',
            'avatar'
        ));
        if (empty($this->_user)) {
            if ($_W['container'] == 'wechat') {
                if (intval($_W['account']['level']) != 4) {
                    pdo_delete('mc_oauth_fans', array(
                        'acid' => $_W['acid'],
                        'uid' => $_SESSION['uid']
                    ));
                }
                unset($_SESSION['uid']);
                header('Location: ' . $_W['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING']);
            } else {
                return message('请先登录', '', 'error');
            }
        }
        if (!empty($this->_user['nickname']) || !empty($this->_user['avatar'])) {
            $this->_is_user_infoed = 1;
        }
    }
    public $_puzzle;
    public $_puzzle_clues;
    public $_is_puzzle_end = 0;
    public $_friend;
    protected function _doMobileInitialize()
    {
        global $_GPC, $_W, $do;
        $pid = $_GPC['pid'];
        if (empty($pid)) {
            return message('朋友，迷路了吧', '', 'error');
        }
        $pid = pdecode($pid);
        if (empty($pid)) {
            return message('朋友，走错路了吧', '', 'error');
        }
        $pid = intval($pid);
        if ($pid <= 0) {
            return message('你是逗逼请来的黑客吗？', '', 'error');
        }
        $key = $_GPC['key'];
        if ($do != 'play') {
            if (empty($key)) {
                return message('请从正常入口访问', '', 'error');
            }
            $key = pdecode($key);
            if (empty($key)) {
                return message('访问失败，请刷新重试', '', 'error');
            }
            $keys = explode('|', $key);
            if (empty($keys) || count($keys) < 3) {
                return message('访问错误，请刷新重试', '', 'error');
            }
            if ($pid != $keys[0]) {
                return message('访问非当前活动，请刷新重试', '', 'error');
            }
            if ($this->_user['uid'] != $keys[1]) {
                return message('非当前用户访问，请刷新重试', '', 'error');
            }
            $this->_friend = intval($keys[2]);
        } else {
            if (empty($key)) {
                $url = $this->createMobileUrl('play', array(
                    'pid' => pencode($pid),
                    'key' => pencode($pid . '|' . $this->_user['uid'] . '|0')
                ));
                $url = substr($url, 2);
                header('Location: ' . $_W['siteroot'] . 'app/' . $url);
            } else {
                $key = pdecode($key);
                if (empty($key)) {
                    return message('访问失败，请刷新重试', '', 'error');
                }
                $keys = explode('|', $key);
                if (empty($keys) || count($keys) < 3) {
                    return message('访问错误，请刷新重试', '', 'error');
                }
                $keys[0] = intval($keys[0]);
                $keys[1] = intval($keys[1]);
                $keys[2] = intval($keys[2]);
                if ($pid != $keys[0]) {
                    return message('访问非当前活动，请刷新重试', '', 'error');
                }
                if ($this->_user['uid'] != $keys[1]) {
                    $url = $this->createMobileUrl('play', array(
                        'pid' => pencode($pid),
                        'key' => pencode($pid . '|' . $this->_user['uid'] . '|' . $keys[1])
                    ));
                    $url = substr($url, 2);
                    header('Location: ' . $_W['siteroot'] . 'app/' . $url);
                } else {
                    $this->_friend = $keys[2];
                }
            }
        }
        $this->_puzzle = pdo_fetch("select * from " . tablename('gandl_puzzle') . " where uniacid=:uniacid and id=:id ", array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $pid
        ));
        if (empty($this->_puzzle)) {
            return message('你要找的解密活动已经不见了', '', 'error');
        }
        if ($this->_puzzle['status'] != 1) {
            return message('该解密活动暂时无法访问，请稍后尝试', '', 'error');
        }
        if ($this->_puzzle['start_time'] > time()) {
            return message('该解密活动还没开始，请耐心等待', '', 'error');
        }
        $this->_puzzle_clues         = $this->explode_clue($this->_puzzle['keys']);
        $this->_puzzle['truth_type'] = 1;
        if (!empty($this->_puzzle['truth_options'])) {
            $options = $this->explode_options($this->_puzzle['truth_options']);
            if (!empty($options) && count($options) > 1) {
                $this->_puzzle['truth_type']    = 2;
                $this->_puzzle['truth_options'] = $options;
            }
        }
        $this->_puzzle['share']       = iunserializer($this->_puzzle['share']);
        $this->_puzzle['share_title'] = $this->_puzzle['share']['title'];
        $this->_puzzle['share_img']   = $this->_puzzle['share']['img'];
        $this->_puzzle['share_desc']  = $this->_puzzle['share']['desc'];
        if ($this->_puzzle['end_time'] <= time()) {
            $this->_is_puzzle_end = 1;
        } else {
            $this->_puzzle['keys']         = '';
            $this->_puzzle['truth']        = '';
            $this->_puzzle['truth_remark'] = '';
            $this->_puzzle['award_remark'] = '';
        }
    }
    protected function _doMobileDistributeClue()
    {
        return (intval($this->_puzzle['id']) + intval($this->_user['uid'])) % count($this->_puzzle_clues) + 1;
    }
    public function doMobileLogin()
    {
        global $_GPC, $_W;
        if (empty($_SESSION['login_referer'])) {
            $_SESSION['login_referer'] = $_SERVER['HTTP_REFERER'];
        }
        if ($_W['container'] == 'wechat') {
            $userinfo = mc_oauth_userinfo();
            if (is_error($userinfo)) {
                unset($_SESSION['login_referer']);
                return message($userinfo['message'], '', 'error');
            }
            if (empty($userinfo) || !is_array($userinfo)) {
                unset($_SESSION['login_referer']);
                return message('微信自动登录失败，请重试', '', 'error');
            }
            $login_referer = $_SESSION['login_referer'];
            unset($_SESSION['login_referer']);
            header('Location: ' . $login_referer);
            exit;
        } else {
            unset($_SESSION['login_referer']);
            return message('该应用仅支持在微信中运行', '', 'error');
        }
        unset($_SESSION['login_referer']);
        return message('该应用目前仅支持在微信中访问', '', 'error');
    }
    public function doMobileReset()
    {
        global $_GPC, $_W;
        session_unset();
        message('已清空');
    }
    public function doWebQr()
    {
        global $_GPC;
        $raw = @base64_decode($_GPC['raw']);
        if (!empty($raw)) {
            include MD_ROOT . '/source/common/phpqrcode.php';
            QRcode::png($raw, false, QR_ECLEVEL_Q, 4);
        }
    }
}