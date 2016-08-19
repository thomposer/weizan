<?php 

class secaikeji_runner_class extends model{
	public $table = 'secaikeji_runner_class';
	//后去所有
	function fetchall(){
		global $_W;
		$data['uniacid'] = $_W['uniacid'];
		$sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid ";
		$params = array(':uniacid'=>$_W['uniacid']);
		$list = pdo_fetchall($sql,$params);
		return $list;
	}
	//获取单个
	function fetch($id){
		global $_W;
		$sql = "SELECT * FROM ".tablename($this->table)." WHERE id = :id";
		$params = array(':id'=>$$id);
		$list = pdo_fetch($sql,$params);
		return $list;
	}
	//更新
	function update($data=array(),$id=0){
		return pdo_update($this->table,$data,array('id'=>$id));
	}
	//插入
	function insert($data=array()){
		global $_W;
		$data['uniacid'] = $_W['uniacid'];
		pdo_insert($this->table,$data);
		return pdo_insertid();
	}
}