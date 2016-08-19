<?php


function get_timelineauction($pubtime){
    $time=time();
    /** 如果不是同一年 */
    /** 以下操作同一年的日期 */
    $seconds=$time-$pubtime;
    $days=idate('z', $time)-idate('z', $pubtime);
    /** 如果是同一天 */
    if($days == 0){
        /** 如果是一小时内 */
        if($seconds < 3600){
            /** 如果是一分钟内 */
            if($seconds < 60){
                if(3 > $seconds){
                    return '刚刚';
                } else {
                    return $seconds.'秒前';
                }
            }
            return intval($seconds / 60).'分钟前';
        }
        return idate('H', $time)-idate('H', $pubtime).'小时前';
    }
    /** 如果是昨天 */
    if($days == 1){
        return '昨天 '.date('H:i', $pubtime);
    }
    /** 如果是前天 */
    if($days == 2){
        return '前天 '.date('H:i', $pubtime);
    }

    if($days <= 7 && $days>0){
        return $days.'天前';
    }
    return date('Y-m-d', $pubtime);
}

function amouse_rebate_svip(){
    global  $_W;
    $weid = $_W['uniacid'];
    $sys= pdo_fetch("SELECT topnumber,isrand FROM ".tablename('amouse_rebate_sysset')." WHERE weid=:weid limit 1", array(':weid'=>$weid));
    if (empty($sys['topnumber'])) {
        $sys['topnumber'] = 3;
    }
    $condition = " WHERE weid =$weid AND vipstatus=2 ";
    
    $randcon = " ORDER BY rand() " ;
    $list = pdo_fetchall("SELECT id,qrcode,headimgurl,hot,nickname,location_p,location_c,vipstatus,weid,intro,updatetime,createtime,uptime,shuaxin,endtime FROM
" . tablename('amouse_rebate_member')." $condition $randcon limit 0,{$sys['topnumber']} ");
    $svips = array();
    foreach($list as $cid=>$card) {
        if (strexists($card['qrcode'], 'http://')||strexists($card['qrcode'], 'https://')) {
            $logo =$card['qrcode'];
        } else {
            $logo =tomedia($card['qrcode']);
        }
        if (strexists($card['headimgurl'], 'http://')||strexists($card['headimgurl'], 'https://')) {
            $headimgurl =$card['headimgurl'];
        } else {
            $headimgurl =tomedia($card['headimgurl']);
        }
        $card['hot']= empty($card['hot']) ? 0: $card['hot'];
        $card['uname']=$card['nickname'];
        $card['pic_path']=$logo;
        $card['head_img']=$headimgurl;
        if($card['location_p']=='北京市'||$card['location_p']=='天津市'||$card['location_p']=='上海市'||$card['location_p']=='重庆市'){
            $p=$card['location_p'] ;
        }else{
            $p=$card['location_c'] ;
        }
        $card['location_c']=$p; 
        if(strlen($card['intro']) > 20){
            $intro=cutstr($card['intro'],20, true);
        }else{
            $intro=$card['intro'];
        }
        $card['intro']=$intro;
        $card['createtime']=get_timelineauction($card['updatetime']);
        $card['endtime']=$card['endtime']-time();
        $svips[] = $card;
    }
    unset($card);
    return $svips;
}

//显示刷新列表
function amouse_rebate_refresh(){
    global  $_W;
    $weid = $_W['uniacid'];
    ignore_user_abort();
    set_time_limit(0);
    $file     = IA_ROOT . "/addons/amouse_rebate/data/refresh";
    $lasttime = strtotime(@file_get_contents($file));
    $interval = intval(@file_get_contents(IA_ROOT . "/addons/amouse_rebate/data/refresh_time"));
    if (empty($interval)) {
        $interval = 10;
    }
    $interval *= 5;
    $current = time();
    $refreshs = array();
    $condition = " WHERE weid=$weid  AND vipstatus!=2 ";
    if ($lasttime + $interval <= $current) {
        file_put_contents($file, date('Y-m-d H:i:s', $current));
     $list = pdo_fetchall("SELECT id,qrcode,headimgurl,hot,nickname,location_p,location_c,vipstatus,weid,intro,updatetime,createtime,endtime,uptime,shuaxin FROM
".tablename('amouse_rebate_member').$condition." ORDER BY id desc,uptime DESC,shuaxin DESC, rand() limit 0 , 2 ");

        foreach($list as $cid=>$card) {
            if (strexists($card['qrcode'], 'http://')||strexists($card['qrcode'], 'https://')) {
                $logo =$card['qrcode'];
            } else {
                $logo =tomedia($card['qrcode']);
            }
            if (strexists($card['headimgurl'], 'http://')||strexists($card['headimgurl'], 'https://')) {
                $headimgurl =$card['headimgurl'];
            } else {
                $headimgurl =tomedia($card['headimgurl']);
            }

            $card['hot']= empty($card['hot']) ? 0: $card['hot'];
            $card['uname']=$card['nickname'];
            $card['pic_path']=$logo; 
            if($card['location_p']=='北京市'||$card['location_p']=='天津市'||$card['location_p']=='上海市'||$card['location_p']=='重庆市'){
                $p=$card['location_p'] ;
            }else{
                $p=$card['location_c'] ;
            }
            $card['location_c']=$p;
            $card['head_img']=$headimgurl;
            if(strlen($card['intro']) > 20){
                $intro=cutstr($card['intro'],20, true);
            }else{
                $intro=$card['intro'];
            }
            $card['intro']=$intro;
            $card['createtime']=get_timelineauction($card['updatetime']);
            $refreshs[] = $card;
        }
        unset($card);
    }

    return $refreshs;
}

