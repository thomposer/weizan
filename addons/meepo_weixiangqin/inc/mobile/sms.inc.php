<?php
global $_W,$_GCP;
$weid = $_W['uniacid'];
$openid = $_W['openid'];
if(empty($openid)){
   message('请从微信重新进入');
}
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
		if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
			 $url=$this->createMobileUrl('Errorjoin');			
				header("location:$url");
				exit;
		}
		if(strpos($useragent, 'WindowsWechat')){
		    $url=$this->createMobileUrl('Errorjoin');			
				header("location:$url");
				exit;
		}
$res = $this->getusers($weid,$openid);
if($res['telephoneconfirm']=='1'){
   message('你的手机已经验证过了哦！','referer','info');
}
include $this->template('sms');
	