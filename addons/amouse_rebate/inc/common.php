<?php



function getRealData($data){
    $data['left']   = intval(str_replace('px', '', $data['left'])) * 2;
    $data['top']    = intval(str_replace('px', '', $data['top'])) * 2;
    $data['width']  = intval(str_replace('px', '', $data['width'])) * 2;
    $data['height'] = intval(str_replace('px', '', $data['height'])) * 2;
    $data['size']   = intval(str_replace('px', '', $data['size'])) * 2;
    $data['src']    = tomedia($data['src']);
    return $data;
}
function remote_file($src_file,$target_file){
    global $_W;
    if (!empty($_W['setting']['remote']['type'])) {
        if (!@copyfiles(tomedia($src_file), $target_file)) {
            message("远程文件失败");
        }
        return tomedia($target_file);
    } else {
        return tomedia($src_file);
    }
}

function createImage($imgurl){
    load()->func('communication');
    $resp = ihttp_request($imgurl);
    return imagecreatefromstring($resp['content']);
}

function createImageUrl($param, $qr_file){
    global $_W;
    load()->func('file');
    $path = "../attachment/images/" . $param['uniacid'].'/'.date("Y/m/d");
    if (!is_dir($path)) {
        load()->func('file');
        mkdirs($path);
    }
    $target_file=$path.'/commision_qr-image-'.$param['openid'].rand().'.jpg';
    if (empty($param['bg'])) {
        $bg_file=IA_ROOT.'/addons/amouse_rebate/style/images/qr_promote.jpg';
    } else{
        $bg_file=$param['bg'];
    }
    set_time_limit(0);
    @ini_set('memory_limit', '256M');
    $target = imagecreatetruecolor(640, 1008);
    $bg     = createImage(tomedia($bg_file));
    imagecopy($target, $bg, 0, 0, 0, 0, 640, 1008);
    imagedestroy($bg);
    $data = json_decode(str_replace('&quot;', "'", $param['data']), true);
    foreach ($data as $d) {
        $d = getRealData($d);
        if ($d['type'] == 'head') {
            $avatar = preg_replace('/\/0$/i', '/96', $param['avatar']);
            $target = newMergeImage($target, $d, $avatar);
        } else if ($d['type'] == 'img') {
            $target =newMergeImage($target, $d, $d['src']);
        } else if ($d['type'] == 'qr') {
            $target = newMergeImage($target, $d, tomedia($qr_file));
        } else if ($d['type'] == 'nickname') {
            $target = mergeText($target, $d, $param['nickname']);
        }
    }
    imagejpeg($target,$target_file);
    imagedestroy($target);
    return $target_file;
}

function newMergeImage($target, $data, $imgurl){
    $img = createImage($imgurl);
    $w   = imagesx($img);
    $h   = imagesy($img);
    imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
    imagedestroy($img);
    return $target;
}

function mergeImage($bg, $qr, $out, $param) {
    list($bgWidth, $bgHeight) = getimagesize($bg);
    list($qrWidth, $qrHeight) = getimagesize($qr);
    $bgImg = imagez($bg);
    $qrImg = imagez($qr);
    $ret=imagecopyresized($bgImg, $qrImg,$param['left'], $param['top'],
        0, 0, $param['width'], $param['height'],$qrWidth, $qrHeight);
    if (!$ret){
        return false;
    }
    ob_start();
    imagejpeg($bgImg, NULL, 100);
    $contents = ob_get_contents();
    ob_end_clean();
    imagedestroy($bgImg);
    imagedestroy($qrImg);
    $fh = fopen($out, "w+");
    fwrite($fh, $contents);
    fclose($fh);
    return true;
}

