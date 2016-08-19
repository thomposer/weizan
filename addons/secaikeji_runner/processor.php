<?php
use Qiniu\json_decode;
/**
 * 小明快跑模块处理程序
 *
 * @author imeepos
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class secaikeji_runnerModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		$content = $this->message['content'];
		include MODULE_ROOT.'/inc/mobile/common/global.func.php';
		
		$qrcode = $this->message['scancodeinfo']['scanresult'];
		if(strpos($qrcode,'secaikeji_runner') == 0){
			$sql = "SELECT * FROM ".tablename('secaikeji_runner3_tasks')." WHERE qrcode = :qrcode";
			$params = array(':qrcode'=>$qrcode);
			$tasks = pdo_fetch($sql,$params);
			if(!empty($tasks)){
				if($tasks['status'] == 1){
					return $this->respText('抱歉，此订单还没有人接哦，完成失败！');
				}
				if($tasks['status'] == 0){
					return $this->respText('抱歉，此订单尚未完成支付，完成失败！');
				}
				if($tasks['status'] == 4){
					return $this->respText('抱歉，此二维码已失效，完成失败！');
				}
				$sql = "SELECT * FROM ".tablename('secaikeji_runner3_recive')." WHERE taskid = :taskid";
				$params = array(':taskid'=>$tasks['id']);
				$recive = pdo_fetch($sql,$params);
				if(empty($recive)){
					return $this->respText('接单人信息错误，完成失败！');
				}
				if($_W['openid'] != $recive['openid']){
					return $this->respText('权限错误，这不是您的单子，请确认！');
				}
				pdo_update('secaikeji_runner3_tasks',array('status'=>4),array('id'=>$tasks['id']));
				if($tasks['type'] == 3){
					//帮我买
					$sql = "SELECT * FROM ".tablename('secaikeji_runner3_buy')." WHERE taskid = :taskid";
					$params = array(':taskid'=>$tasks['id']);
					$detail = pdo_fetch($sql,$params);
					$fee = $detail['freight'];
				}else{
					$sql = "SELECT * FROM ".tablename('secaikeji_runner3_detail')." WHERE taskid = :taskid";
					$params = array(':taskid'=>$tasks['id']);
					$detail = pdo_fetch($sql,$params);
					$fee = $detail['total'];
				}
				$uid = mc_openid2uid($recive['openid']);
				mc_credit_update($uid, 'credit2',$fee,array($uid, '跑腿佣金', 0, 0));
				//插入记录表
				$data = array();
				$data['uniacid'] = $_W['uniacid'];
				$data['openid'] = $_W['openid'];
				$data['create_time'] = time();
				$data['reciveid'] = $recive['id'];
				$data['fee'] = $fee;
				
				$sql = "SELECT * FROM ".tablename('secaikeji_runner3_moneylog')." WHERE reciveid = :reciveid";
				$params = array(':reciveid'=>$recive['id']);
				$m = pdo_fetch($sql,$params);
				
				if(!empty($m)){
					//赏金到账通知
					$content = "";
					$content = "恭喜您，".$fee."赏金已到账！~\n";
					$content .= "订单编号：".$tid."\n";
					$content .= "时间：".date('Y年m月d日 h点i分')."\n";
					$content .= "咚咚咚，恭喜您，恭喜您，任务完成!赏金".$fee."元已到账余额，请注意查收~，点击继续赚钱";
					$url = $_W['siteroot'].'app/'.$this->createMobileUrl('index');
					$retrun = mc_notice_consume2($_W['openid'], '赏金到账通知', $content, $url,'');
					
					return $this->respText('恭喜您，任务完成!赏金'.$fee.'元已到账余额，请注意查收');
				}else{
					$content = "";
					$content = "恭喜您，".$fee."赏金已到账！~\n";
					$content .= "订单编号：".$tid."\n";
					$content .= "时间：".date('Y年m月d日 h点i分')."\n";
					$content .= "咚咚咚，恭喜您，恭喜您，任务完成!赏金".$fee."元已到账余额，请注意查收~，点击继续赚钱";
					$url = $_W['siteroot'].'app/'.$this->createMobileUrl('index');
					$retrun = mc_notice_consume2($_W['openid'], '赏金到账通知', $content, $url,'');
					
					pdo_insert('secaikeji_runner3_moneylog',$data);
					return $this->respText('恭喜您，任务完成!赏金'.$fee.'元已到账余额，请注意查收');
				}
			}else{
				return $this->respText('抱歉，任务完成失败，请确认！');
			}
		}
	}
}