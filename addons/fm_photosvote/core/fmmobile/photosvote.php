<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
		if ($rvote['votepay']==1) {
			$pays = pdo_fetch("SELECT payment FROM " . tablename('uni_settings') . " WHERE uniacid='{$uniacid}' limit 1");
			$pay = iunserializer($pays['payment']);
			
			//付款
			$orderid = date('ymdhis') . random(4, 1);
			$params = array();
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
			$voteordersn = pdo_fetch("SELECT id FROM " . tablename($this->table_log) . " WHERE rid='{$rid}' AND from_user = :from_user AND ordersn = :ordersn ORDER BY id DESC limit 1", array(':from_user'=>$from_user,':ordersn'=>$paymore['ordersn']));
		}
		if (empty($_GPC['paymore'])) {
			if ($cfg['ismiaoxian'] && $cfg['mxnexttime'] != 0) {
				if (!isset($_COOKIE["fm_miaoxian"])) {
					setcookie("fm_miaoxian", 'startmiaoxian', time()+$cfg['mxnexttime']);
					$mxurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('miaoxian', array('rid' => $rid));
					header("location:$mxurl");
					exit;
				}
			}	
		}
		
		//幻灯片
        $banners = pdo_fetchall("SELECT bannername,link,thumb FROM " . tablename($this->table_banners) . " WHERE enabled=1 AND rid= '{$rid}' ORDER BY displayorder ASC");
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
		$keyword = $_GPC['keyword'];
		$tagid = $_GPC['category']['childid'];
		$tagpid = $_GPC['category']['parentid'];
		
		$tags = pdo_fetchall("SELECT * FROM ".tablename($this->table_tags)." WHERE uniacid = :uniacid AND rid = :rid ORDER BY id DESC", array(':uniacid' => $uniacid, ':rid' => $rid));
		$tagname = $this->gettagname($tagid,$tagpid,$rid);
		
		
			$pindex = max(1, intval($_GPC['page']));
			$psize = empty($rdisplay['indextpxz']) ? 10 : $rdisplay['indextpxz'];
			//取得用户列表
			$where = '';
			if (!empty($keyword)) {				
					if (is_numeric($keyword)) 
						$where .= " AND uid = '".$keyword."'";
					else 				
						$where .= " AND (nickname LIKE '%{$keyword}%' OR realname LIKE '%{$keyword}%' )";
			}
			
			$where .= " AND status = '1'";
			
			if (!empty($tagid)) {
				$where .= " AND tagid = '".$tagid."'";
			}elseif (!empty($tagpid)) {
				$where .= " AND tagpid = '".$tagpid."'";
			}
			
			if ($_GPC['indexorder'] == 4) {
					$where .= " ORDER BY `hits` + `xnhits` DESC";
			}else {
				if ($rdisplay['indexorder'] == '1') {
					$where .= " ORDER BY `createtime` DESC";
				}elseif ($rdisplay['indexorder'] == '11') {
					$where .= " ORDER BY `createtime` ASC";
				}elseif ($rdisplay['indexorder'] == '2') {
					$where .= " ORDER BY `uid` DESC";
				}elseif ($rdisplay['indexorder'] == '22') {
					$where .= " ORDER BY `uid` ASC";
				}elseif ($rdisplay['indexorder'] == '3') {
					$where .= " ORDER BY `photosnum` + `xnphotosnum` DESC";
				}elseif ($rdisplay['indexorder'] == '33') {
					$where .= " ORDER BY `photosnum` + `xnphotosnum` ASC";
				}elseif ($rdisplay['indexorder'] == '4') {
					$where .= " ORDER BY `hits` + `xnhits` DESC";
				}elseif ($rdisplay['indexorder'] == '44') {
					$where .= " ORDER BY `hits` + `xnhits` ASC";
				}elseif ($rdisplay['indexorder'] == '5') {
					$where .= " ORDER BY `vedio` DESC, `music` DESC, `uid` DESC";
				}else {
					$where .= " ORDER BY `uid` DESC";
				}
			}
			if ($rbasic['templates'] == 'stylebase') {
				$userlist = pdo_fetchall('SELECT * FROM '.tablename($this->table_users).' WHERE rid = :rid '.$where.' limit '.$rdisplay['indextpxz'], array(':rid' => $rid) );
			}else{
				$userlist = pdo_fetchall('SELECT * FROM '.tablename($this->table_users).' WHERE rid = :rid  '.$where.' LIMIT  ' . ($pindex - 1) * $psize . ',' . $psize, array(':rid' => $rid) );
			}

			$total = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_users).' WHERE rid = :rid '.$where.'', array(':rid' => $rid));
			$total_pages = ceil($total/$psize);
			$pager = pagination($total, $pindex, $psize, '', array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
		
		if (!empty($fromuser)) {
			$titem = pdo_fetch("SELECT * FROM ".tablename($this->table_users)." WHERE rid = :rid AND from_user = :from_user LIMIT 1", array(':rid' => $rid,':from_user' => $fromuser));
			$tcommentnum = $this->getcommentnum($rid, $uniacid,$fromuser);
		}
		
		//查询自己是否参与活动
		if(!empty($from_user)) {
		    $mygift = pdo_fetch("SELECT * FROM ".tablename($this->table_users)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $from_user,':rid' => $rid));
		    $voteer = pdo_fetch("SELECT realname,mobile FROM ".tablename($this->table_voteer)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $from_user,':rid' => $rid));
		     $mcommentnum = $this->getcommentnum($rid, $uniacid,$from_user);
		}

		//参与活动人数
		//查询分享标题以及内容变量
		//$reply['sharetitle'] = $this->get_share($uniacid,$rid,$from_user,$reply['sharetitle']);
		//$reply['sharecontent'] = $this->get_share($uniacid,$rid,$from_user,$reply['sharecontent']);
		
		//整理数据进行页面显示
		//$myavatar = $avatar;
		//$mynickname = $nickname;
		//$shareurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('shareuserview', array('rid' => $rid,'fromuser' => $from_user));//分享URL
		$regurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('reg', array('rid' => $rid));//关注或借用直接注册页
		$title = $rbasic['title'] . ' ';
		
		
		$fmimage = $this->getpicarr($uniacid,$rid, $from_user,1);
		$_share['link'] = $_W['siteroot'] .'app/'.$this->createMobileUrl('shareuserview', array('rid' => $rid,'fromuser' => $from_user,'tfrom_user' => $from_user));//分享URL
		 $_share['title'] = $this->get_share($uniacid,$rid,$from_user,$rshare['sharetitle']);
		$_share['content'] =  $this->get_share($uniacid,$rid,$from_user,$rshare['sharecontent']);
		$_share['imgUrl'] = $this->getphotos($rshare['sharephoto'] , $rshare['sharephoto'], $rshare['sharephoto']);

		
		$templatename = $rbasic['templates'];
		if ($templatename != 'default' && $templatename != 'stylebase') {
			require FM_CORE. 'fmmobile/tp.php';
		}
		$toye = $this->templatec($templatename,$_GPC['do']);
		include $this->template($toye);
		