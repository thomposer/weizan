<?php

/**
 * User: cofan * * QQ : 136670
 * Date: 7/21/15
 * Time: 09:47
 */

require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);

global $_W, $_GPC;
$weid=$_W['uniacid'];

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
load()->func('tpl');
$credittxt= pdo_fetchcolumn("SELECT credittxt FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize =10;
    $condition = "WHERE weid = $weid ";
    $params = array();
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND title LIKE :keyword";
        $params[':keyword'] = "%{$_GPC['keyword']}%";
    }
    $type = $_GPC['type'];
    if ($type != '') {
        $condition .= " AND type = '" . $type. "' ";
    }
    $list = pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_meal')."  $condition ORDER BY createtime DESC LIMIT ".
        ($pindex - 1) * $psize.',
'.$psize, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('amouse_rebate_meal') . " $condition ");
    $pager = pagination($total, $pindex, $psize);

} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    load()->func('tpl');
    load()->func('file');
    if ($id>0) {
        $item = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_meal')." WHERE id = :id" , array(':id' => $id));
        if (empty($item)) {
            message('抱歉，套餐不存在或是已经删除！', '', 'error');
        }

    }
    $nextWeek = time() + (7 * 24 * 60 * 60);
    if (checksubmit('submit')) {
        empty($_GPC['title']) ? message('亲,标题不能为空') : $title= $_GPC['title'];
        $data = array(
            'weid' => $_W['uniacid'],
            'title' => $title,
            'img' =>  $_GPC['img'],
            'desc' =>  $_GPC['desc'],
            'day'=>$_GPC['day'],
            'type'=>$_GPC['type'],
            'price'=>trim($_GPC['price']),
            'createtime' => TIMESTAMP 
        );
        if (empty($id)) {
            pdo_insert('amouse_rebate_meal', $data);
        } else {
            pdo_update('amouse_rebate_meal', $data, array('id' => $id));
        }
        message('套餐更新成功！', $this->createWebUrl('meal', array('op' => 'display')), 'success');
    }
}elseif($op=='delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM ".tablename('amouse_rebate_meal')." WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，记录不存在或是已经被删除！');
    }
    pdo_delete('amouse_rebate_meal', array('id' => $id));
    message('删除成功！', referer(), 'success');
}
include $this->template('web/meal');