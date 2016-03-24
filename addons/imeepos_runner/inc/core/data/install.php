<?php
if(!pdo_tableexists('meepo_common_menu')){
	$sql = "CREATE TABLE ".tablename('meepo_common_menu')." (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL DEFAULT '',
  `icon` varchar(132) NOT NULL DEFAULT '',
  `module` varchar(32) NOT NULL DEFAULT '',
  `code` varchar(32) DEFAULT '',
  `pluginid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8";
pdo_query($sql);
}
if(!pdo_tableexists('meepo_module_update')){
	$sql = "CREATE TABLE ".tablename('meepo_module_update')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `module` varchar(64) DEFAULT '',
	  `desc` text,
	  `time` int(11) DEFAULT '0',
	  `version` varchar(64) DEFAULT '',
	  `alltables` text,
	  `files` mediumblob,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_tableexists('imeepos_runner_message')){
	$sql = "CREATE TABLE `ims_imeepos_runner_message` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) DEFAULT '0',
	  `fopenid` varchar(64) DEFAULT '',
	  `topenid` varchar(64) DEFAULT '',
	  `content` varchar(300) DEFAULT '',
	  `status` tinyint(2) DEFAULT '0',
	  `createtime` int(11) DEFAULT '0',
	  `readtime` int(11) DEFAULT '0',
	  `replytime` int(11) DEFAULT '0',
	  `replayid` int(11) DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}


if(!pdo_tableexists('meepo_module')){
	$sql = "CREATE TABLE ".tablename('meepo_module')." (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`module` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名称',
	`set` text NOT NULL COMMENT '模块设置',
	`time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
	PRIMARY KEY (`id`),
	KEY `IDX_MODULE` (`module`) USING BTREE
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='模块安装表'";
	pdo_query($sql);
}

if(!pdo_tableexists('meepo_common_menu')){
	$sql = "CREATE TABLE ".tablename('meepo_common_menu')." (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(32) NOT NULL DEFAULT '',
	`icon` varchar(132) NOT NULL DEFAULT '',
	`module` varchar(32) NOT NULL DEFAULT '',
	`code` varchar(32) DEFAULT '',
	`pluginid` int(11) DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_tableexists('meepo_common_plugin')){
	$sql = "CREATE TABLE ".tablename('meepo_common_plugin')." (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`displayorder` int(11) DEFAULT '0',
	`name` varchar(50) DEFAULT '',
	`version` varchar(10) DEFAULT '',
	`author` varchar(20) DEFAULT '',
	`module` varchar(50) DEFAULT 'Empty String',
	`set` text,
	`desc` text,
	`fee` varchar(32) DEFAULT '',
	`num` int(11) DEFAULT '0',
	`code` varchar(50) DEFAULT '',
	PRIMARY KEY (`id`),
	KEY `idx_displayorder` (`displayorder`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_tableexists('imeepos_runner_tasks_recive_active')){
	$sql = "CREATE TABLE ".tablename('imeepos_runner_tasks_recive_active')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) DEFAULT '0',
	  `uid` int(11) DEFAULT '0',
	  `reciveid` int(11) DEFAULT '0',
	  `taskid` int(11) DEFAULT '0',
	  `openid` varchar(64) DEFAULT '',
	  `lat` varchar(64) DEFAULT '',
	  `lng` varchar(64) DEFAULT '',
	  `address` varchar(128) DEFAULT '',
	  `time` int(11) DEFAULT '0',
	  `desc` varchar(200) DEFAULT '',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}
if(!pdo_tableexists('imeepos_runner_shop_class')){
	$sql = "CREATE TABLE ".tablename('imeepos_runner_shop_class')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) DEFAULT '0',
	  `title` varchar(64) DEFAULT '',
	  `icon` varchar(200) DEFAULT '',
	  `time` int(11) DEFAULT '0',
	  `desc` varchar(300) DEFAULT '',
	  `fid` int(11) DEFAULT '0',
	  `setting` text,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}
if(!pdo_fieldexists('imeepos_runner_shop_class','displayorder')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop_class')." ADD COLUMN `displayorder` int(11) DEFAULT '0'";
	pdo_query($sql);
}
if(!pdo_tableexists('imeepos_runner_shop_goods')){
	$sql = "CREATE TABLE ".tablename('imeepos_runner_shop_goods')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) DEFAULT '0',
	  `cid` int(11) DEFAULT '0',
	  `title` varchar(64) DEFAULT '',
	  `desc` varchar(300) DEFAULT '',
	  `image` varchar(200) DEFAULT '',
	  `thumbs` text,
	  `createtime` int(11) DEFAULT '0',
	  `fee` decimal(10,2) DEFAULT '0.00',
	  `shopid` int(11) DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner_shop_goods','status')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop_goods')." ADD COLUMN `status` tinyint(2) NULL DEFAULT 0 ";
	pdo_query($sql);
}

