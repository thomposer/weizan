<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
if ($rdisplay['ipannounce'] == 1) {
	$announce = pdo_fetchall("SELECT nickname,content,createtime,url FROM " . tablename($this->table_announce) . " WHERE uniacid= '{$uniacid}' AND rid= '{$rid}' ORDER BY id DESC");
}

//赞助商
if ($rdisplay['isdes'] == 1) {
	$advs = pdo_fetchall("SELECT advname,link,thumb FROM " . tablename($this->table_advs) . " WHERE enabled=1 AND ismiaoxian = 0 AND uniacid= '{$uniacid}'  AND rid= '{$rid}' ORDER BY displayorder ASC");
}
if(!empty($from_user)) {
    $mygift = pdo_fetch("SELECT * FROM ".tablename($this->table_users)." WHERE from_user = :from_user and rid = :rid", array(':from_user' => $from_user,':rid' => $rid));
	
}

$tagid = $_GPC['tagid'];
$ptag = $_GPC['tagpid'];
$tagname = $this->gettagname($tagid,$ptag,$rid);
$tags = pdo_fetchall("SELECT id,parentid,title FROM ".tablename($this->table_tags)." WHERE rid = '{$rid}' ORDER BY parentid ASC, displayorder ASC, id ASC ", array(), 'id');
$parent = array();
$children = array();

if (!empty($tags)) {
	$children = '';
	foreach ($tags as $cid => $cate) {
		$cate['name'] = $cate['title'];
		if (!empty($cate['parentid'])) {
			$children[$cate['parentid']][] = $cate;
		} else {
			$parent[$cate['id']] = $cate;
		}
	}
}


//$reply['sharetitle']= $this->get_share($uniacid,$rid,$from_user,$reply['sharetitle']);
//$reply['sharecontent']= $this->get_share($uniacid,$rid,$from_user,$reply['sharecontent']);

//整理数据进行页面显示		
//$myavatar = $avatar;
//$mynickname = $nickname;
//$shareurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('shareuserview', array('rid' => $rid,'fromuser' => $from_user));//分享URL
//$regurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('reg', array('rid' => $rid));//关注或借用直接注册页
//$guanzhu = $rshare['shareurl'];//没有关注用户跳转引导页
//$lingjiangurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('lingjiang', array('rid' => $rid));//领奖URL
//$mygifturl = $_W['siteroot'] .'app/'.$this->createMobileUrl('photosvote', array('rid' => $rid));//我的页面
$title = $rbasic['title'];


$_share['link'] = $_W['siteroot'] .'app/'.$this->createMobileUrl('shareuserview', array('rid' => $rid,'fromuser' => $from_user));//分享URL
 $_share['title'] = $this->get_share($uniacid,$rid,$from_user,$rshare['sharetitle']);
$_share['content'] =  $this->get_share($uniacid,$rid,$from_user,$rshare['sharecontent']);
$_share['imgUrl'] = toimage($rshare['sharephoto']);		


$templatename = $rbasic['templates'];
$toye = $this->templatec($templatename,$_GPC['do']);
include $this->template($toye);
