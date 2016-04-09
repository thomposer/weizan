<?php
global $_W,$_GPC;
if($_W['ispost']){
	$code = $_GPC['code'];
	if($code == 'imeepos'){
		global $_W,$_GPC;
		$tables = array();
		$tables[] = 'imeepos_runner3_member';
		$tables[] = 'imeepos_runner3_listenlog';
		$tables[] = 'imeepos_runner3_tasks';
		$tables[] = 'imeepos_runner3_setting';
		$tables[] = 'imeepos_runner3_detail';
		$tables[] = 'imeepos_runner3_paylog';
		$tables[] = 'imeepos_runner3_buy';
		$tables[] = 'imeepos_runner3_recive';
		$tables[] = 'imeepos_runner3_moneylog';
		$tables[] = 'imeepos_runner3_code';

		foreach($tables as $table){
			pdo_delete($table);
			pdo_query("alter table ".tablename($table)." AUTO_INCREMENT=1;");

		}
		message('清空数据成功','','success');
	}
}
include $this->template('delete');
