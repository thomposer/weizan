<?php
/**
 * 微小区模块
 *
 * [微赞] Copyright (c) 2013 012wz.com
 */
/**
 * 微信端小区活动
 */

	
	global $_GPC,$_W;

	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
	//判断是否注册，只有注册后，才能进入
	$member = $this->changemember();
	$region = $this->mreg();
	
	if($op == 'list'){
		
		if ($_W['isajax']) {
			$pindex = max(1, intval($_GPC['page']));
			$psize  = 10;
			$condition = '';
			$rows = pdo_fetchall("SELECT * FROM".tablename('xcommunity_activity')."WHERE weid='{$_W['weid']}' order by status desc LIMIT ".($pindex - 1) * $psize.','.$psize);
			$total =pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_activity')."WHERE weid='{$_W['weid']}'");

			$list = array();
			foreach ($rows as $key => $value) {
				$regions = unserialize($value['regionid']);
				if (@in_array($member['regionid'], $regions)) {
					$list[$key]['starttime'] = $value['starttime'] ;
					$list[$key]['endtime'] = $value['endtime'] ;
					$list[$key]['picurl'] = $value['picurl'] ;
					$list[$key]['id'] = $value['id'] ;
					$list[$key]['resnumber'] = $value['resnumber'] ;
					$list[$key]['title'] = $value['title'] ;
				}
			}
			// print_r($list);exit();
			$data = array();
			foreach ($list as $key => $value) {
				$url = $this->createMobileUrl('activity',array('op' => 'detail','id' => $value['id']));
				

				$starttime = date('Y-m-d', $value['starttime']);
				$endtime = date('Y-m-d', $value['endtime']);
				$enddate = strtotime($value['enddate']);

				$picurl = tomedia($value['picurl']);
				$data[]['html'] = "
						
						<div class='row' onclick=\"window.location.href='".$url."'\" style='margin-top:-15px'>
						  <div class='col-sm-6 col-md-4'>

						    <div class='thumbnail'>
						    	<h4 style='margin-top:2px;'>".$value['title']."</h4>
						      <img src='".$picurl."' style='width:100%;height:120px;'>
						      <i class='res'>累计".$value['resnumber']."人报名</i>
						      <p class='p1'>
						      	<span style='float:left'>&nbsp;活动时间：".$starttime."~".$endtime."</span>
						      	<span style='float:right'>立即参加&nbsp;<i class='fa fa-angle-right'></i></span>
						      </p>
						    </div>
						  </div>
						</div>
					
				";
			}
			$r = array(
		    		'allhtml' => $data,
		    		'page_count' => $total,
		    		
		    	);

		   print_r(json_encode($r));exit();
		}
		$styleid = pdo_fetchcolumn("SELECT styleid FROM".tablename('xcommunity_template')."WHERE uniacid='{$_W['uniacid']}'");
		if ($styleid) {
			include $this->template('style/style'.$styleid.'/activity/list');exit();
		}
	}elseif($op == 'detail'){
		$id = intval($_GPC['id']);
		if ($id) {
			$detail = pdo_fetch("SELECT * FROM".tablename('xcommunity_activity')."WHERE id=:id",array(':id' => $id));
			$condition = '';
			if ($detail['price'] != '0.00' && $detail['price'] != '0') {
				$condition .=" AND status = 1";
			}
			$res = pdo_fetch("SELECT * FROM".tablename('xcommunity_res')."WHERE openid=:openid AND aid=:aid $condition",array(':openid' => $_W['fans']['from_user'],':aid' => $id));
			$enddate = strtotime($detail['enddate']);
			$starttime = date('Y-m-d', $detail['starttime']);
			$endtime = date('Y-m-d', $detail['endtime']);
			$picurl = tomedia($detail['picurl']);
			$m = mc_fetch($_W['member']['uid'],array('realname','mobile','address'));
		}
		$styleid = pdo_fetchcolumn("SELECT styleid FROM".tablename('xcommunity_template')."WHERE uniacid='{$_W['uniacid']}'");
		if ($styleid) {
			include $this->template('style/style'.$styleid.'/activity/detail');exit();
		}
	}elseif($op == 'res'){
		$aid = intval($_GPC['aid']);
		if (empty($aid)) {
			message('缺少参数',referer(),'error');
		}
		$item = pdo_fetch("SELECT * FROM".tablename('xcommunity_activity')."WHERE id=:aid",array(':aid' => $aid));
		if (empty($item)) {
			message('活动不存在或已删除',referer(),'error');
		}
		
		if ($_W['isajax']) {
			$data = array(
					'weid'       => $_W['weid'],
					'openid'     => $_W['fans']['from_user'], 
					'truename'   => $_GPC['truename'],
					'mobile'     => $_GPC['mobile'],
					'num'        => intval($_GPC['num']),
					'aid'        => $aid,
					'createtime' => TIMESTAMP,
				);
			$res = pdo_fetch("SELECT id FROM".tablename('xcommunity_res')."WHERE aid=:aid AND openid =:openid",array(':aid' => $aid,':openid' => $_W['fans']['from_user']));
			if ($res) {
				$r1 = pdo_update('xcommunity_res',$data,array('id' => $res['id']));
				$rid = $res['id'];
			}else{
				$r1 = pdo_insert('xcommunity_res',$data);
				$rid = pdo_insertid();
			}
			
			if ($item['price'] != '0.00' && $item['price'] != '0') {
				$data = array(
					'weid' => $_W['uniacid'],
					'from_user' => $_W['fans']['from_user'],
					'createtime' => TIMESTAMP,
					'price'	=> $item['price']*$data['num'],
					'aid' => $rid,
					'type' => 'activity',
					'regionid' => $member['regionid'],
				);

				$order = pdo_fetch("SELECT id FROM".tablename('xcommunity_order')."WHERE aid=:aid",array(':aid' => $res['id']));
				if ($order) {
					pdo_update('xcommunity_order',$data,array('id' => $order['id']));
					$orderid = $order['id'];
				}else{
					$data['ordersn'] = date('YmdHi').random(10, 1);
					pdo_insert('xcommunity_order', $data);
					$orderid =pdo_insertid();
				}
				
				
				if ($orderid) {
					$result = array(
								'status' => 2,
								'orderid' => $orderid,
							);
						echo json_encode($result);exit();
					//header("location: " . $this->createMobileUrl('activity', array('op' => 'pay','orderid' => $orderid)));
				}
			}else{
				$r2 = pdo_query("UPDATE ".tablename('xcommunity_activity')." SET resnumber=resnumber+'{$_GPC['num']}' WHERE id=:aid",array(':aid' => $aid));
				if ($r1 && $r2) {
					$result = array(
								'status' => 1,
							);
						echo json_encode($result);exit();
				}
			}
			
		}
	
	}elseif ($op == 'pay') {
		//查活动支持的支付方式
		$setdata = $this->syspay(4);
		$set = unserialize($setdata['pay']);
		//查当前订单信息
		$orderid = intval($_GPC['orderid']);
		$order = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE id = :id", array(':id' => $orderid));
		if ($order['status'] != '0') {
			message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', referer(), 'error');
		}
		$params['tid'] = $order['ordersn'];
		$params['user'] = $_W['fans']['from_user'];
		$params['fee'] = $order['price'];
		$params['ordersn'] = $order['ordersn'];
		$params['virtual'] = $order['goodstype'] == 2 ? true : false;
		$params['module'] = 'xfeng_community';
		$params['title'] = '活动支付';
		$log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
		if (empty($log)) {
	        $log = array(
	                'uniacid' => $_W['uniacid'],
	                'acid' => $_W['acid'],
	                'openid' => $_W['member']['uid'],
	                'module' => $this->module['name'], //模块名称，请保证$this可用
	                'tid' => $params['tid'],
	                'fee' => $params['fee'],
	                'card_fee' => $params['fee'],
	                'status' => '0',
	                'is_usecard' => '0',
	        );
	        pdo_insert('core_paylog', $log);
		}
		$styleid = pdo_fetchcolumn("SELECT styleid FROM".tablename('xcommunity_template')."WHERE uniacid='{$_W['uniacid']}'");
		if ($styleid) {
			include $this->template('style/style'.$styleid.'/activity/pay');exit();
		}
	}










