<?php
/**
 * User: cofan

 * * QQ : 136670
 * Date: 7/21/15
 * Time: 09:47
 */
require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);

global $_W, $_GPC;
$weid=$_W['uniacid'];
require_once IA_ROOT . "/addons/amouse_rebate/inc/commonutil.php";
$op = empty($_GPC['op']) ? 'other' : trim($_GPC['op']);
load()->func('tpl');
load()->func('file');

$posterid = $_GPC['posterid'];
$redid= $_GPC['redid'];
$bgid= $_GPC['bgid'];
$csetid= $_GPC['csetid'];
$csetid2= $_GPC['csetid2'];
$levid= $_GPC['levid'];
$poster = $this->getPosterSysset($weid);
$set= $this->getSysset($weid);
$settings = $this->getRedpacksSysset($weid);
$level= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_commission_sysset')." where uniacid=$weid limit 1 ");
if(!empty($poster)) {
    $data = json_decode(str_replace('&quot;', "'", $poster['data']), true);
}
if(empty($settings['ip'])) {
    $settings['ip'] = $_SERVER['SERVER_ADDR'];
}

$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));

if($op == 'redpacks') {
    $apisec = iunserializer($settings['apisec']);
}
if(empty($level)) {
    $level['is_level']=0 ;
    $level['level_type']=1;
}
$acid = pdo_fetchcolumn("SELECT acid FROM ".tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(':uniacid' => $weid));
if(checksubmit('submit')){
    $insert=array('weid'=>$weid,'acid'=>$acid);
    if ($op == 'tpl') {
        $insert['tpl'] =$_GPC['tpl'];
        $insert['paytpl']=trim($_GPC['paytpl']);
        $insert['send']=trim($_GPC['send']) ;
        $insert['mtpl']=trim($_GPC['mtpl']);
        $insert['mduetpl']=trim($_GPC['mduetpl']) ;
        $insert['templateid']=trim($_GPC['templateid']) ;

    }else if ($op == 'other') {
        $insert['thumb']=$_GPC['thumb'];
        $insert['needfriend']=intval($_GPC['needfriend']);
        $insert['followurl']=$_GPC['followurl'];
        $insert['banner']=$_GPC['banner'];
        $insert['bannerLink']=$_GPC['bannerLink'];
        $insert['copyright']=$_GPC['copyright'];
        $insert['protocol']=$_GPC['protocol'];
        $insert['useurl']=$_GPC['useurl'];
        $insert['isopen']=$_GPC['isopen'];
        $insert['ischeck']=$_GPC['ischeck'];
       // $insert['ischeck2']=intval($_GPC['ischeck2']);

        $insert['thumb']=$_GPC['thumb'];
        $insert['creditlink'] =$_GPC['creditlink'];
        $insert['admin_tpl'] =$_GPC['admin_tpl'];
        $insert['cnzz']=htmlspecialchars_decode( $_GPC['cnzz']);

    }else if($op=='credit') {
        $insert['new_credit']=$_GPC['new_credit'];
        $insert['success_credit']=$_GPC['success_credit'];
        $insert['top_credit']=$_GPC['top_credit'];
        $insert['sign_credit']=$_GPC['sign_credit'];
        $insert['rec_credit']=$_GPC['rec_credit'];
        $insert['zero']=intval($_GPC['zero']);
        $insert['add_credit']=intval($_GPC['add_credit']);
        $insert['timer'] = intval($_GPC['timer']);
        $insert['topnumber']= intval($_GPC['topnumber']);
        $insert['new_text'] = htmlspecialchars_decode( $_GPC['new_text']) ;
        $insert['add_friend_text'] =htmlspecialchars_decode($_GPC['add_friend_text']);
        $insert['subtext'] =htmlspecialchars_decode($_GPC['subtext']);
        $insert['entrytext'] =htmlspecialchars_decode($_GPC['entrytext']);
        $insert['subtext2'] =htmlspecialchars_decode($_GPC['subtext2']);
        $insert['entrytext2'] =htmlspecialchars_decode($_GPC['entrytext2']);
        $insert['top_text'] = $_GPC['top_text'] ;
        $insert['nickname'] = htmlspecialchars_decode($_GPC['nickname']) ;//再次扫描/关注
        $insert['normal_att_credit'] =$_GPC['normal_att_credit'];
        $insert['normal_attention'] =htmlspecialchars_decode($_GPC['normal_attention']) ;
        $insert['follow_text']=htmlspecialchars_decode($_GPC['follow_text']) ;//首次关注文案
        $insert['isrand']=  trim($_GPC['isrand']);
        $insert['att_credit']=  trim($_GPC['att_credit']);
    }else if($op=='share') {//分享
        $insert['share_title']=$_GPC['share_title'];
        $insert['share_icon']=tomedia($_GPC['share_icon']);
        $insert['share_desc']=$_GPC['share_desc'];
    }elseif($op=='redpacks'){//红包设置
        $input = array();
        if ($_FILES['weixin_cert_file']['name']) {
            $apisec['cert'] = upload_cert('weixin_cert_file');
        }
        if ($_FILES['weixin_key_file']['name']) {
            $apisec['key'] = upload_cert('weixin_key_file');
        }
        if ($_FILES['weixin_root_file']['name']) {
            $apisec['root'] = upload_cert('weixin_root_file');
        }
        $input['uniacid']  = $_W['uniacid'];
        $input['apisec'] =  iserializer($apisec);
        $input['appid'] = trim($_GPC['appid']);
        $input['secret'] = trim($_GPC['secret']);
        $input['mchid'] = trim($_GPC['mchid']);
        $input['password'] = trim($_GPC['password']);
        $input['ip'] = trim($_GPC['ip']);
        $input['sendtype'] = trim($_GPC['sendtype']);
        $input['act_name'] = trim($_GPC['act_name']);
        $input['send_name'] = trim($_GPC['send_name']);
        $input['remark'] = trim($_GPC['remark']);
        $input['tx_money'] = trim($_GPC['tx_money']);
        $input['tx_type'] = trim($_GPC['tx_type']);
        $input['debug'] = trim($_GPC['debug']);
        $input['iscash'] = trim($_GPC['iscash']);
        $input['tx_count']=trim($_GPC['tx_count']);
        $input['person_max_money'] = trim($_GPC['person_max_money']);
        $input['min_money'] = trim($_GPC['min_money']);
        $input['max_money'] = trim($_GPC['max_money']);
        $input['total_money'] = trim($_GPC['total_money']);
        $input['tplid'] = trim($_GPC['tplid']);
        $input['show_money'] = trim($_GPC['show_money']);
        $input['is_open_money']=$_GPC['is_open_money'];
        if (!empty($redid)) {
            pdo_update('amouse_rebate_redpacks_sysset', $input, array('id'=>$redid,'uniacid'=>$weid));
        } else {
            pdo_insert('amouse_rebate_redpacks_sysset', $input);
        }
    }elseif($op=='sms') {//防刷设置
        $insert['sms_resgister'] = $_GPC['sms_resgister'];
        $insert['sms_user'] = $_GPC['sms_user'];
        $insert['sms_secret'] = $_GPC['sms_secret'];
        $insert['sms_type'] = $_GPC['sms_type'];
        $insert['sms_template_code'] = $_GPC['sms_template_code'];
        $insert['sms_free_sign_name'] = $_GPC['sms_free_sign_name'];
    }elseif($op=='level'){
        $level2['uniacid']=$weid;
        $level2['is_level']=$_GPC['is_level'];
        $level2['level_type']=$_GPC['level_type'];
        $level2['level_type2']=$_GPC['level_type2'];
        $level2['member_type']=$_GPC['member_type'];
        $level2['first_level_credit']=$_GPC['first_level_credit'];
        $level2['first_level_text']=$_GPC['first_level_text'];
        $level2['second_level_credit']=$_GPC['second_level_credit'];
        $level2['second_level_text']=$_GPC['second_level_text'];
        $level2['three_level_credit']=$_GPC['three_level_credit'];
        $level2['three_level_text']=$_GPC['three_level_text'];
        $level2['become_child']=$_GPC['become_child'];
        $level2['vip1_level_credit']=$_GPC['vip1_level_credit'];
        $level2['vip2_level_credit']=$_GPC['vip2_level_credit'];
        $level2['vip3_level_credit']=$_GPC['vip3_level_credit'];
        $level2['vip1_level_text']=$_GPC['vip1_level_text'];
        $level2['vip2_level_text']=$_GPC['vip2_level_text'];
        $level2['vip3_level_text']=$_GPC['vip3_level_text'];
        $level2['withdraw1']=$_GPC['withdraw1'];
        $level2['withdraw2']=$_GPC['withdraw2'];
        $level2['settledays1']=$_GPC['settledays1'];
        $level2['settledays2']=$_GPC['settledays2'];
        if(empty($levid)){
            pdo_insert('amouse_rebate_commission_sysset', $level2);
        } else {
            pdo_update('amouse_rebate_commission_sysset', $level2, array('id'=>$levid,'uniacid'=>$weid));

        }
        message('更新分销设置成功！', 'refresh');
    }elseif($op=='custom'){
        $insert2=array('uniacid'=>$weid);
        $insert2['toptxt1']=$_GPC['toptxt1'];
        $insert2['toptxt2']= $_GPC['toptxt2'] ;
        $insert2['toplink1']=$_GPC['toplink1'];
        $insert2['toplink2']=$_GPC['toplink2'];
        $insert2['fanstxt']=$_GPC['fanstxt'];
        $insert2['credittxt']=$_GPC['credittxt'];
        $insert2['is_open_notice']=$_GPC['is_open_notice'];
        $insert2['noticetxt']=$_GPC['noticetxt'];
        $insert2['bgcolor']= trim($_GPC['bgcolor']);
        $insert2['footcolor']= trim($_GPC['footcolor']);
        $insert2['bgimg']= trim($_GPC['bgimg']);
        $insert2['is_left_open']= trim($_GPC['is_left_open']);
        $insert2['left_thumb']= trim($_GPC['left_thumb']);
        $insert2['leftlink']= trim($_GPC['leftlink']);
        $insert2['is_right_open']= trim($_GPC['is_right_open']);
        $insert2['right_thumb']= trim($_GPC['right_thumb']);
        $insert2['rightlink']= trim($_GPC['rightlink']);
        if(empty($csetid2)){
            pdo_insert('amouse_rebate_custom_sysset', $insert2);
        } else {
            pdo_update('amouse_rebate_custom_sysset', $insert2, array('id'=>$csetid2,'uniacid'=>$weid));
        }
        message('更新自定义文字设置成功！', 'refresh');

    }elseif($op=='pro') {
        load()->model('account');
        $acid = pdo_fetchcolumn('select acid from '.tablename('account_wechats').' where uniacid=:uniacid limit 1', array(
            ':uniacid' => $_W['uniacid']
        ));
        $data2 = array(
            'uniacid' => $_W['uniacid'],
            'keyword' => trim($_GPC['keyword']),
            'bg' => tomedia($_GPC['bg']),
            'data' => htmlspecialchars_decode($_GPC['data']),
            'createtime' => time(),
            'oktext' => trim($_GPC['oktext']),
            'waittext' => trim($_GPC['waittext']),
            'entrytext' => trim($_GPC['entrytext'])
        );
        if (!empty($posterid)) {
            pdo_update('amouse_rebate_poster_sysset', $data2, array('id' => $posterid, 'uniacid' => $_W['uniacid']));
        } else {
            pdo_insert('amouse_rebate_poster_sysset', $data2);
            $id = pdo_insertid();
        }
        $rule = pdo_fetch("select * from " . tablename('rule').' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(
            ':uniacid' => $_W['uniacid'],':module' => 'amouse_rebate', ':name' => "amouse_rebate:promote"
        ));
        if (empty($rule)) {
            $rule_data = array(
                'uniacid' => $_W['uniacid'],
                'name' => 'amouse_rebate:promote',
                'module' => 'amouse_rebate', 'displayorder' => 0, 'status' => 1
            );
            pdo_insert('rule', $rule_data);
            $rid          = pdo_insertid();
            $keyword_data = array(
                'uniacid' => $_W['uniacid'],
                'rid' => $rid,
                'module' => 'amouse_rebate',
                'content' =>empty($data2['keyword']) ? "AMOUSE_REBATE_PROMOTE" : trim($data2['keyword']),
                'type' =>3,
                'displayorder' => 0,
                'status' => 1
            );
            pdo_insert('rule_keyword', $keyword_data);
        } else {
            $content =empty($data2['keyword']) ? "AMOUSE_REBATE_PROMOTE" : trim($data2['keyword']);
            pdo_update('rule_keyword', array('content' => $content), array('rid' => $rule['id'] ));
        }
        $ruleauto = pdo_fetch("select * from " . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(
            ':uniacid' => $_W['uniacid'],
            ':module' => 'amouse_rebate',
            ':name' => "amouse_rebate:promote:auto"
        ));
        if (empty($ruleauto)) {
            $rule_data = array(
                'uniacid' => $_W['uniacid'],
                'name' => 'amouse_rebate:promote:auto',
                'module' => 'amouse_rebate',
                'displayorder' => 0,
                'status' => 1
            );
            pdo_insert('rule', $rule_data);
            $rid          = pdo_insertid();
            $keyword_data = array(
                'uniacid' => $_W['uniacid'],
                'rid' => $rid,
                'module' => 'amouse_rebate',
                'content' => 'AMOUSE_REBATE_PROMOTE',
                'type' => 1,
                'displayorder' => 0,
                'status' => 1
            );
            pdo_insert('rule_keyword', $keyword_data);
        }
        message('更新推广图片成功！', $this->createWebUrl('sysset', array('op' => 'pro')), 'success');
    }

    if(!empty($set)){
        pdo_update('amouse_rebate_sysset', $insert, array('weid'=>$weid));
    } else {
        pdo_insert('amouse_rebate_sysset', $insert);
    }
    message('更新参数设置成功！', 'refresh');
}
include $this->template('web/sysset_'.$op);