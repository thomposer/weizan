<?php
/**
 * 小明跑腿模块定义
 *
 * @author imeepos
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
if(file_exists(IA_ROOT.'/addons/imeepos_runner/inc/core/init.php')){
	include IA_ROOT.'/addons/imeepos_runner/inc/core/init.php';
}
class Imeepos_runnerModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
	}

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
		include $this->template('settings');
	}

}