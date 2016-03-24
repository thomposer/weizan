<?php
load()->func('communication');
/*
 * 模板消息发送
 * uid : 会员ID code : 发送类型 database : 发送格式 replace 替换内容
 */
function send_template($uid,$code,$database,$replace){
	global $_W,$_GPC;
	load()->model('mc');
	if(is_numeric($uid)){
		$user = mc_fetch($uid);
		$sql = "SELECT openid FROM ".tablename('mc_mapping_fans')." WHERE uid = :uid AND uniacid = :uniacid ";
		$params = array(':uid'=>$uid,':uniacid'=>$_W['uniacid']);
		$openid = pdo_fetchcolumn($sql,$params);
	}else{
		$user = fans_search($uid);
		$openid = $uid;
	}
	if(empty($openid)){
		message('openid为空，发送消息失败!',referer(),error);
	}
	$sql = "SELECT openid,acid FROM ".tablename('mc_mapping_fans')." WHERE uniacid = :uniacid AND openid = :openid";
	$params = array(':uniacid'=>$_W['uniacid'],':openid'=>$openid);
	$fans = pdo_fetch($sql,$params);
	$send = array();

	if(empty($_W['acid'])){
		$_W['acid'] = $row['acid'];
	}
	if(empty($_W['acid'])){
		$_W['acid'] = $fans['acid'];
	}
	if(empty($_W['acid'])){
		message('请选择公众账号',referer(),error);
	}

	$send['touser'] = trim($openid);
	$send['acid'] = intval($_W['acid']);

	$sql = "SELECT * FROM ".tablename('imeepos_runner_msg_template')." WHERE uniacid = :uniacid AND type = :type ";
	$params = array(':uniacid'=>$_W['uniacid'],':type'=>$code);
	$template = pdo_fetch($sql,$params);

	$send['tpl_id'] = $template['tpl_id'];
	$tags = unserialize($template['tags']);
	$set = unserialize($template['set']);
	$data = array();
	if(is_array($tags)){
		foreach ($tags as $tag){
			$data[$tag] = array('value'=>$set['content'][$tag],'color'=>$set['color'][$tag]);
		}
	}
	$send['data'] = formot_content2($data,$database,$replace);
	$send['url'] = $set['url'];
	$return = send_template_message($send);
	return $return;
}

/*
 * mysql 拼in语句 返回sql语句
 */
if(!function_exists('db_create_in')){
	function db_create_in($item_list, $field_name = '') {
		if (empty($item_list)) {
			return $field_name . " IN ('') ";
		} else {
			if (!is_array($item_list)) {
				$item_list = explode(',', $item_list);
			}
			$item_list = array_unique($item_list);
			$item_list_tmp = '';
			foreach ($item_list AS $item) {
				if ($item !== '') {
					$item_list_tmp.= $item_list_tmp ? ",'$item'" : "'$item'";
				}
			}
			if (empty($item_list_tmp)) {
				return $field_name . " IN ('') ";
			} else {
				return $field_name . ' IN (' . $item_list_tmp . ') ';
			}
		}
	}
}
/*
 * 检查站长权限
 */
function checkAdmin(){
  global $_W;
  checklogin();
  if(empty($_W['isfounder'])) {
    return false;
  }
  return true;
}

/*
 * 对象转数组
 */
