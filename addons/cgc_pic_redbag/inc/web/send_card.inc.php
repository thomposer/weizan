<?php


 function getJsApiTicket($access_token,$acid){
		$cachekey = "wx_card_jsticket:$acid";
		$cache = cache_load($cachekey);
		if(!empty($cache) && !empty($cache['ticket']) && $cache['expire'] > TIMESTAMP) {
			return $cache['ticket'];
		}
	
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=wx_card";
		$content = ihttp_get($url);
		if(is_error($content)) {
			return error(-1, '调用接口获取微信公众号 jsapi_ticket 失败, 错误信息: ' . $content['message']);
		}
		$result = @json_decode($content['content'], true);
		if(empty($result) || intval(($result['errcode'])) != 0 || $result['errmsg'] != 'ok') {
			return error(-1, '获取微信公众号 jsapi_ticket 结果错误, 错误信息: ' . $result['errmsg']);
		}
		$record = array();
		$record['ticket'] = $result['ticket'];
		$record['expire'] = TIMESTAMP + $result['expires_in'] - 200;
		
		cache_write($cachekey, $record);
		return $record['ticket'];
	}



   global $_W, $_GPC;  
   $settings=$this->module['config'];  
   load()->func('tpl');
   $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
   $uniacid=$_W["uniacid"];
   $id=$_GPC['id'];	
   
   $settings=$this->module['config'];
   
   if ($op=='send') { 		
  		
  global $_W,$_GPC;
  $weid=$_W['uniacid'];
  $settings=$this->module['config'];        
  $openid=$_GPC['openid'];
  $op=$_GPC['op'];
  
  
   $cgc_pic_redbag=new cgc_pic_redbag(); 
   $pic_user=$cgc_pic_redbag->selectByOpenid($openid);
  
   if (empty($pic_user)){
     $message="你未上传图片";
   	 message($message);
   	 return;     
   }
   
    if (empty($pic_user['sh_status'])){
     $message="你没通过审核";
   	 message($message);
   	 return;     
   }
  
  load()->func('communication');
  load()->classs('weixin.account');
  $WeiXinAccountService = WeiXinAccount :: create($_W['acid']);
  $access_token = $WeiXinAccountService->getAccessToken();
  if(is_error($token)){
   print_r($token);
   exit();
  }
  
  $ticket=getJsApiTicket($access_token,$_W['acid']);
  $card_id= $settings['wx_cardid'];
  if (is_error($ticket)){
    message($ticket['message']);
  } 
  respcard($pic_user['openid'],$card_id,$ACC_TOKEN,$ticket);
 }
 
 if ($op=='post') {	 	  	 	
  	     $id=$_GPC['id'];  	
  	     $cgc_pic_redbag=new cgc_pic_redbag();
  	     if (!empty($id)){
            $item = $cgc_pic_redbag->getOne($id);        
  	     }
  	     
		if (checksubmit('submit')) {			
			  $data=array("uniacid"=>$_W['uniacid'],
             	   "title"=>trim($_GPC['title']), 
             	   "openid"=>trim($_GPC['openid']), 
             	   "headimgurl"=>trim($_GPC['headimgurl']),           
             	   "nickname"=>trim($_GPC['nickname']),  
             	    "realname"=>trim($_GPC['realname']), 
             	   "remark"=>trim($_GPC['remark']), 
             	   "pic"=>trim($_GPC['pic']),             	   
                   "hb_status"=>trim($_GPC['hb_status']),  
                   "city"=>trim($_GPC['city']),             	   
                   "province"=>trim($_GPC['province']),  
                   "addr"=>trim($_GPC['addr']),             	   
                   "tel"=>trim($_GPC['tel']),  
                   "jy_openid"=>trim($_GPC['jy_openid']),
                   "IP"=>getip(),         
             );
             
           
			if (!empty($id)) {				
				$temp=$cgc_pic_redbag->modify($id,$data); 
			 } else{
			   $data['createtime']=TIMESTAMP;
			   $temp=$cgc_pic_redbag->insert($data); 
			 }						
			 message('信息更新成功',$this->createWebUrl('cgc_pic_redbag', array('op' => 'display')), 'success');
		   }
	     
	      include $this->template('cgc_pic_redbag');
		  exit();
		} 
	 
	 if ($op=='delete') {
	 	$id=$_GPC['id'];
	 	$cgc_pic_redbag=new cgc_pic_redbag();
        $cgc_pic_redbag->delete($id); 
        message('删除成功！',referer(), 'success');
	 }
	 
    if ($op=='delete_all') {
           $cgc_pic_redbag=new cgc_pic_redbag();
           $cgc_pic_redbag->deleteAll();  
           message('删除成功！', $this->createWebUrl('cgc_pic_redbag', array('op' => 'display')), 'success');
     }
     
      if ($op=='send_hb') {
	 	$id=$_GPC['id'];
	 	$status;
	 	$msg='';
	 	switch ( $settings['issue_type'] ) {
		case '1'://发积分模式
			$status = sendcredit1($id,$settings);
			$msg ='发送积分成功';
			break;
		case '2'://发余额模式
			$status =sendcredit2($id,$settings);
			$msg ='发送余额成功';
			break;	
		default://发红包模式
			$status =sendhb($id,$settings);
			$msg ='发送红包成功';
			break;
		}
		if(is_error($status)) {
			message($status['message'], $this->createWebUrl('cgc_pic_redbag', array (
				'op' => 'display'
			)), 'success');
		}
		message($msg, $this->createWebUrl('cgc_pic_redbag', array (
			'op' => 'display'
		)), 'success');
	}
	 
	 
	if ($op=='sh') {
	 	$id=$_GPC['id'];
	    $sh_status=empty($_GPC['sh_status'])?1:0;
	 	$cgc_pic_redbag=new cgc_pic_redbag();
        $item=$cgc_pic_redbag->getOne($id); 
        if (empty($item)){
          message("无记录",referer(), 'success');
        }       
   
        $ret=$cgc_pic_redbag->modify($id,array("sh_status"=>$sh_status));        
        if (empty($ret)){
          message("审核失败",referer(), 'info');
        }
        
       if (!empty($settings['sh_info']) && $sh_status){
		 $url =$_W['siteroot']."app/index.php?i={$_W["uniacid"]}&c=entry&m={$this->modulename}&do=user&fromuser={$item['openid']}";
		 $url="<a href='$url'>输入资料</a>";
		 $hb_url =$_W['siteroot']."app/index.php?i={$_W["uniacid"]}&c=entry&m={$this->modulename}&do=send_hb&id=$id";
		 $hb_url="<a href='$hb_url'>领取红包</a>";
		 $card_url =$_W['siteroot']."app/index.php?i={$_W["uniacid"]}&c=entry&m={$this->modulename}&do=wx_card&id=$id";
		 $card_url="<a href='$card_url'>获取卡券</a>";
		 
		 $settings['sh_info']=str_replace("#user_url#",$url,$settings['sh_info']);
         $settings['sh_info']=str_replace("#hb_url#",$hb_url,$settings['sh_info']);
         $settings['sh_info']=str_replace("#card_url#",$card_url,$settings['sh_info']);
         
         post_send_text($item['openid'],$settings['sh_info']); 
       }
           
        message("审核成功",referer(), 'success');
	 }
     
 