<?php
/**
 * User: cofan * qq:136670
 * Date: 7/21/15
 * Time: 09:47
 */
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize =15;
    $status = $_GPC['status'];
    $params = array();
    $condition = " where uniacid= $weid  ";
    if (!empty($_GPC['keyword'])) {
        $_GPC['keyword'] = trim($_GPC['keyword']);
        $condition .= ' AND ( title LIKE :keyword ) ';
        $params[':keyword'] = '%' . trim($_GPC['keyword']) . '%';
    }

    $list = pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_goods')." {$condition} ORDER BY  isdefault DESC , createtime DESC LIMIT ".($pindex - 1) * $psize.',
'.$psize, $params);

    $total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('amouse_rebate_goods'). $condition , $params);

    $pager = pagination($total, $pindex, $psize);

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    load()->func('tpl');
    if ($id>0) {
        $item = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_goods')." WHERE id = :id" , array(':id' => $id));
        $piclist1 = unserialize($item['thumb_url']);
 
        $piclist  = array();
        if (is_array($piclist1)) {
            foreach ($piclist1 as $p) {
                $piclist[] = is_array($p) ? $p['attachment'] : $p;
            }
        }
    }else{
        $item['status']=1;
    }
    $pindex = max(1, intval($_GPC['page']));
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'=>$weid,
            'title'=>$_GPC['title'],
            'price'=>$_GPC['price'],
            'thumb'=>tomedia($_GPC['thumb']),
            'isdefault'=> $_GPC['isdefault'], 
            'status'=> $_GPC['status'],
            'createtime'=> strtotime($_GPC['createtime'])
        );
        if (is_array($_GPC['thumbs'])) {
            $thumbs    = $_GPC['thumbs'];
            $thumb_url = array();
            foreach ($thumbs as $th) {
                $thumb_url[] = tomedia($th);
            }
            $data['thumb_url'] = serialize($thumb_url);
        }
        if (empty($id)) {
            pdo_insert('amouse_rebate_goods', $data);
            $id = pdo_insertid();
        }else{
            unset($data['createtime']);
            pdo_update('amouse_rebate_goods', $data, array('id' => $id));
        }
        message('更新成功！', $this->createWebUrl('goods', array('op' => 'display','page'=>$pindex)), 'success');
    }
} elseif($op=='delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM ".tablename('amouse_rebate_goods')." WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，记录不存在或是已经被删除！');
    }
    pdo_delete('amouse_rebate_card', array('id' => $id));
    message('删除成功！', referer(), 'success');
} elseif ($op == 'setstatus') {
    $id  = intval($_GPC['id']);
    $data = intval($_GPC['data']);
    $type = $_GPC['type'];
    $data = ($data == 1 ? '0' : '1');
    if ($type == 'status') {
        pdo_update('amouse_rebate_goods', array($type=> $data), array( "id" => $id,"uniacid" => $_W['uniacid']));
        die(json_encode(array(
            'result' => 1,
            'data' => $data
        )));
    }
}
if ($op == 'setdefault') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM ".tablename('amouse_rebate_goods')." WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，商品不存在或是已经被删除！', $this->createWebUrl('goods', array('op' => 'display')), 'error');
    }
    pdo_update('amouse_rebate_goods', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1));
    pdo_update('amouse_rebate_goods', array('isdefault' => 1), array('uniacid' => $_W['uniacid'], 'id' => $row['id']));
    message('商品设置成功！', $this->createWebUrl('goods', array('op' => 'display')), 'success');
}
include $this->template('web/goods');