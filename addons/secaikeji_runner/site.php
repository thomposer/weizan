<?php
/**
 * 小明快跑模块微站定义
 * 
 * 
 *
 * @author imeepos
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

$sql = "SELECT * FROM ".tablename('modules_bindings')." WHERE module = :module AND entry = :entry AND do = :do";
$params = array(':module'=>'secaikeji_runner',':entry'=>'cover',':do'=>'runner');
$item = pdo_fetch($sql,$params);
if(!empty($item)){
	pdo_delete('modules_bindings',array('module'=>'secaikeji_runner','entry'=>'cover','do'=>'runner'));
}

$sql = "SELECT * FROM ".tablename('modules_bindings')." WHERE module = :module AND entry = :entry AND do = :do";
$params = array(':module'=>'secaikeji_runner',':entry'=>'cover',':do'=>'tasks');
$item = pdo_fetch($sql,$params);
if(empty($item)){
	$data = array('module'=>'secaikeji_runner','entry'=>'cover','do'=>'tasks','title'=>'任务大厅','direct'=>1);
	pdo_insert('modules_bindings',$data);
}
load()->func('logging');


if(!function_exists('M')){
	function M($name){
		static $model = array();
		if(empty($model[$name])) {
			include IA_ROOT.'/addons/secaikeji_runner/inc/core/model/'.$name.'.mod.php';
			$model[$name] = new $name();
		}
		return $model[$name];
	}
}

class secaikeji_runnerModuleSite extends WeModuleSite {
	public $modulename = 'secaikeji_runner';
	public $pluginname = '';
	public function doWebannouncement(){
		global $_W,$_GPC;
		$_GPC['do'] = 'announcement';
		if ($_GPC['act'] == 'edit') {
			$id = intval($_GPC['id']);
			if($_W['ispost']){
				$data = array();
				$data['uniacid'] = $_W['uniacid'];
				$data['title'] = trim($_GPC['title']);
				$data['displayorder'] = intval($_GPC['displayorder']);
				$data['link'] = trim($_GPC['link']);
				$data['create_time'] = time();
				if(!empty($id)){
					$data['id'] = $id;
					unset($data['create_time']);
				}
				M('announcement')->update($data);
				message('保存成功',$this->createWebUrl('announcement'),'success');
			}
			$item = M('announcement')->getInfo($id);
			include $this->template('announcement_edit');
			exit();
		}
		if ($_GPC['act'] == 'delete') {
			$id = intval($_GPC['id']);
			if(empty($id)){
				message('参数错误',referer(),'error');
			}
			M('announcement')->delete($id);
			message('删除成功',referer(),'success');
		}
		$page = !empty($_GPC['page'])?intval($_GPC['page']):1;
		$list = M('announcement')->getList($page);
		include $this->template('announcement');
	}
	public function doWebadvs(){
		global $_W,$_GPC;
		$_GPC['do'] = 'advs';
		$options = array();
		$options['adv'] = '滑动广告';
		$options['navs'] = '导航广告';
		$options['footer'] = '底部广告';

		if ($_GPC['act'] == 'edit') {
			$id = intval($_GPC['id']);
			if($_W['ispost']){
				$data = array();
				$data['uniacid'] = $_W['uniacid'];
				$data['title'] = trim($_GPC['title']);
				$data['image'] = tomedia(trim($_GPC['image']));
				$data['link'] = trim($_GPC['link']);
				$data['position'] = trim($_GPC['position']);
				$data['time'] = time();
				if(!empty($id)){
					$data['id'] = $id;
					unset($data['time']);
				}
				M('advs')->update($data);
				message('保存成功',$this->createWebUrl('advs',array('activeid'=>$activeid)),'success');
			}
			$item = M('advs')->getInfo($id);
			include $this->template('advs_edit');
			exit();
		}
		if ($_GPC['act'] == 'delete') {
			$id = intval($_GPC['id']);
			if(empty($id)){
				message('参数错误',referer(),'error');
			}
			M('advs')->delete($id);
			message('删除成功',referer(),'success');
		}
		$page = !empty($_GPC['page'])?intval($_GPC['page']):1;
		$where = "";
		$list = M('advs')->getList($page,$where);
		include $this->template('advs');
	}
	public function doWebonekey(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'onekey';
		$menu = array();
		if(!empty($_GPC['act'])){
			pdo_delete('secaikeji_runner3_navs',array('uniacid'=>$_W['uniacid'],'position'=>trim($_GPC['act'])));
		}
		if($_GPC['act']=='user_home'){
			$menu[] = array('title'=>'常用地址','ido'=>'home_address','icon'=>'fa fa-map-marker','displayorder'=>time(),'position'=>'user_home');
			$menu[] = array('title'=>'我要提现','ido'=>'','icon'=>'fa fa-money','displayorder'=>time(),'position'=>'user_home');
			$menu[] = array('title'=>'我的任务','ido'=>'home_order','icon'=>'fa fa-book','displayorder'=>time(),'position'=>'user_home');
			$menu[] = array('title'=>'我的资料','ido'=>'home_edit','icon'=>'fa fa-mortar-board','displayorder'=>time(),'position'=>'user_home');
		}
		if($_GPC['act']=='runner_home'){
			$menu[] = array('title'=>'我的赏金','ido'=>'runner_money','icon'=>'fa fa-laptop','displayorder'=>time(),'position'=>'runner_home');
			$menu[] = array('title'=>'接单记录','ido'=>'runner_order','icon'=>'fa fa-book','displayorder'=>time(),'position'=>'runner_home');
			$menu[] = array('title'=>'信誉充值','ido'=>'runner_xinyu','icon'=>'fa fa-money','displayorder'=>time(),'position'=>'runner_home');
		}
		if($_GPC['act']=='user'){
			$menu[] = array('title'=>'个人中心','ido'=>'home','icon'=>'fa fa-user','displayorder'=>time(),'position'=>'user');
			$menu[] = array('title'=>'我的任务','ido'=>'home_order','icon'=>'fa fa-book','displayorder'=>time(),'position'=>'user');
			$menu[] = array('title'=>'发布任务','ido'=>'post','icon'=>'fa fa-plus-square','displayorder'=>time(),'position'=>'user');
		}
		if($_GPC['act']=='runner'){
			$menu[] = array('title'=>'跑腿中心','ido'=>'runner','icon'=>'fa fa-user','displayorder'=>time(),'position'=>'runner');
			$menu[] = array('title'=>'我的赏金','ido'=>'runner_money','icon'=>'fa fa-money','displayorder'=>time(),'position'=>'runner');
			$menu[] = array('title'=>'我要听单','ido'=>'index','icon'=>'fa fa-volume-up','displayorder'=>time(),'position'=>'runner');
			$menu[] = array('title'=>'任务大厅','ido'=>'tasks','icon'=>'fa fa-book','displayorder'=>time(),'position'=>'runner');
		}
		if(!empty($menu)){
			foreach ($menu as $key=>$m){
				$data = array();
				$data['uniacid'] = $_W['uniacid'];
				$data['create_time'] = time();
				$data['title'] = $m['title'];
				$data['ido'] = $m['ido'];
				$data['icon'] = $m['icon'];
				$data['displayorder'] = $key;
				$data['position'] = $m['position'];
				$data['link'] = $this->createMobileUrl($data['ido']);
				M('navs')->update($data);
			}
			message('设置成功',$this->createWebUrl('navs',array('position'=>$_GPC['act'])),'success');
		}
	}
	public function doWebquickmenu(){
		global $_W,$_GPC;
		$_GPC['do'] = 'quickmenu';
		if ($_GPC['act'] == 'edit') {
			$id = intval($_GPC['id']);
			if($_W['ispost']){
				$data = array();
				$data['uniacid'] = $_W['uniacid'];
				$data['icon'] = trim($_GPC['icon']);
				$data['link'] = trim($_GPC['link']);
				$data['title'] = trim($_GPC['title']);
				$data['ido'] = trim($_GPC['ido']);
				$data['displayorder'] = intval($_GPC['displayorder']);
				$data['position'] = trim($_GPC['position']);
				$data['create_time'] = time();
				if(!empty($id)){
					$data['id'] = $id;
					unset($data['create_time']);
				}
				M('quickmenu')->update($data);
				message('保存成功',$this->createWebUrl('quickmenu'),'success');
			}
			$item = M('quickmenu')->getInfo($id);
			include $this->template('quickmenu_edit');
			exit();
		}
		if ($_GPC['act'] == 'delete') {
			$id = intval($_GPC['id']);
			if(empty($id)){
				message('参数错误',referer(),'error');
			}
			M('quickmenu')->delete($id);
			message('删除成功',referer(),'success');
		}
		$page = !empty($_GPC['page'])?intval($_GPC['page']):1;
		$list = M('quickmenu')->getList($page);
		include $this->template('quickmenu');
	}
	public function doMobilequnfa(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'qunfa';
		$_share = $this->_share;
	    $taskid = intval($_GPC['id']);

		$task = M('tasks')->getInfo($taskid);

		$paylog = M('tasks_paylog')->getByTasksId($taskid);

		if($task['type'] == 0){
			$task['type_title'] = '帮我送';
		}
		if($task['type'] == 1){
			$task['type_title'] = '帮我送';
		}
		if($task['type'] == 2){
			$task['type_title'] = '帮我买';
		}
		if($task['type'] == 3){
			$task['type_title'] = '帮我买';
		}
		if($task['type'] == 4){
			$task['type_title'] = '帮帮忙';
		}
		if($task['type'] == 5){
			$task['type_title'] = '帮帮忙';
		}
		$user = M('member')->getInfo($task['openid']);

		$sql = "SELECT COUNT(*) FROM ".tablename('secaikeji_runner3_member')." WHERE isrunner = :isrunner AND uniacid = :uniacid AND status = :status";
		$params = array(':isrunner'=>1,':uniacid'=>$_W['uniacid'],':status'=>1);
		$total = pdo_fetchcolumn($sql,$params);
		if($_GPC['r']) {
			$restore = 1;
			isetcookie('__qunfa', base64_encode(json_encode($restore)));
			message('正在群发通知附近服务人员，请不要关闭！总共'.$total.'人！',$this->createMobileUrl('qunfa',array('id'=>$taskid)),'info');
		}
		if($_GPC['__qunfa']){
			$restore = json_decode(base64_decode($_GPC['__qunfa']), true);
			$restore = intval($restore);
			//没有完成 记录群发条数
			//群发
			$where = " AND isrunner = 1 AND status = 1";
			$number = ($restore-1)*5;
			$members = M('member')->getList2($restore,$where);
			if(!empty($members['list'])){
				foreach ($members['list'] as $member){
					if($member['openid'] != $_W['openid']){
//开始群发
						$content = "";
						$content = "最新订单提醒！~\n";
						$content .= "昵称：".$user['nickname']."\n";
						$content .= "类型：".$task['type_title']."\n";
						$type = $paylog['type'];
						if($type == 'delivery'){
							$content .= "支付方式：货到付款\n";
						}
						if($type == 'credit'){
							$content .= "支付方式：余额支付\n";
						}
						if($type == 'alipay'){
							$content .= "支付方式：支付宝支付\n";
						}
						if($type == 'wechat'){
							$content .= "支付方式：微信支付\n";
						}
						if($type == 'unionpay'){
							$content .= "支付方式：银联支付\n";
						}
						if($type == 'baifubao'){
							$content .= "支付方式：百度钱包支付\n";
						}
						$content .= "截止时间：".date('Y-m-d H:i',$task['limit_time'])."\n";
						$url = $_W['siteroot'].'app/'.$this->createMobileUrl('detail',array('id'=>$taskid));
						$retrun = mc_notice_consume2($member['openid'], '新订单提醒', $content, $url,'');
						$number += 1;
					}
				}
				$restore = $restore + 1;
				isetcookie('__qunfa', base64_encode(json_encode($restore)));
				message('正在群发通知附近服务人员，已通知！'.$number.'人', $this->createMobileUrl('qunfa',array('id'=>$taskid)),'info');
			}else{
				isetcookie('__qunfa', '', -1000);
				message('群发完毕！.',$this->createMobileUrl('detail',array('id'=>$taskid)),'success');
			}
		}
	}
	
	public function doWebajax(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'ajax';
		$act = trim($_GPC['act']);
		if($act == 'update'){
			$id = intval($_GPC['id']);
			$data['id'] = $id;
			$data['status'] = 1;
			M('message')->update($data);
		}
		$news = M('message')->getList(1," AND status = 0");
		$news = $news['list'];
		$data = array();
		if(empty($news)){
			$data['status'] = 0;
		}else{
			$data['status'] = 1;
		}
		$data['news'] = $news;
		M('tasks')->clear();
		die(json_encode($data));
	}
	public function doWeblink(){
		global $_W,$_GPC;
		$callback = $_GPC['callback'];
		$runners = array();
		$runners[] = array('url'=>$this->createMobileUrl('home'),'title'=>'个人中心');
		$runners[] = array('url'=>$this->createMobileUrl('post'),'title'=>'发单入口');
		$runners[] = array('url'=>$this->createMobileUrl('home_address'),'title'=>'常用地址');
		$runners[] = array('url'=>$this->createMobileUrl('home_order'),'title'=>'我的任务');
		$runners[] = array('url'=>$this->createMobileUrl('home_edit'),'title'=>'会员资料');
		$users = array();
		$users[] = array('url'=>$this->createMobileUrl('runner'),'title'=>'跑腿中心');
		$users[] = array('url'=>$this->createMobileUrl('tasks'),'title'=>'任务大厅');
		$users[] = array('url'=>$this->createMobileUrl('index'),'title'=>'听单入口');

		$users[] = array('url'=>$this->createMobileUrl('runner_xinyu'),'title'=>'信誉充值');
		$users[] = array('url'=>$this->createMobileUrl('runner_order'),'title'=>'接单记录');
		$users[] = array('url'=>$this->createMobileUrl('runner_money'),'title'=>'我的赏金');
		include $this->template('link');
	}
	public function doWebnavs(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'navs';
		$position = trim($_GPC['position']);
		$options = array();
		$options[] = array('value'=>'user','title'=>'客户端');
		$options[] = array('value'=>'runner','title'=>'服务端');
		$options[] = array('value'=>'tasks_navs','title'=>'大厅导航');
		$options[] = array('value'=>'user_home','title'=>'会员中心');
		$options[] = array('value'=>'runner_home','title'=>'跑腿中心');
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
				$data['title'] = trim($_GPC['title']);
				$data['link'] = trim($_GPC['link']);
				$data['icon_on'] = tomedia(trim($_GPC['icon_on']));
				$data['icon_off'] = tomedia(trim($_GPC['icon_off']));
				$data['icon'] = trim($_GPC['icon']);
				$data['ido'] = trim($_GPC['ido']);
				$data['displayorder'] = intval($_GPC['displayorder']);
				$data['position'] = trim($_GPC['position']);
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('navs')->update($data);
	            message('保存成功',$this->createWebUrl('navs',array('position'=>$position)),'success');
	        }
	        $item = M('navs')->getInfo($id);
	        include $this->template('navs_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            message('参数错误',referer(),'error');
	        }
	        M('navs')->delete($id);
	        message('删除成功',referer(),'success');
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;

		$where = "";
		if(!empty($position)){
			$where = " AND position = '{$position}'";
		}
	    $list = M('navs')->getList($page,$where);
	    include $this->template('navs');
	}
	public function doWebpaylog(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'paylog';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('paylog')->update($data);
	            message('保存成功',$this->createWebUrl('paylog'),'success');
	        }
	        $item = M('paylog')->getInfo($id);
	        include $this->template('paylog_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            message('参数错误',referer(),'error');
	        }
	        M('paylog')->delete($id);
	        message('删除成功',referer(),'success');
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
		$where = " AND status = 1";
		if(!empty($_GPC['openid'])){
			$openid = trim($_GPC['openid']);
			$where .=" AND openid = '{$openid}'";
		}
	    $list = M('paylog')->getList($page,$where);
		$sql = "SELECT SUM(fee) as sum FROM ".tablename('secaikeji_runner3_paylog')."WHERE uniacid = :uniacid {$where}";
		$params = array(':uniacid'=>$_W['uniacid']);
		$total = pdo_fetchcolumn($sql,$params);

	    include $this->template('paylog');
	}
	public function doWebrecive(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'recive';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('recive')->update($data);
	            message('保存成功',$this->createWebUrl('recive'),'success');
	        }
	        $item = M('recive')->getInfo($id);
	        include $this->template('recive_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            message('参数错误',referer(),'error');
	        }
	        M('recive')->delete($id);
	        message('删除成功',referer(),'success');
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
	    $list = M('recive')->getList($page);
	    include $this->template('recive');
	}
	public function doWebtasks_log(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'tasks_log';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
				$data['content'] = trim($_GPC['content']);
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('tasks_log')->update($data);
	            message('保存成功',$this->createWebUrl('tasks_log'),'success');
	        }
	        $item = M('tasks_log')->getInfo($id);
	        include $this->template('tass_log_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            message('参数错误',referer(),'error');
	        }
	        M('tasks_log')->delete($id);
	        message('删除成功',referer(),'success');
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
		$where = "";
		if(!empty($_GPC['taskid'])){
			$taskid = intval($_GPC['taskid']);
			$where .=" AND taskid = '{$taskid}'";
		}
	    $list = M('tasks_log')->getList($page,$where);
	    include $this->template('tasks_log');
	}
	public function doWebstar(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'star';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
				$data['star'] = intval($_GPC['star']);
				$data['content'] = trim($_GPC['content']);
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('star')->update($data);
	            message('保存成功',$this->createWebUrl('star'),'success');
	        }
	        $item = M('star')->getInfo($id);
	        include $this->template('star_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            message('参数错误',referer(),'error');
	        }
	        M('star')->delete($id);
	        message('删除成功',referer(),'success');
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
		$where = "";
		if(!empty($_GPC['taskid'])){
			$taskid = intval($_GPC['taskid']);
			$where .=" AND taskid = '{$taskid}'";
		}
	    $list = M('star')->getList($page,$where);
	    include $this->template('star');
	}
	function upload_cert($fileinput){
		global $_W;
		$path = IA_ROOT . "/addons/".$this->modulename."/cert";
		load()->func('file');
		mkdirs($path, '0777');
		$f           = $fileinput . '_' . $_W['uniacid'] . '.pem';
		$outfilename = $path . "/" . $f;
		$filename    = $_FILES[$fileinput]['name'];
		$tmp_name    = $_FILES[$fileinput]['tmp_name'];
		if (!empty($filename) && !empty($tmp_name)) {
			$ext = strtolower(substr($filename, strrpos($filename, '.')));
			if ($ext != '.pem') {
				message('证书文件格式错误: ' . $fileinput . "!", '', 'error');
			}
			return file_get_contents($tmp_name);
		}
		return "";
	}
	public function doWebtasks_paylog(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'tasks_paylog';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('tasks_paylog')->update($data);
	            message('保存成功',$this->createWebUrl('tasks_paylog'),'success');
	        }
	        $item = M('tasks_paylog')->getInfo($id);
	        include $this->template('tasks_paylog_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            if($_W['ispost']){
	                $data = array();
	                $data['status'] = 1;
	                $data['message'] = '参数错误';
	                die(json_encode($data));
	            }else{
	                message('参数错误',referer(),'error');
	            }
	        }
	        M('tasks_paylog')->delete($id);
	        if($_W['ispost']){
	            $data = array();
	            $data['status'] = 1;
	            $data['message'] = '操作成功';
	            die(json_encode($data));
	        }else{
	            message('删除成功',referer(),'success');
	        }
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
	    $where = "";
		$list = M('tasks_paylog')->getList($page,$where);
	    include $this->template('tasks_paylog');
	}
	public $_share = array();

	public function __construct(){
		global $_W,$_GPC;
		$share = M('setting')->getValue('share');
		$_W['page']['title'] = $share['title'];
		$this->_share = array(
			'title'=>$share['share_title'],
			'imgUrl'=>tomedia($share['share_image']),
			'content'=>$share['share_desc']
		);
		$file = array();
		$file = IA_ROOT.'/addons/'.$this->modulename.'/inc/core/function/global.func.php';
		if(file_exists($file)){
			require $file;
			init($this->modulename);
		}
		if($_W['os'] == 'mobile') {
			if(!empty($_W['openid'])){
				M('member')->update();
			}
		} else {
			$do = $_GPC['do'];
			$doo = $_GPC['doo'];
			$act = $_GPC['act'];
			global $frames;
			$file = IA_ROOT."/addons/iemepos_runner/template/mobile/default/common/header.html";
			if(file_exists($file)){
				@unlink($file);
			}
			$frames = getModuleFrames('secaikeji_runner');
			_calc_current_frames2($frames);
		}
	}
	public function updateRunner($setting,$runner){
		global $_W;
		//$oauth = M('setting')->getSystem('auth');
		//if(empty($oauth['code'])){
		//	return array();
		//}
		$runner_set = M('setting')->getValue('v_set');
		if($runner_set['auto_runner'] == 1){
			if(pdo_update('secaikeji_runner3_member', array('isrunner'=>1,'status'=>1), array('id'=>$runner['id']))){
				//更新跑腿信誉
				$xinyu = intval($setting['xinyu']) + intval($runner['xinyu']);
				pdo_update('secaikeji_runner3_member',array('xinyu'=>$xinyu),array('id' => $runner['id']));
				$content = "";
				$content = "恭喜您，您的跑腿服务人员实名认证已通过！~\n";
				$content .= "订单编号：".$tid."\n";
				$content .= "时间：".date('Y年m月d日 h点i分',time())."\n";
				$content .= "咚咚咚，您的跑腿服务人员实名认证已通过，点击立即去听单~";
				$url = $_W['siteroot'].'app/'.$this->createMobileUrl('index');
				$retrun = mc_notice_consume2($_W['openid'], '跑腿服务人员认证成功通知', $content, $url,'');
				pdo_update('secaikeji_runner3_paylog',array('status'=>1),array('id'=>$paylog['id']));
			}
		}else{
			if(pdo_update('secaikeji_runner3_member', array('isrunner'=>1,'status'=>0), array('id'=>$runner['id']))){
				//更新跑腿信誉
				$xinyu = intval($setting['xinyu']) + intval($runner['xinyu']);
				pdo_update('secaikeji_runner3_member',array('xinyu'=>$xinyu),array('id' => $runner['id']));
				$content = "";
				$content = "恭喜您，您的跑腿服务人员实名认证已通过系统检测，正在等待人工审核！~\n";
				$content .= "订单编号：".$tid."\n";
				$content .= "时间：".date('Y年m月d日 h点i分',time())."\n";
				$content .= "咚咚咚，您的跑腿服务人员实名认证已通过，正在等待人工审核，请耐心等待~";
				$url = $_W['siteroot'].'app/'.$this->createMobileUrl('index');
				$member = M('member')->getInfo($_W['openid']);
				$data = array();
				$data['uniacid'] = $_W['uniacid'];
				$data['create_time'] = time();
				$data['status'] = 0;
				$data['title'] = "【".$member['nickname']."】提交跑腿审核";
				$data['link'] = '';
				M('message')->update($data);

				$retrun = mc_notice_consume2($_W['openid'], '跑腿服务人员认证提交成功通知', $content, $url,'');
				pdo_update('secaikeji_runner3_paylog',array('status'=>1),array('id'=>$paylog['id']));
			}
		}
	}
	public function payResult($params){
		global $_W;
		include MODULE_ROOT.'/inc/mobile/common/global.func.php';

		$tid = $params['tid'];
		//$oauth = M('setting')->getSystem('auth');
		//if(empty($oauth['code'])){
		//	return array();
		//}

		$paylog = M('paylog')->getInfoByOrdersn($tid);
		$setting = iunserializer($paylog['setting']);
		$runner = M('member')->getInfo($_W['openid']);
		//发送消息
		$sysms_set = M('setting')->getValue('sms_set');
		if($paylog['type'] == 'runner'){
			if($params['result'] == 'success'){
				if($paylog['status'] != 1){
					$idcard_set = M('setting')->getValue('card_set');
					if(empty($idcard_set['apikey'])){
						$this->updateRunner($setting,$runner);
					}else{
						$member = M('member')->getInfo($_W['openid']);
						M('idauth')->setKey($idcard_set['apikey']);
						$par = array();
						$par['name'] = $member['realname'];
						$par['cardno'] = $member['cardnum'];
						$idauth_result = M('idauth')->check($par);
						if($idauth_result['code'] == 0){
							$this->updateRunner($setting,$runner);
						}else if($idauth_result['code'] == '101'){
							$content = "";
							$content = "对不起，您填写的身份证号不存在，请重新填写！~\n";
							$content .= "订单编号：".$tid."\n";
							$content .= "时间：".date('Y年m月d日 h点i分',time())."\n";
							$url = $_W['siteroot'].'app/'.$this->createMobileUrl('v');
							$retrun = mc_notice_consume2($_W['openid'], '跑腿服务人员实名认证失败', $content, $url,'');
						}else if($idauth_result['code'] == '102'){
							$content = "";
							$content = "对不起，您填写的姓名和身份证号不一致，请重新填写！~\n";
							$content .= "订单编号：".$tid."\n";
							$content .= "时间：".date('Y年m月d日 h点i分',time())."\n";
							$url = $_W['siteroot'].'app/'.$this->createMobileUrl('v');
							$retrun = mc_notice_consume2($_W['openid'], '跑腿服务人员实名认证失败', $content, $url,'');
						}else{
							$content = "";
							$content = "对不起，身份证查询系统欠费，请管理员充值！~\n";
							$content .= "订单编号：".$tid."\n";
							$content .= "时间：".date('Y年m月d日 h点i分',time())."\n";
							$url = $_W['siteroot'].'app/'.$this->createMobileUrl('v');
							$retrun = mc_notice_consume2($_W['openid'], '身份证查询系统欠费', $content, $url,'');
						}
					}
				}
			}
			if($params['result'] == 'success'){
				pdo_update('secaikeji_runner3_paylog',array('status'=>1),array('id'=>$paylog['id']));
			}
			if ($params['from'] == 'return') {
				if ($params['result'] == 'success') {
					message('支付成功！', $this->createMobileUrl('tasks'), 'success');
				} else {
					message('支付失败！', $this->createMobileUrl('tasks'), 'success');
				}
			}
		}
		//信誉充值
		if($paylog['type'] == 'payxinyu'){
			$setting = iunserializer($paylog['setting']);
			if($params['result'] == 'success'){
				if($paylog['status'] != 1){
					$num = intval($setting['num']);
					$xinyu = intval($setting['num']) + intval($runner['xinyu']);
					pdo_update('secaikeji_runner3_member',array('xinyu'=>$xinyu),array('id' => $runner['id']));
					$content = "";
					$content = "恭喜您，您的充值的".$num."信誉已到账！~\n";
					$content .= "订单编号：".$tid."\n";
					$content .= "时间：".date('Y年m月d日 h点i分',time())."\n";
					$content .= "咚咚咚，恭喜您，您的充值的".$num."信誉已到账，请查收！点击立即前往听单~";
					$url = $_W['siteroot'].'app/'.$this->createMobileUrl('index');
					$retrun = mc_notice_consume2($_W['openid'], '充值信誉到账通知', $content, $url,'');
					pdo_update('secaikeji_runner3_paylog',array('status'=>1),array('id'=>$paylog['id']));
					$member = M('member')->getInfo($_W['openid']);
					$data = array();
					$data['uniacid'] = $_W['uniacid'];
					$data['create_time'] = time();
					$data['status'] = 0;
					$data['title'] = "【".$member['nickname']."】完成信誉充值";
					$data['link'] = '';
					M('message')->update($data);
				}
			}

			if($params['result'] == 'success'){
				pdo_update('secaikeji_runner3_paylog',array('status'=>1),array('id'=>$paylog['id']));
			}
			if ($params['from'] == 'return') {
				if ($params['result'] == 'success') {
					message('支付成功！', $this->createMobileUrl('home'), 'success');
				} else {
					message('支付失败！', $this->createMobileUrl('home'), 'success');
				}
			}
		}
		M('paylog')->payResult($params);
	}
	public function doWebrunner_level(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'runner_level';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
				if(!empty($_GPC['displayorder'])){
					$data['displayorder'] = intval($_GPC['displayorder']);
				}
				if(!empty($_GPC['xinyu'])){
					$data['xinyu'] = intval($_GPC['xinyu']);
				}
				if(!empty($_GPC['title'])){
					$data['title'] = trim($_GPC['title']);
				}
				$data['icon'] = tomedia(trim($_GPC['icon']));
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('runner_level')->update($data);
	            message('保存成功',$this->createWebUrl('runner_level'),'success');
	        }
	        $item = M('runner_level')->getInfo($id);
	        include $this->template('runner_level_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            if($_W['ispost']){
	                $data = array();
	                $data['status'] = 1;
	                $data['message'] = '参数错误';
	                die(json_encode($data));
	            }else{
	                message('参数错误',referer(),'error');
	            }
	        }
	        M('runner_level')->delete($id);
	        if($_W['ispost']){
	            $data = array();
	            $data['status'] = 1;
	            $data['message'] = '操作成功';
	            die(json_encode($data));
	        }else{
	            message('删除成功',referer(),'success');
	        }
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
	    $where = "";
		$list = M('runner_level')->getList($page,$where);
	    include $this->template('runner_level');
	}
	public function doWebmoneylog(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'moneylog';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
	            M('moneylog')->update($data);
	            message('保存成功',$this->createWebUrl('moneylog'),'success');
	        }
	        $item = M('moneylog')->getInfo($id);
	        include $this->template('moneylog_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            if($_W['ispost']){
	                $data = array();
	                $data['status'] = 1;
	                $data['message'] = '参数错误';
	                die(json_encode($data));
	            }else{
	                message('参数错误',referer(),'error');
	            }
	        }
	        M('moneylog')->delete($id);
	        if($_W['ispost']){
	            $data = array();
	            $data['status'] = 1;
	            $data['message'] = '操作成功';
	            die(json_encode($data));
	        }else{
	            message('删除成功',referer(),'success');
	        }
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
	    $where = "";
		$list = M('moneylog')->getList($page,$where);
	    include $this->template('web/task/moneylog');
	}
	public function getWebPlugin($mp,$mdo = ''){
		$file = MODULE_ROOT.'/plugin/'.$mp.'/inc/web/'.$mdo.'.php';
		include_once $file;
	}
	public function getMobilePlugin($mp,$mdo = ''){
		$file = MODULE_ROOT.'/plugin/'.$mp.'/inc/mobile/'.$mdo.'.php';
		include_once $file;
	}
	protected function template($filename) {
		global $_W,$_GPC;
		$name = strtolower($this->modulename);
		$plugin = strtolower($this->pluginname);
		
		if(!empty($_GPC['mp'])){
			$mp = strtolower($_GPC['mp']);
		}
		$defineDir = dirname($this->__define);
		
		if(defined('IN_SYS')) {
			$source = IA_ROOT . "/web/themes/{$_W['template']}/{$name}/{$filename}.html";
			if(empty($mp)){
				$compile = IA_ROOT . "/data/tpl/web/{$_W['template']}/{$name}/{$filename}.tpl.php";
			}else{
				$compile = IA_ROOT . "/data/tpl/web/{$_W['template']}/plugin/{$mp}/{$name}/{$filename}.tpl.php";
			}
			if(!is_file($source)){
				$source = $defineDir . "/plugin/".$mp."/template/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = $defineDir . "/template/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = IA_ROOT . "/web/themes/default/{$name}/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = IA_ROOT . "/web/themes/{$_W['template']}/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = $defineDir . "/template/{$filename}.html";
			}
		} else {
			$source = IA_ROOT . "/app/themes/{$_W['template']}/{$name}/{$filename}.html";
			$compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$name}/{$filename}.tpl.php";
			if(!is_file($source)) {
				$source = IA_ROOT . "/app/themes/default/{$name}/{$filename}.html";
			}
			if(!is_file($source)){
				$source = $defineDir . "/plugin/".$mp."/template/mobile/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = $defineDir . "/template/mobile/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = IA_ROOT . "/app/themes/{$_W['template']}/{$filename}.html";
			}
			if(!is_file($source)) {
				if (in_array($filename, array('header', 'footer', 'slide', 'toolbar', 'message'))) {
					$source = IA_ROOT . "/app/themes/default/common/{$filename}.html";
				} else {
					$source = IA_ROOT . "/app/themes/default/{$filename}.html";
				}
			}
		}
		if(!is_file($source)) {
			exit("Error: template source '{$source}' is not exist!");
		}
		$paths = pathinfo($compile);
		$compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
		if (DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
			template_compile($source, $compile, true);
		}
		return $compile;
	}
	protected function getTemplate($iswechat = true) {
		//模板控制
		global $_W;
		$template = $this -> module['config']['name'];
		if (empty($template)) {
			$template = 'default';
		}
		if($_W['container'] == 'wechat'){
			if(empty($_W['openid']) && empty($_W['member']['uid']) && $iswechat){
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
}
function getModuleFrames($name){
	global $_W;
	$sql = "SELECT * FROM ".tablename('modules')." WHERE name = :name limit 1";
	$params = array(':name'=>$name);
	$module = pdo_fetch($sql,$params);

	$sql = "SELECT * FROM ".tablename('modules_bindings')." WHERE module = :name ";
	$params = array(':name'=>$name);
	$module_bindings = pdo_fetchall($sql,$params);

	$frames = array();

	$frames['set']['title'] = '基础设置';
	$frames['set']['active'] = '';

	$frames['set']['items'] = array();

	$frames['manage']['title'] = '运营管理';
	$frames['manage']['active'] = '';
	$frames['manage']['items'] = array();

	$frames['set']['items']['divider_set']['url'] = url('site/entry/divider_set',array('m'=>$name));
	$frames['set']['items']['divider_set']['title'] = '帮我送设置';
	$frames['set']['items']['divider_set']['actions'] = array();
	$frames['set']['items']['divider_set']['active'] = '';

	$frames['set']['items']['buy_set']['url'] = url('site/entry/buy_set',array('m'=>$name));
	$frames['set']['items']['buy_set']['title'] = '帮我买设置';
	$frames['set']['items']['buy_set']['actions'] = array();
	$frames['set']['items']['buy_set']['active'] = '';
	
	$frames['set']['items']['v_set']['url'] = url('site/entry/v_set',array('m'=>$name));
	$frames['set']['items']['v_set']['title'] = '认证设置';
	$frames['set']['items']['v_set']['actions'] = array();
	$frames['set']['items']['v_set']['active'] = '';
	
	$frames['manage']['items']['task']['url'] = url('site/entry/task',array('m'=>$name));
	$frames['manage']['items']['task']['title'] = '任务管理';
	$frames['manage']['items']['task']['actions'] = array();
	$frames['manage']['items']['task']['active'] = '';


	$frames['manage']['items']['v']['url'] = url('site/entry/v',array('m'=>$name));
	$frames['manage']['items']['v']['title'] = '认证管理';
	$frames['manage']['items']['v']['actions'] = array();
	$frames['manage']['items']['v']['active'] = '';

	$frames['manage']['items']['runner']['url'] = url('site/entry/runner',array('m'=>$name));
	$frames['manage']['items']['runner']['title'] = '监控';
	$frames['manage']['items']['runner']['actions'] = array();
	$frames['manage']['items']['runner']['active'] = '';


	if($_W['role'] == 'founder'){
		$frames['founder']['title'] = '管理员特权';
		$frames['founder']['active'] = '';
		$frames['founder']['items'] = array();

		$frames['founder']['items']['delete']['url'] = url('site/entry/delete',array('m'=>$name));
		$frames['founder']['items']['delete']['title'] = '清理数据';
		$frames['founder']['items']['delete']['actions'] = array();
		$frames['founder']['items']['delete']['active'] = '';
	}
	return $frames;
}

function _calc_current_frames2(&$frames) {
	global $_W,$_GPC,$frames;
	if(!empty($frames) && is_array($frames)) {
		foreach($frames as &$frame) {
			foreach($frame['items'] as &$fr) {
				$query = parse_url($fr['url'], PHP_URL_QUERY);
				parse_str($query, $urls);
				if(defined('ACTIVE_FRAME_URL')) {
					$query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
					parse_str($query, $get);
				} else {
					$get = $_GET;
				}
				if(!empty($_GPC['a'])) {
					$get['a'] = $_GPC['a'];
				}
				if(!empty($_GPC['c'])) {
					$get['c'] = $_GPC['c'];
				}
				if(!empty($_GPC['do'])) {
					$get['do'] = $_GPC['do'];
				}
				if(!empty($_GPC['doo'])) {
					$get['doo'] = $_GPC['doo'];
				}
				if(!empty($_GPC['op'])) {
					$get['op'] = $_GPC['op'];
				}
				if(!empty($_GPC['m'])) {
					$get['m'] = $_GPC['m'];
				}
				$diff = array_diff_assoc($urls, $get);

				if(empty($diff)) {
					$fr['active'] = ' active';
					$frame['active'] = ' active';
				}
			}
		}
	}
}