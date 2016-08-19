<?php
/**
 * 清明节哀思模块定义
 *
 * @author 海纳百川  012wz.com
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
define('STYLE_PATH','../addons/cgc_qmj/template/style');
class Cgc_qmjModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		 load()->func('tpl');
	
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {    
      
            $input =array();
            $input['copy_right'] = trim($_GPC['copy_right']);
            $input['cnzz'] = htmlspecialchars_decode(trim($_GPC['cnzz']));
            $input['dd_num'] = trim($_GPC['dd_num']); 
            $input['share_thumb'] = trim($_GPC['share_thumb']);    
            $input['share_desc'] = trim($_GPC['share_desc']);             
            $input['share_title'] = trim($_GPC['share_title']); 
            $input['share_url'] = trim($_GPC['share_url']);  
            $input['guanzhu_url'] = trim($_GPC['guanzhu_url']);  
            $input['must_guanzhu'] = trim($_GPC['must_guanzhu']); 
            $input['success_url'] = trim($_GPC['success_url']);   
            $input['title'] = trim($_GPC['title']);   
            $input['music_url'] = trim($_GPC['music_url']);  
            $input['pic1'] = trim($_GPC['pic1']);   
            $input['pic2'] = trim($_GPC['pic2']);   
            $input['pic3'] = trim($_GPC['pic3']);   
            $input['pic4'] = trim($_GPC['pic4']); 
             
            $input['fpic1'] = trim($_GPC['fpic1']);   
            $input['fpic2'] = trim($_GPC['fpic2']);   
            $input['fpic3'] = trim($_GPC['fpic3']);   
            $input['fpic4'] = trim($_GPC['fpic4']);   
            $input['fpic41'] = trim($_GPC['fpic41']);   
            $input['fpic42'] = trim($_GPC['fpic42']);  
            $input['wz'] = trim($_GPC['wz']);  
              
            $input['starttime'] = trim($_GPC['starttime']);    
            $input['endtime'] = trim($_GPC['endtime']);   
            
            $input['dian3'] = trim($_GPC['dian3']);    
            $input['dian'] = trim($_GPC['dian']);   
                
            if($this->saveSettings($input)) {
                message('保存参数成功', 'refresh');
            }
        }
 
     
        include $this->template('setting');
	}

}