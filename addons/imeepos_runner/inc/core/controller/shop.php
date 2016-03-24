<?php
class shop extends core{
	function getData(){
		$data = array();
		$data['themes'] = $this->getThemes();
		$data['advs'] = $this->getAdvs();
		$data['navss'] = $this->getNavs();
		$data['tasks'] = $this->getTasks();
		return $data;
	}
	
	function getAdvs(){
		global $_W;
		$m = M('advs');
		$m->setTable('imeepos_runner_adv');
		$list = $m->fetchall(array('uniacid'=>$_W['uniacid'],'isfull'=>0));
		$lists = array();
		foreach ($list as $li){
			$data = array();
			$data['link'] = '';
			$data['image'] = tomedia($li['image']);
			$lists[] = $data;
		}
		
		return $lists;
	}
	
	function getTasks(){
		global $_W;
		$m = M('tasks');
		$m->setTable('imeepos_runner_tasks');
		$list = $m->fetchpage(array('uniacid'=>$_W['uniacid'],'status'=>1));
		$d = M('class');
		$d->setTable('imeepos_runner_class');
		foreach ($list['list'] as $li){
			
			$user = mc_fetch($li['uid'],array('avatar','nickname'));
			$c = array();
			$c['id'] = $li['id'];
			$c['avatar'] = !empty($user['avatar'])?tomedia($user['avatar']):tomedia('../addons/imeepos_runner/icon.jpg');
			$c['nickname'] = $user['nickname'];
			$c['desc'] = $li['desc'];
			$c['startaddress'] = $li['startaddress'];
			$c['startlat'] = $li['startlat'];
			$c['startlng'] = $li['startlng'];
			
			$c['endaddress'] = $li['endaddress'];
			$c['endlat'] = $li['endlat'];
			$c['endlng'] = $li['endlng'];
			
			$c['startdistance'] = getDistance($c['startlat'], $c['startlng'], $lat, $lng);
			$c['startorder'] = $c['startdistance'];
			$c['startkm'] = 'm';
			if($c['startdistance'] > 1000){
				$c['startdistance'] = $c['startdistance'] / 1000;
				$c['startkm'] = 'km';
			}
			
			$c['enddistance'] = floatval(getDistance($c['endlat'], $c['endlng'], $lat, $lng));
			$c['endorder'] = $c['enddistance'];
			$c['endkm'] = 'm';
			if($c['enddistance'] > 1000){
				$c['enddistance'] = $c['enddistance'] / 1000;
				$c['endkm'] = 'km';
			}
			
			$c['distance'] = floatval(getDistance($c['startlat'], $c['startlng'], $c['endlat'], $c['endlng']));
			$c['order'] = $c['order'];
			$c['km'] = 'm';
			if($c['distance'] > 1000){
				$c['distance'] = $c['distance'] / 1000;
				$c['km'] = 'km';
			}
			$c['fee'] = $li['fee'];
			$c['feeorder'] = intval($li['fee']);
			$c['dfeeorder'] = -intval($li['fee']);
			$c['mobile'] = $li['mobile'];
			
			$params = array('id'=>$li['cid']);
			$class = $d->fetchall();
			
			$c['ctitle'] = $class['title'];
			$c['address'] = $li['address'];
			$c['status'] = $li['status'];
			$c['id'] = $li['id'];
			
			$c['createtime'] = date('Y-m-d h:i:s',$li['createtime']);
			
			$tasks[] = $c;
		}
		
		return $tasks;
	}
	
	function getNavs(){
		global $_W;
		$m = M('class');
		$m->setTable('imeepos_runner_class');
		$list = $m->fetchall(array('uniacid'=>$_W['uniacid'],'status'=>1));
		foreach ($list as $li){
			$data = array();
			$data['link'] = '';
			$data['icon'] = tomedia($li['icon']);
			$data['title'] = $li['title'];
			$lists[] = $data;
		}
		$i = 8;
		$j = 4;
		$num1 =0;
		$num2 = 0;
		foreach ($lists as $key=>$nav){
			if($key%$j == 0){
				$num2 = $num2 + 1;
				if($key%$i == 0){
					$num1 = $num1 + 1;
				}
			}
			$navss[$num1][$num2][] = $nav;
		}
		return $navss;
	}
	
	function getThemes(){
		global $_W;
		$m = M('themes');
		$m->setTable('imeepos_runner_settings');
		$item = $m->fetch(array('uniacid'=>$_W['uniacid']));
		$themes = iunserializer($item['themes']);
		return $themes;
	}
}