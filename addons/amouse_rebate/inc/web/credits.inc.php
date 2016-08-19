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
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
load()->func('tpl');
$weid=$_W['uniacid'];
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];
if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize =20;
    $condition = " where weid= $weid AND openid!='' and headimgurl!=''  ";
    if (!empty($_GPC['keyword'])) {
        $_GPC['keyword'] = trim($_GPC['keyword']);
        $condition .= ' AND ( nickname LIKE :keyword or wechatno LIKE :keyword ) ';
        $params[':keyword'] = '%' . trim($_GPC['keyword']) . '%';
    }
    $list=pdo_fetchall("SELECT * FROM ".tablename('amouse_rebate_member')." {$condition}  ORDER BY createtime DESC,id DESC LIMIT ". ($pindex - 1) * $psize.','.$psize, $params);
    $orders = array();
    load()->model('mc');
    foreach ($list as &$item) {
        $uid = mc_openid2uid($item['openid']);
        if (!empty($uid)) {
            $value = pdo_fetch("SELECT credit1,uid FROM ".tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
        }else{
            $value=pdo_fetch("SELECT credit1,id as uid FROM ".tablename('amouse_rebate_member') . " WHERE  weid=:uniacid and openid=:openid limit 1", array(
                ':uniacid' =>$weid, ':openid' => $item['openid']
            ));
        }
        $item['credit1']=$value['credit1'];
        $item['uid']=$value['uid'];
        $orders[] = $item;
    }
    unset($item);
    $total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('amouse_rebate_member'). $condition , $params);
    $pager = pagination($total, $pindex, $psize);
} elseif($op == 'ajaxUpdateCredits') {
    if (checksubmit('submit')) {
        if (!empty($_GPC['credit1']) && empty($_GPC['credit1'])) {
            message('请输入'.$credittxt);
        }
        $openid =$_GPC['cid'];
        if($openid){
            $credit1= $_GPC['credit1'];
            $this->setCredit($openid, 'credit1', $credit1,1, array(0,$_W['account']['name'].'后台赠送'.$credittxt.'+' . $credit1));

            $info_credit1 = $this->getCredit($openid, 'credit1');
        }
        message('赠送'.$credittxt.'操作成功！', $this->createWebUrl('credits', array('op' => 'display')), 'success');
    }

}elseif($op=='list'){
    $pindex = max(1, intval($_GPC['page']));
    $psize =20;
    $fid= $_GPC['fid'];
    $condition = " where uniacid= $weid AND module='amouse_rebate' ";
    if($fid>0){
        $condition.=" AND uid= $fid ";
    }
    $list=pdo_fetchall("SELECT * FROM ".tablename('mc_credits_record')." {$condition}  ORDER BY createtime desc,id DESC LIMIT ". ($pindex - 1) * $psize.','.$psize);
    $total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('mc_credits_record'). $condition );
    $pager = pagination($total, $pindex, $psize);
}
include $this->template('web/credits');