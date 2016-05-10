<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 * @time 2016年1月26日 01：35 
 */
defined('IN_IA') or exit('Access Denied');
if ($_GPC['vfrom'] == 'photosvote') {
	$turl = $this->createMobileUrl('photosvote', array('rid' => $rid));
} elseif ($_GPC['vfrom'] == 'tuser') {
	$turl = $this->createMobileUrl('tuser', array('rid' => $rid));
} elseif ($_GPC['vfrom'] == 'tuserphotos') {
	$turl = $this->createMobileUrl('tuserphotos', array('rid' => $rid));
} else {
	$turl = referer();
}

if ($rshare['subscribe'] == 1) {//判断关注情况
	if ($follow != 1) {
		$fmdata = array(
			"success" => -2,
			"linkurl" => empty($_W['account']['subscribeurl']) ? $rshare['shareurl'] : $_W['account']['subscribeurl'],
			"msg" => '请关注后参与活动，3秒后跳转到关注页面...',
		);
		echo json_encode($fmdata);
		exit;	
	}
}
if($now <= $rbasic['tstart_time'] || $now >= $rbasic['tend_time']) {//判断活动时间是否开始及提示
		
	if ($now <= $rbasic['tstart_time']) {
		$fmdata = array(
			"success" => -1,
			"msg" => $rbasic['ttipstart'],
		);
		echo json_encode($fmdata);
		exit;	
	}
	if ($now >= $rbasic['tend_time']) {
		$fmdata = array(
			"success" => -1,
			"msg" => $rbasic['ttipend'],
		);
		echo json_encode($fmdata);
		exit;	
	}
}

//查询是否参与活动
if(!empty($tfrom_user)) {
	$user = pdo_fetch("SELECT uid,realname,nickname,limitsd,photosnum,hits,xnphotosnum,xnhits,createtime  FROM ".tablename($this->table_users)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $tfrom_user,':rid' => $rid));
	if (empty($user)) {
		$url = $_W['siteroot'] .'app/'. $turl;
		//header("location:$url");
		$fmdata = array(
			"success" => -2,
			"linkurl" => $url,
			"msg" => '此用户还没有参与活动，3秒后返回...',
		);
		echo json_encode($fmdata);
		exit;	
	}
	if ($rbasic['isdaojishi']) {
		$limit_dtime = ($now - $user['createtime'])/86400;
		if ($limit_dtime >= $rbasic['votetime'] ) {
			$fmdata = array(
				"success" => -1,
				"msg" => $rbasic['ttipvote'],
			);
			echo json_encode($fmdata);
			exit;	
		}

	}
}else{
	$url = $_W['siteroot'] .'app/'. $turl;
	//header("location:$url");
	$fmdata = array(
		"success" => -2,
		"linkurl" => $url,
		"msg" => '没有此用户，3秒后返回...',
	);
	echo json_encode($fmdata);
	exit;	
}

$starttime=mktime(0,0,0);//当天：00：00：00
$endtime = mktime(23,59,59);//当天：23：59：59
$times = '';
$times .= ' AND createtime >=' .$starttime;
$times .= ' AND createtime <=' .$endtime;

$paymore = empty($_GPC['paymore']) ? '' : $_GPC['paymore'];
$payordersn = empty($_GPC['payordersn']) ? '' : $_GPC['payordersn'];
$voteordersn = empty($_GPC['voteordersn']) ? '' : $_GPC['voteordersn'];

if (!empty($voteordersn)) {
	$fmdata = array(
		"success" => -2,
		"linkurl" => $turl,
		"msg" => '请勿刷票，否则拉入黑名单！',
	);
	echo json_encode($fmdata);
	exit;	
}
$vote_times = !empty($paymore['vote_times']) ? $paymore['vote_times'] : max(1, intval($_GPC['vote_times']));

