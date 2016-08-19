<?php
/**
 * User: cofan * qq:136670
 * Date: 7/21/15
 * Time: 09:47
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
load()->func('tpl');

if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize =15;
    $status = $_GPC['status'];

    $condition = '';
    $params = array();
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND title LIKE :keyword";
        $params[':keyword'] = '%' . trim($_GPC['keyword']) . '%';
    }
   
    $start=($pindex - 1) * $psize;
    $sql="SELECT * FROM ".tablename('amouse_rebate_group')." WHERE weid = $weid $condition ORDER BY svip DESC ,id DESC LIMIT ".$start.','.$psize;
    $list = pdo_fetchall($sql, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('amouse_rebate_group') . " WHERE weid =$weid  $condition ", $params);
    $pager = pagination($total, $pindex, $psize);

} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    load()->func('tpl');
    if ($id>0) {
        $item = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_group')." WHERE id = :id" , array(':id' => $id));
        if (empty($item)) {
            message('抱歉，记录不存在或是已经删除！', '', 'error');
        }
    }
    if (checksubmit('submit')) {
        $data = array(
            'title'=>$_GPC['title'],
            'qrcode'=>$_GPC['qrcode'],
            'desc'=> $_GPC['desc'],
            'type'=>1,
            'createtime'=>strtotime($_GPC['createtime']),
            'updatetime'=>TIMESTAMP,
            'location_p' => $_GPC['location_p'],
            'location_c' => $_GPC['location_c'],
        );

        if (empty($id)) {
            $data['weid']=$weid;
            $data['hot']=0;
            $data['openid']=$this->generate_password(15);
            pdo_insert('amouse_rebate_group', $data);
        } else {
            $data['createtime']= strtotime($_GPC['createtime']);
            pdo_update('amouse_rebate_group', $data, array('id' => $id));
        }
        message('更新成功！', $this->createWebUrl('group', array('op' => 'display')), 'success');
    }
}elseif($op=='delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM ".tablename('amouse_rebate_group')." WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，记录不存在或是已经被删除！');
    }
    pdo_delete('amouse_rebate_group', array('id' => $id));
    message('删除成功！', referer(), 'success');
}elseif ($op == 'setstatus') {
    $id  = intval($_GPC['id']);
    $data = intval($_GPC['data']);
    $type = $_GPC['type'];
    $data = ($data == 1 ? '0' : '1');

    pdo_update('amouse_rebate_group', array($type=> $data), array("id" => $id));
    die(json_encode(array(
        'result' => 1,
        'data' => $data
    )));

}
include $this->template('web/group');