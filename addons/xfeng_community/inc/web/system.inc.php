<?php
/**
 * 微小区模块
 *
 * [微赞] Copyright (c) 2013 012wz.com
 */
/**
 * 后台系统更新
 */
global $_GPC,$_W;
if (!$_W['isfounder']) {
	message('此功能非系统总管理员无法操作',referer(),'error');exit();
}
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'field';
if ($op == 'field') {
	if ($_W['ispost']) {
		/**V5.0-V6.0扩版本升级**/
		if(!pdo_fieldexists('xcommunity_dp', 'child')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_dp')." ADD `child` varchar(50) ;");
		}
		if(!pdo_fieldexists('xcommunity_dp', 'parent')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_dp')." ADD `parent` varchar(50) ;");
		}
		if(!pdo_fieldexists('xcommunity_region', 'qq')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_region')." ADD `qq` int(11) ;");
		}
		if(!pdo_fieldexists('xcommunity_region', 'dist')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_region')." ADD `dist` varchar(50) ;");
		}
		if(!pdo_fieldexists('xcommunity_region', 'city')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_region')." ADD `city` varchar(50) ;");
		}
		if(!pdo_fieldexists('xcommunity_region', 'province')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_region')." ADD `province` varchar(50) ;");
		}
		if(!pdo_fieldexists('xcommunity_region', 'province')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_region')." ADD `province` varchar(50) ;");
		}
		if(!pdo_fieldexists('xcommunity_carpool', 'backtime')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')." ADD `backtime` varchar(10) ;");
		}
		if(!pdo_fieldexists('xcommunity_res', 'aid')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_res')." ADD `aid` int(10) ;");
		}
		if(!pdo_fieldexists('xcommunity_wechat_smsid', 'businesscode')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')." ADD `businesscode` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_wechat_smsid', 'verify')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')." ADD `verify` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_wechat_smsid', 'verifycode')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')." ADD `verifycode` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_category', 'type')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_category')." ADD `type` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_phone', 'thumb')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_phone')." ADD `thumb` varchar(100) ;");
		}
		if(!pdo_fieldexists('xcommunity_nav', 'isshow')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')." ADD `isshow` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_region', 'thumb')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_region')." ADD `thumb` varchar(100) ;");
		}
		if(!pdo_fieldexists('xcommunity_member', 'memberid')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_member')." ADD `memberid` int(10) ;");
		}
		if(!pdo_fieldexists('xcommunity_report', 'address')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_report')." ADD `address` varchar(100) ;");
		}
		if(!pdo_fieldexists('xcommunity_users', 'menus')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_users')." ADD `menus` varchar(5000) ;");
		}
		if(!pdo_fieldexists('xcommunity_set', 'room_status')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD `room_status` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_set', 'room_enable')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD `room_enable` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_fled', 'black')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_fled')." ADD `black` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_slide', 'type')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_slide')." ADD `type` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_carpool', 'gotime')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')." ADD `gotime` varchar(10) ;");
		}
		if(!pdo_fieldexists('xcommunity_carpool', 'black')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')." ADD `black` int(1) ;");
		}
		if(pdo_fieldexists('xcommunity_member', 'openid')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_member')." modify column `openid` varchar(50) ;");
		}
		if(!pdo_fieldexists('xcommunity_wechat_tplid', 'good_tplid')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_tplid')." ADD `good_tplid` varchar(80) ;");
		}
		if(!pdo_fieldexists('xcommunity_wechat_notice', 'type')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')." ADD `type` int(1) ;");
		}
		$sql = "
			CREATE TABLE IF NOT EXISTS `ims_xcommunity_cart` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `weid` int(10) unsigned NOT NULL,
            `goodsid` int(11) NOT NULL,
            `from_user` varchar(50) NOT NULL,
            `total` int(10) unsigned NOT NULL,
            `marketprice` decimal(10,2) DEFAULT '0.00',
            PRIMARY KEY (`id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='购物车表';
			 CREATE TABLE IF NOT EXISTS `ims_xcommunity_order_goods` (
			              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			              `weid` int(10) unsigned NOT NULL,
			              `orderid` int(10) unsigned NOT NULL,
			              `goodsid` int(10) unsigned NOT NULL,
			              `price` decimal(10,2) DEFAULT '0.00',
			              `total` int(10) unsigned NOT NULL DEFAULT '1',
			              `createtime` int(10) unsigned NOT NULL,
			              PRIMARY KEY (`id`)
			            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 COMMENT='订单商品附表';
			CREATE TABLE IF NOT EXISTS `ims_xcommunity_goods` (
			            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			            `weid` int(10) unsigned NOT NULL,
			            `pcate` int(10) unsigned NOT NULL DEFAULT '0',
			            `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
			            `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
			            `title` varchar(100) NOT NULL DEFAULT '',
			            `thumb` varchar(255) DEFAULT '',
			            `thumb_url` text DEFAULT '',
			            `unit` varchar(5) NOT NULL DEFAULT '',
			            `content` text NOT NULL,
			            `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价',
			            `productprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
			            `total` int(10) NOT NULL DEFAULT '0',
			            `createtime` int(10) unsigned NOT NULL,
			            `credit` int(11) DEFAULT '0',
			            `isrecommand` int(11) DEFAULT '0',
			            PRIMARY KEY (`id`)
			        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 COMMENT='商品表';
			CREATE TABLE IF NOT EXISTS `ims_xcommunity_order` (
			            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			            `weid` int(10) unsigned NOT NULL,
			            `from_user` varchar(50) NOT NULL,
			            `ordersn` varchar(20) NOT NULL COMMENT '订单编号',
			            `price` varchar(10) NOT NULL,
			            `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为已付款，2为已发货，3已成功',
			            `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
			            `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
			            `goodstype` tinyint(1) unsigned NOT NULL DEFAULT '1',
			            `remark` varchar(1000) NOT NULL DEFAULT '',
			            `goodsprice` decimal(10,2) DEFAULT '0.00' COMMENT '商品总价',
			            `createtime` int(10) unsigned NOT NULL,
			            `regionid` int(11) unsigned NOT NULL COMMENT '当前小区ID',
			            `gid` int(11) unsigned NOT NULL COMMENT '优惠券id',
			            `type` varchar(10) NOT NULL COMMENT '订单来源类型',
			            `uid` int(11) unsigned NOT NULL COMMENT '用户id',
			            `pid` int(11) unsigned NOT NULL COMMENT '物业费id',
			            `aid` int(11) unsigned NOT NULL COMMENT '活动预约id',
			            PRIMARY KEY (`id`)
			          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25  COMMENT='订单表';
			CREATE TABLE IF NOT EXISTS `ims_xcommunity_homemaking` (
			        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			        `weid` int(10) unsigned NOT NULL,
			        `openid` varchar(50) NOT NULL,
			        `regionid` int(10) unsigned NOT NULL,
			        `category` int(11) NOT NULL COMMENT '服务类型' ,
			        `servicetime` varchar(30) NOT NULL COMMENT '服务时间',
			        `realname` varchar(30) NOT NULL COMMENT '姓名',
			        `mobile` varchar(15) NOT NULL COMMENT '电话',
			        `address` varchar(15) NOT NULL COMMENT '地址',
			        `content` varchar(500) NOT NULL COMMENT '说明',
			        `status` int(10) unsigned NOT NULL COMMENT '0未完成,1已完成',
			        `createtime` int(10) unsigned NOT NULL,
			        PRIMARY KEY (`id`)
			      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='家政服务表';
			CREATE TABLE IF NOT EXISTS `ims_xcommunity_menu` (
			        `id` int(11) NOT NULL AUTO_INCREMENT,
			        `uniacid` int(11) NOT NULL,
			        `pcate` int(10) NOT NULL,
			        `title` varchar(30) NOT NULL COMMENT '菜单标题',
			        `url` varchar(1000) NOT NULL COMMENT '菜单链接',
			        `do` varchar(20) NOT NULL COMMENT '动作',
			        PRIMARY KEY (`id`)
			      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='后台菜单管理';
			CREATE TABLE IF NOT EXISTS `ims_xcommunity_houselease` (
			        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			        `weid` int(10) unsigned NOT NULL,
			        `openid` varchar(50) NOT NULL,
			        `regionid` int(10) unsigned NOT NULL,
			        `category` int(11) NOT NULL COMMENT '1出租，2求租，3出售，4求购' ,
			        `way` varchar(20) NOT NULL COMMENT '出租方式',
			        `model_room` int(11) NOT NULL COMMENT '' ,
			        `model_hall` int(11) NOT NULL COMMENT '' ,
			        `model_toilet` int(11) NOT NULL COMMENT '' ,
			        `model_area` varchar(15) NOT NULL COMMENT '房屋面积',
			        `floor_layer` int(11) NOT NULL COMMENT '' ,
			        `floor_number` int(11) NOT NULL COMMENT '' ,
			        `fitment` varchar(40) NOT NULL COMMENT '装修情况' ,
			        `house` varchar(40) NOT NULL COMMENT '住宅类别' ,
			        `allocation` varchar(500) NOT NULL COMMENT '房屋配置',
			        `price_way` varchar(30) NOT NULL COMMENT '押金方式',
			        `price` int(10) unsigned NOT NULL COMMENT '租金',
			        `checktime` varchar(30) NOT NULL COMMENT '入住时间',
			        `title` varchar(30) NOT NULL COMMENT '标题',
			        `realname` varchar(30) NOT NULL COMMENT '姓名',
			        `mobile` varchar(15) NOT NULL COMMENT '电话',
			        `content` varchar(500) NOT NULL COMMENT '说明',
			        `status` int(10) unsigned NOT NULL COMMENT '0未成交,1已成交',
			        `createtime` int(10) unsigned NOT NULL,
			        `images` text,
			        PRIMARY KEY (`id`)
			      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='房屋租赁表';
			      CREATE TABLE IF NOT EXISTS `ims_xcommunity_cost_list` (
			          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			          `weid` int(10) unsigned NOT NULL,
			          `regionid` int(10) unsigned NOT NULL,
			          `cid` int(10) unsigned NOT NULL COMMENT'费用时间id',
			          `mobile`   varchar(13) NOT NULL,
			          `username`   varchar(30) NOT NULL,
			          `homenumber` varchar(30)  NOT NULL,
			          `costtime` varchar(30)  NOT NULL,
			          `propertyfee` varchar(50)  NOT NULL,
			          `otherfee` varchar(1000)  NOT NULL,
			          `total` varchar(10)  NOT NULL,
			          `createtime` int(10) unsigned NOT NULL,
			          `status` varchar(3)  NOT NULL COMMENT '是代表缴费，否代表未缴费',
			          `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
			          `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
			          PRIMARY KEY (`id`)
			        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='物业费表';
			        CREATE TABLE IF NOT EXISTS `ims_xcommunity_cost` (
			          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			          `weid` int(10) unsigned NOT NULL,
			          `createtime` int(10) unsigned NOT NULL,
			          `regionid` int(10) unsigned NOT NULL,
			          `costtime` varchar(30)  NOT NULL COMMENT'费用时间',
			          PRIMARY KEY (`id`)
			        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='物业费用时间表';
			        CREATE TABLE IF NOT EXISTS `ims_xcommunity_reading_member` (
			        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			        `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
			        `aid` int(10) unsigned NOT NULL COMMENT '公告id',
			        `openid` varchar(50) NOT NULL COMMENT '',
			        `status` varchar(1000) NOT NULL COMMENT '',
			        PRIMARY KEY (`id`)
			      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公告阅读记录表';
			        CREATE TABLE IF NOT EXISTS `ims_xcommunity_set` (
			        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			        `uniacid` int(10) unsigned NOT NULL,
			        `code_status` int(10) unsigned NOT NULL COMMENT'验证码开启',
			        `room_status` int(10) unsigned NOT NULL COMMENT'验证码开启',
			        `room_enable` int(10) unsigned NOT NULL COMMENT'验证码开启',
			        `range` int(10) unsigned NOT NULL COMMENT 'lbs范围',
			        PRIMARY KEY (`id`)
			      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='小区设置' AUTO_INCREMENT=1 ;
			       CREATE TABLE IF NOT EXISTS `ims_xcommunity_room` (
			        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			        `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
			        `mobile` varchar(13) NOT NULL COMMENT '',
			        `room` varchar(50) NOT NULL COMMENT '',
			        `code` varchar(10) NOT NULL COMMENT '',
			        `regionid` int(10) unsigned NOT NULL COMMENT '',
			        PRIMARY KEY (`id`)
			      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='房号表';
			       CREATE TABLE IF NOT EXISTS `ims_xcommunity_pay` (
			              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			              `uniacid` int(10) unsigned NOT NULL,
			              `pay` varchar(200) NOT NULL,
			              `type` int(1) NOT NULL COMMENT '1超市2物业费3商家4小区活动',
			              PRIMARY KEY (`id`)
			            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 COMMENT='支付方式配置表';
			       CREATE TABLE IF NOT EXISTS `ims_xcommunity_alipayment` (
			              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			              `uniacid` int(10) NOT NULL COMMENT '公众号ID',
			              `pid` int(11) NOT NULL,
			              `account` varchar(50) NOT NULL COMMENT '支付宝账号',
			              `partner` varchar(50) NOT NULL COMMENT '合作者身份',
			              `secret` varchar(50) NOT NULL COMMENT '校验密钥',
			              PRIMARY KEY (`id`)
			            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='独立支付宝配置';
		";
		pdo_run($sql);
		/**V6.3.9增加字段**/
		if(!pdo_fieldexists('xcommunity_menu', 'method')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_menu')." ADD `method` varchar(20) ;");
		}
		/**V6.4.0修复字段**/
		if(pdo_fieldexists('xcommunity_homemaking', 'address')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_homemaking')." modify column `address` varchar(100) ;");
		}
		/**V6.4.2修复字段**/
		if(pdo_fieldexists('xcommunity_region', 'qq')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_region')." modify column `qq` varchar(15) ;");
		}
		/**V6.4.3修复字段**/
		if(pdo_fieldexists('xcommunity_announcement', 'reason')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')." modify column `reason` text ;");
		}
		if(pdo_fieldexists('xcommunity_announcement', 'regionid')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')." modify column `regionid` text ;");
		}
		/**V6.4.6修复字段**/
		if (pdo_tableexists('xcommunity_menu')) {
			pdo_query(" DELETE FROM".tablename('xcommunity_menu'));
		}
		if(!pdo_fieldexists('xcommunity_room', 'realname')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_room')." ADD `realname` varchar(30) ;");
		}
		if(!pdo_fieldexists('xcommunity_room', 'status')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_room')." ADD `status` int(1) ;");
		}
		if(!pdo_fieldexists('xcommunity_room', 'pid')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_room')." ADD `pid` int(11) ;");
		}
		/**V6.4.7修复字段**/
		if(!pdo_fieldexists('xcommunity_wechat_tplid', 'report_wc_tplid')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_tplid')." ADD `report_wc_tplid` varchar(80) ;");
		}
		if(!pdo_fieldexists('xcommunity_wechat_notice', 'change_status')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')." ADD `change_status` int(1) ;");
		}

		message('修复成功',referer(),'success');
	}
	include $this->template('web/system/field');
}
