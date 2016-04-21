<?php
/**
 * 微小区模块
 *
 * [微赞] Copyright (c) 2013 012wz.com
 */
/**
 * 微信端个人页面
 */

	global $_GPC,$_W;
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'member';
	load()->model('mc');
	$userinfo = mc_oauth_userinfo();
	$member = mc_fetch($_W['fans']['uid'],array('mobile','credit1','realname','address'));
	if ($op == 'member') {
		
		
		$dos = "'fled','houselease','homemaking','car','cost','shopping','business','government'";
		$menus = pdo_fetchall("SELECT * FROM".tablename('xcommunity_nav')."WHERE uniacid =:uniacid AND do in({$dos})",array(':uniacid' => $_W['uniacid']),'do');

		$styleid = pdo_fetchcolumn("SELECT styleid FROM".tablename('xcommunity_template')."WHERE uniacid='{$_W['uniacid']}'");
		if ($styleid) {
			include $this->template('style/style'.$styleid.'/member');
		}

	}elseif ($op == 'my') {
		# code...
		$mem = $this->changemember();
		$region = $this->region($mem['regionid']);
		$styleid = pdo_fetchcolumn("SELECT styleid FROM".tablename('xcommunity_template')."WHERE uniacid='{$_W['uniacid']}'");
		if ($styleid) {
			include $this->template('style/style'.$styleid.'/my');
		}
	}elseif ($op == 'edit') {
		$r = $_GPC['r'];
	
			$id = intval($_GPC['id']);
			if ($id) {
				$mem = pdo_fetch("SELECT * FROM".tablename('xcommunity_member')."WHERE id=:id AND weid=:weid",array(':id' => $id,':weid' => $_W['weid']));
			}
			

		if ($_W['isajax']) {
			if ($r == 'm') {
					$rs = mc_update($_W['member']['uid'], array('realname' => $_GPC['realname']));
					//pdo_query("UPDATE ".tablename('xcommunity_member')."SET realname = '{$_GPC['realname']}' WHERE id=:id",array(':id' => $id));
					pdo_update('xcommunity_member',array('realname' => $_GPC['realname']),array('id' => $id));
					$result = array(
									'status' => 1,
								);
					echo json_encode($result);exit();
			}elseif ($r == 'b') {
				$rs = mc_update($_W['member']['uid'], array('mobile' => $_GPC['mobile']));
					//pdo_query("UPDATE ".tablename('xcommunity_member')."SET mobile = :mobile WHERE id=:id",array(':mobile' => $_GPC['mobile'],':id' => $id));
					pdo_update('xcommunity_member',array('mobile' => $_GPC['mobile']),array('id' => $id));
					$result = array(
									'status' => 1,
								);
					echo json_encode($result);exit();
			}elseif ($r == 'a') {
				$rs = mc_update($_W['member']['uid'], array('address' => $_GPC['address']));
					//pdo_query("UPDATE ".tablename('xcommunity_member')."SET address = :address WHERE id=:id",array(':address' => $_GPC['address'],':id' => $id));
					pdo_update('xcommunity_member',array('address' => $_GPC['address']),array('id' => $id));
					$result = array(
									'status' => 1,
								);
					echo json_encode($result);exit();
			}
				
		}
		$styleid = pdo_fetchcolumn("SELECT styleid FROM".tablename('xcommunity_template')."WHERE uniacid='{$_W['uniacid']}'");
		if ($styleid) {
			include $this->template('style/style'.$styleid.'/edit');
		}
	}

	
	