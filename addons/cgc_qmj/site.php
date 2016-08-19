<?php
/**
 * 清明节哀思模块微站定义
 *
 * @author 海纳百川  012wz.com
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
define('STYLE_PATH','../addons/cgc_qmj/template/style');


class Cgc_qmjModuleSite extends WeModuleSite {
  
  //是否关注
  function sfgz_user($fromuser){
  	global $_W;
  	$uniacid=$_W['uniacid'];
   	$follow=pdo_fetchcolumn("SELECT follow FROM " . tablename('mc_mapping_fans').
          " where uniacid=$uniacid and openid='$fromuser'"); 
   	return $follow;
  }
  

  public function doMobileAddcount(){
  	global $_W;
  	$uniacid=$_W['uniacid'];
  	load()->func('cache');
  	$data = cache_load("Cgc_qmjModule".$uniacid ,true);
  	 cache_write("Cgc_qmjModuletime".$uniacid,time());	
     if (empty($data)) {
       cache_write("Cgc_qmjModule".$uniacid,1);
     } else {
       cache_write("Cgc_qmjModule".$uniacid,$data+1);
      }
   }
  
   public function doMobileDefault(){
   	  global $_W, $_GPC;
   	  $uniacid=$_W['uniacid'];
   	  $settings=$this->module['config'];
   	  
   	   if (strtotime($settings['starttime'])>time()  ||  strtotime($settings['endtime'])<time()){
         	 if (strtotime($settings['starttime'])>time()){
         	 	message("活动还没开始");
         	 } else {
         	    message("活动已经结束"); 
         	 }
         }
   	  
      $from_user=$_W['fans']['from_user'];
   	  $ret= $this->sfgz_user($from_user);
   	  $data = cache_load("Cgc_qmjModule".$uniacid ,true);
      $must_guanzhu=$settings['must_guanzhu'];
      $guanzhu_url=$settings['guanzhu_url'];
      if ($must_guanzhu && empty($ret)){
      	if (!empty($guanzhu_url)){
  	      header("location:$guanzhu_url");
  	      exit();
      	} else {
      		message("没设置关注链接");
      	}
       }
       
       $data = cache_load("Cgc_qmjModule".$uniacid ,true);
       $data=empty($data)?0:$data;
       $settings['dd_num']=intval($settings['dd_num'])+$data;
       
       $settings['wz']=empty($settings['wz'])?"已有#num#人为故亲点灯祈福":$settings['wz'];
       
       $settings['music_url']=empty($settings['music_url'])?STYLE_PATH."/1.mp3":tomedia($settings['music_url']);
   	   $settings['share_desc']=str_replace("#num#",$settings['dd_num']+1,$settings['share_desc']);
   	   $settings['share_title']=str_replace("#num#",$settings['dd_num']+1,$settings['share_title']);
	
   	  include $this->template("default");
   }

}