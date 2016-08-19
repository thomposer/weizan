<?php
global $_W, $_GPC;
$settings = $this->module['config'];
load()->func('tpl');
$op      = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$uniacid = $_W["uniacid"];
$id      = $_GPC['id'];
if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize  = 20;
    $con    = "uniacid=$uniacid";
    $name   = $_GPC['name'];
    if (!empty($name)) {
        $con .= " and name like '%$name%'";
    }
    $total            = 0;
    $cgc_addr_forward = new cgc_addr_forward();
    $list             = $cgc_addr_forward->getAll($con, $pindex, $psize, $total);
    $pager            = pagination($total, $pindex, $psize);
    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $url               = $this->createMobileUrl('enter', array(
                'q_id' => $list[$key]['id']
            ));
            $url               = substr($url, 2);
            $url               = $_W['siteroot'] . 'app/' . $url;
            $list[$key]['url'] = $url;
        }
    }
    include $this->template('forward');
    exit();
}
if ($op == 'post') {
    $id               = $_GPC['id'];
    $cgc_addr_forward = new cgc_addr_forward();
    if (!empty($id)) {
        $item                  = $cgc_addr_forward->getOne($id);
        $item['fans_regional'] = unserialize($item['fans_regional']);
    }
    if (checksubmit('submit')) {
        $fans_regional      = array();
        $fans_regional_addr = $_GPC['fans_regional_addr'];
        $fans_regional_url  = $_GPC['fans_regional_url'];
        if (is_array($fans_regional)) {
            foreach ($fans_regional_addr as $key => $value) {
                $d               = array(
                    'fans_regional_addr' => $fans_regional_addr[$key],
                    'fans_regional_url' => $fans_regional_url[$key]
                );
                $fans_regional[] = $d;
            }
        }
        if (!empty($fans_regional)) {
            $_GPC['fans_regional'] = serialize($fans_regional);
        }
        $input                  = array();
        $input['uniacid']       = $uniacid;
        $input['name']          = trim($_GPC['name']);
        $input['default_url']   = trim($_GPC['default_url']);
        $input['fans_regional'] = $_GPC['fans_regional'];
        if (!empty($id)) {
            $temp = $cgc_addr_forward->modify($id, $input);
        } else {
            $temp = $cgc_addr_forward->insert($input);
        }
        message('信息更新成功', $this->createWebUrl('forward', array(
            'op' => 'display'
        )), 'success');
    }
    include $this->template('forward');
    exit();
}
if ($op == 'delete') {
    $id               = $_GPC['id'];
    $cgc_addr_forward = new cgc_addr_forward();
    $cgc_addr_forward->delete($id);
    message('删除成功', $this->createWebUrl('forward', array(
        'op' => 'display'
    )), 'success');
}