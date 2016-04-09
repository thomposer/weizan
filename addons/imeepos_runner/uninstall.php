<?php 
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

foreach($tables as $row){
	if(pdo_tableexists($row)){
		pdo_query("DROP TABLE ".tablename($row));
	}
}
