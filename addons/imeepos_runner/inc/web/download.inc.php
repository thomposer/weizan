<?php
//下载
global $_W, $_GPC;
$op =empty($_GPC['op'])? 'display' : $_GPC['op'];

load()->func('communication');
load()->func('file');
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
		mload()->model('cloud');
		$tables = array();
		$tables[] = 'imeepos_runner_adv';
		$tables[] = 'imeepos_runner_page';
		$tables[] = 'imeepos_runner_apply_certify';
		$tables[] = 'imeepos_runner_apply_service';
		$tables[] = 'imeepos_runner_awards';
		$tables[] = 'imeepos_runner_certify';
		$tables[] = 'imeepos_runner_class';
		$tables[] = 'imeepos_runner_father';
		$tables[] = 'imeepos_runner_feedback';
		$tables[] = 'imeepos_runner_gonggao';
		$tables[] = 'imeepos_runner_runner_log';
		$tables[] = 'imeepos_runner_markets';
		$tables[] = 'imeepos_runner_member';
		$tables[] = 'imeepos_runner_member_level';
		$tables[] = 'imeepos_runner_member_paylog';
		$tables[] = 'imeepos_runner_member_profile';
		$tables[] = 'imeepos_runner_msg_template';
		$tables[] = 'imeepos_runner_msg_template_data';
		$tables[] = 'imeepos_runner_my_certify';
		$tables[] = 'imeepos_runner_my_services';
		$tables[] = 'imeepos_runner_nav';
		$tables[] = 'imeepos_runner_paylog';
		$tables[] = 'imeepos_runner_rule';
		$tables[] = 'imeepos_runner_runner';
		$tables[] = 'imeepos_runner_runner_level';
		$tables[] = 'imeepos_runner_services';
		$tables[] = 'imeepos_runner_settings';
		$tables[] = 'imeepos_runner_sms';
		$tables[] = 'imeepos_runner_tasks';
    $tables[] = 'imeepos_runner_log';
		$tables[] = 'imeepos_runner_tasks_comment';
		$tables[] = 'imeepos_runner_tasks_recive';
		$tables[] = 'imeepos_runner_users_invitecode';
		
		cloud_update_table($tables,'imeepos_runner');
		
  $auth = getAuthSet($this->modulename);
  $versionfile =IA_ROOT . '/addons/'.$this->modulename.'/version.php';
  if (is_file($versionfile)){
    $updatedate =date('Y-m-d H:i', filemtime($versionfile));
  }else{
    $updatedate =date('Y-m-d H:i', filemtime($versionfile));
  }

  set_time_limit(0);
  $auth = getAuthSet($this->modulename);
  global $my_scenfiles;
  my_scandir(IA_ROOT.'/addons/'.$this->modulename.'/');
  $files =array();
  foreach($my_scenfiles as $sf){
    $files[] =array('path' => str_replace(IA_ROOT."/addons/".$this->modulename."/","",$sf), 'md5'=> md5_file($sf));
  }
  $files =base64_encode(json_encode($files));
  $resp =ihttp_post('http://meepo.com.cn/meepo/module/check.php',array('ip'=>$auth['ip'], 'id'=>$auth['id'], 'code'=>$auth['code'], 'domain'=>$auth['domain'], 'version'=>$version, 'files'=>$files ,'module'=>$this->modulename));
  $content = object_to_array(@json_decode($resp['content']));
  
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
  $auth = getAuthSet($this->modulename);
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
    $resp =ihttp_post('http://meepo.com.cn/meepo/module/download.php',array('ip'=>$auth['ip'], 'id'=>$auth['id'], 'code'=>$auth['code'], 'domain'=>$auth['domain'], 'path'=>$path ,'module'=>$this->modulename));
    $ret =object_to_array(@json_decode($resp['content'], true));
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
    
		$updatefile =IA_ROOT."/addons/".$this->modulename."/update.php";
		if(!file_exists($updatefile)){
      mkdirs(dirname($updatefile),"0777");
    }
    file_put_contents($updatefile, base64_decode($upgrade['upgrade']));
    require $updatefile;
		if(file_exists($updatefile)){
      @unlink($updatefile);
    }
    $installfile =IA_ROOT.'/addons/'.$this->modulename.'/install.php';
    if(file_exists($installfile)){
      @unlink($installfile);
    }
		$xmlfile =IA_ROOT.'/addons/'.$this->modulename.'/manifest.xml';
		if(file_exists($xmlfile)){
      @unlink($xmlfile);
    }
    
		file_put_contents(IA_ROOT.'/addons/'.$this->modulename.'/version.php',"<?php if(!defined('VERSION')) {define('VERSION','".$upgrade['version']."');}");
    @rmdirs($tmpdir);
    die(json_encode(array('result'=>2)));
  }
}

?>
