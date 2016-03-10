<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
        $id = intval($_GPC['schoolid']);

        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $id));
        $title = $item['title'];

		$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$_W['uniacid']}' AND schoolid ={$id} And type = 'subject' ORDER BY ssort DESC", array(':weid' => $_W['uniacid'], ':type' => 'subject', ':schoolid' => $id));
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
        if (empty($item)) {
            message('没有找到该学校，请联系管理员！');
        }
		
		$banners = pdo_fetchall("SELECT bannername,link,thumb FROM " . tablename($this->table_banners) . " WHERE enabled=1 AND weid = '{$_W['uniacid']}' AND schoolid = '{$id}' ORDER BY displayorder ASC");

        include $this->template('detail');
?>