function mergeText($target, $data, $text){
    $font = IA_ROOT . '/web/resource/fonts/msyhbd.ttf';
    $colors = hex2rgb($data['color']);
    $color  = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
    imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
    return $target;
}
function hex2rgb($colour){
    if ($colour[0] == '#') {
        $colour = substr($colour, 1);
    }
    if (strlen($colour) == 6) {
        list($r, $g, $b) = array(
            $colour[0] . $colour[1],
            $colour[2] . $colour[3],
            $colour[4] . $colour[5]
        );
    } elseif (strlen($colour) == 3) {
        list($r, $g, $b) = array(
            $colour[0] . $colour[0],
            $colour[1] . $colour[1],
            $colour[2] . $colour[2]
        );
    } else {
        return false;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return array(
        'red' => $r,
        'green' => $g,
        'blue' => $b
    );
}

function imagez($bg){
    $bgImg = @imagecreatefromjpeg($bg);
    if (FALSE == $bgImg) {
        $bgImg = @imagecreatefrompng($bg);
    }
    if (FALSE == $bgImg) {
        $bgImg = @imagecreatefromgif($bg);
    }
    return $bgImg;
}

function barCodeCreateFixed($barcode){
    unset($barcode['expire_seconds']);
    if (empty($barcode['action_info']['scene']['scene_id']) || empty($barcode['action_name'])) {
        return error('1', 'Invalid params');
    }
    $token = $this->fetch_token();
    $url = sprintf("https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s", $token);
    $response = ihttp_request($url, json_encode($barcode));
    if (is_error($response)) {
        return $response;
    }
    $content = @json_decode($response['content'], true);
    if (empty($content)) {
        return error(-1, "接口调用失败, 元数据: {$response['meta']}");
    }
    if (!empty($content['errcode'])) {
        return error(-1, "访问微信接口错误, 错误代码: {$content['errcode']}, 错误信息: {$content['errmsg']},错误详情：{$this->error_code($content['errcode'])}");
    }
    return $content;
}

function createBarcode($obj){
    $ret = array();
    $barcode = array(
        'expire_seconds' => '',
        'action_name' => '',
        'action_info' => array(
            'scene' => array('scene_id' => ''),
        ),
    );
    $uniacccount = WeAccount::create($obj['acid']);
    $uniacid=$obj['uniacid'];
    $memerid  =$obj['memberid'];
    $openid =$obj['openid'];
    $qrcode=pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_promote_qr')." WHERE uniacid =:weid and memberid=:mid and openid=:openid",array(":weid"=>$uniacid,':mid'=>$memerid,':openid'=>$openid));
    if (empty($qrcode)) {
        $sceneid=pdo_fetchcolumn("SELECT qrcid FROM ".tablename('qrcode')." WHERE acid = :acid and model=2 and uniacid =:weid ORDER BY qrcid DESC LIMIT 1", array(':acid'=>$obj['acid'],":weid"=>$uniacid));
        $barcode['action_info']['scene']['scene_id'] = intval($sceneid) + 1;
        if ($barcode['action_info']['scene']['scene_id'] > 100000) {
            return error(-1, '抱歉，永久二维码已经生成最大数量，请先删除一些。');
        }
        $barcode['action_name'] = 'QR_LIMIT_SCENE';
        $result                 = $uniacccount->barCodeCreateFixed($barcode);
        if (is_error($result)) {
            $ret = array("code" => "-1", "msg" => "公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}");
            return $ret;
        }
        $qrimg      = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'];

        $weid = $obj['uniacid'] ;
        $acid = $obj['acid'] ;
        $ims_qrcode = array(
            'uniacid' => $weid,
            'acid' =>$acid,
            'qrcid' => $barcode['action_info']['scene']['scene_id'],
            "model" => 2,
            "name" => "AMOUSE_REBATE_PROMOTE_QRCODE",
            "keyword" => 'AMOUSE_REBATE_PROMOTE',
            "expire" => 0,
            "createtime" => time(),
            "status" => 1,
            'url' => $result['url'],
            "ticket" => $result['ticket']
        );
        pdo_insert('qrcode', $ims_qrcode);

        $data = array(
            "uniacid" => $obj['uniacid'],
            'acid' => $acid,
            'openid' => $openid,
            "memberid" => $obj['memberid'],
            'sceneid' => $barcode['action_info']['scene']['scene_id'],
            'ticket' => $result['ticket'],
            'qr_img' => $qrimg,
            'status'=>1,
            'createtime' => TIMESTAMP,
            'url' => $result['url']
        );
        $qrcode = pdo_insert("amouse_rebate_promote_qr", $data);
        if (empty($qrcode)) {
            $ret = array("code" => "-1", "msg" => "插入二维码表错误");
            return $ret;
        }
        $qr['id']            = pdo_insertid();
    } else {
        if (!empty($qrcode['qr_img'])) {
            $ret = array("code" => "1", "msg" => $qrcode['qr_img']);
            return $ret;
        }
        $qr['id']   = $qrcode['id'];
        $qrimg = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $qrcode['ticket'];
    }
    $update['qr_img'] = createImageUrl($obj, $qrimg); 
    pdo_update('amouse_rebate_promote_qr', $update, array('id' => $qr['id']));
    $ret = array("code" => "1", "msg" => $update['qr_img']);
    return $ret;
}

//重新创建
function newCreateBarcode($obj){
    $ret=array();
    $barcode = array(
        'expire_seconds' => '',
        'action_name' => '',
        'action_info' => array(
            'scene' => array('scene_id' => ''),
        ),
    );
    load()->classs('weixin.account');
    $accObj= WeixinAccount::create($obj['acid']);
    $uniacid=$obj['uniacid'];
    $memerid  =$obj['memberid'];
    $openid =$obj['openid'];
    $qrcode=pdo_fetch("SELECT * FROM ".tablename('amouse_rebate_promote_qr')." WHERE uniacid =:weid and memberid=:mid and openid=:openid",array(":weid"=>$uniacid,':mid'=>$memerid,':openid'=>$openid));
    if (empty($qrcode)) {
        $sceneid=pdo_fetchcolumn("SELECT qrcid FROM ".tablename('qrcode')." WHERE acid = :acid and model=2 and uniacid =:weid  ORDER BY qrcid DESC LIMIT 1", array(':acid'=>$obj['acid'],":weid"=>$uniacid));
        $barcode['action_info']['scene']['scene_id'] = intval($sceneid) + 1;
        if ($barcode['action_info']['scene']['scene_id'] > 100000) {
            $ret = array("code" => "-1", "msg" => '抱歉，永久二维码已经生成最大数量，请先删除一些。');
            return $ret;
        }
        $barcode['action_name'] = 'QR_LIMIT_SCENE';
        $result                 = $accObj->barCodeCreateFixed($barcode);
        if (is_error($result)) {
            $ret = array("code" => "-1", "msg" => "公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}");
            return $ret;
        }
        $qr_img      = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'];
        $weid = $obj['uniacid'] ;
        $acid = $obj['acid'] ;
        $ims_qrcode = array(
            'uniacid' => $weid,
            'acid' =>$acid,
            'qrcid' => $barcode['action_info']['scene']['scene_id'],
            "model" => 2,
            "name" => "AMOUSE_REBATE_PROMOTE_QRCODE",
            "keyword" => 'AMOUSE_REBATE_PROMOTE',
            "expire" => 0,
            "createtime" => time(),
            "status" => 1,
            'url' => $result['url'],
            "ticket" => $result['ticket']
        );
        pdo_insert('qrcode', $ims_qrcode);

        $data = array(
            "uniacid" => $obj['uniacid'],
            'acid' => $acid,
            'openid' => $openid,
            "memberid" => $obj['memberid'],
            'sceneid' => $barcode['action_info']['scene']['scene_id'],
            'ticket' => $result['ticket'],
            'qr_img' => $qr_img,
            'status'=>1,
            'createtime' => TIMESTAMP,
            'url' => $result['url']
        );
        $qrcode = pdo_insert("amouse_rebate_promote_qr", $data);
        if (empty($qrcode)) {
            $ret = array("code" => "-1", "msg" => "插入二维码表错误");
            return $ret;
        }
        $qr['id']            = pdo_insertid();
    } else {
        if (!empty($qrcode['qr_img'])){
            $token=$accObj->fetch_token();
            if  (empty($qrcode['media_id']) || (time()-$qrcode['media_time']>3*86000)){
                $update['media_id']=uploadImage($token,$qrcode['qr_img']);
                $update['media_time'] = TIMESTAMP;
                pdo_update('amouse_rebate_promote_qr', $update, array('id' => $qrcode['id']));
                $qrcode['media_id']=$update['media_id'];
                $qrcode['media_time']=$update['media_time'];
            }
            $ret=array("code"=>"1","qr_img"=>$qrcode['qr_img'], "media_id"=>$qrcode['media_id'],"media_time"=>$qrcode['media_time']);
            return $ret;
        }
        $qr['id'] = $qrcode['id'];
        $qr_img = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $qrcode['ticket'];
    }

    $update['qr_img'] = createImageUrl($obj, $qr_img);
    $token=$accObj->fetch_token(); 
    $update['media_id']=uploadImage($token,$update['qr_img']);
    $update['media_time'] = TIMESTAMP;
    pdo_update('amouse_rebate_promote_qr', $update, array('id' => $qr['id']));
    $ret=array("code"=>"1","qr_img"=>$update['qr_img'],"media_id"=>$update['media_id'],"media_time"=>$update['media_time']);
    return $ret;
}

function copyfiles($file1, $file2){
    $contentx = @file_get_contents($file1);
    $openedfile = fopen($file2, "w");
    fwrite($openedfile, $contentx);
    fclose($openedfile);
    if ($contentx === FALSE) {
        $status = false;
    } else $status = true;
    return $status;
}

function sendImage($access_token, $obj) {
    load()->func('communication');
    $data = array(
        "touser"=>$obj["openid"],
        "msgtype"=>"image",
        "image"=>array("media_id"=>$obj["media_id"])
    ); 
    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}"; 

    $ret=ihttp_request($url, json_encode($data));
    $content = @json_decode($ret['content'], true); 
    return $content['errcode'];
}

