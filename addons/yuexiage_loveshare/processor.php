<?php
/**
 * 大爱分享社区模块处理程序
 *
 * @author yuexiage
 * @url http://test.lotbooking.com
 */
defined('IN_IA') or exit('Access Denied');

class Yuexiage_loveshareModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微赞文档来编写你的代码
	}
}