function object_to_array($obj)
{
  $_arr= is_object($obj) ? get_object_vars($obj) : $obj;
  foreach((array)$_arr as $key=> $val)
  {
    $val= (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
    $arr[$key] = $val;
  }
  return$arr;
}

function imCode($ths){
  $codes = array();
  foreach ($ths as $th) {
    if(!empty($th['code'])){
      $codes[] = $th['code'];
    }
  }
  $mc = implode(',',$codes);
  return $mc;
}

if(!function_exists('uni_is_multi_acid')){
	function uni_is_multi_acid($uniacid = 0) {
		global $_W;
		if(!$uniacid) {
			$uniacid = $_W['uniacid'];
		}
		$cachekey = "unicount:{$uniacid}";
		$nums = cache_load($cachekey);
		$nums = intval($nums);
		if(!$nums) {
			$nums = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('account_wechats') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
			cache_write($cachekey, $nums);
		}
		if($nums == 1) {
			return false;
		}
		return true;
	}
}

/*
 * 前端路由重写 生成会员唯一连接
 */
function imurl($segment, $params = array(), $noredirect = true, $addhost = false){
    global $_W;
    load()->model('mc');
	list($controller, $action, $do) = explode('/', $segment);
	if (!empty($addhost)) {
		$url = $_W['siteroot'] . 'app/';
	} else {
		$url = './';
	}
	$str = '';
	//兼容0.6
	if(uni_is_multi_acid()) {
		$str = "&j={$_W['acid']}";
	}
    if(empty($_W['member']['uid'])){
        if(!empty($_W['openid'])) {
        	$uid = mc_openid2uid($_W['openid']);
			if(empty($uid)){
				$uid = 0;
			}
    		if(_mc_login(array('uid' => intval($uid)))) {
                //登录成功
                $str .= "&u={$_W['member']['uid']}";
            }else{
                $str .= "&u={$_W['openid']}";
            }
    	}
    }else{
        $str .= "&u={$_W['member']['uid']}";
    }

	$url .= "index.php?i={$_W['uniacid']}{$str}&";
	if (!empty($controller)) {
		$url .= "c={$controller}&";
	}
	if (!empty($action)) {
		$url .= "a={$action}&";
	}
	if (!empty($do)) {
		$url .= "do={$do}&";
	}
	if (!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
		if ($noredirect === false) {
			$url .= '&wxref=mp.weixin.qq.com#wechat_redirect';
		}
	}
	return $url;
}

//检查安装
function init(){
	global $_W;
	if(!pdo_tableexists('meepo_module')){
		$sql = "CREATE TABLE `ims_meepo_module` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`module` varchar(32) NOT NULL DEFAULT '',
	`set` text NOT NULL,
	`time` int(11) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM
CHECKSUM=0
DELAY_KEY_WRITE=0;";
		pdo_query($sql);
	}
}
function getCommonUser($uid){
	global $_W;
	$sql = "SELECT * FROM ".tablename('meepo_common_user')." WHERE uid = :uid";
	$params = array(':uid'=>$uid);
	return pdo_fetch($sql,$params);
}

/*
 * 获取地图正方形范围
 */
function squarePoint($lng, $lat, $distance = 0.5) {
	$earth_radius = 6371;
    $dlng = 2 * asin(sin($distance / (2 * $earth_radius)) / cos(deg2rad($lat)));
    $dlng = rad2deg($dlng);

    $dlat = $distance / $earth_radius;
    $dlat = rad2deg($dlat);

    return array(
        'left-top' => array('lat' => $lat + $dlat, 'lng' => $lng - $dlng),
        'right-top' => array('lat' => $lat + $dlat, 'lng' => $lng + $dlng),
        'left-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng - $dlng),
        'right-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng + $dlng)
    );
}
/*
 * 获取地图亮点位置
 */
function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2) {
	$earth_radius = 6371;
    $radLat1 = $lat1 * M_PI / 180;
    $radLat2 = $lat2 * M_PI / 180;
    $a = $lat1 * M_PI / 180 - $lat2 * M_PI / 180;
    $b = $lng1 * M_PI / 180 - $lng2 * M_PI / 180;

    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $s = $s * $earth_radius;
    $s = round($s * 1000);
    if ($len_type > 1) {
        $s /= 1000;
    }
    return round($s, $decimal);
}

//反序列化
function munserializer($value) {
	if (empty($value)) {
		return '';
	}
	if (!is_serialized($value)) {
		if(is_array($value)){
			foreach ($value as $key=>$v){
				$v = munserializer($v);
				$data[$key]=$v;
			}
			return $data;
		}
		return $value;
	}
	$result = iunserializer($value);

	return munserializer($result);
}

function mserializer($value){
	if(empty($value)){
		return '';
	}
	$adv = array();
	foreach ($value as $key=>$p){
		if(is_array($p)){
			$adv[$key] = serialize($p);
		}else{
			$adv[$key] = $p;
		}
	}
	return $adv;
}
/*
 * 获取验证授权
 */
function getAuthSet($module){
	global $_W;
	$set =pdo_fetch("SELECT * FROM " . tablename('meepo_module'). " WHERE `module` = '{$module}' limit 1");
	$sets =iunserializer($set['set']);
	if (is_array($sets)){
		return is_array($sets['auth'])? $sets['auth'] : array();
	}
	return array();
}
/*
 * 设置验证授权
 */
