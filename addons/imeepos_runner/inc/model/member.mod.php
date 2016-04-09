<?php 
class imeepos_runner_member extends model{
	public $table = 'imeepos_runner_member';
	//后去所有
	function fetchall(){
		global $_W;
		$sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid";
		$params = array(':uniacid'=>$_W['uniacid']);
		$list = pdo_fetchall($sql,$params);
		return $list;
	}
	//获取单个
	function fetch($openid =''){
		global $_W;
		$sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND openid = :openid";
		$params = array(':uniacid'=>$_W['uniacid'],':openid'=>$openid);
		$list = pdo_fetch($sql,$params);
		return $list;
	}
	//更新
	function update($data,$id){
		return pdo_update($this->table,$data,array('id'=>$id));
	}
	//插入
	function insert($data){
		pdo_insert($this->table,$data);
		return pdo_insertid();
	}
}