if (!empty($paymore) && !empty($payordersn) && $rvote['votepay'] == 1 && $_W['account']['level'] == 4) {
	if ($paymore['paystatus'] == 'success' && $paymore['vote'] == '1' && $paymore['votepay'] == '1' && $paymore['ordersn'] == $payordersn['ordersn'] && $paymore['payyz'] == $payordersn['payyz']) {
		$tfrom_user = $paymore['tfrom_user'];
		$votedate = array(
			'uniacid' => $uniacid,
			'rid' => $rid,
			'tptype' => '3',
			'vote_times' => $vote_times,
			'avatar' => $avatar,
			'nickname' => $nickname,
			'from_user' => $from_user,
			'afrom_user' => $fromuser,
			'tfrom_user' => $tfrom_user,
			'ordersn' => $paymore['ordersn'],
			'ip' => getip(),
			'createtime' => $now
		);
		$votedate['iparr'] = getiparr($votedate['ip']);
		pdo_insert($this->table_log, $votedate);
		pdo_update($this->table_users, array('photosnum'=> $user['photosnum']+$vote_times,'hits'=> $user['hits']+$vote_times), array('rid' => $rid, 'from_user' => $tfrom_user,'uniacid' => $uniacid));
		pdo_update($this->table_reply_display, array('ljtp_total' => $rdisplay['ljtp_total']+$vote_times,'cyrs_total' => $rdisplay['cyrs_total']+$vote_times), array('rid' => $rid));//增加总投票 总人气
		if ($_W['account']['level'] == 4 && !empty($rhuihua['messagetemplate'])) {
			$tuservote = array('rid' => $rid,'tfrom_user' => $tfrom_user,'from_user' => $from_user,'vote_times'=> $vote_times, 'nickname' => $nickname,'realname' => $nickname,'createtime' => $now);
			$messagetemplate = $rhuihua['messagetemplate'];
			$this->sendMobileVoteMsg($tuservote,$from_user, $messagetemplate);
		}
		$user['realname'] = !empty($user['realname']) ? $user['realname'] : $user['nickname'] ;
				
				
		$str = array('#编号#'=>$user['uid'],'#参赛人名#'=>$user['realname'],'#投票票数#'=>$vote_times);
		$res = strtr($rvote['votesuccess'],$str);										
		$msg = '恭喜您成功的为编号为： '.$user['uid'].' ,姓名为： '.$user['realname'].' 的参赛者投了 '.$vote_times.' 票！';
		$msg = empty($res) ? $msg : $res ;
		$nowuser = pdo_fetch("SELECT photosnum, xnphotosnum FROM ".tablename($this->table_users)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $tfrom_user,':rid' => $rid));
		$photosnum = $nowuser['photosnum'] + $nowuser['xnphotosnum'];
		$ljtp = $rdisplay['ljtp_total'] + $rdisplay['xunips'];//累计投票
		$cyrs = $rdisplay['cyrs_total'] + $rdisplay['xuninum'];//累计人气
		
		$fmdata = array(
			"success" => 1,
			"photosnum" => $photosnum,
			"ljtp" => $ljtp+$vote_times,
			"cyrs" => $cyrs+$vote_times,
			"msg" => $msg,
			"linkurl" => $turl
		);
		echo json_encode($fmdata);
		exit;
	}
}else{
	if($_GPC['vote'] == '1') {
		if (empty($from_user)) {
			$fmdata = array(
					"success" => -1,
					"msg" => '投票人出错'
				);
			echo json_encode($fmdata);
			exit();
		}
		if ($tfrom_user == $from_user) {//自己不能给自己投票
			$msg = '您不能为自己投票';
			$fmdata = array(
				"success" => -1,
				"msg" => $msg,
			);
			echo json_encode($fmdata);
			exit;	
		}
		if (!empty($rvote['limitsd']) && !empty($rvote['limitsdps'])) {// 全体投票限速
			$zf = date('H',time()) * 60 + date('i',time());
			$timeduan = intval((1440 / $rvote['limitsd'])*($zf / 1440));//总时间段 288 当前时间段
			$cstime = $timeduan*$rvote['limitsd'] * 60+mktime(0,0,0);//初始限制时间
			$jstime = ($timeduan+1)*$rvote['limitsd'] * 60+mktime(0,0,0);//结束限制时间


			$tptimes = '';
			$tptimes .= ' AND createtime >=' .$cstime;
			$tptimes .= ' AND createtime <=' .$jstime;
			$limitsdvote = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE tfrom_user = :tfrom_user AND rid = :rid '.$tptimes.' ORDER BY createtime DESC', array(':tfrom_user' => $tfrom_user, ':rid' => $rid));	// 全体当前时间段投票总数


			if ($cstime > 0) {
				if ($limitsdvote >= $rvote['limitsdps']) {
					$msg = '亲，投票的速度太快了';
					$fmdata = array(
						"success" => -1,
						"msg" => $msg,
					);
					echo json_encode($fmdata);
					exit;	
				}
			}
		}
		if (!empty($user['limitsd'])){//个人单独投票限速
			$zf = date('H',time()) * 60 + date('i',time());
			$timeduan = intval((1440 / $user['limitsd'])*($zf / 1440));//总时间段 288 当前时间段
			$cstime = $timeduan*$user['limitsd'] * 60+mktime(0,0,0);//初始限制时间
			$jstime = ($timeduan+1)*$user['limitsd'] * 60+mktime(0,0,0);//结束限制时间


			$tptimesgr = '';
			$tptimesgr .= ' AND createtime >=' .$cstime;
			$tptimesgr .= ' AND createtime <=' .$jstime;
			$limitsdvotegr = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE tfrom_user = :tfrom_user AND rid = :rid '.$tptimesgr.' ORDER BY createtime DESC', array(':tfrom_user' => $tfrom_user, ':rid' => $rid));	//每几分钟投几票 个人
			if ($user['limitsd'] > 0)  {
				if ($limitsdvotegr >= 1) {
					$msg = '亲，您投票的速度太快了';
					$fmdata = array(
						"success" => -1,
						"msg" => $msg,
					);
					echo json_encode($fmdata);
					exit;	
				}
			}
		}
		if (!empty($rvote['usersmostvote'])) {
			if (time() <= $rvote['voteendtime'] && time() > $rvote['votestarttime']) {
				$usersmostvote = pdo_fetch('SELECT photosnum, xnphotosnum FROM '.tablename($this->table_users).' WHERE from_user = :tfrom_user AND rid = :rid limit 1', array(':tfrom_user' => $tfrom_user, ':rid' => $rid));	//总共可以参赛者总共可以得票数
				$mostvote = $usersmostvote['photosnum'] + $usersmostvote['xnphotosnum'];
				if ($mostvote >= $rvote['usersmostvote']) { //总共可以参赛者总共可以得票数
					$msg = '在 '.date('Y年m月d日', $rvote['votestarttime']) .' ~ '. date('Y年m月d日', $rvote['voteendtime']) .'期间，Ta总共可以获得 '.$rvote['usersmostvote'].' 票，无法在增加票数，感谢您的参与！';
					$fmdata = array(
						"success" => -1,
						"msg" => $msg,
					);
					echo json_encode($fmdata);
					exit;	
				}
			}
			
		}

		$fansmostvote = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE from_user = :from_user AND rid = :rid ORDER BY createtime DESC', array(':from_user' => $from_user, ':rid' => $rid));	//总共可以投几次
		if ($fansmostvote >= $rvote['fansmostvote']) { //活动期间一共可以投多少次票限制（全部人）
			$msg = '在此活动期间，你总共可以投 '.$rvote['fansmostvote'].' 次，目前你已经投完！';
			$fmdata = array(
				"success" => -1,
				"msg" => $msg,
			);
			echo json_encode($fmdata);
			exit;	
		}
		$daytpxz = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE from_user = :from_user AND rid = :rid '.$times.' ORDER BY createtime DESC', array(':from_user' => $from_user,':rid' => $rid));
		if ($daytpxz >= $rvote['daytpxz']) {//每天总共投票的次数限制（全部人）
			$msg = '您每天最多可以投 '.$rvote['daytpxz'].' 次，您当天的次数已经投完，请明天再来';
			$fmdata = array(
				"success" => -1,
				"msg" => $msg,
			);
			echo json_encode($fmdata);
			exit;	
		}
		$allonetp = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE from_user = :from_user AND tfrom_user = :tfrom_user AND rid = :rid ORDER BY createtime DESC', array(':from_user' => $from_user, ':tfrom_user' => $tfrom_user,':rid' => $rid));
		if ($allonetp >= $rvote['allonetp']) {//在活动期间，给某个人总共投的票数限制（单个人）
			$msg = '您总共可以给他投 '.$rvote['allonetp'].' 次，您已经投完！';
			$fmdata = array(
				"success" => -1,
				"msg" => $msg,
			);
			echo json_encode($fmdata);
			exit;	
		}
		$dayonetp = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE from_user = :from_user AND tfrom_user = :tfrom_user AND rid = :rid '.$times.' ORDER BY createtime DESC', array(':from_user' => $from_user, ':tfrom_user' => $tfrom_user,':rid' => $rid));
		if ($dayonetp >= $rvote['dayonetp']) {//每天总共可以给某个人投的票数限制（单个人）
			$msg = '您当天最多可以给他投 '.$rvote['dayonetp'].' 次，您已经投完，请明天再来';
			$fmdata = array(
				"success" => -1,
				"msg" => $msg,
			);
			echo json_encode($fmdata);
			exit;	
		}

		if ($rvote['unimoshi'] == 1) {
			$fansmostvote = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE uniacid = '.$uniacid.' AND from_user = :from_user AND rid = :rid ORDER BY createtime DESC', array(':from_user' => $from_user, ':rid' => $rid));	//总共可以投几次
			if ($fansmostvote >= $rvote['uni_fansmostvote']) { //活动期间一共可以投多少次票限制（全部人）
				$msg = '在此活动期间，你总共可以投 '.$rvote['uni_fansmostvote'].' 次，目前你已经投完！';
				$fmdata = array(
					"success" => -1,
					"msg" => $msg,
				);
				echo json_encode($fmdata);
				exit;	
			}
			$daytpxz = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE uniacid = '.$uniacid.' AND from_user = :from_user AND rid = :rid '.$times.' ORDER BY createtime DESC', array(':from_user' => $from_user,':rid' => $rid));
			if ($daytpxz >= $rvote['uni_daytpxz']) {//每天总共投票的次数限制（全部人）
				$msg = '您每天最多可以投 '.$rvote['uni_daytpxz'].' 次，您当天的次数已经投完，请明天再来';
				$fmdata = array(
					"success" => -1,
					"msg" => $msg,
				);
				echo json_encode($fmdata);
				exit;	
			}
			$allonetp = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE uniacid = '.$uniacid.' AND from_user = :from_user AND tfrom_user = :tfrom_user AND rid = :rid ORDER BY createtime DESC', array(':from_user' => $from_user, ':tfrom_user' => $tfrom_user,':rid' => $rid));
			if ($allonetp >= $rvote['uni_allonetp']) {//在活动期间，给某个人总共投的票数限制（单个人）
				$msg = '您总共可以给他投 '.$rvote['uni_allonetp'].' 次，您已经投完！';
				$fmdata = array(
					"success" => -1,
					"msg" => $msg,
				);
				echo json_encode($fmdata);
				exit;	
			}
			$dayonetp = pdo_fetchcolumn('SELECT COUNT(1) FROM '.tablename($this->table_log).' WHERE uniacid = '.$uniacid.' AND from_user = :from_user AND tfrom_user = :tfrom_user AND rid = :rid '.$times.' ORDER BY createtime DESC', array(':from_user' => $from_user, ':tfrom_user' => $tfrom_user,':rid' => $rid));
			if ($dayonetp >= $rvote['uni_dayonetp']) {//每天总共可以给某个人投的票数限制（单个人）
				$msg = '您当天最多可以给他投 '.$rvote['uni_dayonetp'].' 次，您已经投完，请明天再来';
				$fmdata = array(
					"success" => -1,
					"msg" => $msg,
				);
				echo json_encode($fmdata);
				exit;	
			}
		}
		if ($rvote['votenumpiao']==1 || $rvote['voteerinfo']==1) {
			if ($_GPC['up_voteer'] == 1 && $rvote['voteerinfo'] == 1) {
				$voteer = pdo_fetch("SELECT id,realname,mobile FROM ".tablename($this->table_voteer)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $from_user,':rid' => $rid));
				
				if (empty($_GPC['vote_user_realname'])) {
					//message('您的真实姓名没有填写，请填写！');
					$msg = '您的真实姓名没有填写，请填写！';
					$fmdata = array(
						"success" => -1,
						"msg" => $msg,
					);
					echo json_encode($fmdata);
					exit();	
				}
			
				if(!preg_match(REGULAR_MOBILE, $_GPC['vote_user_mobile'])) {
					//message('必须输入手机号，格式为 11 位数字。');
					$msg = '必须输入手机号，格式为 11 位数字。';
					$fmdata = array(
						"success" => -1,
						"msg" => $msg,
					);
					echo json_encode($fmdata);
					exit();	
				}
			
				if ($voteer['realname']) {
					if ($voteer['realname'] == $_GPC['vote_user_realname']) {
					
					}else {
						$realname = pdo_fetch("SELECT * FROM ".tablename($this->table_voteer)." WHERE realname = :realname and rid = :rid", array(':realname' => $_GPC['vote_user_realname'],':rid' => $rid));
						if (!empty($realname)) {
							//message('您的真实姓名已经参赛，请重新填写！');
							$msg = '已经存在改姓名';
							$fmdata = array(
								"success" => -1,
								"msg" => $msg,
							);
							echo json_encode($fmdata);
							exit();	
						}
					}
				
				}
				
		
				if ($voteer['mobile']) {
					if ($voteer['mobile'] == $_GPC['vote_user_mobile']) {
					
					}else {
						$ymobile = pdo_fetch("SELECT * FROM ".tablename($this->table_voteer)." WHERE mobile = :mobile and rid = :rid", array(':mobile' => $_GPC['vote_user_mobile'],':rid' => $rid));
						if(!empty($ymobile)) {
							$msg = '非常抱歉，此手机号码已经被注册，你需要更换注册手机号！';
							$fmdata = array(
								"success" => -1,
								"msg" => $msg,
							);
							echo json_encode($fmdata);
							exit();	
						}
					}
				}
				$voteer_data = array(
					'uniacid' => $uniacid,
					'weid' => $uniacid,
					'rid' => $rid,
					'from_user' => $from_user,
					'nickname' => $nickname,
					'avatar' => $avatar,
					'sex' => $sex,
					'realname' => $_GPC['vote_user_realname'],
					'mobile' => $_GPC['vote_user_mobile'],
					'status' => '1',
					'ip' => getip(),
					'createtime' => time(),
				);
				$voteer_data['iparr'] = getiparr($voteer_data['ip']);
				if (empty($voteer)) {
					pdo_insert($this->table_voteer, $voteer_data);
				}else{
					pdo_update($this->table_voteer, array('realname'=>$_GPC['vote_user_realname'],'mobile' => $_GPC['vote_user_mobile']),array('from_user'=>$from_user,'rid'=>$rid));
				}
			}
		}
		if ($_GPC['votepay'] == 1 && $_GPC['paystatus'] != 'success') {
			//付款
			$params = iunserializer(base64_decode($_GPC['params']));
			$price = $params['fee'] * $vote_times;
			$datas = array(
				'uniacid' => $uniacid,
				'weid' => $uniacid,
				'rid' => $rid,
				'from_user' => $params['user'],
				'tfrom_user' => $tfrom_user,
				'ordersn' => $params['ordersn'],
				'payyz' => '',
				'title' => $params['title'],
				'price' => $price,
				'vote_times' => $vote_times,
				'realname' => $nickname,
				'status' => '0',
				'paytype' => '2',
				'createtime' => time(),
			);
			pdo_insert($this->table_order, $datas);
			$log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
			//在pay方法中，要检测是否已经生成了paylog订单记录，如果没有需要插入一条订单数据
			//未调用系统pay方法的，可以将此代码放至自己的pay方法中，进行漏洞修复
			if (empty($log)) {
		        $log = array(
		                'uniacid' => $_W['uniacid'],
		                'acid' => $_W['acid'],
		                'openid' => $params['user'],
		                'module' => $this->module['name'], //模块名称，请保证$this可用
		                'tid' => $params['tid'],
		                'fee' => $price,
		                'card_fee' => $price,
		                'status' => '0',
		                'is_usecard' => '0',
		        );
		        pdo_insert('core_paylog', $log);
			}


			$toparams = array();
			$toparams['tid'] = $params['tid'];
			$toparams['rid'] = $params['rid'];
			$toparams['user'] = $params['user'];
			$toparams['fee'] = $price;
			$toparams['title'] = $params['title'];
			$toparams['content'] = $params['content'];
			$toparams['ordersn'] = $params['ordersn'];
			$toparams['module'] = $params['module'];
			$toparams['payyz'] = $params['payyz'];
			$toparams['virtual'] = $params['virtual'];
			$entoparams = base64_encode(json_encode($toparams));
			//setcookie("user_toparams",'');
			//setcookie("user_toparams", $entoparams, time()+120);
			$fmdata = array(
					"success" => 1,
					"flag" => 1,
					"votenum" => $vote_times,
					"votefee" => sprintf('%.2f', $price),
					"params" => $entoparams,
					"toparams" => $toparams,
					"msg" => '付款中',
				);
			echo json_encode($fmdata);
			exit();
		}else{
			$shuapiao = pdo_fetch("SELECT from_user , ip FROM ".tablename($this->table_shuapiao)." WHERE (from_user = :from_user OR ip = :ip) and rid = :rid LIMIT 1", array(':from_user' => $from_user,':ip' => getip(),':rid' => $rid));

			if($from_user == $shuapiao['from_user'] || $shuapiao['ip'] == getip()) {
				$msg = '你已被加入黑名单！';
				$fmdata = array(
					"success" => -1,
					"msg" => $msg,
				);
				echo json_encode($fmdata);
				exit;		
			}else{
				$votedate = array(
					'uniacid' => $uniacid,
					'rid' => $rid,
					'tptype' => '1',
					'vote_times' => $vote_times,
					'avatar' => $avatar,
					'nickname' => $nickname,
					'from_user' => $from_user,
					'afrom_user' => $fromuser,
					'tfrom_user' => $tfrom_user,
					'ip' => getip(),
					'createtime' => $now
				);
				$votedate['iparr'] = getiparr($votedate['ip']);
				pdo_insert($this->table_log, $votedate);
				pdo_update($this->table_users, array('photosnum'=> $user['photosnum']+$vote_times,'hits'=> $user['hits']+$vote_times), array('rid' => $rid, 'from_user' => $tfrom_user));
				pdo_update($this->table_reply_display, array('ljtp_total' => $rdisplay['ljtp_total']+$vote_times,'cyrs_total' => $rdisplay['cyrs_total']+$vote_times), array('rid' => $rid));//增加总投票 总人气
				if ($_W['account']['level'] == 4 && !empty($rhuihua['messagetemplate'])) {
					$tuservote = array('rid' => $rid,'tfrom_user' => $tfrom_user,'from_user' => $from_user,'vote_times' => $vote_times,'nickname' => $nickname,'realname' => $nickname,'createtime' => $now);
					$messagetemplate = $rhuihua['messagetemplate'];
					$this->sendMobileVoteMsg($tuservote,$from_user, $messagetemplate);
				}
				$user['realname'] = !empty($user['realname']) ? $user['realname'] : $user['nickname'] ;
						
						
				$str = array('#编号#'=>$user['uid'],'#参赛人名#'=>$user['realname'],'#投票票数#'=>$vote_times);
				$res = strtr($rvote['votesuccess'],$str);										
				$msg = '恭喜您成功的为编号为： '.$user['uid'].' ,姓名为： '.$user['realname'].' 的参赛者投了 '.$vote_times.' 票！';
				$msg = empty($res) ? $msg : $res ;
				$nowuser = pdo_fetch("SELECT photosnum, xnphotosnum FROM ".tablename($this->table_users)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $tfrom_user,':rid' => $rid));
				$photosnum = $nowuser['photosnum'] + $nowuser['xnphotosnum'];
				$ljtp = $rdisplay['ljtp_total'] + $rdisplay['xunips'];//累计投票
				$cyrs = $rdisplay['cyrs_total'] + $rdisplay['xuninum'];//累计人气
				$fmdata = array(
					"success" => 1,
					"photosnum" => $photosnum,
					"ljtp" => $ljtp+$vote_times,
					"cyrs" => $cyrs+$vote_times,
					"msg" => $msg
				);
				echo json_encode($fmdata);
				exit;
			}
		}
	}
}