function uploadImage($access_token, $target_file) {
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
   
    $post = array(
        'media' => '@' . $target_file
    ); 
    load()->func('communication');
    $ret = ihttp_request($url, $post);
    $content = @json_decode($ret['content'], true); 
    return $content['media_id'];
}

//通知上家
function notifyLeader($leader,$amount,$child, $settings){
    global $_W;
    $uniacid = $_W['uniacid'];

    load()->classs('weixin.account');
    $accObj= WeixinAccount::create($_W['acid']);
    //发送 推荐人1元钱红包
    $parent_openid= $leader['parent_openid'];//邀请人
    $child_openid = $child['openid'];//被邀请人
    $temp=pdo_fetch("select wtx_money,user_status,tx_money from ".tablename("amouse_rebate_member")." where weid=$uniacid and openid='$parent_openid'");

    if (!empty($temp) && $temp['user_status']==0) {//拉黑
        $blacktext ="你因为违规操作，已经被拉黑。请联系管理员吧";
        $this->post_send_text(trim($parent_openid), $blacktext);
        $ret['code'] = -2;
        $ret['message'] = $blacktext;
        return $ret;
    }
    if (!empty($settings['total_money'])) {
        $total_money = pdo_fetchcolumn("SELECT sum(tx_money) tx_money from " . tablename('amouse_rebate_member') . "  where weid=$uniacid");
        if ($total_money > $settings['total_money']) {
            return array("code" => "-5", "msg" => "活动奖金已经被领完了");
        }
    }
    $settings['person_max_money'] = empty($settings['person_max_money']) ? 0 : $settings['person_max_money'];
    if ($temp["tx_money"] > $settings['person_max_money']) {
        if (!empty($settings['debug'])) {
            $this->post_send_text($parent_openid, "你领取的福利已经超过了，请给别人一点机会吧");
        }
        $ret['code'] = -2;
        $ret['message'] = "你领取的福利已经超过了，请给别人一点机会吧";
        return $ret;
    }

    if (!empty($settings['iscash'])&& $settings['iscash']==0) {//写人系统余额表
        setCredit($child_openid, 'credit2',$amount, 1,array(0,$_W['account']['name'].'关注人得现金红包+' .$amount));
        setCredit($parent_openid, 'credit2',1,1, array(0,$_W['account']['name'].'推荐人得现金红包+1' ));
    }
    //关注人 提交名片得到随机红包
    updateUserData(array("child_openid" => $child_openid, 'weid' => $uniacid, 'tg_money' => $amount));

    if (!empty($settings['show_money']) && $settings['show_money']==1) {//记录记录金额明细
        $param = array("uniacid" =>$uniacid,"openid" => $child_openid, "money" => $amount, "type" => 1);
        insertUserLog($param);

        $param = array("uniacid" => $uniacid,  "openid" => $parent_openid, "child_openid" => $child_openid, "money" => 1, 'type' => 3);
        insertUserLog($param);
    }

    $ret = send_cash_bonus($settings, $parent_openid, 1 , "恭喜你获得红包");
    return $ret;
}