if(!pdo_tableexists('imeepos_runner_shop')){
	$sql = "CREATE TABLE ".tablename('imeepos_runner_shop')." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uniacid` int(11) DEFAULT '0',
	  `cid` int(11) DEFAULT '0',
	  `title` varchar(64) DEFAULT '',
	  `desc` varchar(300) DEFAULT '',
	  `content` text,
	  `mobile` varchar(32) DEFAULT '',
	  `wechat` varchar(32) DEFAULT '',
	  `createtime` int(11) DEFAULT '0',
	  `image` varchar(200) DEFAULT '',
	  `thumbs` text,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}
if(!pdo_fieldexists('imeepos_runner_shop','status')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop')." ADD COLUMN `status` tinyint(2) NULL DEFAULT 0 ";
	pdo_query($sql);
}
if(!pdo_fieldexists('imeepos_runner_shop','displayorder')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop')." ADD COLUMN `displayorder` int(11) DEFAULT '0'";
	pdo_query($sql);
}
if(!pdo_fieldexists('imeepos_runner_shop','icon')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop')." ADD COLUMN `icon` varchar(200) DEFAULT ''";
	pdo_query($sql);
}
if(!pdo_fieldexists('imeepos_runner_shop','uid')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop')." ADD COLUMN `uid` int(11) DEFAULT '0'";
	pdo_query($sql);
}
if(!pdo_fieldexists('imeepos_runner_shop','opentime')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop')." ADD COLUMN `opentime` varchar(300) DEFAULT ''";
	pdo_query($sql);
}
if(!pdo_fieldexists('imeepos_runner_shop','address')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_shop')." ADD COLUMN `address` varchar(300) DEFAULT ''";
	pdo_query($sql);
}

if(!pdo_fieldexists('meepo_common_menu','code')){
	$sql = "ALTER TABLE ".tablename('meepo_common_menu')." ADD COLUMN `code` varchar(50) DEFAULT ''";
	pdo_query($sql);
}
if(!pdo_fieldexists('meepo_common_menu','pluginid')){
	$sql = "ALTER TABLE ".tablename('meepo_common_menu')." ADD COLUMN `pluginid` int(11) DEFAULT '0'";
	pdo_query($sql);
}

if(!pdo_fieldexists('meepo_common_plugin','code')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `code` varchar(50) DEFAULT ''";
	pdo_query($sql);
}
if(!pdo_fieldexists('meepo_common_plugin','desc')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `desc` text";
	pdo_query($sql);
}
if(!pdo_fieldexists('meepo_common_plugin','num')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `num` int(11) DEFAULT '0'";
	pdo_query($sql);
}
if(!pdo_fieldexists('meepo_common_plugin','fee')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `fee` varchar(32) DEFAULT ''";
	pdo_query($sql);
}


if(!pdo_fieldexists('imeepos_runner_tasks','totalfee')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_tasks')." ADD COLUMN `totalfee` float(10,2) DEFAULT '0.00'";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner_tasks_comment','type')){
	$sql = "ALTER TABLE ".tablename('imeepos_runner_tasks_comment')." ADD COLUMN `type` tinyint(4) DEFAULT '0'";
	pdo_query($sql);
}

if(!pdo_fieldexists('meepo_common_menu','code')){
	$sql = "ALTER TABLE ".tablename('meepo_common_menu')." ADD COLUMN `code` varchar(50) DEFAULT ''";
	pdo_query($sql);
}

if(!pdo_fieldexists('meepo_common_menu','pluginid')){
	$sql = "ALTER TABLE ".tablename('meepo_common_menu')." ADD COLUMN `pluginid` int(11) DEFAULT '0'";
	pdo_query($sql);
}

if(!pdo_fieldexists('meepo_common_plugin','code')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `code` varchar(50) DEFAULT ''";
	pdo_query($sql);
}

if(!pdo_fieldexists('meepo_common_plugin','desc')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `desc` text";
	pdo_query($sql);
}
if(!pdo_fieldexists('meepo_common_plugin','num')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `num` int(11) DEFAULT '0'";
	pdo_query($sql);
}
if(!pdo_fieldexists('meepo_common_plugin','fee')){
	$sql = "ALTER TABLE ".tablename('meepo_common_plugin')." ADD COLUMN `fee` varchar(32) DEFAULT ''";
	pdo_query($sql);
}
