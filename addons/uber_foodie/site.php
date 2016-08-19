<?php
/**
 * 吃货众生相
 */
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
define('UBER_RES', '../addons/uber_foodie/template/mobile');
class Uber_FoodieModuleSite extends WeModuleSite {


	public function  doMobileIndex(){
		global $_GPC,$_W;
		if(!$GLOBALS['shake_hits'])$GLOBALS['shake_hits']=rand(2000,9000);
		$shake_hits=$GLOBALS['shake_hits']+1;
		$title = $this->module['config']['title'];	
		include $this->template ( "index" );
	}	
	
	public function  doMobileShake(){
		global $_GPC,$_W;
		if(!$GLOBALS['shake_hits'])$GLOBALS['shake_hits']=rand(2000,9000);
		$shake_hits=$GLOBALS['shake_hits']+1;
		$shake_pic=rand(1,11);
		$title = $this->module['config']['title'];
		include $this->template ( "shake" );
	}
	public function  doMobileShakeInfo(){
		global $_GPC,$_W;
		if(!$GLOBALS['shake_hits'])$GLOBALS['shake_hits']=rand(2000,9000);
		$shake_hits=$GLOBALS['shake_hits']+1;
		$shake_pic=intval($_GPC['shake_pic']);
		$title = $this->module['config']['title'];
		if(empty($shake_pic))$shake_pic=1;
		include $this->template ( "shakeinfo" );
	}
	public function  doMobileShakeResult(){
		global $_GPC,$_W;
		if(!$GLOBALS['shake_hits'])$GLOBALS['shake_hits']=rand(2000,9000);
		$shake_hits=$GLOBALS['shake_hits']+1;
		$shake_pic=intval($_GPC['shake_pic']);
		if(empty($shake_pic))$shake_pic=1;
		$title = $this->module['config']['title'];
		$card_id = $this->module['config']['cardid'];
		$guideUrl = $this->module['config']['guide_url'];

		if(!empty($card_id)){
			load()->classs('coupon');
			$uniacid=$_W['uniacid'];
			$coupon = new coupon($uniacid);
			$data=array($card_id,TIMESTAMP);
			$card_signature = $coupon->SignatureCard($data);
		
		}
		include $this->template ( "shakeresult" );
	}
	

}