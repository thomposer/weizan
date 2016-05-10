<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

		$regtitlearr = iunserializer($rdisplay['regtitlearr']);
		$vfrom = $_GPC['do'];
		if ($rvote['votepay']==1) {
			$pays = pdo_fetch("SELECT payment FROM " . tablename('uni_settings') . " WHERE uniacid='{$uniacid}' limit 1");
			$pay = iunserializer($pays['payment']);
			
			//付款
			$orderid = date('ymdhis') . random(4, 1);
			$params['tid'] = $orderid;
			$params['rid'] = $rid;
			$params['user'] = $from_user;
			$params['fee'] = $rvote['votepayfee'];
			$params['title'] = $rvote['votepaytitle'];
			$params['content'] = $rvote['votepaydes'];
			$params['ordersn'] = $orderid;
			$params['module'] = $_GPC['m'];
			$params['payyz'] = random(8);
			$params['virtual'] = $item['goodstype'] == 2 ? true : false;
			$pparams = base64_encode(iserializer($params));
			if (!empty($_GPC['paymore'])) {
				$paymore = iunserializer(base64_decode(base64_decode($_GPC['paymore'])));
				//print_r($paymore);
			}
			$payordersn = pdo_fetch("SELECT id,payyz,ordersn FROM " . tablename($this->table_order) . " WHERE rid='{$rid}' AND from_user = :from_user AND paytype = 2 ORDER BY id DESC,paytime DESC limit 1", array(':from_user'=>$from_user));
			$voteordersn = pdo_fetch("SELECT id FROM " . tablename($this->table_log) . " WHERE rid='{$rid}' AND from_user = :from_user AND ordersn = :ordersn  AND tptype =3 ORDER BY id DESC limit 1", array(':from_user'=>$from_user,':ordersn'=>$paymore['ordersn']));

		}
		if ($rdisplay['ipannounce'] == 1) {
			$announce = pdo_fetchall("SELECT nickname,content,createtime,url FROM " . tablename($this->table_announce) . " WHERE rid= '{$rid}' ORDER BY id DESC");
		}
		//赞助商
		if ($rdisplay['isvotexq'] == 1) {
			$advs = pdo_fetchall("SELECT advname,link,thumb FROM " . tablename($this->table_advs) . " WHERE enabled=1 AND ismiaoxian = 0 AND rid= '{$rid}' AND issuiji = 1");
			
			if (!empty($advs)) {
				$adv  = array_rand($advs);
				$advarr = array();
				$advarr['thumb'] .= toimage($advs[$adv]['thumb']);
				$advarr['advname'] .= cutstr($advs[$adv]['advname'], '10');
				$advarr['link'] .= $advs[$adv]['link'];
			}
		}
	
		//查询自己是否参与活动
		if(!empty($from_user)) {
		    $mygift = pdo_fetch("SELECT * FROM ".tablename($this->table_users)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $from_user,':rid' => $rid));
		    $voteer = pdo_fetch("SELECT realname,mobile FROM ".tablename($this->table_voteer)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $from_user,':rid' => $rid));
		}
		
		
		
		//查询是否参与活动
		if(!empty($tfrom_user)) {
		    $user = pdo_fetch("SELECT * FROM ".tablename($this->table_users)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $tfrom_user,':rid' => $rid));
		  	if ($user['status'] != 1 && $tfrom_user != $from_user) {
				$urlstatus =  $_W['siteroot'] .'app/'.$this->createMobileUrl('photosvote',array('rid'=> $rid));
				echo "<script>alert('ID:".$user['uid']." 号选手正在审核中，请查看其他选手，谢谢！');location.href='".$urlstatus."';</script>";     
				die();
		  		//message('该选手正在审核中，请查看其他选手，谢谢！',$this->createMobileUrl('photosvote',array('rid'=> $rid)),'error');
		  	}

			$str = array('&'=>'%26');
			$url = $_W['siteroot'] .'app/'.$this->createMobileUrl('shareuserview', array('rid' => $rid,'duli'=> '1', 'fromuser' => $from_user, 'tfrom_user' => $tfrom_user));
			
			$url = $this->dwz($url);			
			$uavatar = toimage($user['avatar']);
			$ewmavatar = $_W['siteroot'] . 'attachment/headimg_'.$_W['acid'].'.jpg';
		
		  	if ($user) {
		  		$paihangcha = $this->GetPaihangcha($rid, $tfrom_user, $rdisplay['indexpx']);
				$yuedu = $from_user.$rid.$uniacid;
				if (time() == mktime(0,0,0)) {
					setcookie("user_yuedu", -10000);
				}
//
				if ($_COOKIE["user_yuedu"] != $yuedu) {
					 pdo_update($this->table_users, array('hits' => $user['hits']+1), array('rid' => $rid, 'from_user' => $tfrom_user));
					 setcookie("user_yuedu", $yuedu, time()+3600*24);
				}
				//print_r($tfrom_user);
		    }else{
				$url = $_W['siteroot'] .'app/'.$this->createMobileUrl('photosvote', array('rid' => $rid));
				header("location:$url");
				exit;
			}
			$tagname = $this->gettagname($user['tagid'],$user['tagpid'],$rid);
		}
		$sharenum = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->table_data)." WHERE tfrom_user = :tfrom_user and rid = :rid", array(':tfrom_user' => $tfrom_user,':rid' => $rid)) + pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->table_data)." WHERE fromuser = :fromuser and rid = :rid", array(':fromuser' => $tfrom_user,':rid' => $rid)) + $user['sharenum'];
		
		//$picarr = $this->getpicarr($uniacid,$reply['tpxz'],$tfrom_user,$rid);
		$fmimage = $this->getpicarr($uniacid,$rid, $tfrom_user,1);
		$picarrs =  pdo_fetchall("SELECT id, photos,from_user,isfm FROM ".tablename($this->table_users_picarr)." WHERE from_user = :from_user AND rid = :rid ORDER BY isfm DESC", array(':from_user' => $user['from_user'],':rid' => $rid));
		$level = $this->fmvipleavel($rid, $uniacid, $user['from_user']);
		if($rbasic['isdaojishi']==1) {
			$starttime=mktime(0,0,0);//当天：00：00：00
			$endtime = mktime(23,59,59);//当天：23：59：59
			$times = '';
			$times .= ' AND createtime >=' .$starttime;
			$times .= ' AND createtime <=' .$endtime;
			
			$uservote = pdo_fetch("SELECT * FROM ".tablename($this->table_log)." WHERE from_user = :from_user  AND tfrom_user = :tfrom_user AND rid = :rid", array(':from_user' => $from_user,':tfrom_user' => $tfrom_user,':rid' => $rid));
			$uallonetp = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename($this->table_log).' WHERE from_user = :from_user AND tfrom_user = :tfrom_user AND rid = :rid  ORDER BY createtime DESC', array(':from_user' => $from_user, ':tfrom_user' => $tfrom_user,':rid' => $rid));
			
			$udayonetp = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename($this->table_log).' WHERE from_user = :from_user AND tfrom_user = :tfrom_user AND rid = :rid '.$times.' ORDER BY createtime DESC', array(':from_user' => $from_user, ':tfrom_user' => $tfrom_user,':rid' => $rid));

		}

		if ($rdisplay['isvoteusers']) {
			$voteuserlist = pdo_fetchall('SELECT avatar,nickname FROM '.tablename($this->table_log).' WHERE rid = :rid  AND tfrom_user = :tfrom_user GROUP BY `nickname` ORDER BY `id` DESC LIMIT 5', array(':rid' => $rid,':tfrom_user' => $tfrom_user));
		}

		if ($rvote['isbbsreply'] == 1) {//开启评论
			//取得用户列表
			$bbsreply = pdo_fetchall("SELECT avatar,nickname,from_user,content,zan,createtime FROM ".tablename($this->table_bbsreply)." WHERE tfrom_user = :tfrom_user AND rid = :rid AND is_del = 0 ORDER BY `id` DESC LIMIT 10",  array(':tfrom_user' => $tfrom_user,':rid' => $rid));
			$btotal = $this->getcommentnum($rid,$uniacid,$tfrom_user);
		}
		if ($rbasic['isdaojishi']) {
			$votetime = $rbasic['votetime']*3600*24;
			$isvtime = TIMESTAMP - $user['createtime'];
			$ttime = $votetime - $isvtime;
			
			if ($ttime > 0) {
				$totaltime = $ttime;
			} else {
				$totaltime = 0;
			}
		}

		$now = time();
		if($now-$rdisplay['xuninum_time']>$rdisplay['xuninumtime']){
		    pdo_update($this->table_reply_display, array('xuninum_time' => $now,'xuninum' => $rdisplay['xuninum']+mt_rand($rdisplay['xuninuminitial'],$rdisplay['xuninumending'])), array('rid' => $rid));
		}
		//虚拟人数据配置
		//参与活动人数
		//$totals = $rdisplay['xuninum'] + pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_users).' WHERE rid=:rid', array(':rid' => $rid));
		//参与活动人数
		//查询分享标题以及内容变量
		//$reply['sharetitle']= $this->get_share($uniacid,$rid,$from_user,$reply['sharetitle']);
		//$reply['sharecontent']= $this->get_share($uniacid,$rid,$from_user,$reply['sharecontent']);
		//整理数据进行页面显示
		//$myavatar = $avatar;
		//$mynickname = $nickname;
		//$shareurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('shareuserview', array('rid' => $rid,'duli'=> '1', 'fromuser' => $from_user, 'tfrom_user' => $tfrom_user));//分享URL
		//$shouquan = base64_encode($_SERVER ['HTTP_HOST'].'anquan_ma_photosvote');
		//$title = $unrname . ' 的投票详情！';
		$unrname = !empty($user['realname']) ? $user['realname'] : $user['nickname'] ;
		
		$title = $unrname . '正在参加'. $rbasic['title'] .'，快来为'.$unrname.'投票及拉票吧！';
		
		//$sharetitle = $unrname . '正在参加'. $rbasic['title'] .'，快来为'.$unrname.'投票及拉票吧！';
		//$sharecontent = $unrname . '正在参加'. $rbasic['title'] .'，快来为'.$unrname.'投票及拉票吧！';
		//$picture =  toimage($rshare['sharephoto']);
		
		
		
		$_share['link'] =$_W['siteroot'] .'app/'.$this->createMobileUrl('shareuserview', array('rid' => $rid,'duli'=> '1', 'fromuser' => $from_user, 'tfrom_user' => $tfrom_user));//分享URL
		 $_share['title'] = $unrname . '正在参加'. $rbasic['title'] .'，快来为'.$unrname.'投票及拉票吧！';
		$_share['content'] = $unrname . '正在参加'. $rbasic['title'] .'，快来为'.$unrname.'投票及拉票吧！';
		//$_share['imgUrl'] = !empty($user['photo']) ? toimage($user['photo']) : toimage($user['avatar']);
		$_share['imgUrl'] =  $this->getphotos($fmimage['photos'],$user['avatar'],  $rbasic['picture']);
		
		
		
		
		$templatename = $rbasic['templates'];
		if ($templatename != 'default' && $templatename != 'stylebase') {
			require FM_CORE. 'fmmobile/tp.php';
		}
		$toye = $this->templatec($templatename,$_GPC['do']);
		include $this->template($toye);
		
