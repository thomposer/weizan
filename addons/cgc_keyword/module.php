<?php

defined('IN_IA') or exit('Access Denied');

class cgc_keywordModule extends WeModule {


public function settingsDisplay($settings) {
		global $_W, $_GPC;
		
	   require_once IA_ROOT . "/addons/cgc_keyword/inc/common.php"; 
	    $fansgroup = pdo_fetchall("SELECT * FROM ".tablename("cgc_group_info")." WHERE weid = '{$_W['uniacid']}'");	
		
		 load()->func('tpl');
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			$input['group_success'] = trim(htmlspecialchars_decode($_GPC['group_success'])); 
			$input['city'] = trim($_GPC['city']); 
			$input['city_group_id'] = trim($_GPC['city_group_id']);		
			$input['province'] = trim($_GPC['province']); 			
			$input['province_group_id'] = trim($_GPC['province_group_id']); 			
		    $input['man_group_id'] = trim($_GPC['man_group_id']); 			
			$input['woman_group_id'] = trim($_GPC['woman_group_id']); 								
		    $input['auto_province'] = trim($_GPC['auto_province']); 			
			$input['auto_city'] = trim($_GPC['auto_city']); 			
			$input['group_title'] = trim($_GPC['group_title']);
			$input['group_desc'] = trim($_GPC['group_desc']); 
			$input['group_url'] = trim($_GPC['group_url']);     
			$input['group_thumb'] = trim($_GPC['group_thumb']);  
			$input['top'] = trim($_GPC['top']);			
		    $input['locationtype'] = trim($_GPC['locationtype']);  
			$input['re_group'] = trim($_GPC['re_group']);
			$input['enabled'] = trim($_GPC['enabled']);							       
            if($this->saveSettings($input)) {
                message('保存参数成功', 'refresh');
             }
        }
      
        include $this->template('setting');
    }
    
    public function fieldsFormDisplay($rid = 0) {
		global $_W;
		load()->func('tpl');
		$activity = pdo_fetchall("SELECT * FROM " . tablename('cgc_group_info') . " WHERE weid = :weid", 
		array(':weid' => $_W['uniacid']));
		
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
	  global $_GPC;
		if (empty($_GPC['activity'])){
			return '分组名称不得为空';
		}
		return '';
	}

	public function fieldsFormSubmit($rid) {
		global $_GPC;
		$id = intval($_GPC['activity']);	
		$record = array();
		$record['rid'] = $rid;
		$reply = pdo_fetch("SELECT * FROM " . tablename('cgc_group_info') . " WHERE id = :id", array(':id' => $id));
		if($reply) {
			pdo_update('cgc_group_info', $record, array('id' => $reply['id']));
		}
	}
	
	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
	}

}