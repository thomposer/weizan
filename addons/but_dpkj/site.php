<?php
/**
 * 单品砍价模块微站定义
 *
 * @author Titan Pan
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class But_dpkjModuleSite extends WeModuleSite {

	public function doMobileIndex() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		
		
		$urllink = 'http://'.$_SERVER['HTTP_HOST'];
		$sql = 'select * from '.tablename('dpkj_item').' where uniacid = :uniacid';
		$params = array(
		
				':uniacid' => $_W['uniacid']
		
				);
		$item = pdo_fetch($sql,$params);
		$itemimg = tomedia($item['imgurl']);
		$info_sql = 'select * from '.tablename('dpkj_info').' where uniacid = :uniacid';
		$info_params = array(
		
				':uniacid' => $_W['uniacid']
		
				);
		$info = pdo_fetch($info_sql,$info_params);
		
		
		
		if($_GPC['id'] == '' || $_GPC['id'] == $_W['openid']){
			
			//首次进入
			
				$user_sql = 'select * from '.tablename('dpkj_order').' where openid = :openid and uniacid = :uniacid';
				$user_params = array(
						':uniacid' => $_W['uniacid'],
						':openid' => $_W['openid']
				
				
							);
				$user = pdo_fetch($user_sql,$user_params);
				
				
				
				if($user){
					
					
					$help = json_decode($user['helper']);
					$title = '我是'.$user["name"].','.$info["sharetitle"];
					$sharelink = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&id='.$_W['openid'];
					switch($user['status'])
					
					{
					case '0':
					$desc = '<div id="desc">
   							<p>'.$user['name'].'的宝贝</p>
  							<p>已被砍至'.$user['sp'].'元</p>
   							<p>共有'.count($help).'位给力好友帮忙砍价</p>
  							</div>
							<div id="btn">
   							<div onclick="mcover()">加油，就快成功了！</div>
  							</div>';
						break;
					case '1':
					$desc = '<div id="desc">
   							<p>'.$user['name'].'的宝贝</p>
  							<p>已被砍至'.$user['sp'].'元</p>
   							<p>共有'.count($help).'位给力好友帮忙砍价</p>
  							</div>
							<div>
							<div id="btn">
                            <div style="background:white">
							<form name="formp" action="'.$this->createMobileUrl('dh').'" method="post">
							<input type="hidden" name="id" value="'.$user['id'].'">
                            <input type="password" name="password" style="width:80%; border:none; font-size:1.1em; line-height:1.1em; text-align:center" placeholder="请输入兑换密码" />
							</form>
                            </div><br />
   							<div onclick="formp.submit()">确认兑换</div>
  							</div>';
						break;
					case '2':
					$desc = '<div id="desc">
   							<p>'.$user['name'].'的宝贝</p>
  							<p>已被砍至'.$user['sp'].'元</p>
   							<p>共有'.count($help).'位给力好友帮忙砍价</p>
  							</div>
							<div>
							<div id="btn">
   							<div>宝贝已兑换</div>
  							</div>';
					
					break;
							
					}
							
					
					}else{
						$title = $info["name"];
						$sharelink = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
						$desc = '<div id="btn">
   							<a href="'.$this->createMobileUrl('login').'"><div id="addorder">我要领取</div></a>
  							</div>';
						
						
						}
			
			}else{
				//进入别人的订单
				
				$order_sql = 'select * from '.tablename('dpkj_order').' where openid = :openid and uniacid = :uniacid';
				$order_params = array(
						':uniacid' => $_W['uniacid'],
						':openid' => $_GPC['id']
							);
				$order = pdo_fetch($order_sql,$order_params);
				
				
				
				if($order){
					
					$help = json_decode($order['helper']);
					$title = '我是'.$order["name"].','.$info["sharetitle"];
					$sharelink = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&id='.$_GPC['id'];
					
					if($order['status'] == '0'){
					$desc = '<div id="desc">
   							<p>'.$order['name'].'的宝贝</p>
  							<p>已被砍至'.$order['sp'].'元</p>
   							<p id="bangmang">共有'.count($help).'位给力好友帮忙砍价</p>
  							</div>
							<div id="btn">
   							<div id="cut" onclick="cut()">砍他一刀</div><br />
							<a href="'.$this->createMobileUrl('login').'"><div id="join">我也要参加</div></a>
  							</div>';
					}else{
						
						$desc = '<div id="desc">
   							<p>'.$order['name'].'的宝贝</p>
  							<p>已被砍至'.$order['sp'].'元</p>
   							<p>共有'.count($help).'位给力好友帮忙砍价</p>
  							</div>
							<div id="btn">
							<div>宝贝已砍价成功</div><br />
							<a href="'.$this->createMobileUrl('login').'"><div id="join">我也要参加</div></a>
  							</div>';
						
						}
					
					}
				
				
				}
		
		
		$detail = htmlspecialchars_decode($item['detail']);
		
		include $this->template('index');
	}
	public function doMobileLogin(){
		
		global $_W,$_GPC;
		
		
		$member_sql = 'select * from '.tablename('dpkj_order').' where uniacid = :uniacid and openid = :openid';
		$member_pramas = array(
		
				':uniacid' => $_W['uniacid'],
				':openid' =>$_W['openid']
					);
		$member = pdo_fetch($member_sql,$member_pramas);
		if($member){
			$url = $this->createMobileUrl('index',array('id'=>$_W['openid']));
			header("location:".$url);
			exit();
			}
		$sql = 'select * from '.tablename('dpkj_info').' where uniacid = :uniacid';
		$pramas = array(
		
				':uniacid' => $_W['uniacid']
					);
		$info = pdo_fetch($sql,$pramas);
		
		//判断强制关注
		
	
	if($info['forcegz'] == '1'){	
		if($_W['fans']['follow'] != 1){
			
			 $url = $info['gzlink'];
				 $alert = '请先关注我们的公众平台，谢谢！<br />
确定';
				 include $this->template('alert');	
			exit();
			
			}
		
		
		
		}
	//判断完毕
	
	$item_sql = 'select * from '.tablename('dpkj_item').' where `uniacid` = :uniacid';
		$item_pramas = array(
		
				':uniacid' => $_W['uniacid']
					);
		$item = pdo_fetch($item_sql,$item_pramas);	
		
		if($item['count'] < 1){
			
			 $url = $this->createMobileUrl('index');
				 $alert = '对不起！宝贝已经被抢完了<br />
确定';
				 include $this->template('alert');	
			exit();
			}
		
				
	
	if($_GPC['user'] && $_GPC['mobile']){	//写入数据库	
		
			$data = array(
			
				'openid' => $_W['openid'],
				'name' => $_GPC['user'],
				'mobile' => $_GPC['mobile'],
				'sp' =>$item['price'],
				'status'=> 0,
				'uniacid' => $_W['uniacid']
			
					);
					
		$db = pdo_insert('dpkj_order',$data);
		
		if($db){
			
			 $url = $this->createMobileUrl('index',array('id'=>$_W['openid']));
				 $alert = '恭喜您，获得宝贝砍价资格！<br />
确定';
				 include $this->template('alert');
			
			}else{
			 $url = $this->createMobileUrl('index');
				 $alert = '领取失败！<br />
确定';
				 include $this->template('alert');	
				
				
				}
		
		}
	
	$adimg = tomedia($info['ad']);
	include $this->template('login');
	}
	public function doWebSetting() {
		//这个操作被定义用来呈现 系统设置
		global $_W,$_GPC;
		load()->func('tpl');
		$options = array(
					'width'  => 300, // 上传后图片最大宽度
    				'global'=>false 
   					);
		if(checksubmit()){
			
			
				$d = array(
				
					'name' => $_GPC['title'],
					'logo' => $_GPC['logo'],
					'gzlink' => $_GPC['gzlink'],
					'rolecontent' => $_GPC['title'],
					'forcegz' => $_GPC['forcegz'],
					'copyright' => $_GPC['copyright'],
					'shareicon' => $_GPC['shareicon'],
					'sharetitle' => $_GPC['sharetitle'],
					'sharecontent' => $_GPC['sharecontent'],
					'ad' => $_GPC['adimg'],
					'password'=> $_GPC['password']
				
						);
				
			
			$sql = 'select * from '.tablename('dpkj_info').' where `uniacid` = :uniacid';
			$params = array(
			
					':uniacid' => $_W['uniacid']
			
					);
			$data = pdo_fetch($sql,$params);
			
			if($data){
				
			
				
				$info = pdo_update('dpkj_info',$d,array('uniacid' => $_W['uniacid']));
				
				message('修改成功',$this->createWebUrl('setting'));
				
				
				}else{
					
					$d['uniacid'] = $_W['uniacid'];
					
					$info = pdo_insert('dpkj_info',$d);
					
					message('添加信息成功',$this->createWebUrl('setting'));
					}
			
			
			}
			
			$sql = 'select * from '.tablename('dpkj_info').' where `uniacid` = :uniacid';
			$params = array(
			
					':uniacid' => $_W['uniacid']
			
					);
			$data = pdo_fetch($sql,$params);
			
		
		include $this->template('setting');
		
	}
	public function doWebItem() {
		//这个操作被定义用来呈现 商品管理
		global $_W,$_GPC;
		load()->func('tpl');
		
		$options = array(
					'width'  => 300, // 上传后图片最大宽度
    				'global'=>false 
   					);
		if(checksubmit()){
			
				$d = array(
				
					'name' => $_GPC['name'],
					'count' => $_GPC['count'],
					'price' => $_GPC['price'],
					'sp' => $_GPC['sp'],
					'a' => $_GPC['sa'],
					'b' => $_GPC['sb'],
					'imgurl' => $_GPC['imgurl'],
					'detail' => $_GPC['detail'],
					'address' => $_GPC['address']
				
						);
				
			
			$sql = 'select * from '.tablename('dpkj_item').' where `uniacid` = :uniacid';
			$params = array(
			
					':uniacid' => $_W['uniacid']
			
					);
			$data = pdo_fetch($sql,$params);
			
			if($data){
				
			
				
				$info = pdo_update('dpkj_item',$d,array('uniacid' => $_W['uniacid']));
				
				message('修改成功',$this->createWebUrl('item'));
				
				
				}else{
					
					$d['uniacid'] = $_W['uniacid'];
					
					$info = pdo_insert('dpkj_item',$d);
					
					message('添加信息成功',$this->createWebUrl('item'));
					}
			
			
			}
			
			$sql = 'select * from '.tablename('dpkj_item').' where `uniacid` = :uniacid';
			$params = array(
			
					':uniacid' => $_W['uniacid']
			
					);
			$data = pdo_fetch($sql,$params);
			
		
		
		include $this->template('item');
	}
	public function doWebUser() {
		//这个操作被定义用来呈现 用户管理
		global $_W,$_GPC;
		$page = 0;
		$max = 10;
		if($_GPC['page']){
			
			$page = $_GPC['page']*$max;
			
			}
		$sql = 'select * from '.tablename('dpkj_order').' where `uniacid` = :uniacid  limit '.$page.','.$max;
		$sqlcount = 'select * from '.tablename('dpkj_order').' where `uniacid` = :uniacid';
		$params = array(
		
				':uniacid' => $_W['uniacid']
				);
		$data = pdo_fetchall($sql,$params);
		
		$count = count(pdo_fetchall($sqlcount,$params));
		//$pagination = pagination($count, $page, $max); 
		
		include $this->template('user');
	}
public function doMobiledh() {
	global $_W,$_GPC;
	
	
		$sql = 'select * from '.tablename('dpkj_info').' where `uniacid` = :uniacid';
			$params = array(
			
					':uniacid' => $_W['uniacid']
			
					);
			$info = pdo_fetch($sql,$params);
		if($_GPC['password'] == $info['password']){
			
			$t = array(
				'status' => 2
				
				);
			if(pdo_update('dpkj_order',$t,array('id' => $_GPC['id']))){
				
				 $url = $this->createMobileUrl('index');
				 $alert = '兑换成功<br />
确定';
				 include $this->template('alert');	
				
				}else{
					
						 $url = $this->createMobileUrl('index');
				 $alert = '兑换失败<br />
确定';
				 include $this->template('alert');	
					
					}
			
			}
	
	
}
public function doWebAlldel(){
	
	
	global $_W,$_GPC;
	
	 $data = pdo_delete('dpkj_order', array('uniacid' => $_W['uniacid']));

	 if($data){
		 
		 message('删除成功！', $this->createWebUrl('user'));
		 }else{
			 
			 message('删除失败！', $this->createWebUrl('user'));
			 
			 }
	
	
	
	}
public function doMobileKanjia() {
	global $_W,$_GPC;
	
	
	
	
	if($_GPC['order'] != '' && $_GPC['openid'] != ''){
		
		$sql = 'select * from '.tablename('dpkj_order').' where `openid` = :order and `uniacid` = :uniacid';
		$params = array(
		
					':order' => $_GPC['order'],
					':uniacid' => $_GPC['uniacid']
		
					);
		$order = pdo_fetch($sql,$params);
		if($order['status'] != 0){
			
				$data['code'] = 303;
					$data['msg'] = '大侠，该宝贝到手了！';
					echo json_encode($data);
					exit();
			
			}
			
		$item_sql = 'select * from '.tablename('dpkj_item').' where `uniacid` = :uniacid';
		$item_params = array(
		
					
					':uniacid' => $_GPC['uniacid']
		
					);
		
		$item = pdo_fetch($item_sql,$item_params);
		
		if($item['count'] < 1){
			
			$data['code'] = 303;
					$data['msg'] = '大侠，该宝贝被人抢走了！';
					echo json_encode($data);
					exit();
			
			}
		if($order['helper']!=''){
		$help = json_decode($order['helper']);
		
			for($i=0;$i<count($help);$i++){
				
				if($help[$i] == $_GPC['openid']){
					
					$data['code'] = 202;
					$data['msg'] = 0;
					echo json_encode($data);
					exit();
					}
				}
		}
			$help[] = $_GPC['openid'];
			$help = json_encode($help);
		$sj=round($this->randomFloat($item['a'], $item['b']),2); 
		$sp = $order['sp'] - $sj;
		
		if($sp < $item['sp']){
			
			$sp = $item['sp'];
			$t['status'] = 1;
			$count = $item['count'] - 1;
			pdo_update('dpkj_item',array('count' => $count),array('id' => $item['id']));
			
			}
	/*	
		$data['code'] = 102;
					$data['msg'] = $sj;
					echo json_encode($data);
					exit();*/
					
					
					
			$t['helper'] = $help;
			$t['sp'] = $sp;
								
			
				$db = pdo_update('dpkj_order',$t,array('id' => $order['id']));
				
					if($db){
						
			$data['msg'] = $sj;
			$data['code'] = 101;
					}
		}else{
	$data['code'] = 202;
	$data['msg'] = 0;
		}
	echo json_encode($data);
	exit();
	
}
public function randomFloat($min = 0, $max = 1) {  
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);  
}  
}