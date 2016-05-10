<?php
/**
 * 女神来了模块定义
 */
defined('IN_IA') or exit('Access Denied');

$op = !empty($op) ? $op : $_GPC['op'];
$op = in_array($op, array('rshare', 'rhuihua', 'rdisplay', 'rvote', 'rbody', 'rupload', 'rjifen', 'rstar')) ? $op : 'rshare';

			if (!empty($rdisplay['regtitlearr'])) {
				$regtitlearr = iunserializer($rdisplay['regtitlearr']);
			}
if ($op == 'rshare') {
	$rshare = pdo_fetch("SELECT * FROM ".tablename($this->table_reply_share)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	$rshare['subscribedes'] = empty($rshare['subscribedes']) ? "请长按二维码关注或点击“关注投票”，前往".$_W['account']['name']."为您的好友投票。" : $rshare['subscribedes'];		
	$rshare['sharephoto'] = empty($rshare['sharephoto']) ? FM_STATIC_MOBILE . "public/images/pimages.jpg" : $rshare['sharephoto'];
	
	if (checksubmit('submit')) {

		$insert_share = array(
			'rid' => $rid,
			'subscribe' => $_GPC['subscribe'] == 'on' ? 1 : 0,
			'shareurl' => $_GPC['shareurl'],
			'sharetitle' => $_GPC['sharetitle'],
			'sharephoto' => $_GPC['sharephoto'],
			'sharecontent' => $_GPC['sharecontent'],
			'subscribedes' => $_GPC['subscribedes']
		);
		if (!empty($rshare['rid'])) {
			pdo_update($this->table_reply_share, $insert_share, array('rid' => $rid));
		} else {
			pdo_insert($this->table_reply_share, $insert_share);
		}
		message('更新成功！', referer(), 'success');
	}
} elseif ($op == 'rhuihua') {
	$rhuihua = pdo_fetch("SELECT * FROM ".tablename($this->table_reply_huihua)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	$rhuihua['command'] = empty($rhuihua['command']) ? "报名" : $rhuihua['command'];
	$rhuihua['tcommand'] = empty($rhuihua['tcommand']) ? "t" : $rhuihua['tcommand'];		
	if (checksubmit('submit')) {
		$insert_huihua = array(
			'rid' => $rid,
			'command' => $_GPC['command'],
			'tcommand' => $_GPC['tcommand'],
			'ishuodong' => $_GPC['ishuodong'],
			'huodongname' => $_GPC['huodongname'],
			'huodongdes' => $_GPC['huodongdes'],
			'hhhdpicture' => $_GPC['hhhdpicture'],
			'huodongurl' => $_GPC['huodongurl'],
			'regmessagetemplate' => $_GPC['regmessagetemplate'],
			'messagetemplate' => $_GPC['messagetemplate'],
			'shmessagetemplate' => $_GPC['shmessagetemplate'],
			'fmqftemplate' => $_GPC['fmqftemplate'],
			'msgtemplate' => $_GPC['msgtemplate']
		);
		if (!empty($rhuihua['rid'])) {
			pdo_update($this->table_reply_huihua, $insert_huihua, array('rid' => $rid));
		} else {
			pdo_insert($this->table_reply_huihua, $insert_huihua);
		}
		message('更新成功！', referer(), 'success');
	}
} elseif ($op == 'rdisplay') {
	$rdisplay = pdo_fetch("SELECT * FROM ".tablename($this->table_reply_display)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	if (!empty($rdisplay['regtitlearr'])) {
		$regtitlearr = iunserializer($rdisplay['regtitlearr']);
	}
	$rdisplay['indexorder'] = !isset($rdisplay['indexorder']) ? "1" : $rdisplay['indexorder'];
	$rdisplay['indexpx'] = !isset($rdisplay['indexpx']) ? "0" : $rdisplay['indexpx'];
	$rdisplay['indextpxz'] = empty($rdisplay['indextpxz']) ? "10" : $rdisplay['indextpxz'];
	$rdisplay['phbtpxz'] = empty($rdisplay['phbtpxz']) ? "10" : $rdisplay['phbtpxz'];
	$rdisplay['isindex'] = !isset($rdisplay['isindex']) ? "1" : $rdisplay['isindex'];
	$rdisplay['isrealname'] = !isset($rdisplay['isrealname']) ? "1" : $rdisplay['isrealname'];
	$rdisplay['ismobile'] = !isset($rdisplay['ismobile']) ? "1" : $rdisplay['ismobile'];
	$rdisplay['isjob'] = !isset($rdisplay['isjob']) ? "1" : $rdisplay['isjob'];
	$rdisplay['isxingqu'] = !isset($rdisplay['isxingqu']) ? "1" : $rdisplay['isxingqu'];
	$rdisplay['isfans'] = !isset($rdisplay['isfans']) ? "1" : $rdisplay['isfans'];
	$rdisplay['copyrighturl'] = empty($rdisplay['copyrighturl']) ? "http://".$_SERVER ['HTTP_HOST'] : $rdisplay['copyrighturl'];
	$rdisplay['copyright'] = empty($rdisplay['copyright']) ? $_W['account']['name'] : $rdisplay['copyright'];
	$rdisplay['xuninum'] = !isset($rdisplay['xuninum']) ? "0" : $rdisplay['xuninum'];
	$rdisplay['csrs_total'] = !isset($rdisplay['csrs_total']) ? "0" : $rdisplay['csrs_total'];
	$rdisplay['ljtp_total'] = !isset($rdisplay['ljtp_total']) ? "0" : $rdisplay['ljtp_total'];
	$rdisplay['xuninumtime'] = !isset($rdisplay['xuninumtime']) ? "1800" : $rdisplay['xuninumtime'];
	$rdisplay['xuninuminitial'] = !isset($rdisplay['xuninuminitial']) ? "1" : $rdisplay['xuninuminitial'];
	$rdisplay['xuninumending'] = !isset($rdisplay['xuninumending']) ? "50" : $rdisplay['xuninumending'];
	$rdisplay['lapiao'] = empty($rdisplay['lapiao']) ? "拉票" : $rdisplay['lapiao'];
	$rdisplay['sharename'] = empty($rdisplay['sharename']) ? "分享" : $rdisplay['sharename'];
	$rdisplay['tpname'] = empty($rdisplay['tpname']) ? "投Ta一票" : $rdisplay['tpname'];
	$rdisplay['rqname'] = empty($rdisplay['rqname']) ? "人气" : $rdisplay['rqname'];
	$rdisplay['tpsname'] = empty($rdisplay['tpsname']) ? "票数" : $rdisplay['tpsname'];
	$rdisplay['isedes'] = !isset($rdisplay['isedes']) ? "1" : $rdisplay['isedes'];
	$rdisplay['csrs'] = empty($rdisplay['csrs']) ? "参赛人数" : $rdisplay['csrs'];		
	$rdisplay['ljtp'] = empty($rdisplay['ljtp']) ? "累计投票" : $rdisplay['ljtp'];		
	$rdisplay['cyrs'] = empty($rdisplay['cyrs']) ? "参与人数" : $rdisplay['cyrs'];		
	$rdisplay['zanzhums'] = !isset($rdisplay['zanzhums']) ? "1" : $rdisplay['zanzhums'];
	$rdisplay['istopheader'] = !isset($rdisplay['istopheader']) ? "0" : $rdisplay['istopheader'];
	$rdisplay['ipannounce'] = !isset($rdisplay['ipannounce']) ? "0" : $rdisplay['ipannounce'];
	$rdisplay['isbgaudio'] = !isset($rdisplay['isbgaudio']) ? "0" : $rdisplay['isbgaudio'];
	$rdisplay['ishuodong'] = !isset($rdisplay['ishuodong']) ? "0" : $rdisplay['ishuodong'];
	$regtitlearr['cmmrealname'] = empty($regtitlearr['cmmrealname']) ? "姓名" : $regtitlearr['cmmrealname'];
	$regtitlearr['cmmmobile'] = empty($regtitlearr['cmmmobile']) ? "手机" : $regtitlearr['cmmmobile'];
	$regtitlearr['cmmphotosname'] = empty($regtitlearr['cmmphotosname']) ? "宣言" : $regtitlearr['cmmphotosname'];
	$regtitlearr['cmmregdes'] = empty($regtitlearr['cmmregdes']) ? "介绍" : $regtitlearr['cmmregdes'];
	$regtitlearr['cmmweixin'] = empty($regtitlearr['cmmweixin']) ? "微信" : $regtitlearr['cmmweixin'];
	$regtitlearr['cmmqqhao'] = empty($regtitlearr['cmmqqhao']) ? "QQ号" : $regtitlearr['cmmqqhao'];
	$regtitlearr['cmmemail'] = empty($regtitlearr['cmmemail']) ? "电子邮箱" : $regtitlearr['cmmemail'];
	$regtitlearr['cmmjob'] = empty($regtitlearr['cmmjob']) ? "职业" : $regtitlearr['cmmjob'];
	$regtitlearr['cmmxingqu'] = empty($regtitlearr['cmmxingqu']) ? "兴趣" : $regtitlearr['cmmxingqu'];
	$regtitlearr['cmmaddress'] = empty($regtitlearr['cmmaddress']) ? "地址" : $regtitlearr['cmmaddress'];
	if (checksubmit('submit')) {
		$insert_display = array(
			'rid' => $rid,
			'istopheader' => $_GPC['istopheader'] == 'on' ? 1 : 0,
			'ipannounce' => $_GPC['ipannounce'] == 'on' ? 1 : 0,
			'isbgaudio' => $_GPC['isbgaudio'] == 'on' ? 1 : 0,
			'isvoteusers' => $_GPC['isvoteusers'] == 'on' ? 1 : 0,
			'iscontent' => $_GPC['iscontent'] == 'on' ? 1 : 0,
			'bgmusic' => $_GPC['bgmusic'],
			'isedes' => $_GPC['isedes'] == 'on' ? 1 : 0,
			'tmoshi' => intval($_GPC['tmoshi']),
			'indextpxz' => intval($_GPC['indextpxz']),
			'indexorder' => $_GPC['indexorder'],
			'indexpx' => intval($_GPC['indexpx']),
			'phbtpxz' => intval($_GPC['phbtpxz']),
			'zanzhums' => $_GPC['zanzhums'],
			'csrs_total' => $_GPC['csrs_total'],
			'xunips' => $_GPC['xunips'],
			'ljtp_total' => $_GPC['ljtp_total'],
			'xuninum' => $_GPC['xuninum'],
			'cyrs_total' => $_GPC['cyrs_total'],
			'xuninumtime' => $_GPC['xuninumtime'],
			'xuninuminitial' => $_GPC['xuninuminitial'],
			'xuninumending' => $_GPC['xuninumending'],
			'isrealname' => intval($_GPC['isrealname']),
			'ismobile' => intval($_GPC['ismobile']),
			'isphotosname' => intval($_GPC['isphotosname']),
			'isregdes' => intval($_GPC['isregdes']),
			'isweixin' => intval($_GPC['isweixin']),
			'isqqhao' => intval($_GPC['isqqhao']),
			'isemail' => intval($_GPC['isemail']),
			'isjob' => intval($_GPC['isjob']),
			'isxingqu' => intval($_GPC['isxingqu']),
			'isaddress' => intval($_GPC['isaddress']),
			'isindex' => intval($_GPC['isindex']),
			'isvotexq' => intval($_GPC['isvotexq']),
			'ispaihang' => intval($_GPC['ispaihang']),
			'isreg' => intval($_GPC['isreg']),
			'isdes' => intval($_GPC['isdes']),
			'lapiao' => $_GPC['lapiao'],
			'sharename' => $_GPC['sharename'],
			'tpname' => $_GPC['tpname'],
			'tpsname' => $_GPC['tpsname'],
			'rqname' => $_GPC['rqname'],
			'csrs' => $_GPC['csrs'],
			'ljtp' => $_GPC['ljtp'],
			'cyrs' => $_GPC['cyrs'],
			'iscopyright' => $_GPC['iscopyright'] == 'on' ? 1 : 0,
			'copyright' => $_GPC['copyright'],	
			'copyrighturl' => $_GPC['copyrighturl']
		);
		$regtitlearr = array(
			'cmmrealname' => $_GPC['cmmrealname'],
			'cmmmobile' => $_GPC['cmmmobile'],
			'cmmphotosname' => $_GPC['cmmphotosname'],
			'cmmregdes' => $_GPC['cmmregdes'],
			'cmmweixin' => $_GPC['cmmweixin'],
			'cmmqqhao' => $_GPC['cmmqqhao'],
			'cmmemail' => $_GPC['cmmemail'],
			'cmmjob' => $_GPC['cmmjob'],
			'cmmxingqu' => $_GPC['cmmxingqu'],
			'cmmaddress' => $_GPC['cmmaddress'],
			'open_mobile' => $_GPC['open_mobile'],
			'open_photosname' => $_GPC['open_photosname'],
			'open_regdes' => $_GPC['open_regdes'],
			'open_weixin' => $_GPC['open_weixin'],
			'open_qqhao' => $_GPC['open_qqhao'],
			'open_email' => $_GPC['open_email'],
			'open_job' => $_GPC['open_job'],
			'open_xingqu' => $_GPC['open_xingqu'],
			'open_address' => $_GPC['open_address'],
			'open_mobile_zs' => $_GPC['open_mobile_zs'],
			'open_photosname_zs' => $_GPC['open_photosname_zs'],
			'open_regdes_zs' => $_GPC['open_regdes_zs'],
			'open_weixin_zs' => $_GPC['open_weixin_zs'],
			'open_qqhao_zs' => $_GPC['open_qqhao_zs'],
			'open_email_zs' => $_GPC['open_email_zs'],
			'open_job_zs' => $_GPC['open_job_zs'],
			'open_xingqu_zs' => $_GPC['open_xingqu_zs'],
			'open_address_zs' => $_GPC['open_address_zs']
		);
		$insert_display['regtitlearr'] = iserializer($regtitlearr);
		if (!empty($rdisplay['rid'])) {
			pdo_update($this->table_reply_display, $insert_display, array('rid' => $rid));
		} else {
			pdo_insert($this->table_reply_display, $insert_display);
		}
		message('更新成功！', referer(), 'success');
	}
} elseif ($op == 'rvote') {
	$rbasic = pdo_fetch("SELECT binduniacid FROM ".tablename($this->table_reply)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	$rvote = pdo_fetch("SELECT * FROM ".tablename($this->table_reply_vote)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	$uniarr = explode(',',$rbasic['binduniacid']);
	$gduni = $_W['uniacid'];
	$condition = '';
	$pars = array();
	if (!empty($_W['isfounder'])) {
		$condition .= " WHERE a.default_acid <> 0 ";
		$order_by = " ORDER BY a.`rank` DESC";
	} else {
		$condition .= "LEFT JOIN ". tablename('uni_account_users')." as c ON a.uniacid = c.uniacid WHERE a.default_acid <> 0 AND c.uid = :uid";
		$pars[':uid'] = $_W['uid'];
		$order_by = " ORDER BY c.`rank` DESC";
	}
	$condition .= " AND (d.level = 3 OR d.level = 4) AND a.uniacid <> :uniacid";
		$pars[':uniacid'] = $gduni;
	$sql = "SELECT a.uniacid,a.name FROM ". tablename('uni_account'). " as a LEFT JOIN". tablename('account'). " as b ON a.default_acid = b.acid  LEFT JOIN ". tablename('account_wechats')." as d ON a.uniacid = d.uniacid  {$condition} {$order_by}, a.`uniacid` DESC";
	
	$rvote['isbbsreply'] = !isset($rvote['isbbsreply']) ? "1" : $rvote['isbbsreply'];
	$rvote['voteendtime'] = empty($rvote['voteendtime']) ?  strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600)) : $rvote['voteendtime'];		
	$rvote['votestarttime'] = empty($rvote['votestarttime']) ? strtotime(date("Y-m-d H:i", $now + 3 * 24 * 3600)) : $rvote['votestarttime'];	
	$rvote['cqtp'] = !isset($rvote['cqtp']) ? "1" : $rvote['cqtp'];
	$rvote['moshi'] = !isset($rvote['moshi']) ? "2" : $rvote['moshi'];;
	$rvote['tpsh'] = !isset($rvote['tpsh']) ? "0" : $rvote['tpsh'];
	$rvote['tpxz'] = empty($rvote['tpxz']) ? "5" : $rvote['tpxz'];
	$rvote['autolitpic'] = empty($rvote['autolitpic']) ? "500" : $rvote['autolitpic'];
	$rvote['autozl'] = empty($rvote['autozl']) ? "50" : $rvote['autozl'];
	$rvote['daytpxz'] = empty($rvote['daytpxz']) ? "8" : $rvote['daytpxz'];
	$rvote['dayonetp'] = empty($rvote['dayonetp']) ? "1" : $rvote['dayonetp'];
	$rvote['allonetp'] = empty($rvote['allonetp']) ? "1" : $rvote['allonetp'];
	$rvote['fansmostvote'] = empty($rvote['fansmostvote']) ? "1" : $rvote['fansmostvote'];
	$rvote['userinfo'] = empty($rvote['userinfo']) ? "请留下您的个人信息，谢谢!" : $rvote['userinfo'];
	$rvote['addpvapp'] = !isset($rvote['addpvapp']) ? "1" : $rvote['addpvapp'];
	$rvote['iscode'] = !isset($rvote['iscode']) ? "0" : $rvote['iscode'];
	$rvote['codekey'] = empty($rvote['codekey']) ? "" : $rvote['codekey'];
	$rvote['tmreply'] = !isset($rvote['tmreply']) ? "1" : $rvote['tmreply'];
	$rvote['tmyushe'] = !isset($rvote['tmyushe']) ? "1" : $rvote['tmyushe'];
	$rvote['isipv'] = !isset($rvote['isipv']) ? "0" : $rvote['isipv'];
	$rvote['ipturl'] = !isset($rvote['ipturl']) ? "1" : $rvote['ipturl'];
	$rvote['ipstopvote'] = !isset($rvote['ipstopvote']) ? "1" : $rvote['ipstopvote'];
	$rvote['tmoshi'] = !isset($rvote['tmoshi']) ? "0" : $rvote['tmoshi'];
	$rvote['mediatype'] = !isset($rvote['mediatype']) ? "1" : $rvote['mediatype'];		
	$rvote['mediatypem'] = !isset($rvote['mediatypem']) ? "0" : $rvote['mediatypem'];		
	$rvote['mediatypev'] = !isset($rvote['mediatypev']) ? "0" : $rvote['mediatypev'];		
	$rvote['votesuccess'] = empty($rvote['votesuccess']) ? "恭喜您成功的为编号为：#编号# ,姓名为： #参赛人名# 的参赛者投了 #投票票数# 票！" : $rvote['votesuccess'];
	$rvote['limitip'] = empty($rvote['limitip']) ? "10" : $rvote['limitip'];			
	$rvote['votetime'] = empty($rvote['votetime']) ? "10" : $rvote['votetime'];	
	$rvote['iplocaldes'] = empty($rvote['iplocaldes']) ? "你所在的地区不在本次投票地区。本次投票地区： #限制地区#" : $rvote['iplocaldes'];	


	$uniacids = pdo_fetchall($sql, $pars);
	if (checksubmit('submit')) {
		if (!empty($_GPC['binduniacid'])) {
			$binduniacid = implode(',',$_GPC['binduniacid']);
		}
		if ($_GPC['unimoshi'] == 1) {
			$fansmostvote = intval($_GPC['fansmostvote']);
			$daytpxz = intval($_GPC['daytpxz']);
			$allonetp = intval($_GPC['allonetp']);
			$dayonetp = intval($_GPC['dayonetp']);
		}else{
			$fansmostvote = intval($_GPC['u_fansmostvote']);
			$daytpxz = intval($_GPC['u_daytpxz']);
			$allonetp = intval($_GPC['u_allonetp']);
			$dayonetp = intval($_GPC['u_dayonetp']);
		}

		$insert_vote = array(
			'rid' => $rid,
			'iscode' => $_GPC['iscode'] == 'on' ? 1 : 0,
			'codekey' => $_GPC['codekey'],
			'voteerinfo' => $_GPC['voteerinfo'] == 'on' ? 1 : 0,
			'votenumpiao' => $_GPC['votenumpiao'] == 'on' ? 1 : 0,
			'votepay' => $_GPC['votepay'] == 'on' ? 1 : 0,
			'votepaytitle' => $_GPC['votepaytitle'],
			'votepaydes' => $_GPC['votepaydes'],
			'votepayfee' => $_GPC['votepayfee'],
			'regpay' => $_GPC['regpay'] == 'on' ? 1 : 0,
			'regpaytitle' => $_GPC['regpaytitle'],
			'regpaydes' => $_GPC['regpaydes'],
			'regpayfee' => $_GPC['regpayfee'],
			'addpvapp' => $_GPC['addpvapp'] == 'on' ? 1 : 0,
			'isfans' => $_GPC['isfans'] == 'on' ? 1 : 0,
			'mediatype' => $_GPC['mediatype'] == 'on' ? 1 : 0,
			'mediatypem' => $_GPC['mediatypem'] == 'on' ? 1 : 0,
			'ismediatype' => $_GPC['ismediatype'] == 'on' ? 1 : 0,
			'ismediatypem' => $_GPC['ismediatypem'] == 'on' ? 1 : 0,
			'mediatypev' => $_GPC['mediatypev'] == 'on' ? 1 : 0,
			'ismediatypev' => $_GPC['ismediatypev'] == 'on' ? 1 : 0,
			'moshi' => intval($_GPC['moshi']),
			'webinfo' =>  htmlspecialchars_decode($_GPC['webinfo']),
			'cqtp' => $_GPC['cqtp'] == 'on' ? 1 : 0,
			'tpsh' => $_GPC['tpsh'] == 'on' ? 1 : 0,
			'isbbsreply' => $_GPC['isbbsreply'] == 'on' ? 1 : 0,
			'tmyushe' => $_GPC['tmyushe'] == 'on' ? 1 : 0,
			'tmreply' => $_GPC['tmreply'] == 'on' ? 1 : 0,
			'isipv' => $_GPC['isipv'] == 'on' ? 1 : 0,
			'ipturl' => $_GPC['ipturl'] == 'on' ? 0 : 1,
			'ipstopvote' => $_GPC['ipstopvote'] == 'on' ? 0 : 1,
			'iplocallimit' => $_GPC['iplocallimit'],
			'iplocaldes' => $_GPC['iplocaldes'],
			'tpxz' => $_GPC['tpxz'] > 8 ? '8' : intval($_GPC['tpxz']),
			'autolitpic' => intval($_GPC['autolitpic']),
			'autozl' => $_GPC['autozl'] > 100 ? '100' : intval($_GPC['autozl']),
			'limitip' => $_GPC['limitip'],
			'unimoshi' => $_GPC['unimoshi'],
			'usersmostvote' => intval($_GPC['usersmostvote']),	
            'votestarttime' => strtotime($_GPC['vdatelimit']['start']),
            'voteendtime' => strtotime($_GPC['vdatelimit']['end']), 
			'fansmostvote' => $fansmostvote,	
			'daytpxz' => $daytpxz,	
			'allonetp' => $allonetp,	
			'dayonetp' => $dayonetp,	
			'uni_fansmostvote' => intval($_GPC['uni_fansmostvote']),	
			'uni_daytpxz' => intval($_GPC['uni_daytpxz']),
			'uni_allonetp' => intval($_GPC['uni_allonetp']),
			'uni_dayonetp' => intval($_GPC['uni_dayonetp']),
			'uni_all_users' => intval($_GPC['uni_all_users']),
			'userinfo' => $_GPC['userinfo'],
			'votesuccess' => $_GPC['votesuccess'],
			'limitsd' => intval($_GPC['limitsd']),
			'limitsdps' => intval($_GPC['limitsdps'])
		);
		if (!empty($rvote['rid'])) {
			pdo_update($this->table_reply_vote, $insert_vote, array('rid' => $rid));
		} else {
			pdo_insert($this->table_reply_vote, $insert_vote);
		}
		pdo_update($this->table_reply, array('binduniacid' => $_GPC['gduni'].','.$binduniacid), array('rid' => $rid));
		message('更新成功！', referer(), 'success');
	}
} elseif ($op == 'rbody') {
	$rbody = pdo_fetch("SELECT * FROM ".tablename($this->table_reply_body)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	$rbody['zbgcolor'] = empty($rbody['zbgcolor']) ? "#3a0255" : $rbody['zbgcolor'];
	$rbody['zbg'] = empty($rbody['zbg']) ? FM_STATIC_MOBILE . "public/photos/bg.jpg" : $rbody['zbg'];
	$rbody['zbgtj'] = empty($rbody['zbgtj']) ? FM_STATIC_MOBILE . "public/photos/bg_x.png" : $rbody['zbgtj'];
	$rbody['voicebg'] = empty($rbody['voicebg']) ? "" : $rbody['voicebg'];		
	$rbody['topbgcolor'] = empty($rbody['topbgcolor']) ? "" : $rbody['topbgcolor'];
	$rbody['topbg'] = empty($rbody['topbg']) ? "" : $rbody['topbg'];
	$rbody['topbgtext'] = empty($rbody['topbgtext']) ? "" : $rbody['topbgtext'];
	$rbody['topbgrightcolor'] = empty($rbody['topbgrightcolor']) ? "" : $rbody['topbgrightcolor'];
	$rbody['topbgright'] = empty($rbody['topbgright']) ? "" : $rbody['topbgright'];
	$rbody['foobg1'] = empty($rbody['foobg1']) ? "" : $rbody['foobg1'];
	$rbody['foobg2'] = empty($rbody['foobg2']) ? "" : $rbody['foobg2'];
	$rbody['foobgtextn'] = empty($rbody['foobgtextn']) ? "" : $rbody['foobgtextn'];
	$rbody['foobgtexty'] = empty($rbody['foobgtexty']) ? "" : $rbody['foobgtexty'];
	$rbody['foobgtextmore'] = empty($rbody['foobgtextmore']) ? "" : $rbody['foobgtextmore'];
	$rbody['foobgmorecolor'] = empty($rbody['foobgmorecolor']) ? "" : $rbody['foobgmorecolor'];
	$rbody['foobgmore'] = empty($rbody['foobgmore']) ? "" : $rbody['foobgmore'];
	$rbody['bodytextcolor'] = empty($rbody['bodytextcolor']) ? "" : $rbody['bodytextcolor'];
	$rbody['bodynumcolor'] = empty($rbody['bodynumcolor']) ? "" : $rbody['bodynumcolor'];
	$rbody['bodytscolor'] = empty($rbody['bodytscolor']) ? "" : $rbody['bodytscolor'];
	$rbody['bodytsbg'] = empty($rbody['bodytsbg']) ? "" : $rbody['bodytsbg'];
	$rbody['copyrightcolor'] = empty($rbody['copyrightcolor']) ? "" : $rbody['copyrightcolor'];
	$rbody['inputcolor'] = empty($rbody['inputcolor']) ? "" : $rbody['inputcolor'];
	$rbody['xinbg'] = empty($rbody['xinbg']) ? "" : $rbody['xinbg'];
	if (checksubmit('submit')) {
		$insert_body = array(
			'rid' => $rid,
			'zbgcolor' => $_GPC['zbgcolor'],
			'zbg' => $_GPC['zbg'],
			'voicebg' => $_GPC['voicebg'],
			'zbgtj' => $_GPC['zbgtj'],
			'topbgcolor' => $_GPC['topbgcolor'],
			'topbg' => $_GPC['topbg'],
			'topbgtext' => $_GPC['topbgtext'],
			'topbgrightcolor' => $_GPC['topbgrightcolor'],
			'topbgright' => $_GPC['topbgright'],
			'foobg1' => $_GPC['foobg1'],
			'foobg2' => $_GPC['foobg2'],
			'foobgtextn' => $_GPC['foobgtextn'],
			'foobgtexty' => $_GPC['foobgtexty'],
			'foobgtextmore' => $_GPC['foobgtextmore'],
			'foobgmorecolor' => $_GPC['foobgmorecolor'],
			'foobgmore' => $_GPC['foobgmore'],
			'bodytextcolor' => $_GPC['bodytextcolor'],
			'bodynumcolor' => $_GPC['bodynumcolor'],
			'inputcolor' => $_GPC['inputcolor'],
			'bodytscolor' => $_GPC['bodytscolor'],
			'bodytsbg' => $_GPC['bodytsbg'],
			'xinbg' => $_GPC['xinbg'],
			'copyrightcolor' => $_GPC['copyrightcolor']
		);
		if (!empty($rbody['rid'])) {
			pdo_update($this->table_reply_body, $insert_body, array('rid' => $rid));
		} else {
			pdo_insert($this->table_reply_body, $insert_body);
		}
		message('更新成功！', referer(), 'success');
	}
} elseif ($op == 'rupload') {
	$rbasic = pdo_fetch("SELECT qiniu FROM ".tablename($this->table_reply)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
	$qiniu = iunserializer($rbasic['qiniu']);
	$qiniu['videologo'] = empty($qiniu['videologo']) ? FM_PHOTOSVOTE_RESOURCE_URL."static/logo.png" : $qiniu['videologo'];
	if (checksubmit('submit')) {
		$qiniu = array(		
			'isqiniu' => $_GPC['isqiniu'] =='on' ? 1 : 0,
			'accesskey' => $_GPC['accesskey'],
			'secretkey' => $_GPC['secretkey'],
			'qnlink' => $_GPC['qnlink'],
			'bucket' => $_GPC['bucket'],
			'pipeline' => $_GPC['pipeline'],
			'aq' => $_GPC['aq'],
			'videofbl' => $_GPC['videofbl'],
			'videologo' => $_GPC['videologo'],
			'wmgravity' => $_GPC['wmgravity'],
		);
		$insert_basic['qiniu'] = iserializer($qiniu);
		pdo_update($this->table_reply, $insert_basic, array('rid' => $rid));
		message('更新成功！', referer(), 'success');
	}
} elseif ($op == 'rjifen') {
} elseif ($op == 'rstar') {

}

include $this->template('web/system');