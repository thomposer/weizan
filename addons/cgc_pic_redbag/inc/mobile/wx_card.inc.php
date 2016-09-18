<?php



	 function getCardTicket_nice($card_id, $openid)
	{
		global $_W, $_GPC;
		$data = pdo_fetch(" SELECT * FROM " . tablename('n1ce_card_ticket') . " WHERE weid='" . $_W['uniacid'] . "' ");
		load()->func('communication');
		load()->classs('weixin.account');
		if ($data['createtime'] < time()) {
			$tokens = WeAccount::token();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . $tokens . "&type=wx_card";
			$res = json_decode($this->httpGet($url));
			$now = TIMESTAMP;
			$now = intval($now) + 7200;
			$ticket = $res->ticket;
			$insert = array('weid' => $_W['uniacid'], 'createtime' => $now, 'ticket' => $ticket);
			if (empty($data)) {
				pdo_insert('n1ce_card_ticket', $insert);
			} else {
				pdo_update('n1ce_card_ticket', $insert, array('id' => $data['id']));
			}
		} else {
			$ticket = $data['ticket'];
		}
		$now = time();
		$timestamp = $now;
		$nonceStr = "ffadadadaddadadadad";
		$card_id = $card_id;
		$openid = $openid;

		$arr = array($card_id,$openid, $ticket, $nonceStr, $openid, $timestamp);
		asort($arr, SORT_STRING);
		$sortString = "";
		foreach ($arr as $temp) {
			$sortString = $sortString . $temp;
		}
		$signature = sha1($sortString);
		$cardArry = array('code' => $openid, 'openid' => $openid, 'timestamp' => $now, 'signature' => $signature, 'cardId' => $card_id, 'ticket' => $ticket, 'nonceStr' => $nonceStr);
		return $cardArry;
	}



  global $_W,$_GPC;
  $weid=$_W['uniacid'];
  $settings=$this->module['config'];        
  $modulename=$this->modulename; 
  $userinfo=getFromUser($settings,$modulename);
  $userinfo=json_decode($userinfo,true);
  $openid=$userinfo['openid'];
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

  $card_id= $settings['wx_cardid'];
  $openid = $member['openid'];
  

  $WeiXinAccountService = WeiXinAccount :: create($_W['acid']);
  
  $access_token = $WeiXinAccountService->getAccessToken();
  $ticket=getCardTicket($access_token);
  
  if (is_error($ticket)){
    message($ticket['message']);
  }
   
    
  $now = time();
  $timestamp = $now;
  $nonceStr ="ffadadadaddadadadad";
 
  $code=$openid;
  $arr = array($card_id, $code,$ticket, $nonceStr, $openid, $timestamp);
  asort($arr, SORT_STRING);
  $sortString = "";
  foreach ($arr as $temp) {
    $sortString = $sortString . $temp;
  }
  
  $signature = sha1($sortString);
  $cardArry = array('code' => $code, 'openid' => $openid, 'timestamp' => $now, 'signature' => $signature, 'cardId' => $card_id, 'ticket' => $ticket, 'nonceStr' => $nonceStr);
  
  include $this->template("wx_card");
  



 
