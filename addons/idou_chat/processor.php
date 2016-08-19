<?php
/**
 * 聊天机器人模块处理程序
 *
 */
defined('IN_IA') or exit('Access Denied');

class Idou_chatModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$config = $this->module['config'];
		$config['enter_tip'] || $config['enter_tip'] = '你想聊点什么呢';
		$config['keep_time'] || $config['keep_time'] = 300;
		$config['exit_keyword'] || $config['exit_keyword'] = '退出';
		$config['exit_tip'] || $config['exit_tip'] = '下次无聊的时候可以再找我聊天哦';

		if ($this->message['msgtype'] == 'voice') {
			if ($config['can_voice'] == '1') {
				$content = $this->message['recognition'];		// 语音识别，直接开启机器人聊天模式
				$reply = $this->turingAPI($content);
				if (is_array($reply)) {
					return $this->respNews($reply);
				} else {
					return $this->respText($reply);
				}
			}
		} else {
			$content = $this->message['content'];			// 通过消息上下文机制与机器人展开聊天
			if (!$this->inContext) {
				$reply = $config['enter_tip'];
				$this->beginContext($config['keep_time']);					// 5分钟后自动退出上下文模式
			} else {
				if ($content == $config['exit_keyword']) {
					$reply = $config['exit_tip'];
					$this->endContext();
				} else {
					$reply = $this->turingAPI($content);
				}
			}

			if (is_array($reply)) {
				return $this->respNews($reply);
			} else {
				return $this->respText($reply);
			}
		}
			
	}

	// 图灵机器人
	private function turingAPI($keyword) {
		$config = $this->module['config'];
		$config['api_url'] || $config['api_url'] = 'http://www.tuling123.com/openapi/api';
		$config['api_key'] || $config['api_key'] = '5b6d54d86d958fe4fabb67883903dbe9';
		$api_url = $config['api_url'] . "?key=" . $config['api_key'] . "&info=" . $keyword;
		
		$result = file_get_contents ( $api_url );
		$result = json_decode ( $result, true );
		if ($_GET ['format'] == 'test') {
			dump ( '图灵机器人结果：' );
			dump ( $result );
		}
		if ($result ['code'] > 40000 && $result['code'] < 40008) {
			if ($result ['code'] < 40008 && ! empty ( $result ['text'] )) {
				return '图灵机器人请你注意：' . $result ['text'];
			} else {
				return false;
			}
		}
		switch ($result ['code']) {
			case '100000' :
				return $result['text'];
				break;
			case '200000' :
				$text = $result ['text'] . ',<a href="' . $result ['url'] . '">点击进入</a>';
				return $text;
				break;
			case '301000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['name'],
							'Description' => $info ['author'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '302000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['article'],
							'Description' => $info ['source'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '304000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['name'],
							'Description' => $info ['count'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '305000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['start'] . '--' . $info ['terminal'],
							'Description' => $info ['starttime'] . '--' . $info ['endtime'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '306000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['flight'] . '--' . $info ['route'],
							'Description' => $info ['starttime'] . '--' . $info ['endtime'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '307000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['name'],
							'Description' => $info ['info'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '308000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['name'],
							'Description' => $info ['info'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '309000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['name'],
							'Description' => '价格 : ' . $info ['price'] . ' 满意度 : ' . $info ['satisfaction'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '310000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['number'],
							'Description' => $info ['info'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '311000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['name'],
							'Description' => '价格 : ' . $info ['price'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			case '312000' :
				foreach ( $result ['list'] as $info ) {
					$articles [] = array (
							'Title' => $info ['name'],
							'Description' => '价格 : ' . $info ['price'],
							'PicUrl' => $info ['icon'],
							'Url' => $info ['detailurl'] 
					);
				}
				return $articles;
				break;
			default :
				if (empty ( $result ['text'] )) {
					return false;
				} else {
					return $result ['text'];
				}
		}
		return true;
	}
}