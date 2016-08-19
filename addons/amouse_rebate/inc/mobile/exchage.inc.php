<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 11/10/15
 * Time: 12:42 下午
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
$set= $this->getSysset($weid);
if(empty($_W['openid'])){
    load()->model('mc');
    $userinfo = mc_oauth_userinfo();
    $openid = $userinfo['openid'];
}else{
    $openid=$_W['openid'];
}
$fans=$this->checkMember($openid);
if($fans && $fans['user_status']==0){
    $this->returnMessage('抱歉，您没有该操作的访问权限');
}
 
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
$total_credit =intval($this->getCredit($openid, 'credit1'));
if($op=='list'||$op=='step1'){
    $glist=pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_creditshop_goods')." WHERE uniacid =$weid AND status=0 AND type!=2 AND type!=3 ORDER BY displayorder DESC,id DESC");
    if($set && $set['sms_resgister']==1){//开启注册
        if(empty($fans['mobile'])){
            include $this->template('bind_mobile');
            exit;
        }
    }
    include $this->template('exchage_list');
}elseif($op=='detail'){
    $gid = $_GPC['gid'];
    $goods = pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_creditshop_goods')." WHERE uniacid =$weid  AND id=$gid ");
 $creditlog= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_creditshop_log')." WHERE openid = :openid ",array(':openid' => $openid));
    $contain = " WHERE weid =$weid AND openid='{$openid}'";
    if($set && $set['ischeck']==0){//不开启审核
        $contain.=" AND status=0 ";
    }
    if($goods['type']==3){//群
        $groups = pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_group_mp')." {$contain} AND type=1 ORDER BY updatetime desc ");
        include $this->template('exchage_group_detail');
    }elseif($goods['type']==2){//公众号
        $mps = pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_group_mp')." {$contain} AND type=2 ORDER BY updatetime desc ");
        include $this->template('exchage_mp_detail');
    }else{
        include $this->template('exchage_detail');
    }
}