//任务发送红包
function send_cash_task($openid,$amount, $settings){
    global $_W;
    $uniacid = $_W['uniacid'];
    $parent_openid= $openid;//邀请人
    $temp=pdo_fetch("select wtx_money,user_status,tx_money from ".tablename("amouse_rebate_member")." where weid=$uniacid and openid='$parent_openid'");

    if (!empty($temp) && $temp['user_status']==0) {//拉黑
        $blacktext ="你因为违规操作，已经被拉黑。请联系管理员吧";
        $this->post_send_text(trim($parent_openid), $blacktext);
        $ret['code'] = -2;
        $ret['message'] = $blacktext;
        return $ret;
    }
    if (!empty($settings['total_money'])) {
        $total_money = pdo_fetchcolumn("SELECT sum(tx_money) tx_money from " . tablename('amouse_rebate_member') . "  where weid=$uniacid");
        if ($total_money > $settings['total_money']) {
            return array("code" => "-5", "msg" => "活动奖金已经被领完了");
        }
    }
    //关注人 提交名片得到随机红包
    updateUserData(array("child_openid" => $parent_openid, 'weid' => $uniacid, 'tg_money' => $amount));
    if($amount<1){
        return array("code" => "-5", "msg" => "获取的红包金额不足");
    }
    $ret = send_cash_bonus($settings, $parent_openid, $amount , "恭喜你获得红包");
    return $ret;
}

