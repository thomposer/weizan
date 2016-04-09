<?php
$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_user' ) . "(
  	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',	
	`tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
  	`weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID',	
  	`openid` varchar(30) NOT NULL COMMENT 'openid',
	`userinfo` text COMMENT '用户信息',
	`pard` int(1) unsigned NOT NULL COMMENT '关系',
  	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态',
  	`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_set' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
    `istplnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否模版通知',
    `xsqingjia` varchar(200) DEFAULT '' COMMENT '学生请假申请ID',
	`xsqjsh` varchar(200) DEFAULT '' COMMENT '学生请假审核通知ID',
	`jsqingjia` varchar(200) DEFAULT '' COMMENT '教员请假申请体提醒ID',
	`jsqjsh` varchar(200) DEFAULT '' COMMENT '教员请假审核通知ID',
	`xxtongzhi` varchar(200) DEFAULT '' COMMENT '学校通知ID',
	`liuyan` varchar(200) DEFAULT '' COMMENT '家长留言ID',
	`liuyanhf` varchar(200) DEFAULT '' COMMENT '教师回复家长留言ID',
	`bjtz` varchar(200) DEFAULT '' COMMENT '班级通知ID',
       PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_leave' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
	`leaveid` int(10) unsigned NOT NULL,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '微赞UID',
	`tuid` int(10) unsigned NOT NULL COMMENT '老师微赞UID',	
	`openid` varchar(200) DEFAULT '' COMMENT 'openid',
	`sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',	
	`tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
	`type` varchar(10) DEFAULT '' COMMENT '请假类型',
    `startime` varchar(200) DEFAULT '' COMMENT '开始时间',
	`endtime` varchar(200) DEFAULT '' COMMENT '结束时间',
	`conet` varchar(200) DEFAULT '' COMMENT '详细内容',
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
	`cltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
	`bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
	`isliuyan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否留言',
       PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
CREATE TABLE IF NOT EXISTS `ims_wx_school_leave` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `leaveid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `uid` int(10) unsigned NOT NULL COMMENT '微赞UID',
  `tuid` int(10) unsigned NOT NULL COMMENT '老师微赞UID',
  `openid` varchar(200) DEFAULT '' COMMENT 'openid',
  `sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',
  `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
  `type` varchar(10) DEFAULT '' COMMENT '请假类型',
  `startime` varchar(200) DEFAULT '' COMMENT '开始时间',
  `endtime` varchar(200) DEFAULT '' COMMENT '结束时间',
  `conet` varchar(200) DEFAULT '' COMMENT '详细内容',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `cltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
  `isliuyan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否留言',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wx_school_notice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `tid` int(10) unsigned NOT NULL COMMENT '教师ID',
  `tname` varchar(10) DEFAULT '' COMMENT '发布老师名字',
  `title` varchar(50) DEFAULT '' COMMENT '文章名称',
  `content` text NOT NULL COMMENT '详细内容',
  `picarr` text COMMENT '用户信息',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否班级通知',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	";
pdo_run($sql);

// 新增  一个学生绑定三个微信号 默认不绑定 
if(!pdo_fieldexists('wx_school_students', 'xjid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `xjid` int(11) unsigned NOT NULL COMMENT '学籍信息';");
}

if(!pdo_fieldexists('wx_school_students', 'mom')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `mom` varchar(30) NOT NULL DEFAULT '0' COMMENT '母亲微信';");
}

if(!pdo_fieldexists('wx_school_students', 'dad')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `dad` varchar(30) NOT NULL DEFAULT '0' COMMENT '父亲微信';");
}

if(!pdo_fieldexists('wx_school_students', 'ouid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `ouid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(!pdo_fieldexists('wx_school_students', 'muid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `muid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(!pdo_fieldexists('wx_school_students', 'duid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `duid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(!pdo_fieldexists('wx_school_classify', 'erwei')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `erwei` varchar(200) NOT NULL DEFAULT '' COMMENT '群二维码';");
}

if(!pdo_fieldexists('wx_school_classify', 'qun')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `qun` varchar(200) NOT NULL DEFAULT '' COMMENT 'Q群链接';");
}

if(!pdo_fieldexists('wx_school_classify', 'tid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `tid` int(11) unsigned NOT NULL COMMENT '班级主任userid';");
}

if(!pdo_fieldexists('wx_school_teachers', 'code')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `code` int(11) unsigned NOT NULL COMMENT '绑定码';");
}

if(!pdo_fieldexists('wx_school_teachers', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `openid` varchar(30) NOT NULL DEFAULT '0' COMMENT '老师微信';");
}

if(!pdo_fieldexists('wx_school_teachers', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `uid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(pdo_fieldexists('wx_school_students', 'wecha_id')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_students')." CHANGE `wecha_id` `own` varchar(30) NOT NULL DEFAULT '0' COMMENT '自己微信';");
}

if(pdo_fieldexists('wx_school_user', 'status')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `status` `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态';");
}

if(pdo_fieldexists('wx_school_bbsreply', 'iparr')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_bbsreply')." CHANGE `iparr` `shenfen` int(1) unsigned NOT NULL COMMENT '1为班主任，2为母亲，3为父亲，4为本人';");
}

if(pdo_fieldexists('wx_school_user', 'sid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `sid` `sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID';");
}

if(pdo_fieldexists('wx_school_user', 'tid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `tid` `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老师ID';");
}
if(!pdo_fieldexists('wx_school_teachers', 'com')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD   `com` varchar(30) NOT NULL DEFAULT '0' COMMENT '0';");
}

if(!pdo_fieldexists('wx_school_students', 'weixin')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `weixin` varchar(30) NOT NULL DEFAULT '0' COMMENT '0';");
}
if(!pdo_fieldexists('wx_school_students', 'own')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `own` varchar(30) NOT NULL DEFAULT '0' COMMENT '自己微信';");
}
if(!pdo_fieldexists('wx_school_students', 'xjid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `xjid` int(11) unsigned NOT NULL COMMENT '学籍信息';");
}
if(!pdo_fieldexists('wx_school_students', 'mom')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `mom` varchar(30) NOT NULL DEFAULT '0' COMMENT '母亲微信';");
}
if(!pdo_fieldexists('wx_school_students', 'dad')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD     `dad` varchar(30) NOT NULL DEFAULT '0' COMMENT '父亲微信';");
}
if(!pdo_fieldexists('wx_school_students', 'ouid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `ouid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_students', 'duid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD     `duid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_students', 'muid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD    `muid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_teachers', 'code')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD    `code` int(11) unsigned NOT NULL COMMENT '绑定码';");
}

if(!pdo_fieldexists('wx_school_teachers', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD     `openid` varchar(30) NOT NULL DEFAULT '0' COMMENT '老师微信';");
}

if(!pdo_fieldexists('wx_school_teachers', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD    `uid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_notice', 'groupid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD   `groupid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为全体师生2为全体教师3为全体家长和学生';");
}
if(!pdo_fieldexists('wx_school_user', 'status')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_user')." ADD    `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态';");
}

if(!pdo_fieldexists('wx_school_notice', 'km_id')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD     `km_id` int(10) unsigned NOT NULL COMMENT '科目ID';");
}

if(!pdo_fieldexists('wx_school_set', 'zuoye')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD    `zuoye` varchar(200) DEFAULT '' COMMENT '发布作业提醒ID';");
}