<?php
/**
 * 小明跑腿模块处理程序
 *
 * @author imeepos
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class Imeepos_runnerModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		$content = $this->message['content'];
		$rid = $this->rule;
		$sql = "SELECT * FROM ".tablename('rule')." WHERE id = :rid";
		$params = array(':rid'=>$rid);
		$rule = pdo_fetch($sql,$params);
		
		$name = $rule['name'];
		preg_match('/imeepos_runner:pagetype:(.*)/',$name,$match);
		$id = $match[1];
		if(!empty($id)){
			$sql = "SELECT * FROM ".tablename('imeepos_runner_page')." WHERE id = :id";
			$params = array(':id'=>$id);
			$page = pdo_fetch($sql,$params);
			
			$pageinfo = $page['pageinfo'];
			$pageinfo = htmlspecialchars_decode($pageinfo);
			$pageinfo = rtrim($pageinfo, "]");
			$pageinfo = ltrim($pageinfo, "[");
			$pageinfo = json_decode($pageinfo);
		}
		$img = $pageinfo->params->img;
		$desc = $pageinfo->params->desc;
		$title = $pageinfo->params->title;
		
		$news = array();
		
		$news[] = array(
			'title'=> $title,
			'description'=> $desc,
			'picurl'=> $img,
			'url'=> $this->createMobileUrl('page',array('pageid'=>$id))
		);
		return $this->respNews($news);
	}
}