function setAuthSet($set,$module){
	global $_W;
	if(empty($set)){
		$set = array();
	}
	$set =pdo_fetch('SELECT * FROM ' . tablename('meepo_module'). ' WHERE module = :module limit 1', array(':module' => $module));
	if (empty($set)){
		pdo_insert('meepo_module', array('set' => iserializer($set), 'module' => $module,'time'=>time()));
	}else{
		pdo_update('meepo_module', array('set' => iserializer($set),'time'=>time()),array('module'=>$module));
	}
	message('系统授权成功！', referer(), 'success');
	return array();
}
/*
 * 检查验证授权
 */
function mcheck($module){
	global $_W;
	$oauth = getAuthSet($module);
	if(empty($oauth['code'])){
		return 0;
	}
	$ip =gethostbyname($_SERVER['SERVER_ADDR']);
	$domain =$_SERVER['HTTP_HOST'];
	$setting =setting_load('site');
	$id =isset($setting['site']['key'])? $setting['site']['key'] : '1';
	$resp =ihttp_post('http://meepo.com.cn/meepo/module/oauth.php',array('ip'=>$ip,'id'=>$id,'code'=>$oauth['code'],'domain'=>$domain,'module'=>$module));
	$content = json_decode($resp['content']);
	$status = intval($content->status);
	if ($status == 1){
		return 1;
	}
	return 0;
}
//便利文件夹
function my_scandir($dir) {
	global $my_scenfiles;
	if ($handle = opendir($dir)) {
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") {
				if (is_dir($dir . "/" . $file)) {
					my_scandir($dir . "/" . $file);
				} else {
					$my_scenfiles[] = $dir . "/" . $file;
				}
			}
		}
		closedir($handle);
	}
}

function getset($module){
	global $_W;
	$sql = "SELECT * FROM ".tablename('meepo_common_setting')." WHERE uniacid = :uniacid AND module = :module";
	$params = array(':uniacid'=>$_W['uniacid'],':module'=>$module);
	$set = pdo_fetch($sql,$params);
	$setting = munserializer($set['set']);
	if(isset($setting['system'])){
		$setting['system'] = array();
	}

	return $setting;
}

function updateset($set,$module){
	global $_W;
	$data = serialize($set);
	pdo_update('meepo_common_setting',array('set'=>$data),array('uniacid'=>$_W['uniacid'],'module'=>$module));
	return true;
}

function getPlatSet($module){
	$sql = "SELECT * FROM ".tablename('meepo_platset')." WHERE module = :module";
	$params = array(':module'=>$module);
	$row = pdo_fetch($sql,$params);
	return $row;
}

function updatePlatSet($set,$module){
	$data = serialize($set);
	pdo_update('meepo_platset',array('set'=>$data),array('module'=>$module));
	return true;
}

function getMeepoUniacid(){
	global $_W,$_GPC;

}

function updateOauthUser(){
	global $_W;
	if(!empty($_W['openid'])){
		$data = array();
		$data['oauth_openid'] = $_SESSION['__meepo_openid'];
		$data['uniacid'] = $_W['uniacid'];
		$data['acid'] = $_W['acid'];
		$data['openid'] = $_W['openid'];
		$data['uid'] = $_W['member']['uid'];
		$con = '';
		$params = array();
		if(!empty($_W['uniacid'])){
			$con .= ' AND uniacid = :uniacid ';
			$params[':uniacid'] = $_W['uniacid'];
		}
		if(!empty($_W['acid'])){
			$con .= ' AND acid = :acid ';
			$params[':acid'] = $_W['acid'];
		}
		if(!empty($_W['openid'])){
			$con .= ' AND openid = :openid ';
			$params[':openid'] = $_W['openid'];
		}
		if(!empty($_W['member']['uid'])){
			$con .= ' AND uid = :uid ';
			$params[':uid'] = $_W['member']['uid'];
		}
		$sql = "SELECT * FROM ".tablename('meepo_common_oauth_user')." WHERE 1 $con ";
		$oauth_user = pdo_fetch($sql,$params);
		if(empty($oauth_user)){
			pdo_insert('meepo_common_oauth_user',$data);
		}else{
			pdo_update('meepo_common_oauth_user',$data,array('id'=>$oauth_user['id']));
		}
	}
}
