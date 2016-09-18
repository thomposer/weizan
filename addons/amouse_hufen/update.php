<?php
$sql = "

CREATE TABLE IF NOT EXISTS  `ims_amouse_board_product_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_amouse_board_clear_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(255) DEFAULT '',
  `goodsid` int(11) DEFAULT '0',
  `read` int(11) NOT NULL DEFAULT '0',
  `createtime` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT '0' COMMENT '0-未发货 1-已发货 3 取消',
  `usetime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_board_clear_stock_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `openid` varchar(255) DEFAULT '',
  `logo` varchar(255) DEFAULT '',
  `thumb1` varchar(255) DEFAULT '',
  `thumb2` varchar(255) DEFAULT '',
  `thumb3` varchar(255) DEFAULT '',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '市场价',
  `clear_price` decimal(10,2) DEFAULT '0.00' COMMENT '清货价',
  `viewcount` int(11) DEFAULT '0',
  `pcateid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `detail` text,
  `mobile` varchar(18) DEFAULT NULL COMMENT '卖家联系电话',
  `status` tinyint(3) DEFAULT '0',
  `shuaxin` tinyint(2) DEFAULT '0' COMMENT '排序',
  `listorder` int(10) NOT NULL DEFAULT '0',
  `createtime` int(11) DEFAULT '0',
  `endtime` int(11) DEFAULT '0',
  `uptime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_endtime` (`endtime`),
  KEY `idx_uptime` (`uptime`),
  KEY `idx_createtime` (`createtime`),
  KEY `idx_status` (`status`),
  KEY `idx_displayorder` (`displayorder`),
  KEY `idx_openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists('amouse_board_member', 'ipcilent')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_member')."  ADD     `ipcilent` varchar(13) DEFAULT NULL COMMENT 'ip';");
}
if(!pdo_fieldexists('amouse_board_member', 'forever')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_member')."  ADD    `forever` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为未购买过VIP';");
}
if(!pdo_indexexists('amouse_board_log', 'idx_openid')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_log')."  ADD  INDEX `idx_openid` (`openid`);");
}
if(!pdo_fieldexists('amouse_board_card', 'ipcilent')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_card')."  ADD     `ipcilent` varchar(13) DEFAULT NULL COMMENT 'ip';");
}
if(!pdo_indexexists('amouse_board_card', 'idx_openid')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_card')."  ADD  INDEX `idx_openid` (`openid`);");
}
if(!pdo_fieldexists('amouse_board_card_log', 'mid')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_card_log')."  ADD   `mid` int(10) DEFAULT '0';");
}
if(!pdo_fieldexists('amouse_board_sysset', 'deftext')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_sysset')."  ADD    `deftext` text COMMENT '关注者通知';");
}
if(!pdo_fieldexists('amouse_board_sysset', 'sign_credit')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_sysset')."  ADD    `sign_credit` text;");
}
if(pdo_fieldexists('amouse_board_index_sysset', 'ismember')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_index_sysset')."  CHANGE  `ismember` `ismember` tinyint(3) DEFAULT '1';");
}
if(!pdo_fieldexists('amouse_board_order', 'rechargeid')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_order')."  ADD  `rechargeid` int(10) unsigned NOT NULL COMMENT '充值ID';");
}
if(!pdo_fieldexists('amouse_board_card', 'title')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_card')."  ADD   `title` varchar(250) NOT NULL;");
}
if(!pdo_fieldexists('amouse_board_card', 'typeid')) {
	pdo_query("ALTER TABLE ".tablename('amouse_board_card')."  ADD  `typeid` int(10) NOT NULL;");
}