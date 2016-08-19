<?php

   global $_W, $_GPC;  
   $settings=$this->module['config'];  
   load()->func('tpl');
   $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
   $uniacid=$_W["uniacid"];
   $id=$_GPC['id'];
  
   if ($op=='display') { 		
  	   $data = cache_load("Cgc_qmjModule".$uniacid ,true);
  	   $time = cache_load("Cgc_qmjModuletime".$uniacid ,true);
       
    
	   include $this->template('sjtj');
	   exit();
  	}
  	

	 if ($op=='delete') {
	 	
	 	$data = cache_write("Cgc_qmjModule".$uniacid ,"0");
	
        message('删除成功！',referer(), 'success');
	 } 
	 
	 if ($op=='post') {
	   if (checksubmit('submit')) {
	 	$data = cache_write("Cgc_qmjModule".$uniacid ,$_GPC['dd_num']);
        message('修改成功！',$this->createWebUrl("sjtj"), 'success');
	   }
          $data = cache_load("Cgc_qmjModule".$uniacid ,true);
        include $this->template('sjtj');
	   exit();
        
        
	 } 
	 
  
     
     
	    
  
     
  	
