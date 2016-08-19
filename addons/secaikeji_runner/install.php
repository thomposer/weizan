<?php
global $_W,$_GPC;
load()->func('db');
load()->model('setting');

$tables = array();
$tables[] = 'secaikeji_runner3_member';
$tables[] = 'secaikeji_runner3_listenlog';
$tables[] = 'secaikeji_runner3_tasks';
$tables[] = 'secaikeji_runner3_setting';
$tables[] = 'secaikeji_runner3_detail';
$tables[] = 'secaikeji_runner3_paylog';
$tables[] = 'secaikeji_runner3_buy';
$tables[] = 'secaikeji_runner3_recive';
$tables[] = 'secaikeji_runner3_moneylog';
$tables[] = 'secaikeji_runner3_code';
$tables[] = 'secaikeji_runner_adv';
;
cloud_update_table($tables,'secaikeji_runner');

/*
 * 同步云数据库结构
 * */
function cloud_update_table($tables = array(),$module=''){
	load()->func('db');
	load()->func('communication');

	$tables = iserializer($tables);
	$tables = @base64_encode($tables);
	$data = array();
	$data['ip'] = gethostbyname($_SERVER['SERVER_ADDR']);
	$data['domain'] = $_SERVER['HTTP_HOST'];
	$data['s'] = $tables;
	$setting = setting_load('site');
	$data['id'] =isset($setting['site']['key'])? $setting['site']['key'] : '1';
	$data['module']= $module;
	
	$url = 'http://meepo.com.cn/meepo/api/meepo.php';
	$res = ihttp_post($url,$data);
	$res = cloud_object_array($res);
	$content = $res['content'];
	$content = json_decode($content);
	$content = cloud_object_array($content);
	
	if($content['code'] == 0){
		$data = $content['data'];
		$data = @base64_decode($data);
		$data = iunserializer($data);
		$sqls = array();
		if(!empty($data)){
			foreach($data as $da){
				if(!empty($da['tablename'])){
					$schema = db_table_schema(pdo(),$da['tablename']);
					$da['tablename'] = cloud_tablename($da['tablename']);
			
					if(empty($schema['tablename'])){
						//新建数据库
						$sql = db_table_create_sql($da);
					}else{
						$sql = db_table_fix_sql($schema,$da);
					}
			
					$sqls[] = $sql;
				}
			}
		}
		cloud_updatetable($sqls);
		return true;
	}else{
		return false;
	}
}

function cloud_tablename($table) {
	if(empty($GLOBALS['_W']['config']['db']['master'])) {
		return "{$GLOBALS['_W']['config']['db']['tablepre']}{$table}";
	}
	return "{$GLOBALS['_W']['config']['db']['master']['tablepre']}{$table}";
}

/*
 * 结构转数组
 * */
function cloud_object_array($array) {
	if(is_object($array)) {
		$array = (array)$array;
	} if(is_array($array)) {
		foreach($array as $key=>$value) {
			$array[$key] = cloud_object_array($value);
		}
	}
	return $array;
}
/*
 * 执行数据库更新
 * */
function cloud_updatetable($data){
	if(!empty($data)){
		if(is_array($data)){
			foreach($data as $da){
				if(is_array($da)){
					cloud_updatetable($da);
				}else{
					pdo_query($da);
				}
			}
		}else{
			pdo_query($data);
		}
	}
}