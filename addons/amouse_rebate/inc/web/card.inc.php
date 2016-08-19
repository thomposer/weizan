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
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
load()->func('tpl');
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";

if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize =15;
    $status = $_GPC['status'];
    $params = array();
    $condition = " where weid= $weid  AND openid!='' and wechatno!='' ";
    if (!empty($_GPC['keyword'])) {
        $_GPC['keyword'] = trim($_GPC['keyword']);
        $condition .= ' AND ( nickname LIKE :keyword or wechatno LIKE :keyword ) ';
        $params[':keyword'] = '%' . trim($_GPC['keyword']) . '%';
    }
    $list = pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_member')." {$condition} ORDER BY vipstatus DESC,uptime DESC, id DESC , shuaxin DESC LIMIT ".($pindex - 1) * $psize.',
'.$psize, $params);
    $total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('amouse_rebate_member'). $condition , $params);

    $pager = pagination($total, $pindex, $psize);

} elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    load()->func('tpl');
    if ($id>0) {
        $item = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE id = :id" , array(':id' => $id));

         if($item['createtime']<=0){
            $item['createtime']=TIMESTAMP;
        }
    }else{
        $item['createtime']=TIMESTAMP;
    }
    $pindex = max(1, intval($_GPC['page']));
    if (checksubmit('submit')) {
        $data = array(
            'weid'=>$weid,
            'wechatno'=>$_GPC['wechatno'],
            'nickname'=>$_GPC['nickname'],
            'qrcode'=>tomedia($_GPC['qrcode']),
            'headimgurl'=>tomedia($_GPC['headimgurl']),
            'location_p' => $_GPC['location_p'],
            'location_c' => $_GPC['location_c'],
            'intro'=> $_GPC['intro'],'status'=>0,
            'createtime'=> strtotime($_GPC['createtime']),
            'updatetime'=>TIMESTAMP,
            'hot'=>$_GPC['hot'],'friend'=>$_GPC['friend'],
            'vipstatus'=> $_GPC['vipstatus'],
        );
        if (empty($id)) {
            $C = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE `weid`=:weid and wechatno=:wechatno ", array(':weid'=>$weid, ':wechatno'=>$_GPC['wechatno']));
            if($C){
                message('微信号已经存在,请填写正确的微信号！', $this->createWebUrl('card', array('op' => 'display')), 'error');
            }
            $data['openid']=$this->generate_password(25);
            $mdata['openid'] = $data['openid'];
            $mdata['from_user']=$data['openid'];

            pdo_insert('amouse_rebate_member', $data);
        } else {
            $UPDATEC = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE `weid`=:weid and wechatno=:wechatno and id!=$id ", array(':weid'=>$weid, ':wechatno'=>$_GPC['wechatno']));
            if($UPDATEC){
                $res['code']=0;
                $res['msg']="微信号已经存在，请填写正确的微信号";
                message('微信号已经存在,请填写正确的微信号！', $this->createWebUrl('card', array('op' => 'display')), 'error');
            }

            $U= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE `weid`=:weid and id=$id ", array(':weid'=>$weid));
            $data2 = array(
                'wechatno'=>$_GPC['wechatno'],
                'nickname'=>$_GPC['nickname'],
                'qrcode'=>$_GPC['qrcode'],
                'hot'=>$_GPC['hot'],
                'headimgurl'=>$_GPC['headimgurl'],
                'location_p' => $_GPC['location_p'],
                'location_c' => $_GPC['location_c'],
                'vipstatus'=> $_GPC['vipstatus'],
                'createtime'=> strtotime($_GPC['createtime']),
                'friend'=>$_GPC['friend'],
                'intro'=> $_GPC['intro']
            );
            pdo_update('amouse_rebate_member', $data2, array('id' => $id));
        }
        message('更新成功！', $this->createWebUrl('card', array('op' => 'display','page'=>$pindex)), 'success');
    }
}elseif($op=='delete') {
    if(isset($_GPC['delete'])) {
        $ids= implode(",", $_GPC['delete']);
        $sqls= "delete from  ".tablename('amouse_rebate_member')."  where id in(".$ids.")";
        pdo_query($sqls);
        message('删除成功！', referer(), 'success');
    }

    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM ".tablename('amouse_rebate_member')." WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，名片记录不存在或是已经被删除！');
    }
    pdo_delete('amouse_rebate_member', array('id' => $id));
    message('删除成功！', referer(), 'success');
}elseif($op=='send'){
    $settings=$this->getRedpacksSysset($weid);
    $id= intval($_GPC['id']);

    $member = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_member')." WHERE id = :id", array(':id' => $id));

    $ret=send_cash_bonus($settings, $member['openid'], 1, "程序测试,恭喜你获得红包");
    if($ret['code']==0){
        message($ret['msg'], referer(), 'success');
    }else{
        message($ret['msg'], referer(), 'error');
    }
}elseif ($op == 'setstatus') {
    $id  = intval($_GPC['id']);
    $data = intval($_GPC['data']);
    $type = $_GPC['type'];
    $data = ($data == 1 ? '0' : '1');
    if ($type == 'user_status') {
        pdo_update('amouse_rebate_member', array($type=> $data), array( "id" => $id,"weid" => $_W['uniacid']));
        die(json_encode(array(
            'result' => 1,
            'data' => $data
        )));
    }else {
        pdo_update('amouse_rebate_member', array($type=> $data), array( "id" => $id,"weid" => $_W['uniacid']));
        die(json_encode(array(
            'result' => 1,
            'data' => $data
        )));
    }
}elseif($op=='deletefriend'){//
    $openid=$_GPC['openid'];
    pdo_delete('amouse_rebate_log', array('openid'=>$openid));
    pdo_delete('amouse_rebate_card_log', array('openid'=> $openid));
    message('一级好友删除成功!', referer(), 'success');
}elseif($op=='clear'){//清空推广二维码
    load()->func('file');
    pdo_delete('amouse_rebate_promote_qr', array('uniacid' =>  $_W['uniacid']));
    message('推广二维码缓存清除成功!', referer(), 'success');
}
include $this->template('web/card');