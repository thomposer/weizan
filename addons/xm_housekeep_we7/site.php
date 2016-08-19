<?php
defined('IN_IA') or exit('Access Denied');
class Xm_housekeep_we7ModuleSite extends WeModuleSite
{
    function __construct()
    {
        global $_W;
        $this->weid  = $_W['uniacid'];
        $sql         = "SELECT * FROM " . tablename('xm_housekeep_base') . " WHERE weid = '" . $_W['uniacid'] . "'";
        $this->base  = pdo_fetch($sql);
        $this->power = array(
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            '11',
            '12',
            '13',
            '14',
            '15',
            '16',
            '17',
            '18',
            '19',
            '20',
            '21',
            '22'
        );
    }
    public function doWebStaff()
    {
        global $_GPC, $_W;
        checklogin();
        $power  = $this->power;
        $id     = intval($_GPC['id']);
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        if (!empty($list)) {
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id DESC");
            $pager = pagination($total, $pindex, $psize);
            unset($row);
        }
        function getSex($id)
        {
            if ($id == 1) {
                $text = '男';
            } elseif ($id == 2) {
                $text = '女';
            } elseif ($id == 0) {
                $text = '保密';
            }
            return $text;
        }
        include $this->template('staff-list');
    }
    public function doWebStaffadd()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('1', $power)) {
            message('您没有权限操作！', $this->createWebUrl('staff', array()), 'error');
        }
        $id = intval($_GPC['id']);
        if (!empty($id)) {
            $item = pdo_fetch("SELECT * FROM " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "' AND id = '" . $id . "'");
        }
        load()->func('tpl');
        include $this->template('staff-add');
    }
    public function doWebStaffaddok()
    {
        global $_W, $_GPC;
        checklogin();
        if (checksubmit()) {
            $id = intval($_GPC['id']);
            if (empty($_GPC['name'])) {
                message("员工姓名不能为空");
            }
            if (empty($_GPC['mobile'])) {
                message("员工手机号码不能为空");
            }
            if (empty($_GPC['sex'])) {
                message("员工性别不能为空");
            }
            if (empty($id)) {
                if ($this->checkMobile1($_GPC['mobile']) == 1) {
                    message("该手机号码已登记");
                }
            } else {
                if ($this->checkMobile($_GPC['mobile'], $_GPC['name']) == 1) {
                    message("该手机号码已登记");
                }
            }
            if (empty($id)) {
                $random = $this->random(4);
                $random = $this->checkRandom($random);
            } else {
                $random = $_GPC['flag'];
            }
            $data = array(
                'weid' => $this->weid,
                'name' => $_GPC['name'],
                'mobile' => $_GPC['mobile'],
                'sex' => $_GPC['sex'],
                'avatar' => $_GPC['avatar'],
                'flag' => $random,
                'accept' => $_GPC['accept'],
                'addtime' => time()
            );
            if (empty($id)) {
                load()->model('account');
                $postdata                = array();
                $postdata['action_name'] = "QR_LIMIT_SCENE";
                $postdata['action_info'] = ":scene";
                $dat                     = json_encode($postdata);
                $dat2                    = '{"scene":' . json_encode(array(
                    'scene_id' => $random
                )) . '}';
                $dat                     = str_replace('":scene"', $dat2, $dat);
                $dat                     = urldecode($dat);
                $item                    = pdo_fetch("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid =" . $_W['uniacid']);
                load()->classs('weixin.account');
                $accObj  = WeixinAccount::create($item['acid']);
                $token   = $accObj->fetch_token();
                $url     = sprintf("https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s", $token);
                $content = ihttp_post($url, $dat);
                $dat     = $content['content'];
                $result  = @json_decode($dat, true);
                if ($result['errcode'] == '' && $result['ticket'] != '') {
                    $data['ticket'] = $result['ticket'];
                    pdo_insert('xm_housekeep_staff', $data);
                    message('数据添加成功！', $this->createWebUrl('staff', array()), 'success');
                } else {
                    message("公众平台返回接口错误. <br />错误代码为: {$result['errcode']} <br />错误信息为: {$result['errmsg']} <br />错误描述为: " . $account_code($result['errcode']));
                }
            } else {
                pdo_update('xm_housekeep_staff', $data, array(
                    'id' => $id
                ));
                message('数据修改成功！', $this->createWebUrl('staff', array()), 'success');
            }
        }
    }
    public function checkMobile($mobile, $name)
    {
        global $_W, $_GPC;
        $sql  = "SELECT id FROM " . tablename('xm_housekeep_staff') . " where weid='" . $_W['uniacid'] . "' AND mobile != '" . $mobile . "' AND name = '" . $name . "'";
        $item = pdo_fetch($sql);
        if (empty($item['id'])) {
            return 0;
        } else {
            return 1;
        }
    }
    public function checkMobile1($mobile)
    {
        global $_W, $_GPC;
        $sql  = "SELECT id FROM " . tablename('xm_housekeep_staff') . " where weid='" . $_W['uniacid'] . "' AND mobile = '" . $mobile . "'";
        $item = pdo_fetch($sql);
        if (empty($item['id'])) {
            return 0;
        } else {
            return 1;
        }
    }
    public function checkRandom($str)
    {
        global $_W, $_GPC;
        $item = pdo_fetch("SELECT id FROM " . tablename('xm_housekeep_staff') . " where weid='" . $_W['uniacid'] . "' AND flag = '" . $str . "'");
        if (!empty($item['id'])) {
            return $this->random(4);
        } else {
            return $str;
        }
    }
    public function doWebStaffdelete()
    {
        global $_W, $_GPC;
        checklogin();
        $id = intval($_GPC['id']);
        pdo_delete('xm_housekeep_staff', array(
            'id' => $id
        ));
        message('删除成功！', $this->createWebUrl('staff', array()), 'success');
    }
    public function doWebType()
    {
        global $_GPC, $_W;
        checklogin();
        $power  = $this->power;
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_type') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        if (!empty($list)) {
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xm_housekeep_type') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id DESC");
            $pager = pagination($total, $pindex, $psize);
            unset($row);
        }
        include $this->template('type-list');
    }
    public function doWebTypeadd()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('3', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Type', array()), 'error');
        }
        $id = intval($_GPC['id']);
        if (!empty($id)) {
            $item = pdo_fetch("SELECT * FROM " . tablename('xm_housekeep_type') . " WHERE weid='" . $_W['uniacid'] . "' AND id ='" . $id . "'");
        }
        load()->func('tpl');
        include $this->template('type-add');
    }
    public function doWebTypeaddok()
    {
        global $_W, $_GPC;
        checklogin();
        $id = intval($_GPC['id']);
        if (checksubmit('submit')) {
            if (empty($_GPC['name'])) {
                message('类别名称不能为空');
            }
            if (empty($_GPC['icon'])) {
                message('没有上传类别显示图标');
            }
            $data = array(
                'weid' => $_W['uniacid'],
                'name' => $_GPC['name'],
                'icon' => $_GPC['icon'],
                'top' => $_GPC['top'],
                'addtime' => time()
            );
            if (empty($id)) {
                pdo_insert('xm_housekeep_type', $data);
                message('数据添加成功！', $this->createWebUrl('type', array()), 'success');
            } else {
                pdo_update('xm_housekeep_type', $data, array(
                    'id' => $id
                ));
                message('数据修改成功！', $this->createWebUrl('type', array()), 'success');
            }
        }
    }
    public function doWebTypedelete()
    {
        global $_W, $_GPC;
        checklogin();
        $id = intval($_GPC['id']);
        pdo_delete('xm_housekeep_type', array(
            'id' => $id
        ));
        pdo_delete('xm_housekeep_project', array(
            'type_id' => $id
        ));
        message('删除成功！', $this->createWebUrl('type', array()), 'success');
    }
    public function doWebProject()
    {
        global $_W, $_GPC;
        checklogin();
        $power     = $this->power;
        $id        = intval($_GPC['id']);
        $condition = '';
        if (!isset($id) || !empty($id)) {
            $condition .= " AND type_id = '" . $id . "'";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_project') . " WHERE weid = '" . $_W['uniacid'] . "' " . $condition . " ORDER BY typeorder DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        if (!empty($list)) {
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xm_housekeep_project') . " WHERE weid = '" . $_W['uniacid'] . "' " . $condition . " ORDER BY typeorder DESC");
            $pager = pagination($total, $pindex, $psize);
            unset($row);
        }
        function getTypeName($id)
        {
            global $_W, $_GPC;
            $item = pdo_fetch("SELECT name FROM " . tablename('xm_housekeep_type') . " WHERE id = '" . $id . "'");
            return $item['name'];
        }
        include $this->template('project-list');
    }
    public function doWebProjectadd()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('3', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Project', array()), 'error');
        }
        $list = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_type') . " WHERE weid='" . $_W['uniacid'] . "' ORDER BY id DESC");
        load()->func('tpl');
        include $this->template('project-add');
    }
    public function doWebProjectaddok()
    {
        global $_W, $_GPC;
        checklogin();
        if (checksubmit('submit')) {
            if (empty($_GPC['name'])) {
                message('项目名称不能为空');
            }
            if (empty($_GPC['type_id'])) {
                message('请选择所属服务类别');
            }
            if (empty($_GPC['jianjie'])) {
                message('项目简介不能为空');
            }
            if (empty($_GPC['price'])) {
                message('项目价格简介不能为空');
            }
            $data = array(
                'weid' => $_W['uniacid'],
                'name' => $_GPC['name'],
                'type_id' => $_GPC['type_id'],
                'icon' => $_GPC['icon'],
                'jianjie' => $_GPC['jianjie'],
                'price' => $_GPC['price'],
                'price_con' => htmlspecialchars_decode($_GPC['price_con']),
                'istop1' => $_GPC['istop1'],
                'istop2' => $_GPC['istop2'],
                'typeorder' => $_GPC['typeorder'],
                'addtime' => time()
            );
            pdo_insert('xm_housekeep_project', $data);
            message('数据添加成功！', $this->createWebUrl('project', array()), 'success');
        }
    }
    public function doWebProjectedit()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('3', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Project', array()), 'error');
        }
        $id   = intval($_GPC['id']);
        $item = pdo_fetch("SELECT * FROM " . tablename('xm_housekeep_project') . " WHERE weid='" . $_W['uniacid'] . "' AND id='" . $id . "'");
        $list = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_type') . " WHERE weid='" . $_W['uniacid'] . "' ORDER BY id DESC");
        load()->func('tpl');
        include $this->template('project-edit');
    }
    public function doWebProjecteditok()
    {
        global $_W, $_GPC;
        checklogin();
        $id = intval($_GPC['id']);
        if (checksubmit('submit')) {
            if (empty($_GPC['name'])) {
                message('项目名称不能为空');
            }
            if (empty($_GPC['type_id'])) {
                message('请选择所属服务类别');
            }
            if (empty($_GPC['jianjie'])) {
                message('项目简介不能为空');
            }
            if (empty($_GPC['price'])) {
                message('项目价格简介不能为空');
            }
            $data = array(
                'weid' => $_W['uniacid'],
                'name' => $_GPC['name'],
                'type_id' => $_GPC['type_id'],
                'icon' => $_GPC['icon'],
                'jianjie' => $_GPC['jianjie'],
                'price' => $_GPC['price'],
                'price_con' => htmlspecialchars_decode($_GPC['price_con']),
                'istop1' => $_GPC['istop1'],
                'istop2' => $_GPC['istop2'],
                'typeorder' => $_GPC['typeorder'],
                'addtime' => time()
            );
            pdo_update('xm_housekeep_project', $data, array(
                'id' => $id
            ));
            message('数据修改成功！', $this->createWebUrl('project', array()), 'success');
        }
    }
    public function doWebProjectdel()
    {
        global $_W, $_GPC;
        checklogin();
        $id = intval($_GPC['id']);
        pdo_delete('xm_housekeep_project', array(
            'id' => $id
        ));
        message('删除成功！', $this->createWebUrl('project', array()), 'success');
    }
    public function doWebOrder()
    {
        global $_GPC, $_W;
        checklogin();
        $power = $this->power;
        if (!in_array('8', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Order', array()), 'error');
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_orderform') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY orderformid DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        if (!empty($list)) {
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xm_housekeep_orderform') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY ftime DESC");
            $pager = pagination($total, $pindex, $psize);
            unset($row);
        }
        include $this->template('order-list');
    }
    public function doWebPaidan()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('5', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Order', array()), 'error');
        }
        $orderid = intval($_GPC['orderid']);
        $sql1    = "SELECT orderformid,openid,typeid,ftime,address,mark FROM " . tablename('xm_housekeep_orderform') . " WHERE orderformid =" . $orderid;
        $item    = pdo_fetch($sql1);
        $sql2    = "SELECT id,openid,name,flag FROM " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "'";
        $list    = pdo_fetchall($sql2);
        include $this->template('paidan');
    }
    public function doWebPaidanok()
    {
        global $_W, $_GPC;
        $orderid  = intval($_GPC['orderid']);
        $waiterid = $_GPC['waiterid'];
        $openid   = $_GPC['openid'];
        $tid      = $_GPC['typeid'];
        $ftime    = $_GPC['ftime'];
        $address  = $_GPC['address'];
        $mark     = $_GPC['mark'];
        $data     = array(
            'state' => 1,
            'waiterid' => $waiterid,
            'paitime' => date('Y-m-d H:i:s', time())
        );
        $item     = pdo_fetch("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid =" . $_W['uniacid']);
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($item['acid']);
        $token  = $accObj->fetch_token();
        pdo_update('xm_housekeep_orderform', $data, array(
            'orderformid' => $orderid
        ));
        $base = $this->base;
        require_once IA_ROOT . '/framework/function/communication.func.php';
        $url          = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $token;
        $remark1      = str_replace("{address}", $address, $base['remark1']);
        $remark1      = str_replace("{remark}", $mark, $remark1);
        $staff_mobile = $this->getmobile($waiterid);
        $remark1      = str_replace("{mobile}", $staff_mobile, $remark1);
        $remark2      = str_replace("{address}", $address, $base['remark2']);
        $remark2      = str_replace("{remark}", $mark, $remark2);
        $mobile       = $this->getSj($openid);
        $remark2      = str_replace("{mobile}", $mobile, $remark2);
        $data         = array(
            'touser' => $openid,
            'template_id' => $base['msg1'],
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/app/index.php?i=' . $_W[uniacid] . '&c=entry&staff_id=' . $waiterid . '&name=xm_housekeep_we7&do=staff&m=xm_housekeep_we7',
            'topcolor' => '#FF0000',
            'data' => array(
                'first' => array(
                    'value' => $base['hello1'],
                    'color' => '#173177'
                ),
                'goods_name' => array(
                    'value' => $this->gettypename($tid),
                    'color' => '#173177'
                ),
                'service_time' => array(
                    'value' => $ftime,
                    'color' => '#173177'
                ),
                'engineer_name' => array(
                    'value' => $this->getwaiter($waiterid),
                    'color' => '#173177'
                ),
                'cost_standard' => array(
                    'value' => '请参考【服务说明】',
                    'color' => '#173177'
                ),
                'remark' => array(
                    'value' => $remark1,
                    'color' => '#173177'
                )
            )
        );
        ihttp_post($url, json_encode($data));
        $wopenid = $this->getwaiteropenid($waiterid);
        if (!empty($wopenid)) {
            $data1 = array(
                'touser' => $wopenid,
                'template_id' => $base['msg2'],
                'url' => '',
                'topcolor' => '#FF0000',
                'data' => array(
                    'first' => array(
                        'value' => $base['hello2'],
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $this->gettypename($tid),
                        'color' => '#173177'
                    ),
                    'keyword2' => array(
                        'value' => $this->getwaiter($waiterid),
                        'color' => '#173177'
                    ),
                    'keyword3' => array(
                        'value' => $ftime,
                        'color' => '#173177'
                    ),
                    'remark' => array(
                        'value' => $remark2,
                        'color' => '#173177'
                    )
                )
            );
            ihttp_post($url, json_encode($data1));
        }
        message('已派单成功！', $this->createWebUrl('Order', array()), 'success');
    }
    public function doWebFinish()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('6', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Order', array()), 'error');
        }
        $orderid = intval($_GPC['orderid']);
        $sql1    = "SELECT orderformid,openid,typeid,ftime,address,mark,waiterid FROM " . tablename('xm_housekeep_orderform') . " WHERE orderformid =" . $orderid;
        $item    = pdo_fetch($sql1);
        include $this->template('finish');
    }
    public function doWebFinishok()
    {
        global $_W, $_GPC;
        $orderid    = $_GPC['orderid'];
        $waiterid   = $_GPC['waiterid'];
        $openid     = $_GPC['openid'];
        $closemoney = $_GPC['closemoney'];
        $data       = array(
            'state' => 2,
            'closemoney' => $closemoney,
            'closetime' => date('Y-m-d H:i:s', time())
        );
        $getRes     = pdo_update('xm_housekeep_orderform', $data, array(
            'orderformid' => $orderid
        ));
        load()->model('mc');
        $base   = $this->base;
        $credit = floor($closemoney / $base['sbili']);
        $mc     = pdo_fetch("SELECT uid FROM " . tablename('mc_mapping_fans') . " WHERE openid='" . $openid . "' AND uniacid='" . $_W['uniacid'] . "'");
        if (getRes) {
            $result = mc_credit_update($mc['uid'], 'credit1', $credit);
        }
        $sql1  = "SELECT fromopenid FROM " . tablename('xm_housekeep_userfrom') . " WHERE openid = '" . $openid . "'";
        $item1 = pdo_fetch($sql1);
        if (!empty($item1)) {
            $cut = sprintf("%.2f", ($closemoney * ($base['bili'] / 100)));
        }
        $sql2  = "SELECT id,openid,name,mobile,cutmoney FROM " . tablename('xm_housekeep_staff') . " WHERE flag = '" . $item1['fromopenid'] . "' AND weid = '" . $_W['uniacid'] . "'";
        $item2 = pdo_fetch($sql2);
        $data2 = array(
            'weid' => $_W['uniacid'],
            'orderformid' => $orderid,
            'waiterid' => $waiterid,
            'openid' => $openid,
            'closemoney' => $closemoney,
            'cut' => $cut,
            'staff_id' => $item2['id'],
            'staff_openid' => $item2['openid'],
            'staff_name' => $item2['name'],
            'staff_mobile' => $item2['mobile'],
            'addtime' => date('Y-m-d H:i:s')
        );
        if ($result) {
            $res = pdo_insert('xm_housekeep_cutlog', $data2);
            if ($res) {
                if (!empty($item2['name'])) {
                    $data3 = array(
                        'cutmoney' => $item2['cutmoney'] + $cut
                    );
                    pdo_update('xm_housekeep_staff', $data3, array(
                        'id' => $item2['id']
                    ));
                }
                $item = pdo_fetch("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid =" . $_W['uniacid']);
                load()->classs('weixin.account');
                $accObj = WeixinAccount::create($item['acid']);
                $token  = $accObj->fetch_token();
                require_once IA_ROOT . '/framework/function/communication.func.php';
                $url  = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $token;
                $data = array(
                    'touser' => $openid,
                    'template_id' => $base['msg3'],
                    'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/app/index.php?i=' . $_W[uniacid] . '&c=entry&orderid=' . $orderid . '&name=xm_housekeep_we7&do=Orderpage&m=xm_housekeep_we7',
                    'topcolor' => '#FF0000',
                    'data' => array(
                        'first' => array(
                            'value' => $base['hello3'],
                            'color' => '#173177'
                        ),
                        'keyword1' => array(
                            'value' => $orderid,
                            'color' => '#173177'
                        ),
                        'keyword2' => array(
                            'value' => $this->getPro($orderid),
                            'color' => '#173177'
                        ),
                        'remark' => array(
                            'value' => $base['remark3'],
                            'color' => '#173177'
                        )
                    )
                );
                ihttp_post($url, json_encode($data));
                $data3 = array(
                    'touser' => $openid,
                    'template_id' => $base['msg5'],
                    'url' => '',
                    'topcolor' => '#FF0000',
                    'data' => array(
                        'first' => array(
                            'value' => $base['hello5'],
                            'color' => '#173177'
                        ),
                        'keyword1' => array(
                            'value' => $credit,
                            'color' => '#173177'
                        ),
                        'keyword2' => array(
                            'value' => date('Y-m-d H:i:s'),
                            'color' => '#173177'
                        ),
                        'keyword3' => array(
                            'value' => $this->getPro($orderid) . '消费' . $closemoney,
                            'color' => '#173177'
                        ),
                        'remark' => array(
                            'value' => $base['remark5'],
                            'color' => '#173177'
                        )
                    )
                );
                ihttp_post($url, json_encode($data3));
            }
            message('此派单已完工！', $this->createWebUrl('Order', array()), 'success');
        }
    }
    public function doWebShow()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('7', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Order', array()), 'error');
        }
        $orderid = intval($_GPC['orderid']);
        $sql1    = "SELECT orderformid,openid,typeid,ftime,address,mark,waiterid,closemoney FROM " . tablename('xm_housekeep_orderform') . " WHERE orderformid =" . $orderid;
        $item    = pdo_fetch($sql1);
        include $this->template('show');
    }
    public function getCut($orderid)
    {
        $sql1 = "SELECT cut FROM " . tablename('xm_housekeep_cutlog') . " WHERE orderformid =" . $orderid;
        $item = pdo_fetch($sql1);
        return $item['cut'];
    }
    public function getName($orderid)
    {
        $sql1 = "SELECT staff_name FROM " . tablename('xm_housekeep_cutlog') . " WHERE orderformid =" . $orderid;
        $item = pdo_fetch($sql1);
        return $item['staff_name'];
    }
    public function doWebQuestion()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        $item  = pdo_fetch("SELECT * FROM " . tablename('xm_housekeep_question') . " WHERE weid='" . $_W['uniacid'] . "' ORDER BY id DESC");
        load()->func('tpl');
        include $this->template('question');
    }
    public function doWebQuestionok()
    {
        global $_W, $_GPC;
        checklogin();
        if (checksubmit()) {
            $id = intval($_GPC['id']);
            if (empty($_GPC['content'])) {
                message("问题说明不能为空");
            }
            $data = array(
                'weid' => $this->weid,
                'name' => $_GPC['name'],
                'content' => htmlspecialchars_decode($_GPC['content']),
                'addtime' => time()
            );
            if (empty($id)) {
                pdo_insert('xm_housekeep_question', $data);
                message('数据添加成功！', $this->createWebUrl('question', array()), 'success');
            } else {
                pdo_update('xm_housekeep_question', $data, array(
                    'id' => $id
                ));
                message('数据修改成功！', $this->createWebUrl('question', array()), 'success');
            }
        }
    }
    public function doWebService()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        $item  = pdo_fetch("SELECT * FROM " . tablename('xm_housekeep_service') . " WHERE weid='" . $_W['uniacid'] . "' ORDER BY id DESC");
        load()->func('tpl');
        include $this->template('service');
    }
    public function doWebServiceok()
    {
        global $_W, $_GPC;
        checklogin();
        if (checksubmit()) {
            $id = intval($_GPC['id']);
            if (empty($_GPC['content'])) {
                message("服务说明不能为空");
            }
            $data = array(
                'weid' => $this->weid,
                'name' => $_GPC['name'],
                'content' => htmlspecialchars_decode($_GPC['content']),
                'addtime' => time()
            );
            if (empty($id)) {
                pdo_insert('xm_housekeep_service', $data);
                message('数据添加成功！', $this->createWebUrl('service', array()), 'success');
            } else {
                pdo_update('xm_housekeep_service', $data, array(
                    'id' => $id
                ));
                message('数据修改成功！', $this->createWebUrl('service', array()), 'success');
            }
        }
    }
    public function random($c)
    {
        $a = range(0, 9);
        for ($i = 0; $i < $c; $i++) {
            $b[] = array_rand($a);
        }
        return join("", $b);
    }
    public function doWebAdv()
    {
        global $_GPC, $_W;
        checklogin();
        $power  = $this->power;
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_adv') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        if (!empty($list)) {
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xm_housekeep_adv') . " WHERE weid = '" . $_W['uniacid'] . "' ORDER BY id DESC");
            $pager = pagination($total, $pindex, $psize);
            unset($row);
        }
        include $this->template('adv-list');
    }
    public function doWebAdvadd()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('13', $power)) {
            message('您没有权限操作！', $this->createWebUrl('Adv', array()), 'error');
        }
        $id = intval($_GPC['id']);
        if (!empty($id)) {
            $item = pdo_fetch("SELECT * FROM " . tablename('xm_housekeep_adv') . " WHERE weid='" . $_W['uniacid'] . "' AND id='" . $id . "'");
        }
        load()->func('tpl');
        include $this->template('adv-add');
    }
    public function doWebAdvaddok()
    {
        global $_W, $_GPC;
        checklogin();
        $id = intval($_GPC['id']);
        if (checksubmit('submit')) {
            if (empty($_GPC['name'])) {
                message('幻灯片名称不能为空');
            }
            if (empty($_GPC['link'])) {
                message('幻灯片链接地址不能为空');
            }
            if (empty($_GPC['pic'])) {
                message('没有上传图片');
            }
            if (empty($_GPC['top'])) {
                $top = 0;
            } else {
                $top = $_GPC['top'];
            }
            $data = array(
                'weid' => $_W['uniacid'],
                'name' => $_GPC['name'],
                'link' => $_GPC['link'],
                'pic' => $_GPC['pic'],
                'top' => $_GPC['top'],
                'addtime' => time()
            );
            if (empty($id)) {
                pdo_insert('xm_housekeep_adv', $data);
                message('数据添加成功！', $this->createWebUrl('adv', array()), 'success');
            } else {
                pdo_update('xm_housekeep_adv', $data, array(
                    'id' => $id
                ));
                message('数据修改成功！', $this->createWebUrl('adv', array()), 'success');
            }
        }
    }
    public function doWebAdvdelete()
    {
        global $_W, $_GPC;
        checklogin();
        $id = intval($_GPC['id']);
        pdo_delete('xm_housekeep_adv', array(
            'id' => $id
        ));
        message('删除成功！', $this->createWebUrl('adv', array()), 'success');
    }
    public function doWebBase()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        $sql1  = "SELECT id,openid,name FROM " . tablename('xm_housekeep_staff') . " WHERE weid='" . $_W['uniacid'] . "' AND accept = 1 AND 1=1";
        $list  = pdo_fetchall($sql1);
        $sql2  = "SELECT * FROM " . tablename('xm_housekeep_base') . " WHERE weid='" . $_W['uniacid'] . "' AND 1=1";
        $item  = pdo_fetch($sql2);
        load()->func('tpl');
        include $this->template('base');
    }
    public function doWebBaseaddok()
    {
        global $_W, $_GPC;
        $id   = intval($_GPC['id']);
        $data = array(
            'yyopenid' => $_GPC['yyopenid'],
            'weid' => $_W['uniacid'],
            'bili' => $_GPC['bili'],
            'lead' => $_GPC['lead'],
            'sbili' => $_GPC['sbili'],
            'comment1' => $_GPC['comment1'],
            'comment2' => $_GPC['comment2'],
            'comment3' => $_GPC['comment3'],
            'msg1' => $_GPC['msg1'],
            'hello1' => $_GPC['hello1'],
            'remark1' => $_GPC['remark1'],
            'msg2' => $_GPC['msg2'],
            'hello2' => $_GPC['hello2'],
            'remark2' => $_GPC['remark2'],
            'msg3' => $_GPC['msg3'],
            'hello3' => $_GPC['hello3'],
            'remark3' => $_GPC['remark3'],
            'msg4' => $_GPC['msg4'],
            'hello4' => $_GPC['hello4'],
            'remark4' => $_GPC['remark4'],
            'msg5' => $_GPC['msg5'],
            'hello5' => $_GPC['hello5'],
            'remark5' => $_GPC['remark5'],
            'share_title' => $_GPC['share_title'],
            'share_icon' => $_GPC['share_icon'],
            'share_content' => $_GPC['share_content'],
            'link' => $_GPC['link']
        );
        if (empty($id)) {
            $data['addtime'] = date('Y-m-d H:i:s');
            pdo_insert('xm_housekeep_base', $data);
            message('数据添加成功！', $this->createWebUrl('Base', array()), 'success');
        } else {
            $data['updatetime'] = date('Y-m-d H:i:s');
            pdo_update('xm_housekeep_base', $data, array(
                'id' => $id
            ));
            message('数据修改成功！', $this->createWebUrl('base', array()), 'success');
        }
    }
    public function doWebPower()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('17', $power)) {
            message('您没有权限操作！');
        }
        $account = pdo_fetch("SELECT * FROM " . tablename('uni_account') . " WHERE uniacid = " . $_W['uniacid']);
        if (empty($account)) {
            message('抱歉，您操作的公众号不存在或是已经被删除！');
        }
        $permission = pdo_fetchall("SELECT id, uid, role FROM " . tablename('uni_account_users') . " WHERE uniacid = " . $_W['uniacid']);
        include $this->template('power');
    }
    public function getUser($uid)
    {
        $member = pdo_fetch("SELECT username, uid FROM " . tablename('users') . " WHERE uid=" . $uid);
        return $member['username'];
    }
    public function getcheck($uid)
    {
        global $_W, $_GPC;
        if (pdo_fetchcolumn('SELECT id FROM ' . tablename('uni_account_users') . ' WHERE uniacid = :uniacid AND uid = :uid', array(
            ':uniacid' => $_W['uniacid'],
            ':uid' => $uid
        ))) {
            return 1;
        } else {
            return 0;
        }
    }
    public function doWebAddpower()
    {
        global $_W, $_GPC;
        checklogin();
        $uid   = intval($_GPC['uid']);
        $from  = $_GPC['from'];
        $sql   = "SELECT power FROM " . tablename('xm_housekeep_power') . " WHERE weid = '" . $_W['uniacid'] . "' AND uid = '" . $uid . "' AND 1=1";
        $item  = pdo_fetch($sql);
        $power = explode(",", $item['power']);
        include $this->template('addpower');
    }
    public function doWebaddpowerok()
    {
        global $_W, $_GPC;
        $uid   = intval($_GPC['id']);
        $power = $_GPC['power'];
        $power = implode(",", $power);
        $data  = array(
            'weid' => $_W['uniacid'],
            'uid' => $uid,
            'power' => $power,
            'addtime' => date('Y-m-d H:i:s')
        );
        $item  = pdo_fetch("SELECT id FROM " . tablename('xm_housekeep_power') . " WHERE uid=" . $uid . " AND weid=" . $this->weid . "");
        if (empty($item['id'])) {
            pdo_insert('xm_housekeep_power', $data);
            message('权限添加成功！', $this->createWebUrl('power', array()), 'success');
        } else {
            pdo_update('xm_housekeep_power', $data, array(
                'id' => $item['id']
            ));
            message('权限修改成功！', $this->createWebUrl('power', array()), 'success');
        }
    }
    public function doWebCut()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('18', $power)) {
            message('您没有权限操作！');
        }
        $where           = '';
        $params          = array();
        $params[':weid'] = $this->weid;
        if (isset($_GPC['keyword'])) {
            $where .= ' AND `name` LIKE :keywords';
            $params[':keywords'] = "%{$_GPC['keyword']}%";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_staff') . " WHERE weid =:weid " . $where . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xm_housekeep_staff') . " WHERE weid =:weid " . $where, $params);
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('cut');
    }
    public function doWebCutlog()
    {
        global $_W, $_GPC;
        $id     = intval($_GPC['id']);
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_cutlog') . " WHERE weid = '" . $_W['uniacid'] . "' AND staff_id = " . $id . " ORDER BY addtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        if (!empty($list)) {
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xm_housekeep_cutlog') . " WHERE weid = '" . $_W['uniacid'] . "' AND staff_id = " . $id . " ORDER BY addtime DESC");
            $pager = pagination($total, $pindex, $psize);
            unset($row);
        }
        include $this->template('cutlog');
    }
    public function getOrder($orderid)
    {
        global $_W, $_GPC;
        $sql  = "SELECT typeid,ftime,address FROM " . tablename('xm_housekeep_orderform') . " WHERE orderformid='" . $orderid . "'";
        $item = pdo_fetch($sql);
        return $item['ftime'] . '在<' . $item['address'] . '>进行[' . $this->gettypename($item['typeid']) . ']';
    }
    public function doWebGivecut()
    {
        global $_W, $_GPC;
        $id   = intval($_GPC['id']);
        $item = pdo_fetch("SELECT id,name,openid,cutmoney,getmoney FROM " . tablename('xm_housekeep_staff') . " WHERE id=" . $id);
        include $this->template('givecut');
    }
    public function doWebGivecutok()
    {
        global $_W, $_GPC;
        $openid = $_GPC['staff_openid'];
        $cut    = $_GPC['cut'];
        if (empty($cut)) {
            $cut = 0;
        }
        $yu = $_GPC['yu'];
        if ($cut > $yu) {
            message('发放金额大于剩余金额，不能发放');
        }
        $data   = array(
            'weid' => $_W['uniacid'],
            'staff_id' => $_GPC['staff_id'],
            'openid' => $openid,
            'staff_name' => $_GPC['staff_name'],
            'cut' => $_GPC['cut'],
            'addtime' => date('Y-m-d H:i:s')
        );
        $getres = pdo_insert('xm_housekeep_givecut', $data);
        if ($getres) {
            $item  = pdo_fetch("SELECT id,getmoney FROM " . tablename('xm_housekeep_staff') . " WHERE id = '" . $_GPC['staff_id'] . "'");
            $data1 = array(
                'getmoney' => $item['getmoney'] + $_GPC['cut']
            );
            pdo_update('xm_housekeep_staff', $data1, array(
                'id' => $item['id']
            ));
            message('提成发放成功！', $this->createWebUrl('Cut', array()), 'success');
        }
    }
    public function doWebFacut()
    {
        global $_W, $_GPC;
        $where           = '';
        $params          = array();
        $params[':weid'] = $this->weid;
        if (isset($_GPC['keyword'])) {
            $where .= ' AND `staff_name` LIKE :keywords';
            $params[':keywords'] = "%{$_GPC['keyword']}%";
        }
        if (isset($_GPC['staff_id'])) {
            $where .= ' AND `staff_id` = ' . $_GPC['staff_id'] . '';
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_givecut') . " WHERE weid =:weid " . $where . " ORDER BY addtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xm_housekeep_givecut') . " WHERE weid =:weid " . $where, $params);
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('facut');
    }
    public function doWebUser()
    {
        global $_W, $_GPC;
        checklogin();
        $power = $this->power;
        if (!in_array('22', $power)) {
            message('您没有权限操作！');
        }
        $where           = '';
        $params          = array();
        $params[':weid'] = $this->weid;
        if (isset($_GPC['keyword'])) {
            $where .= ' AND `nickname` LIKE :keywords';
            $params[':keywords'] = "%{$_GPC['keyword']}%";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('mc_members') . " WHERE uniacid = '" . $_W['uniacid'] . "' AND nickname<>'' " . $where . " ORDER BY uid DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . " WHERE uniacid = '" . $_W['uniacid'] . "'  AND nickname<>'' " . $where, $params);
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('user');
    }
    public function doWebBelong()
    {
        global $_W, $_GPC;
        $where  = '';
        $params = array();
        if (isset($_GPC['keyword'])) {
            $where .= ' AND `name` LIKE :keywords';
            $params[':keywords'] = "%{$_GPC['keyword']}%";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "'" . $where . " ORDER BY addtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "'" . $where, $params);
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('belong');
    }
    public function doWebBelonglist()
    {
        global $_W, $_GPC;
        $flag   = $_GPC['flag'];
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 20;
        $list   = pdo_fetchall("SELECT * FROM " . tablename('xm_housekeep_userfrom') . " WHERE weid = '" . $_W['uniacid'] . "' AND fromopenid = '" . $flag . "' ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        if (!empty($list)) {
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('xm_housekeep_userfrom') . " WHERE weid = '" . $_W['uniacid'] . "' AND fromopenid = '" . $flag . "' ORDER BY id DESC");
            $pager = pagination($total, $pindex, $psize);
            unset($row);
        }
        include $this->template('belonglist');
    }
    public function doMobilexmCover()
    {
        global $_GPC, $_W;
        $sql1 = 'SELECT  id,weid,name,jianjie,icon,istop1,istop2,typeorder  FROM ' . tablename('xm_housekeep_project') . ' WHERE weid = ' . $_W['uniacid'] . '  order by istop1 desc,istop2 desc, typeorder asc limit 0,2';
        $top1 = pdo_fetchall($sql1);
        $sql2 = 'SELECT  id,weid,name,jianjie,icon,istop1,istop2,typeorder  FROM ' . tablename('xm_housekeep_project') . ' WHERE weid = ' . $_W['uniacid'] . '  order by istop2 desc, typeorder asc limit 0,5';
        $top2 = pdo_fetchall($sql2);
        $sql3 = 'SELECT link,pic FROM ' . tablename('xm_housekeep_adv') . ' WHERE weid = ' . $_W['uniacid'] . ' ORDER BY top ASC,addtime DESC';
        $list = pdo_fetchall($sql3);
        if (empty($list)) {
            $list = array(
                array(
                    'pic' => 'images/default.png'
                )
            );
        }
        $from = 'index';
        $base = $this->base;
        include $this->template('index');
    }
    public function checkfollow($openid)
    {
        global $_W, $_GPC;
        $sql  = "SELECT follow FROM " . tablename('mc_mapping_fans') . " WHERE openid = '" . $openid . "' AND  uniacid = '" . $_W['uniacid'] . "'";
        $item = pdo_fetch($sql);
        if (empty($item)) {
            return 0;
        } else {
            return $item['follow'];
        }
    }
    public function doMobileValidate()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $sql  = "SELECT id,name,mobile FROM " . tablename('xm_housekeep_staff') . " WHERE openid = '" . $openid . "' AND weid='" . $_W['uniacid'] . "'";
        $item = pdo_fetch($sql);
        if (!empty($item)) {
            $headurl    = $_W['fans']['tag']['avatar'];
            $niname     = $_W['fans']['nickname'];
            $isValidate = 1;
        }
        include $this->template('validate');
    }
    public function doMobileValidateok()
    {
        global $_W, $_GPC;
        $openid = $_W['fans']['from_user'];
        $mobile = $_GPC['mobile'];
        $sql    = "SELECT id,mobile FROM " . tablename('xm_housekeep_staff') . " WHERE mobile = '" . $mobile . "'";
        $item   = pdo_fetch($sql);
        if (empty($item)) {
            $msg = '0';
        } else {
            $data = array(
                'openid' => $openid,
                'updatetime' => date('Y-m-d H:i:s')
            );
            $res  = pdo_update('xm_housekeep_staff', $data, array(
                'id' => $item['id']
            ));
            if ($res) {
                $msg = '1';
            } else {
                $msg = '0';
            }
        }
        return $msg;
    }
    public function doMobileDetailed()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $id       = $_GPC['id'];
        $typename = $_GPC['typename'];
        $sql      = "SELECT id,price FROM " . tablename('xm_housekeep_project') . " WHERE id=" . $id;
        $item     = pdo_fetch($sql);
        load()->model('mc');
        $members = mc_fetch($_W['member']['uid'], array(
            'mobile',
            'address'
        ));
        $from    = 'index';
        include $this->template('order-form');
    }
    public function doMobilePrice()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $id   = $_GPC['id'];
        $sql  = "SELECT price_con FROM " . tablename('xm_housekeep_project') . " WHERE id=" . $id;
        $item = pdo_fetch($sql);
        $from = 'index';
        include $this->template('price');
    }
    public function doMobileMore()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $sql  = "select id,name,icon from " . tablename('xm_housekeep_type') . " where weid='" . $_W['uniacid'] . "' order by top asc,addtime desc";
        $list = pdo_fetchall($sql);
        $from = 'index';
        function getProList($id)
        {
            global $_W, $_GPC;
            $proSql  = "select id,name,icon from " . tablename('xm_housekeep_project') . " where type_id='" . $id . "' order by typeorder asc,addtime desc";
            $proList = pdo_fetchall($proSql);
            $divStr  = '';
            foreach ($proList as $val) {
                $icon   = "" . $_W['attachurl'] . "" . $val['icon'] . "";
                $url    = 'http://' . $_SERVER['HTTP_HOST'] . '/app/index.php?i=' . $_W[weid] . '&c=entry&id=' . $val[id] . '&typename=' . $val[name] . '&do=Detailed&m=xm_housekeep_we7&wxref=mp.weixin.qq.com#wechat_redirect';
                $divStr = $divStr . '<a href="' . $url . '" class="ufl ub ub-ver ub-ac ub-pc" style="width:25%; height:4rem">';
                $divStr .= '<div><img src="' . $icon . '" style="width:1.8rem;height:1.8rem"></div>';
                $divStr .= '<div class="t-gra font-b ulev-1">' . $val[name] . '</div></a>';
            }
            if (empty($proList)) {
                $divStr = '<div class="t-gra font-b ulev-1">暂无项目</div>';
            }
            return $divStr;
        }
        include $this->template('more');
    }
    public function doMobileSaveorderform()
    {
        global $_W, $_GPC;
        $base    = $this->base;
        $tid     = $_GPC['id'];
        $ftime   = $_GPC['ftime'];
        $address = $_GPC['address'];
        $mark    = $_GPC['mark'];
        $mobile  = $_GPC['mobile'];
        $openid  = $_W['openid'];
        if (strlen($openid) < 15) {
            header('Location:' . $base['lead']);
        }
        $data = array(
            'weid' => $_W['uniacid'],
            'typeid' => $tid,
            'openid' => $openid,
            'ftime' => $ftime,
            'address' => $address,
            'mark' => $mark,
            'mobile' => $mobile,
            'addtime' => date("y-m-d H:i:s")
        );
        if (!empty($openid)) {
            $getRes = pdo_insert('xm_housekeep_orderform', $data);
            require_once IA_ROOT . '/framework/function/communication.func.php';
            $url  = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $_W['account']['access_token']['token'];
            $data = array(
                'touser' => $base['yyopenid'],
                'template_id' => $base['msg4'],
                'url' => '',
                'topcolor' => '#FF0000',
                'data' => array(
                    'first' => array(
                        'value' => $base['hello4'],
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $getRes,
                        'color' => '#173177'
                    ),
                    'keyword2' => array(
                        'value' => $this->gettypename($tid),
                        'color' => '#173177'
                    ),
                    'keyword3' => array(
                        'value' => $address,
                        'color' => '#173177'
                    ),
                    'keyword4' => array(
                        'value' => $ftime,
                        'color' => '#173177'
                    ),
                    'keyword5' => array(
                        'value' => $mark,
                        'color' => '#173177'
                    ),
                    'remark' => array(
                        'value' => $base['remark'],
                        'color' => '#173177'
                    )
                )
            );
            ihttp_post($url, json_encode($data));
            if ($getRes) {
                load()->model('mc');
                $result = mc_update($_W['member']['uid'], array(
                    'address' => $address,
                    'mobile' => $mobile
                ));
                $prompt = "订单提交成功,我们会尽快与您联系!";
            } else {
                $flag   = 0;
                $prompt = "订单提交失败,请重新输入订单!";
            }
            $from = 'index';
            include $this->template('info');
        }
    }
    public function doMobileUsercenter()
    {
        global $_W, $_GPC;
        $base    = $this->base;
        $headurl = $_W['fans']['tag']['avatar'];
        $niname  = $_W['fans']['nickname'];
        load()->model('mc');
        $result = mc_credit_fetch($_W['member']['uid'], array(
            'credit1'
        ));
        if (empty($result['credit1'])) {
            $credit1 = 0;
        } else {
            $credit1 = floor($result['credit1']);
        }
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $sql  = "SELECT id,ticket FROM " . tablename('xm_housekeep_staff') . " WHERE openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "'";
        $item = pdo_fetch($sql);
        if (!empty($item['id'])) {
            $is = 1;
        }
        include $this->template('usercenter');
    }
    public function doMobileMycut()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $sql1  = "SELECT sum(cut) FROM " . tablename('xm_housekeep_cutlog') . "WHERE staff_openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "' AND 1=1";
        $sum1  = sprintf("%0.2f", pdo_fetchcolumn($sql1));
        $sql11 = "SELECT staff_openid,cut,addtime FROM " . tablename('xm_housekeep_cutlog') . "WHERE staff_openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "' AND 1=1";
        $list1 = pdo_fetchall($sql11);
        $sql2  = "SELECT sum(cut) FROM " . tablename('xm_housekeep_givecut') . "WHERE openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "' AND 1=1";
        $sum2  = sprintf("%0.2f", pdo_fetchcolumn($sql2));
        $sql22 = "SELECT openid,cut,addtime FROM " . tablename('xm_housekeep_givecut') . "WHERE openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "' AND 1=1";
        $list2 = pdo_fetchall($sql22);
        $from  = 'user';
        include $this->template('mycut');
    }
    public function doMobileMycut1()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $sql1  = "SELECT sum(cut) FROM " . tablename('xm_housekeep_cutlog') . "WHERE staff_openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "' AND 1=1";
        $sum1  = sprintf("%0.2f", pdo_fetchcolumn($sql1));
        $sql2  = "SELECT sum(cut) FROM " . tablename('xm_housekeep_givecut') . "WHERE openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "' AND 1=1";
        $sum2  = sprintf("%0.2f", pdo_fetchcolumn($sql2));
        $sql22 = "SELECT openid,cut,addtime FROM " . tablename('xm_housekeep_givecut') . "WHERE openid = '" . $openid . "' AND weid = '" . $_W['uniacid'] . "' AND 1=1";
        $list2 = pdo_fetchall($sql22);
        $from  = 'user';
        include $this->template('mycut1');
    }
    public function doMobileReg()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $headurl = $_W['fans']['tag']['avatar'];
        $niname  = $_W['fans']['nickname'];
        load()->model('mc');
        $members = mc_fetch($_W['member']['uid'], array(
            'realname',
            'mobile',
            'gender'
        ));
        $from    = 'user';
        include $this->template('reg');
    }
    public function doMobileRegok()
    {
        global $_W, $_GPC;
        $openid      = $_W['fans']['from_user'];
        $realname    = $_POST['realname'];
        $mobile      = $_POST['mobile'];
        $gender      = $_POST['gender'];
        $checkMobile = pdo_fetch("SELECT * FROM " . tablename('mc_members') . " WHERE `uniacid` = " . $_W['uniacid'] . " AND mobile = '" . $mobile . "'");
        if ($checkMobile['mobile'] == "") {
            $data_mc = array(
                'weid' => $_W['weid'],
                'realname' => $realname,
                'mobile' => $mobile,
                'gender' => $gender
            );
            load()->model('mc');
            mc_update($_W['member']['uid'], $data_mc);
            $msg = '1';
        } else {
            $check = pdo_fetch("SELECT * FROM " . tablename('mc_members') . " WHERE `uniacid` = " . $_W['weid'] . " AND  mobile = '" . $mobile . "' AND uid != '" . $_W['member']['uid'] . "'");
            if (empty($check)) {
                $data_mc = array(
                    'weid' => $_W['weid'],
                    'realname' => $realname,
                    'mobile' => $mobile,
                    'gender' => $gender
                );
                load()->model('mc');
                mc_update($_W['member']['uid'], $data_mc);
                $msg = '1';
            } else {
                $msg = '0';
            }
        }
        return $msg;
    }
    public function doMobileQuestion()
    {
        global $_W, $_GPC;
        $sql  = "select * from " . tablename('xm_housekeep_question') . " WHERE weid = " . $_W['uniacid'] . " AND 1=1";
        $item = pdo_fetch($sql);
        $from = 'question';
        $base = $this->base;
        include $this->template('question');
    }
    public function doMobileService()
    {
        global $_W, $_GPC;
        $sql  = "select * from " . tablename('xm_housekeep_service') . " WHERE weid = " . $_W['uniacid'] . " AND 1=1";
        $item = pdo_fetch($sql);
        $from = 'service';
        $base = $this->base;
        include $this->template('service');
    }
    public function doMobileMyorderform()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $act = $_GPC['isok'];
        if ($act == "yes") {
            $sql     = "select * from " . tablename('xm_housekeep_orderform') . " WHERE weid = " . $_W['uniacid'] . " and openid= '" . $openid . "' and state = 2 order by orderformid desc";
            $tmplate = 'myorderform_1';
        } else {
            $sql     = "select * from " . tablename('xm_housekeep_orderform') . " WHERE weid = " . $_W['uniacid'] . " and openid= '" . $openid . "' and state <> 2 order by orderformid desc";
            $tmplate = 'myorderform';
        }
        $rows = pdo_fetchall($sql);
        $from = 'user';
        include $this->template($tmplate);
    }
    public function doMobileOrderpage()
    {
        global $_W, $_GPC;
        $base   = $this->base;
        $openid = $_W['fans']['from_user'];
        if ($this->checkfollow($openid) != 1) {
            header('Location:' . $base['lead']);
        }
        $id = intval($_GPC['orderid']);
        if (empty($id)) {
            $prompt = "获取订单失败!";
            $flag   = 0;
            $from   = 'user';
            include $this->template('info');
        }
        $sql  = "SELECT * FROM " . tablename('xm_housekeep_orderform') . " WHERE orderformid = " . $id;
        $item = pdo_fetch($sql);
        $from = 'user';
        include $this->template('order-page');
    }
    public function doMobileStaff()
    {
        global $_W, $_GPC;
        $staff_id = $_GPC['staff_id'];
        $sql      = "SELECT * FROM " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "' AND id = '" . $staff_id . "'";
        $item     = pdo_fetch($sql);
        $from     = 'user';
        include $this->template('staff');
    }
    public function doMobileComment()
    {
        global $_W, $_GPC;
        $base     = $this->base;
        $openid   = $_W['fans']['from_user'];
        $xing     = $_POST['xing'];
        $staff_id = $_POST['staff_id'];
        $orderid  = $_POST['orderid'];
        $comment  = $_GPC['comment'];
        if (empty($comment)) {
            $comment = $base['comment' . rand(1, 3) . ''];
            if (empty($comment)) {
                $comment = $base['comment1'];
            }
        }
        $data   = array(
            'weid' => $_W['uniacid'],
            'openid' => $openid,
            'staff_id' => $staff_id,
            'xing' => $xing,
            'comment' => $comment,
            'orderid' => $orderid,
            'addtime' => date('Y-m-d H:i:s')
        );
        $getRes = pdo_insert('xm_housekeep_comment', $data);
        if ($getRes) {
            $data1 = array(
                'xing' => $xing
            );
            $res   = pdo_update('xm_housekeep_orderform', $data1, array(
                'orderformid' => $orderid
            ));
            $msg   = 1;
        } else {
            $msg = 0;
        }
        echo $msg;
    }
    public function gettypename($typeid)
    {
        $sql = "select id,name from " . tablename('xm_housekeep_project') . " WHERE id=" . $typeid;
        $row = pdo_fetch($sql);
        return ($row['name']);
    }
    public function getPro($orderid)
    {
        global $_W, $_GPC;
        $item = pdo_fetch("SELECT typeid FROM " . tablename('xm_housekeep_orderform') . " WHERE orderformid = " . $orderid . "");
        $sql  = "select id,name from " . tablename('xm_housekeep_project') . " WHERE id=" . $item['typeid'];
        $row  = pdo_fetch($sql);
        return ($row['name']);
    }
    public function getwaiter($sid)
    {
        if ($sid != 0) {
            $sql = "select id,name from " . tablename('xm_housekeep_staff') . " WHERE id=" . $sid;
            $row = pdo_fetch($sql);
            return ($row['name']);
        } else {
            return ('未指定');
        }
    }
    public function getmobile($sid)
    {
        $sql = "select id,mobile from " . tablename('xm_housekeep_staff') . " WHERE id=" . $sid;
        $row = pdo_fetch($sql);
        return ($row['mobile']);
    }
    public function getwaiteropenid($sid)
    {
        $sql = "select id,openid from " . tablename('xm_housekeep_staff') . " WHERE id=" . $sid;
        $row = pdo_fetch($sql);
        return ($row['openid']);
    }
    public function getstate($state)
    {
        if ($state == 0) {
            return ("待派单");
        } elseif ($state == 1) {
            return ("已派单");
        } else {
            return ('已完工');
        }
    }
    public function getnickname($openid)
    {
        global $_W, $_GPC;
        $sql = "select uid from " . tablename('mc_mapping_fans') . " WHERE openid='" . $openid . "'";
        $row = pdo_fetch($sql);
        load()->model('mc');
        $members = mc_fetch($row['uid'], array(
            'nickname',
            'realname'
        ));
        return ($members['nickname']);
    }
    public function getAvatar($openid)
    {
        global $_W, $_GPC;
        $sql = "select uid from " . tablename('mc_mapping_fans') . " WHERE openid='" . $openid . "'";
        $row = pdo_fetch($sql);
        load()->model('mc');
        $members = mc_fetch($row['uid'], array(
            'avatar'
        ));
        if (empty($members['avatar'])) {
            $avatar = $_W['attachurl'] . 'images/avatar.jpg';
        } else {
            $avatar = $members['avatar'];
        }
        return $avatar;
    }
    public function getRealname($openid)
    {
        global $_W, $_GPC;
        $sql = "select uid from " . tablename('mc_mapping_fans') . " WHERE openid='" . $openid . "'";
        $row = pdo_fetch($sql);
        load()->model('mc');
        $members = mc_fetch($row['uid'], array(
            'realname'
        ));
        return ($members['realname']);
    }
    public function getSj($openid)
    {
        global $_W, $_GPC;
        $sql = "select uid from " . tablename('mc_mapping_fans') . " WHERE openid='" . $openid . "'";
        $row = pdo_fetch($sql);
        load()->model('mc');
        $members = mc_fetch($row['uid'], array(
            'mobile'
        ));
        return ($members['mobile']);
    }
    public function getFlag($flag)
    {
        global $_W, $_GPC;
        $sql = "select name from " . tablename('xm_housekeep_staff') . " WHERE flag='" . $flag . "' AND weid='" . $_W['uniacid'] . "'";
        $row = pdo_fetch($sql);
        return $row['name'];
    }
    public function getSex($id)
    {
        if ($id == 1) {
            $text = '男';
        } elseif ($id == 2) {
            $text = '女';
        } elseif ($id == 0) {
            $text = '保密';
        }
        return $text;
    }
    public function getOrderSum($uid)
    {
        global $_W, $_GPC;
        $sql  = "select openid from " . tablename('mc_mapping_fans') . " WHERE uid='" . $uid . "' AND uniacid = '" . $_W['uniacid'] . "'";
        $row  = pdo_fetch($sql);
        $sql1 = "SELECT count(*) FROM " . tablename('xm_housekeep_orderform') . " WHERE weid = '" . $_W['uniacid'] . "' AND openid = '" . $row['openid'] . "'";
        $item = pdo_fetchcolumn($sql1);
        return $item;
    }
    public function getBelong($uid)
    {
        global $_W, $_GPC;
        $sql  = "select openid from " . tablename('mc_mapping_fans') . " WHERE uid='" . $uid . "' AND uniacid = '" . $_W['uniacid'] . "'";
        $row  = pdo_fetch($sql);
        $sql1 = "SELECT fromopenid FROM " . tablename('xm_housekeep_userfrom') . " WHERE weid = '" . $_W['uniacid'] . "' AND openid = '" . $row['openid'] . "'";
        $item = pdo_fetch($sql1);
        if (empty($item)) {
            return '';
        } else {
            $sql2  = "SELECT id,name FROM " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "' AND flag = '" . $item['fromopenid'] . "'";
            $item2 = pdo_fetch($sql2);
            return $item2['name'];
        }
    }
    public function getFans($flag)
    {
        global $_W, $_GPC;
        $sql = "select count(*) from " . tablename('xm_housekeep_userfrom') . " WHERE fromopenid='" . $flag . "' AND weid = '" . $_W['uniacid'] . "'";
        $row = pdo_fetchcolumn($sql);
        return $row;
    }
    public function getComment($orderid)
    {
        global $_W, $_GPC;
        $sql  = "SELECT comment FROM " . tablename('xm_housekeep_comment') . " WHERE orderid=" . $orderid . " AND weid = '" . $_W['uniacid'] . "'";
        $item = pdo_fetch($sql);
        return $item['comment'];
    }
    public function getXing($staff_id)
    {
        global $_W, $_GPC;
        $sql  = "SELECT sum(xing) FROM " . tablename('xm_housekeep_comment') . " WHERE staff_id='" . $staff_id . "' AND weid = '" . $_W['uniacid'] . "'";
        $item = pdo_fetchcolumn($sql);
        if (empty($item)) {
            $item = 0;
        }
        $sql2  = "select count(*) from " . tablename('xm_housekeep_comment') . " WHERE staff_id='" . $staff_id . "' AND weid = '" . $_W['uniacid'] . "'";
        $total = pdo_fetchcolumn($sql2);
        if (empty($total)) {
            $total = 0;
        }
        return round($item / $total, 1);
    }
    public function getComment5($staff_id)
    {
        global $_W, $_GPC;
        $sql    = "SELECT openid,comment,addtime FROM " . tablename('xm_housekeep_comment') . " WHERE staff_id=" . $staff_id . " AND weid = '" . $_W['uniacid'] . "' ORDER BY addtime desc limit 0,5";
        $list   = pdo_fetchall($sql);
        $divStr = '';
        foreach ($list as $val) {
            $divStr = $divStr . '<div class="uinn5 ubb b-bla01 ub ub-ac"><div class="umar-r">';
            $divStr .= '<div class="uc-a50 c-org ub-img1 " style="height:3em; width:3em; background-image:url(' . $this->getAvatar($val[openid]) . ')"></div></div>';
            $divStr .= '<div class="ub-f1"><div class="ulev-2 t-gra">' . $val[addtime] . '</div><div class="ulev-1">' . $val[comment] . '</div></div>';
            $divStr .= '</div>';
        }
        return $divStr;
    }
    public function getAvatarA($openid)
    {
        global $_W, $_GPC;
        $sql  = "select avatar from " . tablename('xm_housekeep_staff') . " WHERE weid = '" . $_W['uniacid'] . "' and openid='" . $openid . "'";
        $item = pdo_fetch($sql);
        if (empty($item['avatar'])) {
            $row = pdo_fetch("select uid from " . tablename('mc_mapping_fans') . " WHERE openid='" . $openid . "'");
            load()->model('mc');
            $members = mc_fetch($row['uid'], array(
                'avatar'
            ));
            if (empty($members['avatar'])) {
                $avatar = '';
            } else {
                $avatar = $members['avatar'];
            }
        } else {
            $avatar = $_W['attachurl'] . $item['avatar'];
        }
        return $avatar;
    }
    public function wxHttpsRequest($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    public function doMobileMyqrcode()
    {
        global $_W, $_GPC;
        require_once IA_ROOT . '/framework/function/communication.func.php';
        $url     = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $_W['account']['access_token']['token'];
        $data    = array(
            'action_name' => 'QR_LIMIT_SCENE',
            'action_info' => array(
                'scene' => array(
                    'scene_id' => 456
                )
            )
        );
        $jsonstr = ihttp_post($url, json_encode($data));
        $arrstr  = json_decode($jsonstr['content'], true);
        $ticket  = $arrstr['ticket'];
        header('location:https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . UrlEncode($ticket));
    }
}