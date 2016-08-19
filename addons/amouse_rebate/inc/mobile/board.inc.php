<?php

require_once IA_ROOT . "/addons/amouse_rebate/author.php";
$url=trim($_SERVER['SERVER_NAME']);
fuckAway($this->modulename,$url);

global $_W, $_GPC;
require_once IA_ROOT . "/addons/amouse_rebate/inc/common.php";
$weid=$_W['uniacid'];

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

$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;
$custom_set= pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_custom_sysset')." WHERE uniacid=:weid limit 1", array(':weid'=>$weid));
$credittxt = empty($custom_set['credittxt']) ? "积分" : $custom_set['credittxt'];

$info['credit1'] = $this->getCredit($openid, 'credit1');
$top_credit=intval($info['credit1']- $set['top_credit']);
$top_credit2=intval($set['top_credit']-$info['credit1']);

$pindex = max(1, intval($_GPC['pageIndex']));
$psize = 10;
$start =($pindex - 1) * $psize;
$p=$_GPC['p'];
$list="";
$setting= pdo_fetch("SELECT ischeck FROM ".tablename('amouse_rebate_sysset')." WHERE weid=:weid limit 1", array(':weid'=>$weid));
$contain =" WHERE weid =$weid and wechatno!='' ";//这边查
if($setting && $setting['ischeck']==0){//不开启审核
    $contain.=" AND status=0 ";
}
if((empty($p) || $p=='全国')) {
    $sql = "SELECT id,qrcode,headimgurl,hot,nickname,location_p,location_c,vipstatus,weid,intro,updatetime,createtime,uptime,openid FROM ".tablename('amouse_rebate_member')." $contain ORDER BY uptime DESC,vipstatus DESC limit $start,$psize";
    $list = pdo_fetchall($sql);
    $total = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('amouse_rebate_member') . " $contain ");
}elseif($p=='全国'){
    $sql = "SELECT id,qrcode,headimgurl,hot,nickname,location_p,location_c,vipstatus,weid,intro,updatetime,createtime,uptime,openid FROM ".tablename('amouse_rebate_member')." $contain ORDER BY uptime DESC,vipstatus DESC limit $start,$psize";
    $list = pdo_fetchall($sql);
    $total = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('amouse_rebate_member') . " $contain  ");
}elseif($p!='全国'){
    $sql="SELECT id,qrcode,headimgurl,hot,nickname,location_p,location_c,vipstatus,weid,intro,updatetime,createtime,uptime,openid FROM ".tablename('amouse_rebate_member')." $contain AND location_p LIKE '{$p}%'  ORDER BY  uptime DESC,vipstatus DESC limit $start,$psize";
    $list = pdo_fetchall($sql);
    $total = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('amouse_rebate_member') . " $contain AND location_p LIKE '{$p}%'  ");
}
$tpage= ceil($total / $psize);
$ms = array();
if(count($list)>0){
    foreach($list as $cid=>$_qr) {
        if(strexists($_qr['qrcode'], 'http://')||strexists($_qr['qrcode'], 'https://')) {
            $logo =$_qr['qrcode'];
        }else{
            $logo =tomedia($_qr['qrcode']);
        }
        if(strexists($_qr['headimgurl'], 'http://')||strexists($_qr['headimgurl'], 'https://')) {
            $avatar =$_qr['headimgurl'];
        }else{
            $avatar=tomedia($_qr['headimgurl']);
        }
        $_qr['hot']= empty($_qr['hot']) ? 0: $_qr['hot'];
        $_qr['nickname']=$_qr['nickname'];
        $_qr['vipstatus']=$_qr['vipstatus'];
        $_qr['qrcode']=$logo;
        if(strlen($_qr['intro']) > 20){
            $intro=cutstr($_qr['intro'],20, true);
        }else{
            $intro=$_qr['intro'];
        }
        $_qr['intro']=$intro;
        $_qr['headimgurl']=$avatar;
        if($_qr['location_p']=='北京市'||$_qr['location_p']=='天津市'||$_qr['location_p']=='上海市'||$_qr['location_p']=='重庆市'){
            $p=$_qr['location_p'] ;
        }else{
            $p=$_qr['location_c'] ;
        }
        $_qr['location_c']=$p;
        $ms[] = $_qr;
    }
    unset($_qr);
    $status=1;
}else{
    $status=0;
}

if(isset($_GPC['isajax']) && $_GPC['isajax']==1){
    $arr = array(
        'status' => $status,
        'total'=>$total,
        'gtotal'=>$tpage+1,
        'html' =>$ms
    );
    echo json_encode($arr);
}else{

    $needfriend =$set['needfriend']-$fans['friend'];//还需要加多少好友
    $op=!empty($_GPC['op']) ? $_GPC['op'] : "b";
    $p=$_GPC['p'];


    $fanstxt= empty($custom_set['fanstxt']) ? "加好友" : $custom_set['fanstxt'];
    $shareimg =empty($set['share_icon']) ? toimage($fans['headimgurl']) : toimage($set['share_icon']);
    $sharetitle= str_replace('[nickname]', $fans['nickname'], $set['share_title']);
    $sharedesc = empty($set['share_desc']) ? $_W['account']['name'].'是一个新出的快速爆粉平台，微商必备神器。' : str_replace("\r\n", " ", $set['share_desc']);
    $sharedesc= str_replace('[nickname]', $fans['nickname'], $sharedesc);
    $shareurl= $_W['siteroot']."app/".substr($this->createMobileUrl('board',array(),true), 2);
    $vip = $fans['vipstatus']<=0 ? 0 : $fans['vipstatus'];
    $fansid = $fans['id'] ? $fans['id'] : 0;
    $uptime = $fans['uptime'] ? $fans['uptime'] : 0;
    $mytime = time() - $uptime;
    $xianzhitime = 60*intval($set['timer']);

    include $this->template('rmb/person_list');
}


