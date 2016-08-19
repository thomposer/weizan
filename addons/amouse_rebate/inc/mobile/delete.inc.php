<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/20/15
 * Time: 9:59 下午
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$ptype=$_GPC['ptype'];
$id=$_GPC['pk'];
if($ptype=='person'){
    pdo_delete('amouse_rebate_member', array('id' => $id));
    
    $this->returnMessage('删除个人名片成功！',$this->createMobileUrl('board'), 'success');

}
