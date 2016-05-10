<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 * @function 输出瀑布流队列
 */
defined('IN_IA') or exit('Access Denied');
		$rid = $_GPC['rid'];
		$item_per_page = empty($_GPC['indextpxz']) ? 10 : $_GPC['indextpxz'];
		$page_number = max(1, intval($_GPC['pagesnum']));  
		if(!is_numeric($page_number)){  
   			header('HTTP/1.1 500 Invalid page number!');  
    		exit();  
		}
      	//print_r($_GPC['indextpxz']);
		$position = ($page_number-1) * $item_per_page;  
		$where = '';
		if (!empty($_GPC['keyword'])) {
				$keyword = $_GPC['keyword'];
				if (is_numeric($keyword)) 
					$where .= " AND uid = '".$keyword."'";
				else 				
					$where .= " AND (nickname LIKE '%{$keyword}%' OR realname LIKE '%{$keyword}%' )";
			
		}
		
		$where .= " AND status = '1'";


		$tagid = $_GPC['tagid'];
		$tagpid = $_GPC['tagpid'];
		
		if (!empty($tagid)) {
			$where .= " AND tagid = '".$tagid."'";
		}elseif (!empty($tagpid)) {
			$where .= " AND tagpid = '".$tagpid."'";
		}
		
		if ($_GPC['indexorder'] == '1') {
			$where .= " ORDER BY `istuijian` DESC, `createtime` DESC";
		}elseif ($_GPC['indexorder'] == '11') {
			$where .= " ORDER BY `istuijian` DESC, `createtime` ASC";
		}elseif ($_GPC['indexorder'] == '2') {
			$where .= " ORDER BY `istuijian` DESC, `uid` DESC, `id` DESC";
		}elseif ($_GPC['indexorder'] == '22') {
			$where .= " ORDER BY `istuijian` DESC, `uid` ASC, `id` ASC";
		}elseif ($_GPC['indexorder'] == '3') {
			$where .= " ORDER BY `istuijian` DESC, `photosnum` + `xnphotosnum` DESC";
		}elseif ($_GPC['indexorder'] == '33') {
			$where .= " ORDER BY `istuijian` DESC, `photosnum` + `xnphotosnum` ASC";
		}elseif ($_GPC['indexorder'] == '4') {
			$where .= " ORDER BY `istuijian` DESC, `hits` + `xnhits` DESC";
		}elseif ($_GPC['indexorder'] == '44') {
			$where .= " ORDER BY `istuijian` DESC, `hits` + `xnhits` ASC";
		}elseif ($_GPC['indexorder'] == '5') {
			$where .= " ORDER BY `istuijian` DESC, `vedio` DESC, `music` DESC, `id` DESC";
		}else {
			$where .= " ORDER BY `istuijian` DESC, `id` DESC";
		}

		
		
		

		$userlist = pdo_fetchall('SELECT id,uid,from_user,nickname,realname,avatar,photosnum,xnphotosnum,istuijian FROM '.tablename($this->table_users).' WHERE rid = :rid '.$where.'  LIMIT ' . $position . ',' . $item_per_page, array(':rid' => $rid) );
		
		foreach ($userlist as $key => $row) {
			$fmimage = $this->getpicarr($uniacid,$rid, $row['from_user'],1);	
			$userlist[$key]['avatar'] = $this->getphotos($fmimage['photos'], $row['avatar'], $row['avatar']);
			$userlist[$key]['username'] .= $this->getusernames($row['realname'], $row['nickname'], '10');
			$userlist[$key]['piao'] .= $row['photosnum'] + $row['xnphotosnum'];
		}
		
		if (!empty($userlist)) {
			//赞助商
			if ($_GPC['isindex'] == 1) {
				$advs = pdo_fetchall('SELECT advname, thumb, link FROM '.tablename($this->table_advs).' WHERE rid = :rid AND enabled = 1 AND ismiaoxian = 0 AND issuiji = 1  ', array(':rid' => $rid) );
				if (!empty($advs)) {
					$adv  = array_rand($advs);
					$advarr = array();
					$advarr['avatar'] .= toimage($advs[$adv]['thumb']);
					$advarr['username'] .= cutstr($advs[$adv]['advname'], '10');
					$advarr['link'] .= $advs[$adv]['link'];
					$advarr['type'] .= 'adv';
					$userlist[] = $advarr;
				}
			}
		}
			
    	echo json_encode($userlist);
		exit;