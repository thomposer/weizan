<?php

defined('IN_IA') or exit('Access Denied');
class cgc_addr_forwardModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		$settings['fans_regional'] = unserialize($settings['fans_regional']);
		
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			load()->func('file');
			

			
			$fans_regional=array();
			$fans_regional_addr=$_GPC['fans_regional_addr'];
			$fans_regional_url=$_GPC['fans_regional_url'];
			if(is_array($fans_regional)){
				foreach($fans_regional_addr as $key=>$value){
					$d=array(
							'fans_regional_addr'=>$fans_regional_addr[$key],
							'fans_regional_url'=>$fans_regional_url[$key],
					);
					$fans_regional[]=$d;
				}
			}
			if(!empty($fans_regional)){
				$_GPC['fans_regional'] = serialize($fans_regional);
			}
				    
		     
            $input =array();
            $input['default_url'] = trim($_GPC['default_url']);                                          
            $input['fans_regional'] = $_GPC['fans_regional']; 
    
            
            if($this->saveSettings($input)) {
                message('保存参数成功', 'refresh');
            }
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}