function send_template_message($openid,$templateid, $obj){
    $templateMsg['template_id'] =$templateid;
    $templateMsg['touser'] = $openid;
    $templateMsg['url'] = $obj['url'];
    $templateMsg['topcolor'] = '#FF0000';
    $data = array();
    $data['first'] = array('value'=>$obj['firstvalue'], 'color'=>'#173177');
    $data['keyword1'] = array('value'=>$obj['keyword1'], 'color'=>'#173177');
    $data['keyword2'] = array('value'=>$obj['keyword2'], 'color'=>'#173177');
    if($obj['keyword3']){
        $data['keyword3'] = array('value'=>$obj['keyword3'], 'color'=>'#173177');
    }
    if($obj['keyword4']){
        $data['keyword4'] = array('value'=>$obj['keyword4'], 'color'=>'#173177');
    }
    $data['remark'] = array('value'=>$obj['remark'] , 'color'=>'#173177');
    $templateMsg['data'] = $data;
    $jsonData = json_encode($templateMsg);
    load()->func('communication');
    load()->classs('weixin.account');
    $accObj = WeixinAccount::create($obj['acid']);
    $token = $accObj->fetch_token();
    $apiUrl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
    $result = ihttp_request($apiUrl, $jsonData); 
}

function post_send_text($openid, $content){
    global $_W;
    $weid = $_W['acid'];
    load()->classs('weixin.account');
    $accObj = WeixinAccount::create($weid);
    $token = $accObj->fetch_token();
    load()->func('communication');
    $data['touser'] = $openid;
    $data['msgtype'] = 'text';
    $data['text']['content'] = urlencode($content);
    $dat = json_encode($data);
    $dat = urldecode($dat);
    //客服消息
    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $token;
    $ret = ihttp_post($url, $dat);
    $dat = $ret['content'];
    $result = @json_decode($dat, true);
    if ($result['errcode'] == '0') {

    } else {

    }
}

