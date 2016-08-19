<?php
global $_W, $_GPC;
$uniacid  = $_W['uniacid'];
$qid      = $_GPC['q_id'];
$settings = $this->module['config'];
if (empty($qid)) {
    include $this->template('enter');
}
$cgc_addr_forward      = new cgc_addr_forward();
$item                  = $cgc_addr_forward->getOne($qid);
$item['fans_regional'] = unserialize($item['fans_regional']);
include $this->template('enter');