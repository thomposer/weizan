<?php 

class secaikeji_runner_task extends model{
	public $table = 'secaikeji_runner_tasks';
	//后去所有
	function fetchall($page,$psize){
		global $_W;
		$sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND status = :status limit ".($page-1)*$psize.",".$psize;
		$params = array(':uniacid'=>$_W['uniacid'],':status'=>1);
		$list = pdo_fetchall($sql,$params);
		return $list;
	}
	//获取单个
	function getOne($id){
		global $_W;
		$sql = "SELECT * FROM ".tablename($this->table)." WHERE id = :id";
		$params = array(':id'=>$$id);
		$list = pdo_fetch($sql,$params);
		return $list;
	}
	//更新
	function update($data,$id){
		return pdo_update($this->table,$data,array('id'=>$id));
	}
	//插入
	function insert($data){
		global $_W;
		$data['uniacid'] = $_W['uniacid'];
		pdo_insert($this->table,$data);
		return pdo_insertid();
	}
}