function setCredit($openid = '', $credittype = 'credit1', $credits = 0, $isadd=0, $log = array()){
    global $_W;
    load()->model('mc');
    $uid = mc_openid2uid($openid);
    if (!empty($uid)) {
        $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('mc_members') . " WHERE `uid` = :uid", array(':uid' => $uid));
        if($isadd==0){//--
            $newcredit = $value - $credits;
        }else{
            $newcredit = $value + $credits;
        }
        if ($newcredit <= 0) {
            $newcredit = 0;
        }
        pdo_update('mc_members', array($credittype => $newcredit), array('uid' => $uid));
        if (empty($log) || !is_array($log)) {
            $log = array($uid,'未记录');
        }
        $data = array(
            'uid' => $uid,
            'credittype' => $credittype,
            'uniacid' => $_W['uniacid'],
            'num' => $credits,
            'module' => 'amouse_rebate',
            'createtime' => TIMESTAMP,
            'operator' => intval($log[0]),
            'remark' => $log[1]
        );
        pdo_insert('mc_credits_record', $data);
    } else {
        $value=pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('amouse_rebate_member') . " WHERE  weid=:uniacid and openid=:openid limit 1", array(
            ':uniacid' => $_W['uniacid'], ':openid' => $openid
        ));
        if($isadd==0) {//--
            $newcredit = $value-$credits;
        }else{
            $newcredit = $value+$credits;
        }
        if ($newcredit <= 0) {
            $newcredit = 0;
        }
        pdo_update('amouse_rebate_member', array($credittype => $newcredit), array('weid' => $_W['uniacid'],'openid' => $openid));
    }
}


