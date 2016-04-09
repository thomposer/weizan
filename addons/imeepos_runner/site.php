<?php
defined('IN_IA') or exit('Access Denied');
class Imeepos_runnerModuleSite extends WeModuleSite
{
    public function __construct()
    {
        global $_W, $_GPC;
        if ($_W['os'] == 'mobile') {
        } else {
            $do  = $_GPC['do'];
            $doo = $_GPC['doo'];
            $act = $_GPC['act'];
            global $frames;
            $frames = getModuleFrames('imeepos_runner');
            _calc_current_frames2($frames);
        }
    }
    public function payResult($params)
    {
        global $_W;
        $tid     = $params['tid'];
        $sql     = "SELECT * FROM " . tablename('imeepos_runner3_paylog') . " WHERE uniacid = :uniacid AND tid = :tid";
        $par     = array(
            ":uniacid" => $_W['uniacid'],
            ':tid' => $tid
        );
        $paylog  = pdo_fetch($sql, $par);
        $setting = iunserializer($paylog['setting']);
        if ($params['result'] == 'success') {
            pdo_update('imeepos_runner3_paylog', array(
                'status' => 1
            ), array(
                'id' => $paylog['id']
            ));
        }
        if ($paylog['type'] == 'post_task') {
            $setting = iunserializer($paylog['setting']);
            if ($params['result'] == 'success') {
                $return = pdo_update('imeepos_runner3_tasks', array(
                    'status' => 1
                ), array(
                    'id' => intval($setting['taskid'])
                ));
            }
            if ($params['from'] == 'return') {
                if ($params['result'] == 'success') {
                    message('支付成功！', $this->createMobileUrl('manage', array(
                        'id' => $setting['taskid']
                    )), 'success');
                } else {
                    message('支付失败！', $this->createMobileUrl('manage', array(
                        'id' => $setting['taskid']
                    )), 'success');
                }
            }
        }
        if ($paylog['type'] == 'post_buy') {
            $setting = iunserializer($paylog['setting']);
            if ($params['result'] == 'success') {
                $return = pdo_update('imeepos_runner3_tasks', array(
                    'status' => 1
                ), array(
                    'id' => intval($setting['taskid'])
                ));
            }
            if ($params['from'] == 'return') {
                if ($params['result'] == 'success') {
                    message('支付成功！', $this->createMobileUrl('manage', array(
                        'id' => $setting['taskid']
                    )), 'success');
                } else {
                    message('支付失败！', $this->createMobileUrl('manage', array(
                        'id' => $setting['taskid']
                    )), 'success');
                }
            }
        }
        if ($paylog['type'] == 'runner') {
            $setting = iunserializer($paylog['setting']);
            if ($params['result'] == 'success') {
                $return = pdo_update('imeepos_runner3_member', array(
                    'isrunner' => 1
                ), array(
                    'openid' => $_W['openid'],
                    'uniacid' => $_W['uniacid']
                ));
                $xinyu  = intval($setting['xinyu']);
                pdo_update('imeepos_runner3_member', array(
                    'xinyu' => $xinyu
                ), array(
                    'openid' => $_W['openid'],
                    'uniacid' => $_W['uniacid']
                ));
            }
            if ($params['from'] == 'return') {
                if ($params['result'] == 'success') {
                    message('支付成功！', $this->createMobileUrl('index'), 'success');
                } else {
                    message('支付失败！', $this->createMobileUrl('index'), 'success');
                }
            }
        }
    }
    protected function getTemplate()
    {
        global $_W;
        $template = $this->module['config']['name'];
        if (empty($template)) {
            $template = 'default';
        }
        if (empty($_W['openid'])) {
            die("<!DOCTYPE html>
			 <html>
			 <head>
			 <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
			 <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
			 </head>
			 <body>
			 <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请在微信客户端打开链接</h4></div></div></div>
			 </body>
			 </html>");
        }
        return $template;
    }
}
function getModuleFrames($name)
{
    global $_W;
    $sql                                              = "SELECT * FROM " . tablename('modules') . " WHERE name = :name limit 1";
    $params                                           = array(
        ':name' => $name
    );
    $module                                           = pdo_fetch($sql, $params);
    $sql                                              = "SELECT * FROM " . tablename('modules_bindings') . " WHERE module = :name ";
    $params                                           = array(
        ':name' => $name
    );
    $module_bindings                                  = pdo_fetchall($sql, $params);
    $frames                                           = array();
    $frames['set']['title']                           = '基础设置';
    $frames['set']['active']                          = '';
    $frames['set']['items']                           = array();
    $frames['manage']['title']                        = '运营管理';
    $frames['manage']['active']                       = '';
    $frames['manage']['items']                        = array();
    $frames['set']['items']['divider_set']['url']     = url('site/entry/divider_set', array(
        'm' => $name
    ));
    $frames['set']['items']['divider_set']['title']   = '帮我送设置';
    $frames['set']['items']['divider_set']['actions'] = array();
    $frames['set']['items']['divider_set']['active']  = '';
    $frames['set']['items']['buy_set']['url']         = url('site/entry/buy_set', array(
        'm' => $name
    ));
    $frames['set']['items']['buy_set']['title']       = '帮我买设置';
    $frames['set']['items']['buy_set']['actions']     = array();
    $frames['set']['items']['buy_set']['active']      = '';
    $frames['set']['items']['v_set']['url']           = url('site/entry/v_set', array(
        'm' => $name
    ));
    $frames['set']['items']['v_set']['title']         = '认证设置';
    $frames['set']['items']['v_set']['actions']       = array();
    $frames['set']['items']['v_set']['active']        = '';
    $frames['manage']['items']['task']['url']         = url('site/entry/task', array(
        'm' => $name
    ));
    $frames['manage']['items']['task']['title']       = '任务管理';
    $frames['manage']['items']['task']['actions']     = array();
    $frames['manage']['items']['task']['active']      = '';
    $frames['manage']['items']['v']['url']            = url('site/entry/v', array(
        'm' => $name
    ));
    $frames['manage']['items']['v']['title']          = '认证管理';
    $frames['manage']['items']['v']['actions']        = array();
    $frames['manage']['items']['v']['active']         = '';
    $frames['manage']['items']['runner']['url']       = url('site/entry/runner', array(
        'm' => $name
    ));
    $frames['manage']['items']['runner']['title']     = '监控';
    $frames['manage']['items']['runner']['actions']   = array();
    $frames['manage']['items']['runner']['active']    = '';
    if ($_W['role'] == 'founder') {
        $frames['founder']['title']                      = '管理员特权';
        $frames['founder']['active']                     = '';
        $frames['founder']['items']                      = array();
        $frames['founder']['items']['oauth']['url']      = url('site/entry/oauth', array(
            'm' => $name
        ));
        $frames['founder']['items']['oauth']['title']    = '正版验证';
        $frames['founder']['items']['oauth']['actions']  = array();
        $frames['founder']['items']['oauth']['active']   = '';
        $frames['founder']['items']['update']['url']     = url('site/entry/download', array(
            'm' => $name
        ));
        $frames['founder']['items']['update']['title']   = '更新升级';
        $frames['founder']['items']['update']['actions'] = array();
        $frames['founder']['items']['update']['active']  = '';
        $frames['founder']['items']['delete']['url']     = url('site/entry/delete', array(
            'm' => $name
        ));
        $frames['founder']['items']['delete']['title']   = '清理数据';
        $frames['founder']['items']['delete']['actions'] = array();
        $frames['founder']['items']['delete']['active']  = '';
    }
    return $frames;
}
function _calc_current_frames2(&$frames)
{
    global $_W, $_GPC, $frames;
    if (!empty($frames) && is_array($frames)) {
        foreach ($frames as &$frame) {
            foreach ($frame['items'] as &$fr) {
                $query = parse_url($fr['url'], PHP_URL_QUERY);
                parse_str($query, $urls);
                if (defined('ACTIVE_FRAME_URL')) {
                    $query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
                    parse_str($query, $get);
                } else {
                    $get = $_GET;
                }
                if (!empty($_GPC['a'])) {
                    $get['a'] = $_GPC['a'];
                }
                if (!empty($_GPC['c'])) {
                    $get['c'] = $_GPC['c'];
                }
                if (!empty($_GPC['do'])) {
                    $get['do'] = $_GPC['do'];
                }
                if (!empty($_GPC['doo'])) {
                    $get['doo'] = $_GPC['doo'];
                }
                if (!empty($_GPC['op'])) {
                    $get['op'] = $_GPC['op'];
                }
                if (!empty($_GPC['m'])) {
                    $get['m'] = $_GPC['m'];
                }
                $diff = array_diff_assoc($urls, $get);
                if (empty($diff)) {
                    $fr['active']    = ' active';
                    $frame['active'] = ' active';
                }
            }
        }
    }
}
