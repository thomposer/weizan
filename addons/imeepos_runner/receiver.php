<?php
/**
 * 小明跑腿模块订阅器
 *
 * @author imeepos
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class Imeepos_runnerModuleReceiver extends WeModuleReceiver {
	public function receive() {
		$type = $this->message['type'];
	}
}