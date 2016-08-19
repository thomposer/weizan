<?php
defined('IN_IA') or exit('Access Denied');
 

class Ruifan_diandengpaoModuleProcessor extends WeModuleProcessor {

	public function respond() {
		global $_W;
		$rid = $this->rule;
		$sql = "SELECT * FROM " . tablename('ruifan_diandengpao_reply') . " WHERE `rid`=:rid LIMIT 1";
		$row = pdo_fetch($sql, array(':rid' => $rid));

		if ($row == false) {
			return $this->respText("活动已取消...");
		}

		if ($row['starttime'] > time()) {
			return $this->respText("活动未开始，请等待...");
		}

			return $this->respNews(array(
				'Title' => $row['title'],
				'Description' => $row['description'],
				'PicUrl' => toimage($row['start_picurl']),
				'Url' => $this->createMobileUrl('index', array('id' => $rid)),
			));

	}

}
