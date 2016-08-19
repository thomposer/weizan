<?php
/**
 * User: cofan * qq:136670
 * Date: 7/21/15
 * Time: 09:47
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
load()->func('tpl');
if ($op == 'list') {
    $pindex = max(1, intval($_GPC['page']));
    $psize =15;

    $cardid=$_GPC['cardid'];

    $condition = " where log.uniacid={$_W['uniacid']} and log.cardid=" .$cardid;
    $params = array();
    if (!empty($_GPC['keyword'])) {
        $_GPC['keyword'] = trim($_GPC['keyword']);
        $condition .= ' AND ( m.nickname LIKE :keyword or m.wechatno LIKE :keyword   ) ';
        $params[':keyword'] = '%' . trim($_GPC['keyword']) . '%';
    }
    if (!empty($_GPC['keyword1'])) {
        $_GPC['keyword1'] = trim($_GPC['keyword1']);
        $condition .= ' AND ( m1.nickname LIKE :keyword1 or m1.wechatno LIKE :keyword1 ) ';
        $params[':keyword1'] = '%' . trim($_GPC['keyword1']) . '%';
    }
    $sql="SELECT log.*, m.headimgurl,m.nickname,m.wechatno,m1.headimgurl as avatar1,m1.nickname as nickname1,m1.wechatno as realname1 FROM
" . tablename('amouse_rebate_card_log') . " as log left join " . tablename('amouse_rebate_member') . ' as m1 on m1.openid = log.openid ' . " left join
" . tablename('amouse_rebate_member') . ' m on m.openid = log.from_openid ' . " {$condition} ORDER BY log.createtime desc " . "  LIMIT " . ($pindex - 1) *
        $psize . ',' . $psize;

    $list  =pdo_fetchall($sql, $params);


    $total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('amouse_rebate_card_log'). " as log left join " . tablename('amouse_rebate_member').'as m1 on m1.openid = log.openid ' . " left join
" . tablename('amouse_rebate_member') . ' m on m.openid = log.from_openid ' . "  {$condition}  ", $params);
    foreach ($list as &$row) {
        $row['times'] = pdo_fetchcolumn('select count(*) from ' . tablename('amouse_rebate_card_log') . ' where from_openid=:from_openid and cardid=:cardid and uniacid=:uniacid', array(
            ':from_openid' => $row['from_openid'],
            ':cardid' => intval($_GPC['cardid']),
            ':uniacid' => $_W['uniacid']
        ));
    }
    unset($row);
    $pager = pagination($total, $pindex, $psize);

} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    load()->func('tpl');
    if ($id>0) {
        $item = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_log')." WHERE id = :id" , array(':id' => $id));
        if (empty($item)) {
            message('抱歉，号码不存在或是已经删除！', '', 'error');
        }
    }
    if (checksubmit('submit')) {
        $data = array(

            'wechatno'=>$_GPC['wechatno'],
            'pcateid'=>$_GPC['pcateid'],
            'qrcode'=>$_GPC['qrcode'],
            'intro'=> $_GPC['intro'],
        );

        if (empty($id)) {
            pdo_insert('amouse_rebate_log', $data);
        } else {
            pdo_update('amouse_rebate_log', $data, array('id' => $id));
        }
        message('更新成功！', $this->createWebUrl('card', array('op' => 'display')), 'success');
    }
}elseif($op=='delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM ".tablename('amouse_rebate_log')." WHERE id = :id", array(':id' => $id));
    if (empty($row)) {

    }
    pdo_delete('amouse_rebate_log', array('id' => $id));
    message('删除成功！', referer(), 'success');
}
include $this->template('web/log');