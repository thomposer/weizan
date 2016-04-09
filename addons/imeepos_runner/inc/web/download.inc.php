<?php
//下载
global $_W, $_GPC;
$op =empty($_GPC['op'])? 'display' : $_GPC['op'];

load()->func('communication');
load()->func('file');
load()->model('setting');
load()->func('communication');
$setting = setting_load('site');
$setting = $content['setting'];

if(!empty($setting) && $setting['status'] == 1){
	//message('验证授权成功',referer(),success);
	$code = $setting['code'];
	$tmpdir =IA_ROOT."/addons/".$this->modulename."/".date('ymd');
	$versionfile = IA_ROOT."/addons/".$this->modulename."/version.php";
	if(file_exists($versionfile)){
		require_once $versionfile;
		$version = VERSION;
		if($version == '0.0.0'){
			$version = '开发同步版';
		}
	}else{
		$version = '1.0.0';
	}
	if(!is_dir($tmpdir)){
		mkdirs($tmpdir);
	}
	if ($op == 'display'){
		$versionfile =IA_ROOT . '/addons/'.$this->modulename.'/version.php';
		if (is_file($versionfile)){
			$updatedate =date('Y-m-d H:i', filemtime($versionfile));
		}else{
			$updatedate =date('Y-m-d H:i', filemtime($versionfile));
		}
		set_time_limit(0);
		global $my_scenfiles;
		my_scandir(IA_ROOT.'/addons/'.$this->modulename.'/');
		$files =array();
		foreach($my_scenfiles as $sf){
			$files[] =array('path' => str_replace(IA_ROOT."/addons/".$this->modulename."/","",$sf), 'md5'=> md5_file($sf));
		}
		
		$files =base64_encode(json_encode($files));
		$resp =ihttp_post('http://meepo.com.cn/meepo/module/check.php',array('ip'=>$oauth['ip'], 'id'=>$oauth['id'], 'code'=>$setting['code'], 'domain'=>$oauth['domain'], 'version'=>$version, 'files'=>$files ,'module'=>$this->modulename));
		$content = cloud_object_array(@json_decode($resp['content']));
		
		if($content['status'] ==1){
			$files =array();
			if (!empty($content['files'])){
				foreach ($content['files'] as $file){
					$entry =IA_ROOT . "/addons/".$this->modulename."/".$file['path'];
					if (!is_file($entry)|| md5_file($entry)!= $file['md5']){
	
						if($file['path'] == '/install.php' || $file['path'] == '/update.php' || $file['path'] == '/manifest.xml' || $file['path'] == '/version.php'){
	
						}else{
							$files[] =array('path'=>$file['path'],'download'=>0);
						}
					}
				}
			}
			$content['files'] = $files;
			$message = '重要: 本次更新涉及到程序变动, 请做好备份.';
			file_put_contents($tmpdir."/file.txt",json_encode($content));
		}else if($content['status'] == -1){
			$files = array();
			$message = '当前版本为最新版本！';
		}else{
			$files = array();
			$message = '免费版，暂无更新服务！';
		}
		include $this->template('download');
	}else if ($op == 'download'){
	  $f =file_get_contents($tmpdir."/file.txt");
	  $upgrade =json_decode($f,true);
	  $files =$upgrade['files'];
	  $path ="";
	  if(!empty($files)){
	    foreach($files as $f){
	      if(empty($f['download'])){
	        $path =$f['path'];
	        break;
	      }
	    }
	  }
	  if(!empty($path)){
	    $resp =ihttp_post('http://meepo.com.cn/meepo/module/download.php',array('ip'=>$oauth['ip'], 'id'=>$oauth['id'], 'code'=>$code, 'domain'=>$oauth['domain'], 'path'=>$path ,'module'=>$this->modulename));
	    $ret =cloud_object_array(@json_decode($resp['content'], true));
	    if($ret['status'] == 0){
	      die(json_encode(array('result'=>1, 'total'=>1,'success'=>$ret['message'])));
	    }
	    if ($ret['status'] == 1){
	      $path =$ret['path'];
	      if(!file_exists(IA_ROOT.'/addons/'.$this->modulename.'/'.$path)){
	        mkdirs(dirname(IA_ROOT.'/addons/'.$this->modulename.'/'.$path),"0777");
	      }
	      $content =base64_decode($ret['content']);
	      file_put_contents(IA_ROOT.'/addons/'.$this->modulename.''.$path, $content);
	      $success =0;
	      foreach($files as &$f){
	        if($f['path']==$path){
	          $f['download'] =1;
	          break;
	        }
	        if($f['download']){
	          $success++;
	        }
	      }
	      unset($f);
	      $upgrade['files'] =$files;
	      file_put_contents($tmpdir."/file.txt",json_encode($upgrade));
	      die(json_encode(array('result'=>1, 'total'=>count($files),'success'=>$success."(".$path.")")));
	    }
	  }else{
		file_put_contents(IA_ROOT.'/addons/'.$this->modulename.'/version.php',"<?php if(!defined('VERSION')) {define('VERSION','".$upgrade['version']."');}");
	    @rmdirs($tmpdir);
	    die(json_encode(array('result'=>2)));
	  }
	}
}else{
	message('验证授权失败，请联系客服处理',referer(),'error');
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

function getAuthSet(){
	global $_W;
	$sql = "SELECT * FROM ".tablename('imeepos_runner3_setting')." WHERE code = :code";
	$params = array(':code'=>'auth');
	$setting = pdo_fetch($sql,$params);
	$item = iunserializer($item['value']);
	return $item['code'];
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