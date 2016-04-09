<?php
/**
 * 小明跑腿模块定义
 *
 * @author imeepos
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class Imeepos_runnerModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		$setting = $this->module['config'];
		$path = IA_ROOT . '/addons/imeepos_runner/template/mobile/';
		
		if (is_dir($path)) {
			$apis = array();
			if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						$stylesResults[] = $file;
					}
				}
			}
		}
		foreach ($stylesResults as $item){
			if(file_exists($path.$item.'/preview.png')){
				$stylesResult[] = $item;
			}
		}
		if(!empty($_GPC['name'])){
			$dat = array();
			$dat['name'] = $_GPC['name'];
			$this->saveSettings($dat);
			message('模板设置成功',referer(),'success');
		}
		include $this->template('setting');
	}

}