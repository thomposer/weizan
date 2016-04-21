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
	$do = $_GPC['do'];
	$GLOBALS['frames'] = $this->NavMenu($do);
	$menu = $this->NavMenu($do);
	$url = $menu[0]['items'][0]['url'];
	header("location: " . $url);