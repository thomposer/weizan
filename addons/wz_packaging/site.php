<?php
/**
 * 云打包模块微站定义
 *
 * @author 包打
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class Wz_packagingModuleSite extends WeModuleSite {

	public function doWebPack() {
		global $_W, $_GPC;
		if(!$_W['isfounder']){
			message('抱歉，您不是超级管理员，不能使用此功能！');
		}
		load()->func('communication');
		$sql = 'SELECT name,title FROM ' . tablename('modules') . ' WHERE `type` <> :type and `name` <> :name';
		$modules = pdo_fetchall($sql, array(':type' => 'system',':name' => 'wz_packaging'), 'name');
		$tables  = pdo_fetchall("show tables");
		$table = pdo_fetch("SELECT DATABASE()");
		$tbj = "Tables_in_".$table["DATABASE()"];
		if (checksubmit('submit')){
			$name=trim($_GPC['mname']);
			if(empty($name)){message('请选择要打包的模块！');}
			$type=trim($_GPC['type']);
			$sql =$_GPC['tables'];
			$bindings=pdo_fetchall("SELECT * FROM " . tablename('modules_bindings') . " WHERE module = :module", array(':module' => $name));
            $module=pdo_get('modules',array('name'=>$name));
			$module['subscribes']=iunserializer($module['subscribes']);
			$module['handles']   =iunserializer($module['handles']);
			$installs='';
			$uninstalls='';
			if(!empty($sql)){
				    foreach($sql as  $row){
	                $in=pdo_fetch('show create table '.$row);
	                $installs.=$in['Create Table'];
	                $installs.=";\n";
	                $uninstalls.="DROP TABLE IF EXISTS `".$row."`;\n";
                }
			}
			$installs=str_replace("CREATE TABLE","CREATE TABLE IF NOT EXISTS",$installs);
			$manifest=array();
			$zipname=random(8).$name;
			$manifest['bindings']=$bindings;
			$manifest['module']=$module;
			$manifest['istall']=base64_encode($installs);
			$manifest['uninstall']=base64_encode($uninstalls);
			$manifest['zipname']=$zipname;
			$manifest['url']=rtrim($_W['siteroot'], '/');
			$fname =IA_ROOT . "/data/".$zipname.".zip";
            $zip = new ZipArchive();
            $zip->open($fname, ZipArchive::CREATE);
            $zip->addEmptyDir($name);
            addFileToZipp(IA_ROOT . '/addons/' .$name,$zip,IA_ROOT . '/addons/');
            $zip->close();
			$api="http://yun.012wz.com/web/index.php?c=user&a=pack";
			$back=ihttp_request($api, $manifest, array(), 120);
			if($back['content']=='sucess'){
				unlink($fname);
				$data=array(
				    ':name'=>$manifest['module']['name'],
					':version'=>$manifest['module']['version'],
					':url'=>$manifest['url']
				);
				$iframe=$api."&do=ifram&data=.".base64_encode(json_encode($data));
				
			}
			else{
				unlink($fname);
				print_r($back['content']);
				exit;
			}
			
		}
		include $this->template('pack');
	}

}
function addFileToZipp($path,$zip,$rpath){
	foreach(scandir($path) as $afile)
	{
		if($afile=='.'||$afile=='..') continue; 
		if(is_dir($path.'/'.$afile)) 
		{ 				
			addFileToZipp($path.'/'.$afile,$zip,$rpath); 
		} else { 
			$zip->addFile($path.'/'.$afile,str_replace($rpath,"",$path).'/'.$afile);
		} 
	} 
}