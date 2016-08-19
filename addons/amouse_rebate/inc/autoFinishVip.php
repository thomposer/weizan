<?php
/**
 * User: cofan
 * qq:136670
 */
function autoFinshVip(){
    error_reporting(0);
    ignore_user_abort();
    set_time_limit(0);
    global $_W;
    $sets = pdo_fetchall("SELECT weid,acid,mduetpl FROM " . tablename('amouse_rebate_sysset'));
    load()->classs('weixin.account');
    foreach ($sets as $set) {
        $sweid = $set['weid'];
        $sacid = $set['acid'];
        if (empty($sweid) || empty($sacid)) {
            continue;
        }
        $accObj = WeixinAccount::create($sacid);
        $file2 = IA_ROOT . "/addons/amouse_rebate/data/pindex";
        $pindex = intval(@file_get_contents($file2));
        if (empty($pindex)) {
            $pindex = 1;
        }
        $psize = 5;
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ". tablename('amouse_rebate_member') . " WHERE isauto=1 ");
        $total_page = ceil($total / $psize);
        $autos = pdo_fetchall("SELECT id,uptime,shuaxin FROM " . tablename('amouse_rebate_member')." where isauto=1 and uptime<=unix_timestamp() order by uptime ASC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
        if (!empty($autos)) {
            foreach ($autos as $k => $auto) {
                pdo_update('amouse_rebate_member', array('uptime'=>time(),'updatetime'=>time(),'shuaxin'=>$k+1), array('id'=>$auto['id']));
            }
        }
        $pindex=$pindex+1;
        file_put_contents($file2, $pindex);
        if($pindex > $total_page) {
            file_put_contents($file2, 0);
        }
        $tempVip = pdo_fetchall("SELECT id,listorder,times,uptime FROM " . tablename('amouse_rebate_member') . " where  listorder=1 and times>0 and times<=unix_timestamp() ");
        if (!empty($tempVip)) {
            foreach ($tempVip as $k => $temp) {
                pdo_update('amouse_rebate_member', array('listorder' => 0, 'uptime' => $temp['times'] - 360, 'times' => 0), array('id' => $temp['id']));
            }
        }

        $cards = pdo_fetchall("SELECT id,openid,createtime,autotime,nickname FROM ".tablename('amouse_rebate_member')." where vipstatus=2 and  createtime>0 and createtime<=unix_timestamp() ");
        if (!empty($cards)) {
            foreach ($cards as $card) { 
                $u = array('createtime' => 0);
                $u['sviptime'] = 0;
                $u['endtime'] = 0;
                pdo_update('amouse_rebate_member', $u, array('id' => $card['id']));
            }
        }

    }
}