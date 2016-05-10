<?php
/**
 * 微小区模块
 *
 * [微赞] Copyright (c) 2013 012wz.com
 */
/**
 * 后台小区活动
 */
	global $_W,$_GPC;
	//导入后台菜单数据
		$menus = pdo_fetchall("SELECT * FROM".tablename('xcommunity_menu')."WHERE uniacid= '{$_W['uniacid']}'");
		if (empty($menus)) {
			$data1 =array('pcate' => 0 ,'title' => '管理中心','url' => '','uniacid' => $_W['uniacid'],'method' => 'manage');
			$data2 =array('pcate' => 0 ,'title' => '功能管理','url' => '','uniacid' => $_W['uniacid'],'method' => 'fun');
			$data3 =array('pcate' => 0 ,'title' => '小区超市','url' => '','uniacid' => $_W['uniacid'],'method' => 'shop');
			$data4 =array('pcate' => 0 ,'title' => '小区商家','url' => '','uniacid' => $_W['uniacid'],'method' => 'business');
			$data5 =array('pcate' => 0 ,'title' => '分权系统','url' => '','uniacid' => $_W['uniacid'],'method' => 'perm');
			$data6 =array('pcate' => 0 ,'title' => '系统设置','url' => '','uniacid' => $_W['uniacid'],'method' => 'sysset');
			if ($_W['isfounder']) {
				$data7 =array('pcate' => 0 ,'title' => '系统超级管理','url' => '','uniacid' => $_W['uniacid'],'method' => 'other');
			}
			
			if ($data1) {
					pdo_insert('xcommunity_menu',$data1);
					$nid1 = pdo_insertid();
					$m1 = array(
							array('pcate' => $nid1,'title' => '小区管理','url' => './index.php?c=site&a=entry&op=list&do=region&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'region','method' => 'manage'),
							array('pcate' => $nid1,'title' => '房号管理','url' => './index.php?c=site&a=entry&op=list&do=room&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'room','method' => 'manage'),

							array('pcate' => $nid1,'title' => '物业管理','url' => './index.php?c=site&a=entry&op=list&do=property&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'property','method' => 'manage'),
							array('pcate' => $nid1,'title' => '业主管理','url' => './index.php?c=site&a=entry&op=list&do=member&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'member','method' => 'manage'),
							array('pcate' => $nid1,'title' => '菜单设置','url' => './index.php?c=site&a=entry&op=list&do=nav&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'nav','method' => 'manage'),
							array('pcate' => $nid1,'title' => '模板设置','url' => './index.php?c=site&a=entry&op=list&do=style&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'style','method' => 'manage'),
							array('pcate' => $nid1,'title' => '幻灯管理','url' => './index.php?c=site&a=entry&op=list&do=slide&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'slide','method' => 'manage'),

					);
					foreach ($m1 as $key => $value1) {
						pdo_insert('xcommunity_menu',$value1);
					}
			}
			if ($data2) {
					pdo_insert('xcommunity_menu',$data2);
					$nid2 = pdo_insertid();
					$m2 = array(
							array('pcate' => $nid2,'title' => '小区公告','url' => './index.php?c=site&a=entry&op=list&do=announcement&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'announcement','method' => 'fun'),
							array('pcate' => $nid2,'title' => '小区报修','url' => './index.php?c=site&a=entry&op=list&do=repair&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'repair','method' => 'fun'),
							array('pcate' => $nid2,'title' => '意见建议','url' => './index.php?c=site&a=entry&op=list&do=report&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'report','method' => 'fun'),
							array('pcate' => $nid2,'title' => '家政服务','url' => './index.php?c=site&a=entry&op=list&do=homemaking&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'homemaking','method' => 'fun'),
							array('pcate' => $nid2,'title' => '租赁服务','url' => './index.php?c=site&a=entry&op=list&do=houselease&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'houselease','method' => 'fun'),
							array('pcate' => $nid2,'title' => '缴物业费','url' => './index.php?c=site&a=entry&op=list&do=cost&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'cost','method' => 'fun'),
							array('pcate' => $nid2,'title' => '小区活动','url' => './index.php?c=site&a=entry&op=list&do=activity&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'activity','method' => 'fun'),
							array('pcate' => $nid2,'title' => '便民查询','url' => './index.php?c=site&a=entry&op=list&do=search&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'search','method' => 'fun'),
							array('pcate' => $nid2,'title' => '便民号码','url' => './index.php?c=site&a=entry&op=list&do=phone&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'phone','method' => 'fun'),
							array('pcate' => $nid2,'title' => '二手市场','url' => './index.php?c=site&a=entry&op=list&do=fled&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'fled','method' => 'fun'),
							array('pcate' => $nid2,'title' => '小区拼车','url' => './index.php?c=site&a=entry&op=list&do=car&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'car','method' => 'fun'),
							array('pcate' => $nid2,'title' => '黑名单管理','url' => './index.php?c=site&a=entry&op=list&do=black&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'black','method' => 'fun'),
					);
					foreach ($m2 as $key => $value1) {
						pdo_insert('xcommunity_menu',$value1);
					}
			}
			if ($data3) {
					pdo_insert('xcommunity_menu',$data3);
					$nid3 = pdo_insertid();
					$m3 = array(
							array('pcate' => $nid3,'title' => '订单管理','url' => './index.php?c=site&a=entry&op=order&do=shopping&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'shoppingorder','method' => 'shop'),
							array('pcate' => $nid3,'title' => '商品管理','url' => './index.php?c=site&a=entry&op=goods&do=shopping&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'shoppinggoods','method' => 'shop'),
							array('pcate' => $nid3,'title' => '商品分类','url' => './index.php?c=site&a=entry&op=category&do=shopping&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'shoppingcategory','method' => 'shop'),
							array('pcate' => $nid3,'title' => '提现审核','url' => './index.php?c=site&a=entry&op=cash&do=shopping&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'shoppingcash','method' => 'shop'),

					);
					foreach ($m3 as $key => $value1) {
						pdo_insert('xcommunity_menu',$value1);
					}
			}
			if ($data4) {
					pdo_insert('xcommunity_menu',$data4);
					$nid4 = pdo_insertid();
					$m4 = array(
							// array('pcate' => $nid4,'title' => '用户管理','url' => './index.php?c=site&a=entry&op=users&do=business&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'business'),
							// array('pcate' => $nid4,'title' => '店铺分类','url' => './index.php?c=site&a=entry&op=category&do=business&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'business'),
							array('pcate' => $nid4,'title' => '店铺管理','url' => './index.php?c=site&a=entry&op=dp&do=business&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'businessdp','method' => 'business'),
							array('pcate' => $nid4,'title' => '卡券核销','url' => './index.php?c=site&a=entry&op=coupon&do=business&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'businesscoupon','method' => 'business'),
							array('pcate' => $nid4,'title' => '提现审核','url' => './index.php?c=site&a=entry&op=cash&do=business&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'businesscash','method' => 'business'),

							array('pcate' => $nid4,'title' => '订单管理','url' => './index.php?c=site&a=entry&op=order&do=business&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'businessorder','method' => 'business'),

					);
					foreach ($m4 as $key => $value1) {
						pdo_insert('xcommunity_menu',$value1);
					}
			}
			if ($data5) {
					pdo_insert('xcommunity_menu',$data5);
					$nid5 = pdo_insertid();
					$m5 = array(
							array('pcate' => $nid5,'title' => '用户管理','url' => './index.php?c=site&a=entry&op=list&do=users&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'users','method' => 'perm'),
					);
					foreach ($m5 as $key => $value1) {
						pdo_insert('xcommunity_menu',$value1);
					}
			}
			if ($data6) {
					pdo_insert('xcommunity_menu',$data6);
					$nid6 = pdo_insertid();
					$m6 = array(
							array('pcate' => $nid6,'title' => '小区设置','url' => './index.php?c=site&a=entry&do=set&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'set','method' => 'sysset'),
							array('pcate' => $nid6,'title' => '通知设置','url' => './index.php?c=site&a=entry&op=list&do=notice&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'notice','method' => 'sysset'),
							array('pcate' => $nid6,'title' => '短信设置','url' => './index.php?c=site&a=entry&do=sms&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'sms','method' => 'sysset'),
							array('pcate' => $nid6,'title' => '打印机设置','url' => './index.php?c=site&a=entry&op=list&do=print&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'print','method' => 'sysset'),
							array('pcate' => $nid6,'title' => '模板消息设置','url' => './index.php?c=site&a=entry&do=tpl&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'tpl','method' => 'sysset'),
							array('pcate' => $nid6,'title' => '支付方式设置','url' => './index.php?c=site&a=entry&do=pay&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'pay','method' => 'sysset'),
					);
					foreach ($m6 as $key => $value1) {
						pdo_insert('xcommunity_menu',$value1);
					}
			}
			if ($data7) {
					pdo_insert('xcommunity_menu',$data7);
					$nid7 = pdo_insertid();
					$m7 = array(

							array('pcate' => $nid7,'title' => '小区控制','url' => './index.php?c=site&a=entry&op=list&do=control&m=xfeng_community','uniacid' => $_W['uniacid'],'do' => 'control','method' => 'other'),
					);
					foreach ($m7 as $key => $value1) {
						pdo_insert('xcommunity_menu',$value1);
					}
			}
		}
	$do = $_GPC['do'];
	$GLOBALS['frames'] = $this->NavMenu($do);
	$menu = $this->NavMenu($do);
	$url = $menu[0]['items'][0]['url'];
	header("location: " . $url);