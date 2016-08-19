<?php

session_start();
defined ('IN_IA') or exit ('Access Denied');
class Water_dearwhereModuleSite extends WeModuleSite{
    public $metable = 'water_dearwhere_me';
    public $deartable = 'water_dearwhere_dear';
    public function doMobileIndex(){
        global $_GPC, $_W;
        $system = $this -> module['config'];
        $openid = $_W ['fans'] ['from_user'];
        $from1 = $openid;
        include $this -> template ('myself');
    }
    public function doMobileCeshi(){
        global $_GPC, $_W;
        $system = $this -> module['config'];
        $openid = $_W ['fans'] ['from_user'];
        $from1 = $openid;
        include $this -> template ('form');
    }
    public function doMobileIndex2(){
        global $_GPC, $_W;
        $system = $this -> module['config'];
        $openid = $_W ['fans'] ['from_user'];
        $lat = $_GPC ['lat'];
        $lng = $_GPC ['lng'];
        include $this -> template ('myself2');
    }
    public function doMobileShow(){
        global $_GPC, $_W;
        $system = $this -> module['config'];
        $simgs = unserialize($system['simgs']);
        $openid = $_W ['fans'] ['from_user'];
        $frommy = $_GPC ['frommy'];
        include $this -> template ('index');
    }
    public function doMobileMylocation(){
        global $_GPC, $_W;
        $system = $this -> module['config'];
        $openid = $_W ['fans'] ['from_user'];
        $lat = $_GPC ['lat'];
        $lng = $_GPC ['lng'];
        $wzdata = array('lng' => $lng, 'lat' => $lat,);
        $data = array('mewz' => serialize($wzdata));
        $me = pdo_fetch ("SELECT * FROM " . tablename ($this -> metable) . " WHERE uniacid = '{$_W['uniacid']}' and openid ='{$openid}'");
        if(empty($me)){
            $data['openid'] = $openid;
            $data['uniacid'] = $_W['uniacid'];
            pdo_insert($this -> metable, $data);
            $id = pdo_insertid();
        }else{
            pdo_update ($this -> metable, $data, array ('id' => $me['id']));
        }
        die(json_encode(array("result" => 1, "msg" => 'success', "wz" => $data)));
    }
    public function doMobileSetlocation(){
        global $_GPC, $_W;
        $openid = $_W ['fans'] ['from_user'];
        $system = $this -> module['config'];
        $lat = $_GPC ['lat'];
        $lng = $_GPC ['lng'];
        $from = $_GPC ['frommy'];
        $wzdata = array('lng' => $lng, 'lat' => $lat,);
        $me = pdo_fetch ("SELECT * FROM " . tablename ($this -> metable) . " WHERE uniacid = '{$_W['uniacid']}' and openid ='{$from}'");
        $slct = unserialize($me['mewz']);
        $juli = $this -> getDistance($lng, $lat, $slct['lng'], $slct['lat']);
        $data = array('dwz' => serialize($wzdata), 'dtime' => date("Y-m-d H:i", time()), 'distance' => $juli,);
        $dear = pdo_fetch ("SELECT * FROM " . tablename ($this -> deartable) . " WHERE uniacid = '{$_W['uniacid']}' and mfrom = '{$from}' and openid ='{$openid}' ");
        if(empty($dear)){
            $data['openid'] = $openid;
            $data['mfrom'] = $from;
            $data['uniacid'] = $_W['uniacid'];
            pdo_insert($this -> deartable, $data);
            $id = pdo_insertid();
        }else{
            pdo_update ($this -> deartable, $data, array ('id' => $dear['id']));
        }
        $yhorderurl = $_W['siteroot'] . 'app/' . $this -> createMobileUrl('index2', $wzdata);
        $data1 = array('touser' => $from, 'template_id' => $system['msgid'], 'url' => $yhorderurl, 'topcolor' => '#FF0000',);
        $data1['data'] = array('first' => array('value' => '成功获取位置信息', 'color' => '#173177',), 'keyword1' => array('value' => date('Y-m-d H:i:s', TIMESTAMP), 'color' => '#173177',), 'keyword2' => array('value' => '亲爱哒位置距您:' . $juli, 'color' => '#173177',), 'remark' => array('value' => '点击打开位置地图，仅供粉丝娱乐，请勿用于非法用途哦！', 'color' => '#173177',),);
        $token = $this -> getToken();
        $this -> sendMBXX($token, $data1);
        die(json_encode(array("result" => 1, "msg" => 'success')));
    }
    public function getToken(){
        global $_W;
        load() -> classs('weixin.account');
        $accObj = WeixinAccount :: create($_W['acid']);
        $access_token = $accObj -> fetch_token();
        return $access_token;
    }
    public function sendMBXX($access_token, $data){
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        ihttp_post($url, json_encode($data));
    }
    public function doMobileUploadSlogo(){
        global $_W, $_GPC;
        $openid = $_W ['fans'] ['from_user'];
        if(empty($openid)){
            die(json_encode(array("result" => 0, "msg" => "系统错误")));
        }
        $media_id = $_GPC ['media_ids'];
        $file = $this -> downloadFromWxServer($media_id);
        die(json_encode(array("result" => 1, "msg" => "success", "url" => $file[0]['path'])));
    }
    function downloadFromWxServer($media_ids){
        global $_W, $_GPC;
        $media_ids = explode(',', $media_ids);
        if(!$media_ids){
            die(json_encode(array('res' => '101', 'message' => 'media_ids error')));
        }
        load() -> classs('weixin.account');
        $accObj = WeixinAccount :: create($_W['account']['acid']);
        $access_token = $accObj -> fetch_token();
        load() -> func('communication');
        load() -> func('file');
        $contentType["image/gif"] = ".gif";
        $contentType["image/jpeg"] = ".jpeg";
        $contentType["image/png"] = ".png";
        foreach($media_ids as $id){
            if(!empty($id)){
                $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=" . $access_token . "&media_id=" . $id;
                $data = ihttp_get($url);
                $filetype = $data['headers']['Content-Type'];
                $filename = date('YmdHis') . '_' . rand(1000000000, 9999999999) . '_' . rand(1000, 9999) . $contentType[$filetype];
                $wr = file_write('/images/water_o2o/' . $filename, $data['content']);
                if($wr){
                    $file_succ[] = array('name' => $filename, 'path' => $_W['attachurl'] . '/images/water_o2o/' . $filename, 'spath' => 'images/water_o2o/' . $filename, 'type' => 'local');
                }
            }
        }
        if (!empty($_W['setting']['remote']['type'])){
            foreach ($file_succ as $key => $value){
                $r = file_remote_upload($value['spath']);
                if(is_error($r)){
                    unset($file_succ[$key]);
                    continue;
                }
                $file_succ[$key]['path'] = tomedia($value['spath']);
                $file_succ[$key]['type'] = 'other';
            }
        }
        return $file_succ;
    }
    static function getDistance($lng1, $lat1, $lng2, $lat2){
        $EARTH_RADIUS = 6378.137;
        $PI = 3.1415926;
        $radLat1 = $lat1 * $PI / 180.0;
        $radLat2 = $lat2 * $PI / 180.0;
        $a = $radLat1 - $radLat2;
        $b = ($lng1 * $PI / 180.0) - ($lng2 * $PI / 180.0);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 1000);
        $distance = round($s, 2);
        if($distance < 1000){
            $distance = floor($distance);
            $unit = '米';
        }else{
            $distance = round($distance / 1000, 2);
            $unit = '千米';
        }
        return $distance . $unit;
    }
}

?>