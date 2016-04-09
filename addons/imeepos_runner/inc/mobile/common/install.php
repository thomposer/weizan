<?php 
if(!pdo_tableexists('imeepos_runner3_member')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `uniacid` int(11) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `groupid` int(11) unsigned NOT NULL,
  `time` int(11) DEFAULT NULL,
  `openid` varchar(64) DEFAULT NULL,
  `online` tinyint(2) DEFAULT '0',
  `nickname` varchar(32) DEFAULT '',
  `avatar` varchar(320) DEFAULT NULL,
  `gender` tinyint(2) DEFAULT '0',
  `city` varchar(32) DEFAULT '',
  `provice` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8";
	pdo_query($sql);
}


if(!pdo_tableexists('imeepos_runner3_listenlog')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_listenlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_tableexists('imeepos_runner3_tasks')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '1',
  `create_time` int(11) DEFAULT '0',
  `cityid` int(11) DEFAULT '0',
  `media_id` varchar(132) DEFAULT '',
  `openid` varchar(64) DEFAULT '',
  `desc` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_tasks','desc')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD COLUMN `desc` text");
}

if(!pdo_tableexists('imeepos_runner3_setting')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `code` varchar(32) DEFAULT '',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_tableexists('imeepos_runner3_detail')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `goodsweight` float(10,2) DEFAULT '0.00',
  `goodscost` float(10,2) DEFAULT '0.00',
  `goodsname` varchar(64) DEFAULT '',
  `sendprovince` varchar(32) DEFAULT '',
  `sendcity` varchar(32) DEFAULT '',
  `sendaddress` varchar(132) DEFAULT '',
  `receiveprovince` varchar(32) DEFAULT '',
  `receivecity` varchar(32) DEFAULT '',
  `receiveaddress` varchar(132) DEFAULT '',
  `pickupdate` int(11) DEFAULT '0',
  `sendlon` varchar(64) DEFAULT '',
  `sendlat` varchar(64) DEFAULT '',
  `receivelon` varchar(64) DEFAULT '',
  `receivelat` varchar(64) DEFAULT '',
  `distance` int(11) DEFAULT '0',
  `dataTimeValue` int(11) DEFAULT '0',
  `time` tinyint(2) DEFAULT '0',
  `base_fee` float(10,2) DEFAULT '0.00',
  `fee` float(10,2) DEFAULT '0.00',
  `total` float(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_detail','base_fee')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD COLUMN `base_fee` float(10,2) DEFAULT '0.00'");
}
if(!pdo_fieldexists('imeepos_runner3_detail','fee')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD COLUMN `fee` float(10,2) DEFAULT '0.00'");
}
if(!pdo_fieldexists('imeepos_runner3_detail','total')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD COLUMN `total` float(10,2) DEFAULT '0.00'");
}


if(!pdo_tableexists('imeepos_runner3_paylog')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `tid` varchar(64) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `setting` text,
  `status` tinyint(2) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `fee` float(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_paylog','fee')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_paylog')." ADD COLUMN `fee` float(10,2) DEFAULT '0.00'");
}

if(!pdo_fieldexists('imeepos_runner3_paylog','type')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_paylog')." ADD COLUMN `type` varchar(32) DEFAULT ''");
}

if(!pdo_tableexists('imeepos_runner3_buy')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `freight` float(10,2) DEFAULT '0.00',
  `title` varchar(132) DEFAULT '',
  `buyprovince` varchar(32) DEFAULT '',
  `buycity` varchar(32) DEFAULT '',
  `province` varchar(32) DEFAULT '',
  `city` varchar(32) DEFAULT '',
  `address` varchar(132) DEFAULT '',
  `receivelon` varchar(32) DEFAULT '',
  `receivelat` varchar(32) DEFAULT '',
  `expectedtime` int(11) DEFAULT '0',
  `buyaddress` varchar(132) DEFAULT '',
  `sendlon` varchar(32) DEFAULT '',
  `sendlat` varchar(32) DEFAULT '',
  `other` varchar(320) DEFAULT '',
  `distance` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_buy','limit_time')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD COLUMN `limit_time` int(11) DEFAULT '0'");
}

if(!pdo_fieldexists('imeepos_runner3_buy','receiveaddress')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD COLUMN `receiveaddress` varchar(132) DEFAULT ''");
}

if(!pdo_fieldexists('imeepos_runner3_tasks','city')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD COLUMN `city` varchar(32) DEFAULT ''");
}

if(!pdo_fieldexists('imeepos_runner3_tasks','type')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD COLUMN `type` tinyint(4) DEFAULT '0'");
}

if(!pdo_tableexists('imeepos_runner3_recive')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_recive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `taskid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `fee` float(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_member','realname')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `realname` varchar(32) DEFAULT ''");
}

if(!pdo_fieldexists('imeepos_runner3_member','mobile')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `mobile` varchar(32) DEFAULT ''");
}

if(!pdo_fieldexists('imeepos_runner3_member','xinyu')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `xinyu` int(11) DEFAULT '0'");
}
if(!pdo_fieldexists('imeepos_runner3_member','isrunner')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `isrunner` tinyint(2) DEFAULT '0'");
}

if(!pdo_tableexists('imeepos_runner3_moneylog')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_moneylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `reciveid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `fee` float(10,2) DEFAULT '0.00',
  `openid` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_tableexists('imeepos_runner3_code')){
	$sql = "CREATE TABLE `ims_imeepos_runner3_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(32) DEFAULT '',
  `code` varchar(32) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `content` varchar(320) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	pdo_query($sql);
}

if(!pdo_fieldexists('imeepos_runner3_code','uniacid')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_code')." ADD COLUMN `uniacid` int(11) DEFAULT '0'");
}
if(!pdo_fieldexists('imeepos_runner3_code','openid')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_code')." ADD COLUMN `openid` varchar(64) DEFAULT ''");
}

if(!pdo_fieldexists('imeepos_runner3_member','card_image1')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `card_image1` varchar(320) DEFAULT ''");
}
if(!pdo_fieldexists('imeepos_runner3_member','card_image2')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `card_image2` varchar(320) DEFAULT ''");
}
if(!pdo_fieldexists('imeepos_runner3_member','cardnum')){
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD COLUMN `cardnum` varchar(64) DEFAULT ''");
}