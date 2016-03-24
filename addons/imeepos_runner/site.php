<?php
/**
 * 小明跑腿模块微站定义
 *
 * @author imeepos
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
if (file_exists(IA_ROOT . '/addons/imeepos_runner/inc/core/init.php')) {
	include IA_ROOT . '/addons/imeepos_runner/inc/core/init.php';
}
define('EARTH_RADIUS', 6371);
class Imeepos_runnerModuleSite extends WeModuleSite {
	public function payResult($ret){
		global $_W;
		load()->model('mc');
		$tid = $ret['tid'];
		$uid = mc_openid2uid($ret['user']);
		$sql = "SELECT * FROM ".tablename('imeepos_runner_paylog')." WHERE uniacid = :uniacid AND tid = :tid";
		$params = array(':uniacid'=>$_W['uniacid'],':tid'=>$tid);
		$paylog = pdo_fetch($sql,$params);
		
		$result = $ret['result'];
		if($result == 'success'){
			pdo_update('imeepos_runner_paylog',array('status'=>1),array('uniacid'=>$_W['uniacid'],'tid'=>$tid));
			$type = intval($paylog['type']);
			if($type == 1){
				//任务发布
				pdo_update('imeepos_runner_tasks',array('status'=>1),array('uniacid'=>$_W['uniacid'],'ordersn'=>$tid));
				$sql = "SELECT * FROM ".tablename('imeepos_runner_tasks')." WHERE uniacid = :uniacid AND ordersn = :ordersn";
				$params = array(':uniacid'=>$_W['uniacid'],':ordersn'=>$tid);
				$task = pdo_fetch($sql,$params);
				
				$data = array();
				$data['code'] = 0;
				$data['message'] = '支付成功';
				$data['data'] = $task['id'];
				die(json_encode($data));
			}
			
			if($type == 2){
				//跑腿认证
				$sql = "SELECT * FROM ".tablename('imeepos_runner_member_paylog')." WHERE ordersn = :ordersn AND uniacid = :uniacid";
				$params = array(':ordersn'=>$tid,':uniacid'=>$_W['uniacid']);
				$log = pdo_fetch($sql,$params);
				pdo_update('imeepos_runner_member_paylog', $data, array('ordersn' => $tid,'uniacid'=>$_W['uniacid']));
				$sql = "SELECT * FROM " . tablename('imeepos_runner_runner') . " WHERE uid = :uid";
				$par = array(':uid' => $uid);
				$runner = pdo_fetch($sql, $par);
				
				if (empty($runner)) {
					//插入跑腿婊
					$data = array();
					$data['uniacid'] = $_W['uniacid'];
					$data['uid'] = $uid;
					$data['time'] = time();
					$data['status'] = 0;
					$data['groupid'] = $log['groupid'];
					pdo_insert('imeepos_runner_runner', $data);
				} else {
					$data = array();
					$data['uniacid'] = $_W['uniacid'];
					$data['uid'] = $uid;
					$data['time'] = time();
					$data['status'] = 0;
					$data['groupid'] = $log['groupid'];
					pdo_update('imeepos_runner_runner', $data, array('uid' => $uid));
				}
			
				$startnum = $group['startnum'];
				$sql = "SELECT * FROM " . tablename('imeepos_runner_member') . " WHERE uid = :uid";
				$par = array(':uid' => $uid);
				$member = pdo_fetch($sql, $par);
			
				//增加经验
				$credit_runner = $member['credit_runner'] + $startnum;
				$credit_deposit = $member['credit_deposit'] + $group['price'];
				pdo_update('imeepos_runner_member', array('credit_runner' => $credit_runner, 'credit_deposit' => $credit_deposit, 'is_runner' => 1), array('uid' => $uid));
				mload() -> model('imc');
				imc_notice_runner_credit_change($_W['openid'], $_W['member']['uid'], $startnum, $url = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('user'), $remark = '认证跑腿员赠送');
				$data = array();
				$data['code'] = 0;
				$data['data'] = $tid;
				$data['message'] = '支付成功';
			
				die(json_encode($data));
			}
		}
	}
	
	public function doMobileConfirm(){
		//确认订单
		global $_W,$_GPC;
		$type = trim($_GPC['type']);
		$uid = $this->getUid();
		if(empty($uid)){
			$data = array();
			$data['code'] = -2;
			$data['message'] = '登陆失效，请重新打开！';
			$data['uid'] = $uid;
			die(json_encode($data));
		}
		$userinfo = $this->userInfo();
		//发布任务
		if($type == '1'){
			$tid = intval($_GPC['tid']);
			$task = $this->getTaskDetail($tid);
			if(!empty($task['endtime'])){
				if($task['endtime']>$task['starttime']){
					$task['timelimit'] = '约'.ceil(($task['endtime']-$task['starttime'])/3600).'小时';
				}else{
					$task['timelimit'] = '已过期';
				}
			}else{
				$task['timelimit'] = '不限时长';
			}
			$task['starttime'] = date('Y-m-d h:i',$task['starttime']);
			$task['endtime'] = date('Y-m-d h:i',$task['endtime']);
			$task['totalfee'] = $task['totalfee'] - floatval($_W['meepo_totalfee']);
			$cid = $task['cid'];
			$set = $this->getClassSet($cid);
			include $this->template('mui/task_confirm');
		}
	}

	public function doMobileIndex() {
		global $_W, $_GPC;
		//pdo_update('imeepos_runner_tasks',array('status'=>1));
		$userinfo = $this -> userInfo();
		if(empty($userinfo)){
			$userinfo = array();
		}
		$template = $this -> getTemplate();
		$uid = $this->getUid();
		if(empty($uid)){
			$uid = 0;
		}
		if ($template == 'webApp') {
			include $this -> template('webApp/index');
		} else {
			$pagetype = 1;
			$re = $this -> getPageInfo($pagetype);
			$data = $re['data'];
			$pageinfo = $re['pageinfo'];
			//pdo_delete('imeepos_runner_tasks',array('uniacid'=>$_W['uniacid']));
			$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE uniacid = :uniacid AND peoplelimit >0 AND status = 1 ORDER BY createtime DESC";
			$params = array(':uniacid' => $_W['uniacid']);
			$list = pdo_fetchall($sql, $params);
			$orders = array();
			
			foreach ($list as $li) {
				$user = mc_fetch($li['uid']);
				$li['avatar'] = tomedia($user['avatar']);
				$li['nickname'] = $user['nickname'];
				//获取分类
				$li['ctitle'] = $this -> getClassTitle($li['cid']);
				$li['createtime'] = $this -> format_created_at($li['createtime']);
				
				$set = $this -> getClassSet($li['cid']);
				
				$orders[] = $this -> formatRestJson($li);
			}
			include $this -> template('page');
		}
	}

	public function doMobileOnline() {
		global $_W, $_GPC;
		load() -> model('mc');
		$uid = $_W['member']['uid'] > 0 ? $_W['member']['uid'] : mc_openid2uid($_W['openid']);

		if ($uid > 0) {
			$userinfo = mc_fetch($uid, array('avatar', 'nickname'));
		} else {
			$userinfo = mc_oauth_userinfo();
		}
		$userinfo['uniacid'] = $_W['uniacid'];
		$userinfo['openid'] = $_W['openid'];
		$sql = "SELECT * FROM " . tablename('imeepos_runner_adv') . " WHERE uniacid = :uniacid AND status = :status AND isfull = :isfull";
		$params = array(':uniacid' => $_W['uniacid'], ':status' => 1, ':isfull' => 0);
		$list = pdo_fetchall($sql, $params);
		$advs = array();
		foreach ($list as $li) {
			$l['image'] = tomedia($li['image']);
			$l['link'] = $li['link'];
			$advs[] = $l;
		}
		unset($l);
		unset($list);

		$template = $this -> getTemplate();
		include $this -> template($template . '/online');
	}

	public function doMobileService() {
		global $_W, $_GPC;
		$pagetype = 2;
		$re = $this -> getPageInfo($pagetype);
		$data = $re['data'];
		$pageinfo = $re['pageinfo'];
		$services = $this -> getServices();
		include $this -> template('page');
	}

	public function doMobileMessage() {
		global $_W, $_GPC;
		$template = $this -> getTemplate();
		$act = !empty($_GPC['act']) ? trim($_GPC['act']) : 'index';
		if ($act == 'index') {
			$pagetype = 4;
			$re = $this -> getPageInfo($pagetype);
			$data = $re['data'];
			$pageinfo = $re['pageinfo'];
			include $this -> template($template . '/message');
		}
		if ($act == 'list') {
			include $this -> template($template . '/message_list');
		}
		if ($act == 'detail') {
			include $this -> template($template . '/message_detail');
		}
		if ($act == 'post') {
			include $this -> template($template . '/message_post');
		}
	}

	public function doMobileMap() {
		global $_W, $_GPC;
		$template = $this -> getTemplate();
		$userinfo = $this -> userInfo();
		$runners = $this -> getAllRunner();
		$tasks = $this -> getAllTasks();
		$taskcount = count($tasks);
		$act = !empty($_GPC['act']) ? trim($_GPC['act']) : 'map';
		if ($act == 'map') {
			include $this -> template($template . '/map');
		}
		if ($act == 'post') {
			include $this -> template($template . '/map_post');
		}
		if ($act == 'edit') {
			include $this -> template($template . '/map_edit');
		}
		if ($act == 'delete') {
			include $this -> template($template . '/map_delete');
		}
		if ($act == 'info') {
			include $this -> template($template . '/map_info');
		}
		if ($act == 'mylocation') {
			$input = $_GPC['__input'];
			$uid = $this -> getUid();
			$profile = $this -> getProfile($uid);
			$data = array();
			$data['latitude'] = $input['lat'];
			$data['longitude'] = $input['lng'];
			if (!empty($profile)) {
				pdo_update('imeepos_runner_member_profile', $data, array('uniacid' => $_W['uniacid'], 'uid' => $uid));
			} else {
				$data['uid'] = $uid;
				$data['openid'] = $_W['openid'];
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('imeepos_runner_member_profile', $data);
			}
		}
	}

	public function doMobileShop() {
		global $_W, $_GPC;
		$template = $this -> getTemplate();
		if ($template == 'webApp') {
			$url = $this -> createMobileUrl('index');
			header("location:$url");
			exit();
		}
		$act = !empty($_GPC['act']) ? trim($_GPC['act']) : 'list';
		//完成
		if ($act == 'list') {
			$pagetype = 2;
			$re = $this -> getPageInfo($pagetype);
			$data = $re['data'];
			$pageinfo = $re['pageinfo'];
			include $this -> template($template . '/shop');
		} else if ($act == 'post') {
			include $this -> template($template . '/shop_post');
		} else if ($act == 'edit') {
			include $this -> template($template . '/shop_edit');
		} else if ($act == 'manage') {
			$shop = $this -> getMyShop();
			if (empty($shop)) {
				$url = $this -> createMobileUrl('shop', array('act' => 'post'));
				header("location:$url");
				exit();
			}
			include $this -> template($template . '/shop_manage');
		} else if ($act == 'class') {
			include $this -> template($template . '/shop_class');
		} else if ($act == 'search') {
			include $this -> template($template . '/shop_search');
		} else if ($act == 'detail') {
			include $this -> template($template . '/shop_detail');
		} else if ($act == 'goods') {
			include $this -> template($template . '/shop_manage_goods');
		} else if ($act = 'add_goods') {
			$cid = intval($_GPC['cid']);
			if (empty($cid)) {
				$cats = $this -> getAllShopClass();
				include $this -> template($template . '/shop_add_goods_class');
				die();
			}
			$classSet = $this -> getClassSet($cid);
			if ($_W['ispost']) {
				$this -> postTask();
			}
			include $this -> template($template . '/shop_add_goods');
		} else if ($act == 'message') {

		}else if($act == 'log'){
			include $this -> template($template . '/shop_add_goods');
		}
	}

	/**
	 * 前台任务（完成）
	 * */
	public function doMobileTask() {
		global $_W, $_GPC;
		load() -> model('mc');
		$uid = $_W['member']['uid'] > 0 ? $_W['member']['uid'] : mc_openid2uid($_W['openid']);
		$userinfo = $this -> getUserinfo($uid);
		$template = $this -> getTemplate();

		$act = !empty($_GPC['act']) ? trim($_GPC['act']) : 'add';
		if ($act == 'add') {
			$cid = intval($_GPC['cid']);
			if (empty($cid)) {
				$cats = $this -> getAllClass();
				include $this -> template($template . '/task_class');
				die();
			}
			$classSet = $this -> getClassSet($cid);
			if ($_W['ispost']) {
				$this -> postTask();
			}
			$tid = $_GPC['tid'];
			if(!empty($tid)){
				$task = $this->getTask($tid);
				$task['thumbs'] = iunserializer($task['thumbs']);
				if(empty($task['thumbs'])){
					$task['thumbs'] = array();
				}
				$task['starttime'] = date('Y/m/d h:i',$task['starttime']);
				$task['endtime'] = date('Y/m/d h:i',$task['endtime']);
			}else{
				$task = array();
			}
			include $this -> template($template . '/task_add');
		} else if ($act == 'detail') {
			$id = intval($_GPC['id']);
			$data = $this -> taskDetail($id);
			$task = $data['detail'];
			$recives = $data['recives'];
			$set = $data['set'];
			$lessfee = $data['lessfee'];
			$role = $data['role'];
			$recive = $this->getReciveByUId($id, $uid);
			include $this -> template($template . '/taskdetail');
		} else if ($act == 'recive') {
			$id = intval($_GPC['id']);
			$return = $this -> reciveTask($uid, $id);
		} else if ($act == 'delete') {
			//发单删除
			$id = intval($_GPC['id']);
			if (empty($uid) || empty($id)) {
				$data = array();
				$data['code'] = -1;
				$data['message'] = '会员登录失效，请重新登录！';
				die(json_encode($data));
			}
			if (!$this -> isMyPost($id)) {
				$data = array();
				$data['code'] = -1;
				$data['message'] = '此任务不是您的任务，请不要搞怪！';
				die(json_encode($data));
			}
			$this -> deleteTask($id);
			$data = array();
			$data['code'] = 0;
			die(json_encode($data));
		} else if ($act == 'edit') {
			$id = intval($_GPC['id']);
			$data = $this -> taskDetail($id);
			$task = $data['detail'];
			$recives = $data['recives'];
			$set = $data['set'];
			$lessfee = $data['lessfee'];
			$role = $data['role'];
			if ($_W['ispost']) {
				$this -> editTask();
			}
			include $this -> template($template . '/task_edit');
		} else if ($act == 'giveup') {
			//接单后放弃
			$id = intval($_GPC['id']);
			$return = $this -> giveupTask($id);
		} else if ($act == 'reciveActive') {
			$id = intval($_GPC['id']);
			$recive = $this -> getTaskReciveDetail($id);
			include $this -> template($template . '/task_recive');
		} else if ($act == 'ping') {
			$this->postPingData();
		}else if($act == 'quhuo'){
			$this->postQuhuoData();
		}else if($act == 'dongtai'){
			$this->postDongtaiData();
		}else if($act == 'shouhuo'){
			$this->postShouhuoData();
		}else if($act == 'class'){
			$pagetype = 7;
			$re = $this -> getPageInfo($pagetype);
			$data = $re['data'];
			$pageinfo = $re['pageinfo'];
			$cid = intval($_GPC['cid']);
			
			$con = " `peoplelimit` > :peoplelimit AND `uniacid` = :uniacid ";
			$params = array(':peoplelimit'=>0,':uniacid'=>$_W['uniacid']);
			
			if(!empty($cid)){
				$con .= " AND `cid` = :cid ";
				$params[':cid'] = $cid;
			}
			
			$keyword = $_GPC['keywords'];
			if(!empty($keyword)){
				$con .= " AND `desc` like '%{$keyword}%' ";;
			}
			$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE {$con} ORDER BY createtime DESC";
			
			$list = pdo_fetchall($sql, $params);
			
			$orders = array();
			if(!empty($list)){
				foreach ($list as $li) {
					$user = mc_fetch($li['uid']);
					$li['avatar'] = tomedia($user['avatar']);
					$li['nickname'] = $user['nickname'];
					//获取分类
					$li['ctitle'] = $this -> getClassTitle($li['cid']);
					$li['createtime'] = $this -> format_created_at($li['createtime']);
					
					$set = $this -> getClassSet($li['cid']);
					
					$orders[] = $this -> formatRestJson($li);
				}
			}
			include $this -> template($template . '/task_class');
		}
	}
	

	/**
	 * 前台跑腿
	 * */
	 
	 
	public function doMobileRunner() {
		global $_W, $_GPC;
		$template = $this -> getTemplate();
		$act = !empty($_GPC['act']) ? trim($_GPC['act']) : 'runner';
		$userinfo = $this -> userInfo();
		if ($act == 'runner') {
			$pagetype = 12;
			$re = $this -> getPageInfo($pagetype);
			$data = $re['data'];
			$pageinfo = $re['pageinfo'];
			$runner = $this -> getRunner();
			
			if(empty($runner)){
				$url = $this->createMobileUrl('runner',array('act'=>'post'));
				header("location:$url");
				exit();
			}
			include $this -> template($template . '/runner');
		}
		if ($act == 'myorder') {
			$list = $this -> getMyOrders();
			include $this -> template($template . '/runner_myorder');
		}
		if ($act == 'log') {
			//跑腿日志 任务评分及评价
			$uid = intval($_GPC['uid']);
			$mid = $this->getUid();
			
			if($uid == $mid || empty($uid)){
				$uid = $mid;
				$isme = 1;
			}else{
				$isme = 0;
			}
			$type = 4;
			$sql = "SELECT * FROM ".tablename('imeepos_runner_tasks_comment')." WHERE uniacid = :uniacid AND tuid = :uid AND type= :type";
			$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid,':type'=>$type);
			$list = pdo_fetchall($sql,$params);
			include $this -> template($template . '/runner_log');
		}
		if ($act == 'info') {
			//跑腿资料
			$uid = intval($_GPC['uid']);
			$mid = $this->getUid();
			
			if($uid == $mid || empty($uid)){
				$uid = $mid;
				$isme = 1;
			}else{
				$isme = 0;
			}
			
			$profile = $this->getProfile($uid);
			$userinfo = array_merge($userinfo,$profile);
			if($userinfo['gender'] == 1){
				$userinfo['sex'] = '男';
			}else if($userinfo['gender'] == 2){
				$userinfo['sex'] = '女';
			}else{
				$userinfo['sex'] = '保密';
			}
			$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_tasks_comment')." WHERE uniacid = :uniacid AND tuid = :uid AND type = :type";
			$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid,':type'=>4);
			$userinfo['pingnum'] = pdo_fetchcolumn($sql,$params);
			include $this -> template($template . '/runner_info');
		}
		if ($act == 'vip') {
			//认证vip
			include $this -> template($template . '/runner_vip');
		}
		
		if($act == 'post'){
			//认证跑腿
			$profile = $this->getProfile($uid);
			$userinfo = array_merge($userinfo,$profile);
			
			if($userinfo['gender'] == 1){
				$userinfo['sex'] = '男';
			}else if($userinfo['gender'] == 2){
				$userinfo['sex'] = '女';
			}else{
				$userinfo['sex'] = '请选择';
			}
			$sql = "SELECT * FROM ".tablename('imeepos_runner_runner')." WHERE uniacid = :uniacid AND uid = :uid";
			$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid);
			$runner = pdo_fetch($sql,$params);
			
			if(empty($runner)){
				$sql = "SELECT * FROM ".tablename('imeepos_runner_runner_level')." WHERE uniacid = :uniacid AND isdefault = :isdefault";
				$params = array(':uniacid'=>$_W['uniacid'],':isdefault'=>1);
				$defulat = pdo_fetch($sql,$params);
				
				$userinfo['grouptitle'] = $defulat['title'];
				$userinfo['fee'] = $defulat['price'];
				$userinfo['groupid'] = $defulat['id'];
			}
			
			if($_W['ispost']){
				$input = $_GPC['__input'];
				$data = array();
				
				die(json_encode($input));
			}
			
			include $this -> template($template . '/runner_post');
		}
	}

	public function getMyOrders() {
		global $_W;
		$uid = $this -> getUid();
		$sql = "SELECT b.* FROM " . tablename("imeepos_runner_tasks") . " as b LEFT JOIN " . tablename('imeepos_runner_tasks_recive') . " as c ON b.id = c.taskid WHERE c.from_uid = :uid";
		$params = array(':uid' => $uid);
		$list = pdo_fetchall($sql, $params);
		$lists = array();
		foreach($list as $li){
			$li['createtime'] = date('Y-m-d',$li['createtime']);
			$lists[] = $li;
		}
		return $lists;
	}

	/*
	 * 会员中心处理
	 * */
	public function doMobileUser() {
		global $_W, $_GPC;
		load() -> model('mc');
		$uid = $_W['member']['uid'] > 0 ? $_W['member']['uid'] : mc_openid2uid($_W['openid']);
		$userinfo = $this->userInfo();

		$template = $this -> getTemplate();
		$act = !empty($_GPC['act']) ? trim($_GPC['act']) : 'user';

		if ($act == 'user') {
			$pagetype = 5;
			$re = $this -> getPageInfo($pagetype);
			$data = $re['data'];
			$pageinfo = $re['pageinfo'];
			include $this -> template($template . '/user');
		}

		if ($act == 'mypost') {
			$list = $this -> getMyPosts();
			include $this -> template($template . '/user_mypost');
		}

		if ($act == 'info') {
			
			$uid = intval($_GPC['uid']);
			$mid = $this->getUid();
			
			if($uid == $mid || empty($uid)){
				$uid = $mid;
				$isme = 1;
			}else{
				$isme = 0;
			}
			$userinfo = $this->userInfo($uid);
			$profile = $this->getProfile($uid);
			$userinfo = array_merge($userinfo,$profile);
			if($userinfo['gender'] == 1){
				$userinfo['sex'] = '男';
			}else if($userinfo['gender'] == 2){
				$userinfo['sex'] = '女';
			}else{
				$userinfo['sex'] = '保密';
			}
			$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_tasks_comment')." WHERE uniacid = :uniacid AND tuid = :uid AND type = :type";
			$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid,':type'=>4);
			$userinfo['pingnum'] = pdo_fetchcolumn($sql,$params);
			
			include $this -> template($template . '/user_info');
		}
		
		if($act == 'real'){
			
		}
		if($act == 'moneylog'){
			
		}
		if($act == 'widthdraw'){
			//提现
			$userinfo = $this->userInfo();
			
			include $this -> template($template . '/user_widthdraw');
		}
		if($act == 'widthdrawlog'){
			
		}
		if($act == 'feedback'){
			include $this -> template($template . '/user_feedback');
		}
		if ($act == 'money') {
			$market_in = $this->getMarketIn();
			include $this -> template($template . '/user_mymoney');
		}
		if ($act == 'aboutus') {
			$m = M('setting');
			$m -> setTable('imeepos_runner_settings');
			$setting = $m -> fetch(array('uniacid' => $_W['uniacid']));
			$about = iunserializer($setting['about']);
			$system = iunserializer($setting['set']);
			$about['logo'] = $system['logo'];
			include $this -> template($template . '/user_aboutus');
		}
	}
	public function getMarketIn(){
		global $_W;
		$table = 'imeepos_runner_markets';
		$sql = "SELECT * FROM ".tablename($table)." WHERE uniacid = :uniacid";
		$params = array(':uniacid'=>$_W['uniacid']);
		$list = pdo_fetchall($sql,$params);
		return $list;
	}
	public function getMyPosts() {
		global $_W;
		$uid = $this -> getUid();
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE uid = :uid";
		$params = array(':uid' => $uid);
		$list = pdo_fetchall($sql, $params);
		$lists = array();
		foreach($list as $li){
			$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_tasks_recive')." WHERE taskid = :taskid";
			$params = array(':taskid'=>$li['id']);
			$li['recivenum'] = pdo_fetchcolumn($sql,$params);
			
			$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_tasks_recive')." WHERE taskid = :taskid AND status = :status";
			$params = array(':taskid'=>$li['id'],'status'=>1);
			$li['startnum'] = pdo_fetchcolumn($sql,$params);
			
			$sql = "SELECT COUNT(*) FROM ".tablename('imeepos_runner_tasks_recive')." WHERE taskid = :taskid AND status >= :status";
			$params = array(':taskid'=>$li['id'],'status'=>3);
			$li['finishnum'] = pdo_fetchcolumn($sql,$params);
			
			$lists[] = $li;
		}
		return $lists;
	}

	public function doMobileGuide() {
		global $_W, $_GPC;
		$m = M('adv');
		$m -> setTable('imeepos_runner_adv');
		$list = $m -> fetchall(array('uniacid' => $_W['uniacid'], 'isfull' => 1));

		include $this -> template('mui/guide');
	}

	protected function getTemplate() {
		//模板控制
		global $_W;
		$template = $this -> module['config']['name'];
		if (empty($template)) {
			$template = 'mui';
		}
		if($template != 'webApp'){
		 if(empty($_W['openid'])){
		 die("<!DOCTYPE html>
		 <html>
		 <head>
		 <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
		 <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
		 </head>
		 <body>
		 <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请在微信客户端打开链接</h4></div></div></div>
		 </body>
		 </html>");
		 }
		 }
		return $template;
	}

	public function getPluginList() {
		$module = $this -> modulename;
		$sql = "SELECT * FROM " . tablename('meepo_common_plugin') . " WHERE module = :module ";
		$params = array(':module' => $module);
		$list = pdo_fetchall($sql, $params);
		return $list;
	}

	public function getMenuByCode($code) {
		global $_W, $_GPC;
		$module = $this -> modulename;
		$sql = "SELECT * FROM " . tablename('imeepos_module_menu') . " WHERE code = :code AND module = :module";
		$params = array(':code' => $code, ':module' => $module);
		$item = pdo_fetch($sql, $params);
		return $item;
	}

	//前台插件接口接受
	public function doMobileDoplugin() {
		global $_W, $_GPC;
		$plugin = $_GPC['plugin'];
		$code = $_GPC['code'];
		$op = $_GPC['op'];

		$file = MODULE_ROOT . '/plugin/__init.php';
		if (file_exists($file)) {
			require $file;
		}

		$file = MODULE_ROOT . '/plugin/' . $plugin . '/__init.php';
		if (file_exists($file)) {
			require $file;
		}

		$file = MODULE_ROOT . '/plugin/' . $plugin . '/inc/app/__init.php';
		if (file_exists($file)) {
			require $file;
		}

		$file = MODULE_ROOT . '/plugin/' . $plugin . '/inc/app/' . $code . '.php';
		if (file_exists($file)) {
			require $file;
		}
	}

	//前台入口，带会员标示
	protected function createMobileUrl($do, $query = array(), $noredirect = true) {
		global $_W;
		$this -> checkLogin();
		$query['do'] = $do;
		$query['m'] = strtolower($this -> modulename);
		return imurl('entry', $query, $noredirect);
	}

	/*前台插件调用接口*/
	protected function createMobilePluginUrl($do, $query = array(), $noredirect = true) {
		global $_W;
		$this -> checkLogin();
		$query['do'] = 'doplugin';
		$query['m'] = strtolower($this -> modulename);
		list($plugin, $code, $op) = explode('/', $do);
		$query['plugin'] = $plugin;
		$query['code'] = $code;
		$query['op'] = $op;
		return imurl('entry', $query, $noredirect);
	}

	//后台插件接口接收
	public function doWebDoplugin() {
		global $_W, $_GPC;
		$plugin = $_GPC['plugin'];
		$code = $_GPC['code'];
		$op = $_GPC['op'];

		$file = MODULE_ROOT . '/plugin/__init.php';
		if (file_exists($file)) {
			require $file;
		}

		$file = MODULE_ROOT . '/plugin/' . $plugin . '/__init.php';
		if (file_exists($file)) {
			require $file;
		}

		$file = MODULE_ROOT . '/plugin/' . $plugin . '/inc/web/__init.php';
		if (file_exists($file)) {
			require $file;
		}

		$file = MODULE_ROOT . '/plugin/' . $plugin . '/inc/web/' . $code . '.php';
		if (file_exists($file)) {
			require $file;
		}
	}

	public function getWebPluginPageHeader($acts, $op, $id = 'id', $ext = "") {
		global $_W, $_GPC;
		$plugin = trim($_GPC['plugin']);
		$code = trim($_GPC['code']);
		foreach ($acts as $ac) {
			if ($op == $ac['act']) {
				if ($ac['needid'] && $_GPC[$id] > 0) {
					$header[] = array('href' => $this -> createWebPluginUrl("{$plugin}/{$code}", array('act' => $ac['act'], $id => $_GPC[$id])) . $ext, 'title' => $ac['title'], 'active' => true);
				} else if (!$ac['needid'] && empty($_GPC[$id])) {
					$header[] = array('href' => $this -> createWebPluginUrl("{$plugin}/{$code}", array('act' => $ac['act'])) . $ext, 'title' => $ac['title'], 'active' => true);
				} else if (!$ac['needid'] && !empty($_GPC[$id])) {
					$header[] = array('href' => $this -> createWebPluginUrl("{$plugin}/{$code}", array('act' => $ac['act'])) . $ext, 'title' => $ac['title'], 'active' => false);
				}
			} else {
				if ($ac['needid'] && $_GPC['id'] > 0) {
					$header[] = array('href' => $this -> createWebPluginUrl("{$plugin}/{$code}", array('act' => $ac['act'], $id => $_GPC[$id])) . $ext, 'title' => $ac['title'], 'active' => false);
				} else if (!$ac['needid']) {
					$header[] = array('href' => $this -> createWebPluginUrl("{$plugin}/{$code}", array('act' => $ac['act'])) . $ext, 'title' => $ac['title'], 'active' => false);
				}
			}
		}
		return $header;
	}

	/*后台插件调用接口*/
	protected function createWebPluginUrl($do, $query = array()) {
		$query['do'] = 'doplugin';
		$query['m'] = strtolower($this -> modulename);
		list($plugin, $code, $op) = explode('/', $do);
		$query['plugin'] = $plugin;
		$query['code'] = $code;
		$query['op'] = $op;
		return wurl('site/entry', $query);
	}

	/**
	 *	@return 编译后的模板文件
	 */
	public function ptemplate($name) {
		global $_W, $_GPC;
		$plugin = trim($_GPC['plugin']);
		$filename = trim($name);

		$name = strtolower($this -> modulename);
		$defineDir = dirname($this -> __define);
		if (defined('IN_SYS')) {
			$source = $defineDir . "/plugin/" . $plugin . "/view/{$filename}.html";
			$compile = IA_ROOT . "/data/tpl/web/{$_W['template']}/{$name}/plugin/{$plugin}/{$filename}.tpl.php";

		} else {
			$source = IA_ROOT . "/app/themes/{$_W['template']}/{$name}/{$filename}.html";
			$compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$name}/plugin/{$plugin}/app/{$filename}.tpl.php";
			if (!is_file($source)) {
				$source = IA_ROOT . "/app/themes/default/{$name}/{$filename}.html";
			}
			if (!is_file($source)) {
				$source = $defineDir . "/plugin/" . $plugin . "/view/mobile/{$filename}.html";
			}
			if (!is_file($source)) {
				$source = IA_ROOT . "/app/themes/{$_W['template']}/{$filename}.html";
			}
			if (!is_file($source)) {
				if (in_array($filename, array('header', 'footer', 'slide', 'toolbar', 'message'))) {
					$source = IA_ROOT . "/app/themes/default/common/{$filename}.html";
				} else {
					$source = IA_ROOT . "/app/themes/default/{$filename}.html";
				}
			}
		}
		if (!is_file($source)) {
			exit("Error: template source '{$source}' is not exist!");
		}
		$paths = pathinfo($compile);
		$compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
		if (DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
			template_compile($source, $compile, true);
		}
		return $compile;
	}

	public function unescape($str) {
		$ret = '';
		$len = strlen($str);
		for ($i = 0; $i < $len; $i++) {
			if ($str[$i] == '%' && $str[$i + 1] == 'u') {
				$val = hexdec(substr($str, $i + 2, 4));
				if ($val < 127) {
					$ret .= chr($val);
				} else {
					if ($val < 2048) {
						$ret .= chr(192 | $val>>6) . chr(128 | $val & 63);
					} else {
						$ret .= chr(224 | $val>>12) . chr(128 | $val>>6 & 63) . chr(128 | $val & 63);
					}
				}
				$i += 5;
			} else {
				if ($str[$i] == '%') {
					$ret .= urldecode(substr($str, $i, 3));
					$i += 2;
				} else {
					$ret .= $str[$i];
				}
			}
		}
		return $ret;
	}

	public function getPluginByCode($code) {
		global $_W, $_GPC;
		$module = $this -> modulename;
		$sql = "SELECT * FROM " . tablename('meepo_common_plugin') . " WHERE code = :code AND module = :module";
		$params = array(':code' => $code, ':module' => $module);
		$item = pdo_fetch($sql, $params);
		return $item;
	}

	public function returnSquarePoint($lon, $lat, $distance = 100) {
		$dlon = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
		$dlon = rad2deg($dlon);

		$dlat = $distance / EARTH_RADIUS;
		$dlat = rad2deg($dlat);
		return array('left-top' => array('lat' => $lat + $dlat, 'lon' => $lon - $dlon), 'right-top' => array('lat' => $lat + $dlat, 'lon' => $lon + $dlon), 'left-bottom' => array('lat' => $lat - $dlat, 'lon' => $lon - $dlon), 'right-bottom' => array('lat' => $lat - $dlat, 'lon' => $lon + $dlon));
	}

	public function apiLocation($location) {
		if (is_string($location)) {
			$location = json_decode($location, true);
		}
		empty($location['lat']) || $location['lat'] = round($location['lat'], 6);
		empty($location['lon']) || $location['lon'] = round($location['lon'], 6);

		$location = array_merge(array('name' => '', 'lat' => '0', 'lon' => '0'), (array)$location);

		return $location;
	}

	public function formatRestJson($array) {
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				if ($value === '' || is_null($value)) {
					unset($array[$key]);
					//移除空
				} else if (is_numeric($value)) {
					if (floatval($value) <= 0) {
						unset($array[$key]);
					}
				} else if (is_string($value)) {
					$array[$key] = trim($value);
				} else if (is_array($value)) {
					$value = $this -> formatRestJson($value);
					if (!empty($value)) {
						$array[$key] = $value;
					} else {
						unset($array[$key]);
					}
				} else if (is_bool($value)) {
					$array[$key] = intval($value);
				}
			}
		}
		return $array;
	}

	public function apiTime($timeString) {
		return strtotime($timeString) < 0 ? '2014-01-01 00:00:00 +0800' : date('Y/m/d H:i:s O', strtotime($timeString));
	}

	public function unread_message_count() {
		global $_W, $_GPC;
		$unread_count = 0;
		$openid = $_W['openid'];
		$sql = "SELECT COUNT(*) FROM " . tablename('imeepos_runner_message') . " WHERE status = :status AND topenid = :topenid";
		$params = array(':status' => 0, ':topenid' => $openid);
		$unread_count = pdo_fetchcolumn($sql, $params);
		if (empty($unread_count)) {
			$unread_count = 0;
		}
		return $unread_count;
	}

	public function format_created_at($created_at) {
		if (!is_numeric($created_at)) {
			$created_at = strtotime($created_at);
		}
		$seconds = time() - $created_at;
		$minutes = floor($seconds / 60);
		$hours = floor($seconds / (60 * 60));
		$days = floor($seconds / (60 * 60 * 24));
		if ($seconds < 60) {
			return "刚刚";
		} elseif ($seconds < 120) {
			return "1分钟前";
		} elseif ($minutes < 60) {
			return $minutes . "分钟前";
		} elseif ($minutes < 120) {
			return "1小时前";
		} elseif ($hours < 24) {
			return $hours . "小时前";
		} elseif ($hours < 24 * 2) {
			return "1天前";
		} elseif ($days < 30) {
			return $days . "天前";
		} elseif ($days < 365) {
			return floor($days / 30) . "个月前";
		} else {
			return date("YYYY年mm月dd日", $created_at);
		}
	}

	public function format_end_time($created_at) {
		if (!is_numeric($created_at)) {
			$created_at = strtotime($created_at);
		}

		$seconds = $created_at - time();
		$minutes = floor($seconds / 60);
		$hours = floor($seconds / (60 * 60));
		$days = floor($seconds / (60 * 60 * 24));

		if ($seconds <= 0) {
			return "已经结束";
		} else if ($seconds < 60) {
			return "即将结束";
		} elseif ($seconds < 120) {
			return "1分钟后结束";
		} elseif ($minutes < 60) {
			return $minutes . "分钟后结束";
		} elseif ($minutes < 120) {
			return "1小时后结束";
		} elseif ($hours < 24) {
			return $hours . "小时后结束";
		} elseif ($hours < 24 * 2) {
			return "1天后结束";
		} elseif ($days < 30) {
			return $days . "天后结束";
		} elseif ($days < 365) {
			return floor($days / 30) . "个月后结束";
		} else {
			return floor($days / 365) . "年后截止";
		}
	}

	public function format_start_time($created_at) {
		if (!is_numeric($created_at)) {
			$created_at = strtotime($created_at);
		}
		$seconds = $created_at - time();
		$minutes = floor($seconds / 60);
		$hours = floor($seconds / (60 * 60));
		$days = floor($seconds / (60 * 60 * 24));
		if ($seconds <= 0) {
			return "已经开始";
		} else if ($seconds < 60 && $seconds > 0) {
			return "即将开始";
		} elseif ($seconds < 120) {
			return "1分钟后开始";
		} elseif ($minutes < 60) {
			return $minutes . "分钟后开始";
		} elseif ($minutes < 120) {
			return "1小时后开始";
		} elseif ($hours < 24) {
			return $hours . "小时后开始";
		} elseif ($hours < 24 * 2) {
			return "1天后开始";
		} elseif ($days < 30) {
			return $days . "天后开始";
		} elseif ($days < 365) {
			return floor($days / 30) . "个月后开始";
		} else {
			return date("YYYY年mm月dd日", $created_at);
		}
	}

	public function getClassSet($cid = 0) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_class') . " WHERE id = :id";
		$params = array(':id' => $cid);
		$class = pdo_fetch($sql, $params);
		$set = iunserializer($class['set']);
		return $set;
	}

	public function getClassTitle($cid = 0) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_class') . " WHERE id = :id";
		$params = array(':id' => $cid);
		$class = pdo_fetch($sql, $params);
		return $class['title'];
	}

	public function getAllClass() {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_class') . " WHERE uniacid = :uniacid ";
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall($sql, $params);
		foreach ($list as $li) {
			$li['icon'] = tomedia($li['icon']);
			$lists[] = $li;
		}
		return $lists;
	}

	public function getTaskRecives($id) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks_recive') . " WHERE taskid = :taskid ORDER BY time DESC";
		$params = array(':taskid' => $id);
		$list = pdo_fetchall($sql, $params);
		$lists = array();
		foreach ($list as $li) {
			$li['user'] = $this -> userInfo($li['from_uid']);
			$lists[] = $li;
		}
		return $lists;
	}

	

	public function getUid() {
		global $_W;
		load() -> model('mc');
		$uid = $_W['member']['uid'] > 0 ? $_W['member']['uid'] : mc_openid2uid($_W['openid']);
		return $uid;
	}

	/*
	 * 接单处理 @meepo
	 * */
	public function reciveTask($uid, $id) {
		global $_W;
		$user = $this -> userInfo($uid);
		if (empty($id)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务不存在或已删除';
			die(json_encode($data));
		}
		if (empty($uid)) {
			$data = array();
			$data['code'] = -2;
			$data['message'] = '登陆失效，请重新登陆';
			die(json_encode($data));
		}
		//任务详情
		$table = 'imeepos_runner_tasks';
		$sql = "SELECT * FROM " . tablename($table) . " WHERE id = :id";
		$params = array(':id' => $id);
		$task = pdo_fetch($sql, $params);
		if (empty($task)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务不存在或已删除';
			die(json_encode($data));
		}
		if ($task['fee'] > 0) {
			if ($task['status'] == 0) {
				$data = array();
				$data['code'] = -1;
				$data['message'] = '该任务尚未完成支付！';
				die(json_encode($data));
			}
		}
		if ($task['uid'] == $uid) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '这个任务是您自己的哦！';
			die(json_encode($data));
		}
		$recive = $this -> getTaskRecive($task['id'], $uid);
		if (!empty($recive)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '您已经预约过此任务！';
			die(json_encode($data));
		}
		//人数限制
		if ($task['peoplelimit'] > 0) {
			if (pdo_update($table, array('peoplelimit' => $task['peoplelimit'] - 1), array('id' => $id))) {
				$data = array();
				$recivetable = 'imeepos_runner_tasks_recive';
				$data['from_uniacid'] = $_W['uniacid'];
				$data['to_uniacid'] = $task['uniacid'];
				$data['from_uid'] = $_W['member']['uid'];
				$data['to_uid'] = $task['uid'];
				$data['from_openid'] = $_W['openid'];
				$data['to_openid'] = $task['openid'];
				$data['taskid'] = $task['id'];
				$data['status'] = 0;
				$data['time'] = time();
				if (pdo_insert($recivetable, $data)) {
					//接单成功
					mload() -> model('imc');
					$url = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('index');
					imc_notice_task_recive($task['openid'], $task, $url);

					$data = array();
					$data['code'] = 0;
					$data['message'] = '接单成功';
					$data['data'] = $task['id'];
					die(json_encode($data));
				}
				$data = array();
				$data['code'] = -1;
				$data['data'] = $task['id'];
				$data['message'] = '接单失败';
				die(json_encode($data));
			}
		} else {
			$data = array();
			$data['code'] = -1;
			$data['data'] = $task['id'];
			$data['message'] = '任务名额已经被抢光了';
			die(json_encode($data));
		}
	}

	public function getUserinfo($uid = 0) {
		global $_W;
		load() -> model('mc');
		$userinfo = mc_fetch($uid, array('avatar', 'nickname', 'mobile'));
		return $userinfo;
	}

	public function getPageInfo($pagetype) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_page') . " WHERE pagetype = :pagetype AND uniacid = :uniacid";
		$params = array(':pagetype' => $pagetype, ':uniacid' => $_W['uniacid']);
		$item = pdo_fetch($sql, $params);
		if (!empty($item)) {
			$data = htmlspecialchars_decode($item['datas']);
			$data = json_decode($data, true);
			if (!empty($data)) {
				foreach ($data as $i1 => &$dd) {
					if ($dd['temp'] == 'goods') {

					} elseif ($dd['temp'] == 'richtext') {
						$dd['content'] = $this -> unescape($dd['content']);
					}
				}
				unset($dd);
				$data = json_encode($data);
			}
			$data = rtrim($data, "]");
			$data = ltrim($data, "[");
			$pageinfo = htmlspecialchars_decode($item['pageinfo']);
			$pageinfo = rtrim($pageinfo, "]");
			$pageinfo = ltrim($pageinfo, "[");
		}

		return array('data' => $data, 'pageinfo' => $pageinfo);
	}

	public function getAllShopClass() {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_shop_class') . " WHERE uniacid = :uniacid";
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall($sql, $params);
		$lists = array();
		foreach ($list as $li) {
			$li['icon'] = tomedia($li['icon']);

			$lists[] = $li;
		}
		return $lists;
	}

	public function getMemberShop($uid = 0) {
		global $_W;
		if (empty($uid)) {
			$uid = $this -> getUid();
		}
		$sql = "SELECT * FROM " . tablename('imeepos_runner_shop') . " WHERE uid = :uid";
		$params = array(':uid' => $uid);
		$item = pdo_fetch($sql, $params);
		return $item;
	}

	public function getMember($uid = 0) {
		global $_W;
		if (empty($uid)) {
			$uid = $this -> getUid();
		}
		$sql = "SELECT groupid FROM " . tablename('imeepos_runner_member') . " WHERE uid = :uid";
		$params = array(':uid' => $uid);
		$member = pdo_fetch($member);
		return $member;
	}

	public function getMemberGroup($uid = 0) {
		global $_W;
		$member = $this -> getMember($uid);
		$groupid = $member['groupid'];
		$sql = "SELECT * FROM " . tablename('imeepos_runner_member_level') . " WHERE id = :id";
		$params = array(':id' => $groupid);
		$group = pdo_fetch($sql, $params);
		return $group;
	}

	public function deleteTask($id) {
		global $_W;
		$task = $this -> getTask($id);
		$uid = $this -> getUid();
		if ($task['status'] == 1) {
			$peoplelimit = intval($task['peoplelimit']);
			if ($peoplelimit > 0) {
				//已支付，检查接单情况，计算退换金额
				$fee = floatval($task['fee']);
				$totalfee = floatval($task['totalfee']);
				$lessfee = floatval($task['lessfee']);

				$fanfee = $fee * $peoplelimit;
				mc_credit_update($uid, 'credit2', $fanfee, array($uid, '订单撤销退换余额' . $fanfee . '元，任务编号【' . $task['id'] . '】,中途撤销任务押金【' . $lessfee . '元】不返还！'));
				pdo_update('imeepos_runner_tasks', array('status' => 3), array('id' => $id));
				$data = array();
				$data['code'] = 0;
				die(json_encode($data));
			} else {
				//订单已被抢完 不可临时撤销
				$data = array();
				$data['code'] = -1;
				$data['message'] = '订单已被抢完 不可临时撤销';
				die(json_encode($data));
			}

		} else if ($task['status'] == 0) {
			//未支付,直接删除
			$data = array();
			$data['code'] = 0;
			pdo_delete('imeepos_runner_tasks', array('id' => $id));
			$data = array();
			$data['code'] = 0;
			die(json_encode($data));
		} else if ($task['status'] == 2) {
			//已完结 不可撤销
			$data = array();
			$data['code'] = -1;
			$data['message'] = '已完结 不可撤销';
			die(json_encode($data));
		} else {
			//已删除 不要重复操作
			$data = array();
			$data['code'] = -1;
			$data['message'] = '已删除 不要重复操作';
			die(json_encode($data));
		}
	}

	public function isMyPost($id) {
		global $_W;
		$task = $this -> getTask($id);
		$uid = $this -> getUid();

		if ($task['uid'] == $uid) {
			return true;
		} else {
			return false;
		}
	}

	public function getTask($id) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE id = :id";
		$params = array(':id' => $id);
		return pdo_fetch($sql, $params);
	}

	public function getShopClass($cid) {
		$sql = "SELECT * FROM " . tablename('imeepos_runner_shop_class') . " WHERE id = :id";
		$params = array(':id' => $cid);
		return pdo_fetch($sql, $params);
	}

	public function getShopClassTitle($cid) {
		$class = $this -> getShopClass($cid);
		return $class['title'];
	}

	public function getShopClassSet($cid) {
		global $_W;
		$class = $this -> getShopClass($cid);
		$setting = $class['setting'];
		return iunserializer($setting);
	}

	public function getServices() {
		global $_W, $_GPC;
		$list = array();
		$sql = "SELECT * FROM " . tablename('imeepos_runner_shop_goods') . " WHERE uniacid = :uniacid limit 20";
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall($sql, $params);
		return $list;
	}

	public function getProfile($uid) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_member_profile') . " WHERE uniacid = :uniacid AND uid = :uid";
		$params = array(':uniacid' => $_W['uniacid'], ':uid' => $uid);
		$item = pdo_fetch($sql, $params);
		if(empty($item)){
			$item = array();
		}
		return $item;
	}

	public function getAllRunner() {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_runner') . " WHERE uniacid = :uniacid";
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall($sql, $params);
		$lists = array();
		foreach ($list as $li) {
			//if(!empty($li['latitude'])){
			$profile = $this -> getProfile($li['uid']);
			$li = array_merge($li, $profile);
			$lists[] = $li;
			//}
		}
		return $lists;
	}

	public function getAllTasks() {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE uniacid = :uniacid AND peoplelimit >0 ORDER BY createtime DESC";
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall($sql, $params);

		foreach ($list as $li) {
			$user = $this -> userinfo($li['uid']);
			$l = array();
			$l['id'] = $li['id'];
			$l['avatar'] = tomedia($user['avatar']);
			//获取分类
			$l['ctitle'] = $this -> getClassTitle($li['cid']);
			$l['createtime'] = $this -> format_created_at($li['createtime']);
			$l['startaddress'] = $li['startaddress'];
			$l['startlat'] = $li['startlat'];
			$l['startlng'] = $li['startlng'];
			$l['fee'] = $li['fee'];
			$l['desc'] = $li['desc'];

			$set = $this -> getClassSet($li['cid']);
			if (!empty($set)) {
				foreach ($set as $s) {
					if (isset($set['code'])) {
						if ($s['code'] == 'endaddress') {
							$l['endaddress'] = $li['endaddress'];
							$l['startlat'] = $li['startlat'];
							$l['startlng'] = $li['startlng'];
						}
						if ($s['code'] == 'starttime') {
							$l['startaddress'] = $li['address'];
							$l['startlat'] = $li['startlat'];
							$l['startlng'] = $li['startlng'];
						}
						if ($s['code'] == 'starttime') {
							$l['starttime'] = $this -> format_created_at($li['starttime']);
						}
						if ($s['code'] == 'endtime') {
							$l['endtime'] = $this -> format_created_at($li['endtime']);
						}

						if ($s['code'] == 'desc') {
							$l['desc'] = $li['desc'];
						}
						if ($s['code'] == 'postrealname') {
							$l['postrealname'] = $li['postrealname'];
						}
						if ($s['code'] == 'postmobile') {
							$l['postmobile'] = $li['postmobile'];
						}
						if ($s['code'] == 'reciverealname') {
							$l['reciverealname'] = $li['reciverealname'];
						}
						if ($s['code'] == 'recivemobile') {
							$l['recivemobile'] = $li['recivemobile'];
						}

						if ($s['code'] == 'peoplelimit') {
							$l['peoplelimit'] = $li['peoplelimit'];
						}
						if ($s['code'] == 'kglimit') {
							$l['kglimit'] = $li['kglimit'];
						}
						if ($s['code'] == 'timelimit') {
							$l['timelimit'] = $li['timelimit'];
						}
					}
				}
			}

			$orders[] = $this -> formatRestJson($l);
		}
		return $orders;
	}

	public function getMyShop() {
		global $_W;
		$uid = $this -> getUid();
		$sql = "SELECT * FROM " . tablename('imeepos_runner_shop') . " WHERE uid = :uid";
		$params = array(':uid' => $uid);
		$shop = pdo_fetch($sql, $params);

		return $shop;
	}

	public function giveupTask($id) {
		global $_W;
		$task = getTaskDetail($id);
		$uid = $this -> getUid();
		$recive = $this -> getTaskRecive($id, $uid);
		if (!empty($recive)) {
			pdo_update('imeepos_runner_tasks_recive', array('status' => -1), array('taskid' => $id, 'from_uid' => $uid));
			pdo_update('imeepos_runner_tasks', array('peoplelimit' => $task['peoplelimit'] + 1), array('id' => $id));

			$data = array();
			$data['code'] = 0;
			$data['message'] = '放弃订单成功';
			die(json_encode($data));
		} else {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '接单信息错误';
			die(json_encode($data));
		}
	}

	public function getTaskDetail($id) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE id = :id";
		$params = array(':id' => $id);
		$item = pdo_fetch($sql, $params);
		$item['thumbs'] = iunserializer($item['thumbs']);
		return $item;
	}

	public function getTaskRecive($id, $uid) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks_recive') . " WHERE taskid = :taskid AND from_uid = :from_uid";
		$params = array(':taskid' => $id, ':from_uid' => $uid);
		$item = pdo_fetch($sql, $params);
		return $item;
	}

	public function editTask() {
		global $_W, $_GPC;
		$poster = $_GPC['__input'];
		$id = intval($_GPC['id']);
		if (empty($id)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务不存在或已删除';
			die(json_encode($data));
		}

		$uid = $this -> getUid();

		if (empty($uid)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '会员不存在';
			die(json_encode($data));
		}

		$data = array();
		if (!empty($poster['desc'])) {
			$data['desc'] = trim($poster['desc']);
		}
		if (!empty($poster['startlat'])) {
			$data['startlat'] = $poster['startlat'];
		}
		if (!empty($poster['startlng'])) {
			$data['startlng'] = $poster['startlng'];
		}
		if (!empty($poster['endlat'])) {
			$data['endlat'] = $poster['endlat'];
		}
		if (!empty($poster['endlng'])) {
			$data['endlng'] = $poster['endlng'];
		}
		if (!empty($poster['startaddress'])) {
			$data['startaddress'] = trim($poster['startaddress']);
		}

		if (!empty($poster['endaddress'])) {
			$data['endaddress'] = trim($poster['endaddress']);
		}
		if (!empty($poster['thumbs'])) {
			$data['thumbs'] = iserializer($poster['thumbs']);
		}
		if (!empty($poster['postmobile'])) {
			$data['postmobile'] = trim($poster['postmobile']);
		}
		if (!empty($poster['postrealname'])) {
			$data['postrealname'] = trim($poster['postrealname']);
		}
		if (!empty($poster['recivemobile'])) {
			$data['recivemobile'] = trim($poster['recivemobile']);
		}
		if (!empty($poster['postrealname'])) {
			$data['reciverealname'] = trim($poster['reciverealname']);
		}
		$starttime = $this -> str_format_time($poster['starttime']);
		if (!empty($starttime)) {
			$data['starttime'] = $starttime;
		}
		$endtime = $this -> str_format_time($poster['endtime']);
		if (!empty($endtime)) {
			$data['endtime'] = $endtime;
		}
		if (!empty($poster['endtime'])) {
			$data['timelimit'] = trim($poster['timelimit']);
		}
		if (!empty($poster['endtime'])) {
			$data['addresslimit'] = trim($poster['addresslimit']);
		}

		pdo_update('imeepos_runner_tasks', $data, array('id' => $id));
		$data['code'] = 0;
		die(json_encode($data));
	}

	public function postTask() {
		global $_W, $_GPC;
		$poster = $_GPC['__input'];
		
		$cid = intval($_GPC['cid']);
		if (empty($cid)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '分类错误';
			die(json_encode($data));
		}

		$uid = $this -> getUid();
		if (empty($uid)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '会员不存在';
			die(json_encode($data));
		}
		
		$classSet = $this->getClassSet($cid);
		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['uid'] = $uid;
		$data['openid'] = $_W['openid'];
		$data['cid'] = intval($_GPC['cid']);
		$data['status'] = 0;
		$data['ordersn'] = date('YmdHi').random(10, 1);
		$data['look_num'] = 0;
		$data['share_num'] = 0;
		$data['zhong_num'] = 0;
		$data['jing_num'] = 0;
		$data['totalfee'] = floatval($poster['totalfee']);
		$data['createtime'] = time();
		foreach($classSet as $set){
			if($set['code'] == 'desc'){
				$data['desc'] = trim($poster['desc']);
			}
			if($set['code'] == 'fee'){
				$data['fee'] = floatval($poster['fee']);
			}
			if($set['code'] == 'startaddress'){
				$data['startlat'] = $poster['startlat'];
				$data['startlng'] = $poster['startlng'];
				$data['startaddress'] = trim($poster['startaddress']);
			}
			if($set['code'] == 'endaddress'){
				$data['endlat'] = $poster['endlat'];
				$data['endlng'] = $poster['endlng'];
				$data['endaddress'] = trim($poster['endaddress']);
			}
			if($set['code'] == 'peoplelimit'){
				$data['peoplelimit'] = intval($poster['peoplelimit']);
				$data['sheng_num'] = intval($poster['peoplelimit']);
			}
			if($set['code'] == 'thumbs'){
				$data['thumbs'] = iserializer($poster['thumbs']);
			}
			if($set['code'] == 'postrealname'){
				$data['postrealname'] = trim($poster['postrealname']);
			}
			if($set['code'] == 'postmobile'){
				$data['postmobile'] = trim($poster['postmobile']);
			}
			if($set['code'] == 'recivemobile'){
				$data['recivemobile'] = trim($poster['recivemobile']);
			}
			if($set['code'] == 'reciverealname'){
				$data['reciverealname'] = trim($poster['reciverealname']);
			}
			if($set['code'] == 'starttime'){
				$data['starttime'] = $this -> str_format_time($poster['starttime']);
			}
			if($set['code'] == 'endtime'){
				$data['endtime'] = $this -> str_format_time($poster['endtime']);
			}
			if($set['code'] == 'lessfee'){
				$data['lessfee'] = floatval($poster['lessfee']);
			}
			if($set['code'] == 'kglimit'){
				$data['kglimit'] = trim($poster['kglimit']);
			}
			if($set['code'] == 'unitname'){
				$data['unitname'] = trim($poster['unitname']);
			}
			if($set['code'] == 'timelimit'){
				$data['timelimit'] = trim($poster['timelimit']);
			}
			if($set['code'] == 'addresslimit'){
				$data['addresslimit'] = trim($poster['addresslimit']);
			}
		}
		$return = array();
		if(!empty($poster['id'])){
			$id = intval($poster['id']);
			$task = $this->getTask($id);
			$data['status'] = $task['status'];
			$_W['meepo_totalfee'] = $task['totalfee'];
			$data['totalfee'] = $task['totalfee'] + $data['totalfee'];
			pdo_update('imeepos_runner_tasks',$data,array('id'=>$id));
			$return['message'] = '修改任务成功';
		}else{
			pdo_insert('imeepos_runner_tasks', $data);
			$id = pdo_insertid();
			mload() -> model('imc');
			$url = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'detail', 'id' => $task['id']));
			imc_notice_task_post_success($_W['openid'], $data, $url);
			$return['message'] = '提交任务成功';
		}
		
		$return['code'] = 0;
		$return['data'] = $id;
		
		die(json_encode($return));
	}

	public function checkPomition() {
		global $_W;
		$uid = $this -> getUid();
		if (!empty($uid)) {
			return true;
		} else {
			return false;
		}
	}

	public function str_format_time($timestamp) {
		if (is_string($timestamp)) {
			list($date, $time) = explode(" ", $timestamp);
			list($year, $month, $day) = explode("/", $date);
			list($hour, $minute) = explode(":", $time);
			$seconds = 0;
			if (!empty($date) && !empty($time)) {
				$timestamp = mktime($hour, $minute, $seconds, $month, $day, $year);
				return $timestamp;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function getRunner($uid = 0) {
		global $_W;
		if (empty($uid)) {
			$uid = $this -> getUid();
		}
		$sql = "SELECT * FROM " . tablename('imeepos_runner_runner') . " WHERE uid = :uid";
		$params = array(':uid' => $uid);
		$item = pdo_fetch($sql, $params);
		return $item;
	}

	/*
	 * 任务详情 @meepo
	 * */
	public function taskDetail($id) {
		global $_W;
		load() -> model('mc');
		$uid = $_W['member']['uid'] > 0 ? $_W['member']['uid'] : mc_openid2uid($_W['openid']);
		//task
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " WHERE id = :id";
		$params = array(':id' => $id);
		$task = pdo_fetch($sql, $params);

		pdo_update('imeepos_runner_tasks', array('look_num' => $task['look_num'] + 1), array('id' => $id));

		$task['user'] = $this -> userInfo($task['uid']);
		if ($task['createtime'] == $task['starttime'] || empty($task['starttime'])) {
			$task['starttime'] = '随时开始';
		} else {
			$task['starttime'] = date('Y/m/d h:i', $task['starttime']);
		}
		if ($task['createtime'] == $task['endtime'] || empty($task['endtime'])) {
			$task['endtime'] = '不限时间';
		} else {
			$task['endtime'] = date('Y/m/d h:i', $task['endtime']);
		}

		$task['createtime'] = $this -> format_created_at($task['createtime']);

		$task['thumbs'] = iunserializer($task['thumbs']);

		$task = $this -> formatRestJson($task);
		$task['look_num'] = $task['look_num'] > 0 ? $task['look_num'] : '1';
		$task['share_num'] = $task['share_num'] > 0 ? $task['share_num'] : '0';
		$task['fee'] = $task['fee'] > 0 ? $task['fee'] : '0';

		$classSet = $this -> getClassSet($task['cid']);
		if (!empty($classSet)) {
			foreach ($classSet as $set) {
				if (isset($set['code'])) {
					if ($set['code'] == 'lessfee') {
						$lessfee = $set['params']['min'];
					}
				}
			}
		}

		$recive = $this -> getTaskRecives($id);

		$role = 'fans';
		if ($task['uid'] == $uid) {
			$role = 'mypost';
		}
		if (!empty($recive)) {
			foreach ($recive as $re) {
				$re['time'] = $this -> format_created_at($re['time']);
				$user = $this -> userInfo($re['from_uid']);
				$re['avatar'] = tomedia($user['avatar']);
				$re['nickname'] = $user['nickname'];
				if ($re['from_uid'] == $uid) {
					$role = 'myorder';
				}
				if ($re['status'] == 0) {
					$re['status'] = '未开始';
				}
				if ($re['status'] == 1) {
					$re['status'] = '正在进行';
				}
				if ($re['status'] == 2) {
					$re['status'] = '最新动态';
				}
				if ($re['status'] == 3) {
					$re['status'] = '待评价';
				}
				if ($re['status'] == 4) {
					$re['status'] = '已结束';
				}
				$recives[] = $re;
			}
		}
		return array('detail' => $task, 'set' => $classSet, 'recives' => $recives, 'lessfee' => $lessfee, 'role' => $role);
	}

	//自动登录
	public function checkLogin() {
		global $_W;
		if (!empty($_W['member']['uid'])) {
			return true;
		}
		if (!empty($_W['openid'])) {
			$uid = mc_openid2uid($_W['openid']);
			if (_mc_login(array('uid' => intval($uid)))) {
				return true;
			}
		}
		return false;
	}

	//是否自己
	public function isMe() {
		global $_W, $_GPC;
		$isLogin = $this -> checkLogin();
		if ($isLogin) {
			if (!empty($_GPC['u'])) {
				$u = trim($_GPC['u']);
				$uid = mc_openid2uid($u);
				if ($uid == $_W['member']['uid'] && !empty($uid)) {
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}
	
	public function postShouhuoData(){
		global $_W, $_GPC;
		$input = $_GPC['__input'];
		$uid = $this -> getUid();
		if (empty($uid)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '未关注或未注册，请前往关注注册！';
			$data['url'] = $_W['account']['subscribeurl'];
			die(json_encode($data));
		}
		$id = intval($input['taskid']);
		$task = $this -> getTask($id);
		if (empty($task)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务不存在或已删除！';
			$data['url'] = $this -> createMobileUrl('index');
			die(json_encode($data));
		}
		$recive = $this -> getReciveByUId($input['taskid'], $uid);
		if($recive['status'] != 2){
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务还没有任何动态，请上传动态后完成任务！';
			$data['url'] = $this -> createMobileUrl('index');
			die(json_encode($data));
		}
		$user = $this->getUserinfo($uid);
		$data = array();
		$data['taskid'] = $id;
		$data['title'] = '【'.$user['nickname'] . '】完成任务';
		$data['desc'] = $input['desc'];
		$data['reciveid'] = $recive['id'];
		$data['type'] = 3;//开始任务
		$data['time'] = time();
		$data['fuid'] = $uid;
		$data['uniacid'] = $_W['uniacid'];
		$data['tuid'] = $task['uid'];
		pdo_insert('imeepos_runner_tasks_comment', $data);
		pdo_update('imeepos_runner_tasks_recive',array('status'=>3),array('id'=>$data['reciveid']));
		//完成订单发送消息
		$url = $_W['siteroot'].'/app/'.$this->createMobileUrl('task',array('act'=>'detail','id'=>$id));
		if(strlen($_W['openid'])>10){
			imc_notice_task_finish($_W['openid'],$task,$url);
		}
		
		$data = array();
		$data['code'] = 0;
		$data['message'] = '完成任务成功！';

		$data['url'] = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'reciveActive', 'id' => $recive['id']));
		die(json_encode($data));
	}
	public function postDongtaiData(){
		global $_W, $_GPC;
		$input = $_GPC['__input'];
		$uid = $this -> getUid();
		if (empty($uid)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '未关注或未注册，请前往关注注册！';
			$data['url'] = $_W['account']['subscribeurl'];
			die(json_encode($data));
		}
		$id = intval($input['taskid']);
		$task = $this -> getTask($id);
		if (empty($task)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务不存在或已删除！';
			$data['url'] = $this -> createMobileUrl('index');
			die(json_encode($data));
		}
		$recive = $this -> getReciveByUId($input['taskid'], $uid);
		if($recive['status'] == 0){
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务还没有开始，请点击开始！';
			$data['url'] = $this -> createMobileUrl('index');
			die(json_encode($data));
		}
		$user = $this->getUserinfo($uid);
		$data = array();
		$data['taskid'] = $id;
		$data['title'] = '【'.$user['nickname'] . '】的动态';
		$data['desc'] = $input['desc'];
		$data['reciveid'] = $recive['id'];
		$data['type'] = 2;//开始任务
		$data['time'] = time();
		$data['fuid'] = $uid;
		$data['uniacid'] = $_W['uniacid'];
		$data['tuid'] = $task['uid'];
		pdo_insert('imeepos_runner_tasks_comment', $data);
		pdo_update('imeepos_runner_tasks_recive',array('status'=>2),array('id'=>$data['reciveid']));
		$data = array();
		$data['code'] = 0;
		$data['message'] = '动态上传成功！';

		$data['url'] = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'reciveActive', 'id' => $recive['id']));
		die(json_encode($data));
	}

	public function postQuhuoData(){
		global $_W, $_GPC;
		$input = $_GPC['__input'];
		$uid = $this -> getUid();
		if (empty($uid)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '未关注或未注册，请前往关注注册！';
			$data['url'] = $_W['account']['subscribeurl'];
			die(json_encode($data));
		}
		$id = intval($input['taskid']);
		$task = $this -> getTask($id);
		if (empty($task)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务不存在或已删除！';
			$data['url'] = $this -> createMobileUrl('index');
			die(json_encode($data));
		}
		$recive = $this -> getReciveByUId($input['taskid'], $uid);
		if($recive['status'] != 0){
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务正在进行中，请上传任务进行动态！';
			$data['url'] = $this -> createMobileUrl('index');
			die(json_encode($data));
		}
		$user = $this->getUserinfo($uid);
		if ($this -> checkQuhuo($recive['id'])) {
			$data = array();
			$data['taskid'] = $id;
			$data['title'] = '【'.$user['nickname'] . '】开始任务';
			$data['desc'] = $input['desc'];
			$data['reciveid'] = $recive['id'];
			$data['type'] = 1;//开始任务
			$data['time'] = time();
			$data['fuid'] = $uid;
			$data['uniacid'] = $_W['uniacid'];
			$data['tuid'] = $task['uid'];
			pdo_insert('imeepos_runner_tasks_comment', $data);
			pdo_update('imeepos_runner_tasks_recive',array('status'=>1),array('id'=>$data['reciveid']));
			$data = array();
			$data['code'] = 0;
			$data['message'] = '开始任务成功！';

			$data['url'] = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'reciveActive', 'id' => $recive['id']));
			die(json_encode($data));
		} else {
			$data = array();
			$data['code'] = -1;
			$data['message'] = 'sorry,您已经开始了任务，请尽快完成！';
			$data['url'] = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'reciveActive', 'id' => $recive['id']));
			die(json_encode($data));
		}
	}
	
	public function checkQuhuo($reciveid){
		$sql = "SELECT * FROM ".tablename('imeepos_runner_tasks_comment')." WHERE reciveid = :reciveid AND type = 1";
		$params = array(':reciveid'=>$reciveid);
		$item = pdo_fetch($sql,$params);
		if(empty($item)){
			return ture;
		}else{
			return false;
		}
	}

	public function postPingData() {
		global $_W, $_GPC;
		$input = $_GPC['__input'];
		$uid = $this -> getUid();
		if (empty($uid)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '未关注或未注册，请前往关注注册！';
			$data['url'] = $_W['account']['subscribeurl'];
			die(json_encode($data));
		}
		$id = intval($input['taskid']);
		$task = $this -> getTask($id);
		if (empty($task)) {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务不存在或已删除！';
			$data['url'] = $this -> createMobileUrl('index');
			die(json_encode($data));
		}
		$recive = $this -> getReciveByUId($input['taskid'], $uid);
		$user = $this->getUserinfo($uid);
		if ($recive['status'] == 3) {
			$data = array();
			$data['taskid'] = $id;
			$data['title'] = '【'.$user['nickname'] . '】的追加评论';
			$data['ratting2'] = $input['val'];
			$data['desc'] = $input['desc'];
			$data['reciveid'] = $recive['id'];
			$data['type'] = 4;//追加评论
			$data['time'] = time();
			$data['fuid'] = $uid;
			$data['uniacid'] = $_W['uniacid'];
			$data['tuid'] = $task['uid'];
			//奖励经验 完成任务
			$sql = "SELECT * FROM ".tablename('imeepos_runner_settings')." WHERE uniacid = :uniacid";
			$params = array(':uniacid'=>$_W['uniacid']);
			$setting = pdo_fetch($sql,$params);
			
			$taskset = iunserializer($setting['tasks']);
			if(empty($taskset['start'])){
				$taskset['start'] = 10;
			}
			$data['ratting3'] = $data['ratting2'] * $taskset['start'];
			$data['ratting1'] = $task['fee'];
			
			pdo_insert('imeepos_runner_tasks_comment', $data);
			pdo_update('imeepos_runner_tasks_recive',array('status'=>4),array('id'=>$data['reciveid']));
			
			//发送消息 经验变化
			mload()->model('imc');
			$url = $this->createMobileUrl('runner',array('act'=>'log'));
			$remark = '完成订单，编号为：'.$task['tid'];
			//奖励会员经验
			$member = $this->userInfo($task['uid']);
			pdo_update('imeepos_runner_member',array('credit_member'=>$member['credit_member'] + $data['ratting3']),array('uid'=>$task['uid']));
			
			$data = array();
			$data['code'] = 0;
			$data['message'] = '追加评论成功！';
			
			$data['url'] = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'reciveActive', 'id' => $recive['id']));
			die(json_encode($data));
		} else {
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务还没有完成，请完成任务！';
			$data['url'] = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'reciveActive', 'id' => $recive['id']));
			die(json_encode($data));
		}
	}

	public function checkPingPost($reciveid) {
		global $_W;
		$uid = $this -> getUid();
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks_comment') . " WHERE reciveid = :reciveid AND type = 0";
		$params = array(':reciveid' => $reciveid);
		$item = pdo_fetch($sql, $params);
		if($item['status'] != 3){
			$data = array();
			$data['code'] = -1;
			$data['message'] = '任务尚未完成，不能追加评论！';
			$data['url'] = $_W['siteroot'] . '/app/' . $this -> createMobileUrl('task', array('act' => 'reciveActive', 'id' => $recive['id']));
			die(json_encode($data));
		}
		if (empty($item)) {
			return true;
		} else {
			return false;
		}
	}

	public function getReciveByUId($id, $uid) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks_recive') . " WHERE taskid = :taskid AND from_uid = :from_uid";
		$params = array(':taskid' => $id, ':from_uid' => $uid);
		return pdo_fetch($sql, $params);
	}

	public function getTaskReciveDetail($id) {
		global $_W;
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks_comment') . " WHERE reciveid = :reciveid ORDER BY time DESC";
		$params = array(':reciveid' => $id);
		$list = pdo_fetchall($sql, $params);
		$lists = array();
		foreach($list as $li){
			$li['time'] = $this->format_created_at($li['time']);
			$lists[] = $li;
		}
		return $lists;
	}
	public function getFooter() {
		global $_W;
		$m = M('imeepos_runner_settings');
		$m -> setTable('imeepos_runner_settings');
		$setting = $m -> fetch(array('uniacid' => $_W['uniacid']));
		$themes = iunserializer($setting['themes']);
		return $themes['tabs'];
	}
	
	public function doMobileWechatPay(){
		global $_W,$_GPC;
		$sl = $_GPC['ps'];
		$params = @json_decode(base64_decode($sl), true);
		if($_GPC['done'] == '1') {
			$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `plid`=:plid';
			$pars = array();
			$pars[':plid'] = $params['tid'];
			$log = pdo_fetch($sql, $pars);
			if(!empty($log)) {
				if (!empty($log['tag'])) {
					$tag = iunserializer($log['tag']);
				}
				if(!$log['status']) {
					$record = array();
					$record['status'] = $log['status'] = '1';
					pdo_update('core_paylog', $record, array('plid' => $log['plid']));
					if($log['is_usecard'] == 1 && $log['card_type'] == 1 &&  !empty($log['encrypt_code']) && $log['acid']) {
						load()->classs('coupon');
						$acc = new coupon($log['acid']);
						$codearr['encrypt_code'] = $log['encrypt_code'];
						$codearr['module'] = $log['module'];
						$codearr['card_id'] = $log['card_id'];
						$acc->PayConsumeCode($codearr);
					}
					load()->model('mc');
					$log['uid'] = mc_openid2uid($log['openid']);
					if($log['is_usecard'] == 1 && $log['card_type'] == 2) {
						$now = time();
						$log['card_id'] = intval($log['card_id']);
						$iscard = pdo_fetchcolumn('SELECT iscard FROM ' . tablename('modules') . ' WHERE name = :name', array(':name' => $log['module']));
						$condition = '';
						if($iscard == 1) {
							$condition = " AND grantmodule = '{$log['module']}'";
						}
						pdo_query('UPDATE ' . tablename('activity_coupon_record') . " SET status = 2, usetime = {$now}, usemodule = '{$log['module']}' WHERE uniacid = :aid AND couponid = :cid AND uid = :uid AND status = 1 {$condition} LIMIT 1", array(':aid' => $_W['uniacid'], ':uid' => $log['uid'], ':cid' => $log['card_id']));
					}
				}
		
				$site = WeUtility::createModuleSite($log['module']);
				if(!is_error($site)) {
					$method = 'payResult';
					if (method_exists($site, $method)) {
						$ret = array();
						$ret['weid'] = $log['uniacid'];
						$ret['uniacid'] = $log['uniacid'];
						$ret['result'] = $log['status'] == '1' ? 'success' : 'failed';
						$ret['type'] = $log['type'];
						$ret['from'] = 'return';
						$ret['tid'] = $log['tid'];
						$ret['uniontid'] = $log['uniontid'];
						$ret['user'] = $log['openid'];
						$ret['fee'] = $log['fee'];
						$ret['tag'] = $tag;
						$ret['is_usecard'] = $log['is_usecard'];
						$ret['card_type'] = $log['card_type'];
						$ret['card_fee'] = $log['card_fee'];
						$ret['card_id'] = $log['card_id'];
						exit($site->$method($ret));
					}
				}
			}
		}
		
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `plid`=:plid';
		$log = pdo_fetch($sql, array(':plid' => $params['tid']));
		if(!empty($log) && $log['status'] != '0') {
			$data = array();
			$data['code'] = -1;
			$data['message']  = '这个订单已经支付成功, 不需要重复支付.';
			die(json_encode($data));
		}
		$auth = sha1($sl . $log['uniacid'] . $_W['config']['setting']['authkey']);
		if($auth != $_GPC['auth']) {
			$data = array();
			$data['code'] = -1;
			$data['message']  = '参数传输错误.';
			die(json_encode($data));
		}
		load()->model('payment');
		$_W['uniacid'] = intval($log['uniacid']);
		$_W['openid'] = intval($log['openid']);
		$setting = uni_setting($_W['uniacid'], array('payment'));
		if(!is_array($setting['payment'])) {
			$data = array();
			$data['code'] = -1;
			$data['message']  = '没有设定支付参数.';
			die(json_encode($data));
		}
		$wechat = $setting['payment']['wechat'];
		$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
		$row = pdo_fetch($sql, array(':acid' => $wechat['account']));
		$wechat['appid'] = $row['key'];
		$wechat['secret'] = $row['secret'];
		$wOpt = wechat_build($params, $wechat);
		if (is_error($wOpt)) {
			if ($wOpt['message'] == 'invalid out_trade_no' || $wOpt['message'] == 'OUT_TRADE_NO_USED') {
				$id = date('YmdH');
				pdo_update('core_paylog', array('plid' => $id), array('plid' => $log['plid']));
				pdo_query("ALTER TABLE ".tablename('core_paylog')." auto_increment = ".($id+1).";");
				$data = array();
				$data['code'] = -1;
				$data['message']  = '抱歉，发起支付失败，系统已经修复此问题，请重新尝试支付。';
				die(json_encode($data));
			}
			$data = array();
			$data['code'] = -1;
			$data['message']  = '抱歉，发起支付失败';
			die(json_encode($data));
			exit;
		}
		
		$data = array();
		$data['code']  = 1;
		$data['data'] = $wOpt;
		die(json_encode($data));
	}

	
	public function doMobileSelectPay(){
		global $_W,$_GPC;
		$uid = $this->getUid();
		if(empty($uid)){
			$data = array();
			$data['code'] = -2;
			$data['message'] = '登陆失效，请重新打开！';
			$data['uid'] = $uid;
			die(json_encode($data));
		}
		$userinfo = $this->userInfo();
		
		$tasktable = 'imeepos_runner_tasks';
		$runnertable = 'imeepos_runner_runner';
		$paylogtable = 'imeepos_runner_member_paylog';
		
		$tid = intval($_GPC['tid']);
		$type = trim($_GPC['type']);
		
		if(!empty($type)){
			if(empty($tid)){
				$data = array();
				$data['code'] = -2;
				$data['message'] = '参数错误，请刷新重试！';
				$data['data'] = $task['id'];
				die(json_encode($data));
			}
			if(empty($type)){
				$data = array();
				$data['code'] = -2;
				$data['message'] = '支付类型错误，请重新选择！';
				$data['data'] = $task['id'];
				die(json_encode($data));
			}
			$task = $this->getTaskDetail($tid);
			if($task['status'] != 0){
				$data = array();
				$data['code'] = 0;
				$data['message'] = '此订单已经支付成功！';
				$data['data'] = $task['id'];
				die(json_encode($data));
			}
			if($task['totalfee'] <= 0){
				$data = array();
				$data['code'] = 0;
				$data['message'] = '支付成功！';
				$data['data'] = $task['id'];
				pdo_update('imeepos_runner_tasks', array('status'=>1), array('id' => $task['id']));
				die(json_encode($data));
			}
			$ordersn = $task['ordersn'];
			if(empty($ordersn)){
				$data = array();
				$data['code'] = -2;
				$data['message'] = '订单号错误，请重新提交！';
				$data['data'] = $task['id'];
				die(json_encode($data));
			}
			
			$params = array(
				'tid' => $task['ordersn'],
				'ordersn' => $task['ordersn'],
				'title' => '订单编号：'.$task['ordersn'],
				'fee' => $task['totalfee'],
				'user' => $_W['member']['uid'],
			);
			$params['module'] = $this->module['name'];
			
			
			$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
			$pars = array(':uniacid'=>$_W['uniacid'],':module'=>$this->module['name'],':tid'=>$params['tid']);
			$log = pdo_fetch($sql, $pars);
			
			if(!empty($log) && $log['status'] == '1') {
				$data  = array();
				$data['code'] = 0;
				$data['message'] = '这个订单已经支付成功, 不需要重复支付.';
				die(json_encode($data));
			}
			
			$setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
			if(!is_array($setting['payment'])) {
				$data  = array();
				$data['code'] = -1;
				$data['message'] = '没有有效的支付方式, 请联系网站管理员.';
				die(json_encode($data));
			}
			$pay = $setting['payment'];
			if (empty($_W['member']['uid'])) {
				$pay['credit']['switch'] = false;
			}
			if (!empty($pay['credit']['switch'])) {
				$credtis = mc_credit_fetch($_W['member']['uid']);
			}
			
			if(!empty($log) && $log['status'] == '0') {
				pdo_delete('core_paylog', array('plid' => $log['plid']));
				$log = null;
			}
			
			$type = trim($_GPC['type']);
			$types = array('wechat','credit_red','credit2');
			
			if(empty($type) || !in_array($type,$types)){
				$data  = array();
				$data['code'] = -1;
				$data['message'] = '支付类型错误.';
				die(json_encode($data));
			}
			
			if(empty($log)) {
				$moduleid = pdo_fetchcolumn("SELECT mid FROM ".tablename('modules')." WHERE name = :name", array(':name' => $params['module']));
				$moduleid = empty($moduleid) ? '000000' : sprintf("%06d", $moduleid);
				$fee = $params['fee'];
				$record = array();
				$record['uniacid'] = $_W['uniacid'];
				$record['openid'] = $_W['member']['uid'];
				$record['module'] = $params['module'];
				$record['type'] = $type;
				$record['tid'] = $params['tid'];
				$record['uniontid'] = date('YmdHis').$moduleid.random(8,1);
				$record['fee'] = $fee;
				$record['status'] = '0';
				$record['is_usecard'] = 0;
				$record['card_id'] = 0;
				$record['card_fee'] = $fee;
				$record['encrypt_code'] = '';
				$record['acid'] = $_W['acid'];
				
				if(pdo_insert('core_paylog', $record)) {
					$plid = pdo_insertid();
					$record['plid'] = $plid;
					$log = $record;
					
					//模块支付记录
					$data = array();
					$data['uniacid'] = $_W['uniacid'];
					$data['openid'] = $_W['openid'];
					$data['tid'] = $params['tid'];
					$data['fee'] = $params['fee'];
					$data['status'] = 0;
					$data['type'] = 1;
					$data['time'] = time();
					$data['actiontype'] = '1';//消费
					$data['title'] = $params['title'];
					$data['uid'] = $params['uid'];
					
					pdo_insert('imeepos_runner_paylog', $data);
				} else {
					$data  = array();
					$data['code'] = -1;
					$data['message'] = '系统错误, 请稍后重试.';
					die(json_encode($data));
				}
			}

			$ps = array();
			$ps['tid'] = $log['plid'];
			$ps['uniontid'] = $log['uniontid'];
			$ps['user'] = !empty($_W['fans']['from_user'])?$_W['fans']['from_user']:$_W['openid'];
			$ps['fee'] = $params['fee'];
			$ps['title'] = $params['title'];
			$ps['ordersn'] = $log['tid'];
			
			$params = $ps;
			$setting = uni_setting($_W['uniacid'], array('payment'));
			if(!is_array($setting['payment'])) {
				$data  = array();
				$data['code'] = -1;
				$data['message'] = '没有设定支付参数.';
				die(json_encode($data));
			}
			//红包支付
			if($type == 'credit_red'){
				$uid = $_W['member']['uid'];
				$sql = "SELECT * FROM ".tablename('imeepos_runner_member')." WHERE uid = :uid";
				$p = array(':uid'=>$uid);
				$member = pdo_fetch($sql,$p);
				
				$credit_red = floatval($member['credit_red']);
				$credit_num = $credit_red-$params['fee'];
				if($credit_num <= 0){
					$data = array();
					$data['code'] = -1;
					$data['message'] = '红包金额不足！';
					die(json_encode($data));
				}
				
				if(pdo_update('imeepos_runner_member',array('credit_red'=>$credit_num),array('uid'=>$uid))){
					$data = array();
					$data['status'] = 1;
					pdo_update($tasktable, $data, array('ordersn' => $params['ordersn']));
					
					$data = array();
					$data['code'] = 0;
					$data['message'] = '红包支付成功！';
					die(json_encode($data));
				}else{
					$data = array();
					$data['code'] = -1;
					$data['message'] = '系统错误！';
					die(json_encode($data));
				}
			}
			//余额支付
			if($type == 'credit2'){
				load()->model('mc');
				$uid = $_W['member']['uid'];
				if(empty($uid)){
					$data = array();
					$data['code'] = -1;
					$data['message'] = '登录失效，或会员不存在！';
					die(json_encode($data));
				}
				$return = mc_credit_update($uid, 'credit2','-'.$params['fee'],array($uid,$params['title']));
				if(is_error($return)){
					$data  = array();
					$data['code'] = -1;
					$data['message'] = $return['message'];
					die(json_encode($data));
				}
				$data = array();
				$data['status'] = 1;
				pdo_update($tasktable, $data, array('ordersn' => $params['ordersn']));
				$data = array();
				$data['code'] = 0;
				$data['message'] = '支付成功';
				die(json_encode($data));
			}
			//微信支付
			if($type == 'wechat'){
				$data = array();
				$data['code']  = 1;
				$data['message'] = '正在跳转微信支付';
				$sl = base64_encode(json_encode($params));
				$auth = sha1($sl . $_W['uniacid'] . $_W['config']['setting']['authkey']);
				$data['data'] = $sl;
				$data['auth']  = $auth;
				die(json_encode($data));
			}
			
			$data = array();
			$data['code'] = -1;
			$data['message'] = '系统错误';
			die(json_encode($data));
		}
		include $this->template('mui/selectPay');
	}

	/*
	 * 调试用
	 * */
	public function doMobilePage() {
		global $_W, $_GPC;
		$pageid = intval($_GPC['pageid']);
		$pagetype = intval($_GPC['pagetype']);

		if (empty($pagetype)) {
			$sql = "SELECT * FROM " . tablename('imeepos_runner_page') . " WHERE id = :id AND uniacid = :uniacid";
			$params = array(':id' => $pageid, ':uniacid' => $_W['uniacid']);
			$item = pdo_fetch($sql, $params);
			$pagetype = intval($item['pagetype']);
		}

		$re = $this -> getPageInfo($pagetype);
		$data = $re['data'];
		$pageinfo = $re['pageinfo'];
		include $this -> template('page');
	}
	
	//附近任务
	public function doMobilePostAround() {
		global $_W, $_GPC;
		$pageSize = !empty($_GPC['pageSize']) ? intval($_GPC['pageSize']) : 10;
		$location = $this -> apiLocation($_GPC['location']);
		if (empty($location['lat'])) {
			$squares = array();
		} else {
			$squares = $this -> returnSquarePoint($location['lon'], $location['lat']);
		}
		$sort_by = !empty($_GPC['sort_by']) ? trim($_GPC['sort_by']) : 'location_asc';
		$limit = $pageSize + 1;

		$offset = "";
		$hasMore = 0;
		$total = 0;
		$orderBy = " createtime DESC ";

		$orderWhere = 'WHERE 1 AND uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		$page = !empty($_GPC['page']) ? intval($_GPC['page']) : 1;
		$offset = ' OFFSET ' . $pageSize * ($page - 1);

		//$squares = $this->returnSquarePoint($location['lon'],$location['lat']);
		if (!empty($squares['right-bottom']['lat'])) {
			$orderWhere .= " AND startlat <>0 AND startlat > {$squares['right-bottom']['lat']}";
		}
		if (!empty($squares['left-top']['lat'])) {
			$orderWhere .= " AND startlat < {$squares['left-top']['lat']} ";
		}
		if (!empty($squares['left-top']['lon'])) {
			$orderWhere .= " AND startlng > {$squares['left-top']['lon']} ";
		}
		if (!empty($squares['right-bottom']['lon'])) {
			$orderWhere .= " AND startlng < {$squares['right-bottom']['lon']} ";
		}
		$sql = "SELECT * FROM " . tablename('imeepos_runner_tasks') . " $orderWhere order by $orderBy limit $limit $offset";
		$tasks = pdo_fetchall($sql, $params);
		$sql = "SELECT COUNT(*) FROM " . tablename('imeepos_runner_tasks') . " $orderWhere order by $orderBy limit $limit $offset";
		$total = pdo_fetchcolumn($sql, $params);

		$hasMore = count($tasks) < $pageSize ? 0 : 1;

		$return = array('total' => $total, 'count' => count($tasks) < $pageSize ? count($orders) : $pageSize, 'more' => $hasMore, 'tasks' => $tasks, );
	}

	public function userInfo($uid = 0) {
		global $_W;
		load() -> model('mc');
		if (empty($uid)) {
			$uid = $this -> getUid();
		}
		load() -> model('mc');
		$userinfo = mc_fetch($uid, array('uid', 'avatar','realname', 'nickname', 'gender','mobile','credit2','resideprovince','residecity','residedist'));
		if (empty($userinfo)) {
			$userinfo = mc_oauth_userinfo();
		}
		$m = M('member');
		$m -> setTable('imeepos_runner_member');
		
		$member = $m -> fetch(array('uid' => $uid));
		if (empty($member)) {
			$data = array();
			$data['uniacid'] = $_W['uniacid'];
			$data['openid'] = $_W['openid'];
			$data['uid'] = $uid;
			$data['time'] = time();
			$data['fid'] = 0;
			pdo_insert('imeepos_runner_member', $data);
			$member = $m -> fetch(array('uid' => $uid));
		}
		if (!empty($member) || !empty($userinfo)) {
			$userinfo = array_merge($userinfo, $member);
		}
		return $userinfo;
	}
}