function updateUserData($obj){
    $weid = $obj['weid'];
    $openid = $obj['child_openid'];
    $sql = "select openid from ".tablename("amouse_rebate_member")." where weid=$weid and openid='$openid' ";
    $userdata = pdo_fetchcolumn($sql);

    if (empty($userdata)) {
        $temp = pdo_insert("amouse_rebate_member",array("weid"=>$weid,"openid"=>$openid,"credit2"=>$obj['tg_money'],"tx_money" => 0,"wtx_money"=>$obj['tg_money'],"parent_openid" => $openid));
        if ($temp == false) {
            
        }
        return;
    }
    $temp=pdo_query("UPDATE ".tablename('amouse_rebate_member')." SET credit2=credit2+:money,wtx_money=wtx_money+:money,createtime=:currenttime  WHERE weid=:uniacid AND
    openid=:openid", array(':money'=>$obj['tg_money'],':currenttime'=>TIMESTAMP, ':uniacid'=>$weid,':openid'=>$openid));
    if ($temp == false) {
         
    }
}

function insertUserLog($param){
    $temp = pdo_insert("amouse_rebate_user_log",
        array("uniacid" => $param['uniacid'],
            "openid" => $param['openid'],
            "child_openid" => $param['child_openid'],
            "money" => $param['money'],
            "type" => $param['type'],
            "createtime" => TIMESTAMP,
        ));
}

//现金红包接口
function send_cash_bonus($settings, $fromUser, $amount, $desc){
    $Hour = date('G');
    if (intval($Hour) <= 8) {
        return send_mmpaymkttransfers($settings, $fromUser, $amount, $desc);
    }
    $ret = array();
    $ret['code'] = 0;
    $ret['message'] = "success";
    $amount = $amount * 100;
    $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
    $pars = array();
    $pars['nonce_str'] = random(32);
    $pars['mch_billno'] = random(10) . date('Ymd') . random(3);
    $pars['mch_id'] = $settings['mchid'];
    $pars['wxappid'] = $settings['appid'];
    $pars['nick_name'] = $settings['send_name'];
    $pars['send_name'] = $settings['send_name'];
    $pars['re_openid'] = $fromUser;
    $pars['total_amount'] = $amount;
    $pars['min_value'] = $amount;
    $pars['max_value'] = $amount;
    $pars['total_num'] = 1;
    $pars['wishing'] = $desc;
    $pars['client_ip'] = $settings['ip'];
    $pars['act_name'] = $settings['act_name'];
    $pars['remark'] = $settings['remark'];

    ksort($pars, SORT_STRING);
    $string1 = '';
    foreach ($pars as $k => $v) {
        $string1 .= "{$k}={$v}&";
    }
    $string1 .= "key={$settings['password']}";
    $pars['sign'] = strtoupper(md5($string1));
    $xml = array2xml($pars);
    $extras = array();
    $certs        = iunserializer($settings['apisec']);

    if (is_array($certs)) {
        if (empty($certs['cert']) || empty($certs['key']) || empty($certs['root'])) {
            message('未上传完整的微信支付证书，请到【参数设置】->【红包设置】中上传!', '', 'error');
        }
        $certfile = IA_ROOT . "/addons/amouse_rebate/cert/" . random(128);
        file_put_contents($certfile, $certs['cert']);
        $keyfile = IA_ROOT . "/addons/amouse_rebate/cert/" . random(128);
        file_put_contents($keyfile, $certs['key']);
        $rootfile = IA_ROOT . "/addons/amouse_rebate/cert/" . random(128);
        file_put_contents($rootfile, $certs['root']);
        $extras['CURLOPT_SSLCERT'] = $certfile;
        $extras['CURLOPT_SSLKEY']  = $keyfile;
        $extras['CURLOPT_CAINFO']  = $rootfile;
    } else {
        message('未上传完整的微信支付证书，请到【参数设置】->【红包设置】中上传!', '', 'error');
    }

    load()->func('communication');
    $procResult = null;
    $resp = ihttp_request($url, $xml, $extras);

    @unlink($certfile);
    @unlink($keyfile);
    @unlink($rootfile);
    if(is_error($resp)) {
        $procResult = $resp["message"];
        $ret['code'] = -1;
        $ret['msg'] = $procResult;
        return $ret;
    } else {
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        $dom = new DOMDocument();
        if ($dom->loadXML($xml)) {
            $xpath = new DOMXPath($dom);
            $code = $xpath->evaluate('string(//xml/return_code)');
            $result = $xpath->evaluate('string(//xml/result_code)');
            if (strtolower($code) == 'success' && strtolower($result) == 'success') {
                $ret['code'] = 0;
                $ret['msg'] = "success";
                return $ret;
            } else {
                $error = $xpath->evaluate('string(//xml/err_code_des)');
                $ret['code'] = -2;
                $ret['msg'] = $error;
                return $ret;
            }
        } else {
            $ret['code'] = -3;
            $ret['msg'] = "3error3";
            return $ret;
        }
    }
}

//企业付款接口
function send_mmpaymkttransfers($settings, $fromUser, $amount, $desc){
    $ret = array();
    $amount = $amount * 100;
    $ret['amount'] = $amount;
    $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    $pars = array();
    $pars['mch_appid'] = $settings['appid'];
    $pars['mchid'] = $settings['mchid'];
    $pars['nonce_str'] = random(32);
    $pars['partner_trade_no'] = random(10) . date('Ymd') . random(3);
    $pars['openid'] = $fromUser;
    $pars['check_name'] = "NO_CHECK";
    $pars['amount'] = $amount;
    $pars['desc'] = $desc;
    $pars['spbill_create_ip'] = $settings['ip'];
    ksort($pars, SORT_STRING);
    $string1 = '';
    foreach ($pars as $k => $v) {
        $string1 .= "{$k}={$v}&";
    }
    $string1 .= "key={$settings['password']}";
    $pars['sign'] = strtoupper(md5($string1));
    $xml = array2xml($pars);
    $extras = array();
    $certs        = iunserializer($settings['apisec']);
    if (is_array($certs)) {
        if (empty($certs['cert']) || empty($certs['key']) || empty($certs['root'])) {
            message('未上传完整的微信支付证书，请到【参数设置】->【红包设置】中上传!', '', 'error');
        }
        $certfile = IA_ROOT . "/addons/amouse_rebate/cert/" . random(128);
        file_put_contents($certfile, $certs['cert']);
        $keyfile = IA_ROOT . "/addons/amouse_rebate/cert/" . random(128);
        file_put_contents($keyfile, $certs['key']);
        $rootfile = IA_ROOT . "/addons/amouse_rebate/cert/" . random(128);
        file_put_contents($rootfile, $certs['root']);
        $extras['CURLOPT_CAINFO']  = $rootfile;
        $extras['CURLOPT_SSLCERT'] = $certfile;
        $extras['CURLOPT_SSLKEY']  = $keyfile;

    } else {
        message('未上传完整的微信支付证书，请到【参数设置】->【红包设置】中上传!', '', 'error');
    }

    load()->func('communication');
    $procResult = null;

    $resp = ihttp_request($url, $xml, $extras);
    @unlink($certfile);
    @unlink($keyfile);
    @unlink($rootfile);
    if (is_error($resp)) {
        $procResult = $resp['message'];
        $ret['code'] = -1;
        $ret['message'] = "-1:" . $procResult;
        return $ret;
    } else {
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        $dom = new DOMDocument();
        if ($dom->loadXML($xml)) {
            $xpath = new DOMXPath($dom);
            $code = $xpath->evaluate('string(//xml/return_code)');
            $result = $xpath->evaluate('string(//xml/result_code)');
            if (strtolower($code) == 'success' && strtolower($result) == 'success') {
                $ret['code'] = 0;
                $ret['message'] = "success";
                return $ret;

            } else {
                $error = $xpath->evaluate('string(//xml/return_msg)') . "<br/>" . $xpath->evaluate('string(//xml/err_code_des)');
                $ret['code'] = -2;
                $ret['message'] = "-2:" . $error;
                return $ret;
            }
        } else {
            $ret['code'] = -3;
            $ret['message'] = "error response";
            return $ret;
        }
    }
}



function url_base64_encode($str){
    $str = base64_encode($str);
    $code = url_encode($str);
    return $code;
}
function url_encode($code){
    $code = str_replace('+', "!", $code);
    $code = str_replace('/', "*", $code);
    $code = str_replace('=', "", $code);
    return $code;
}
function url_base64_decode($code)
{
    $code = url_decode($code);
    $str = base64_decode($code);
    return $str;
}
function url_decode($code)
{
    $code = str_replace("!", '+', $code);
    $code = str_replace("*", '/', $code);
    return $code;
}
function pencode($code, $seed = 'fuckaway9876543210')
{
    $c = url_base64_encode($code);
    $pre = substr(md5($seed . $code), 0, 3);
    return $pre . $c;
}
function pdecode($code, $seed = 'fuckaway9876543210')
{
    if (empty($code) || strlen($code) <= 3) {
        return "";
    }
    $pre = substr($code, 0, 3);
    $c = substr($code, 3);
    $str = url_base64_decode($c);
    $spre = substr(md5($seed . $str), 0, 3);
    if ($spre == $pre) {
        return $str;
    } else {
        return "";
    }
}