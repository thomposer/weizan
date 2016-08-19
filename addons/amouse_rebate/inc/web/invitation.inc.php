<?php
/**
  * User: cofan * qq:136670
 * Date: 7/21/15
 * Time: 09:42
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($op == 'display') {
    $condition = "WHERE uniacid = $weid  ";
    $invs = pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_invitation_set')." $condition ORDER BY createtime DESC ");

}elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    pdo_delete('amouse_rebate_invitation_set', array('id' => $id));
    message('分类删除成功！', $this->createWebUrl('sign', array('do' => 'display')), 'success');

}elseif($op==='post'){
    $id = intval($_GPC['id']);
    if($id>0){
        $invitation = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_invitation_set')." where id=$id ");
    }else{
        $invitation['starttime']=TIMESTAMP;
        date("Y-m-d",strtotime("+7 day")) ;
        $invitation['endtime']= strtotime(date("Y-m-d  H:i:s",strtotime("+7 day")));
    }
    if (checksubmit('submit')) {
        $insert = array(
            'award' => $_GPC['award'],
            'uniacid'=>$weid,
            'starttime' => strtotime($_GPC['starttime']),
            'endtime' => strtotime($_GPC['endtime']),
            'rules'=>$_GPC['rules'],
            'status' => $_GPC['status']
        );
        if ($id) {
            pdo_update("amouse_rebate_invitation_set", $insert, array('id' =>$id));
        } else {
            $insert['createtime']=time();
            pdo_insert("amouse_rebate_invitation_set", $insert);
        }

        message('更新成功！', $this->createWebUrl('invitation', array('op' => 'display','page'=>$pindex)), 'success');
    }
}elseif ($op == 'setstatus') {
    $id  = intval($_GPC['id']);
    $data = intval($_GPC['data']);
    $type = $_GPC['type'];
    $data = ($data == 1 ? '0' : '1');
    pdo_update('amouse_rebate_invitation_set', array($type=> $data), array( "id" => $id,"uniacid" => $_W['uniacid']));
    die(json_encode(array(
        'result' => 1,
        'data' => $data
    )));
}

include $this->template('web/Invitation_list');