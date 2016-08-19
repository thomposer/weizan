<?php
/**
 * 聊天机器人模块定义
 *
 */
defined('IN_IA') or exit('Access Denied');

class Idou_chatModule extends WeModule {
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
	
		if(checksubmit()) {
			$cfg = array(
				'can_voice' => intval($_GPC['can_voice']),
				'api_url' => htmlspecialchars($_GPC['api_url']),
				'api_key' => htmlspecialchars($_GPC['api_key']),
				'enter_tip' => htmlspecialchars($_GPC['enter_tip']),
				'keep_time' => intval($_GPC['keep_time']),
				'exit_keyword' => htmlspecialchars($_GPC['exit_keyword']),
				'exit_tip' => htmlspecialchars_decode($_GPC['exit_tip'])
			);
			if ($this->saveSettings($cfg)) {
				message('保存设置成功', 'refresh', 'success');
			}
			
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}