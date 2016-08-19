<?php
defined('IN_IA') or exit('Access Denied');

class Ruifan_diandengpaoModule extends WeModule {

	public $tablename = 'ruifan_diandengpao_reply';

	public function fieldsFormDisplay($rid = 0) {
		global $_GPC, $_W;


		if (!empty($rid)) {
			$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		}
		if (!$reply) {
			$now = time();
			$reply = array(
				"title" => "",
				"start_picurl" => "",
				"description" => "",
				"starttime" => $now,
				"endtime" => strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600)),
				"show_num" => 1,
			);
		}
		load()->func('tpl');
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		$id = intval($_GPC['reply_id']);

		$insert = array(
			'rid' => $rid,
			'weid' => $_W['uniacid'],
			'title' => $_GPC['title'],
			'content' => $_GPC['content'],
			'description' => $_GPC['description'],
			'start_picurl' => $_GPC['start_picurl'],
			'backpicurl' => $_GPC['backpicurl'],
			'bannerurl' => $_GPC['bannerurl'],
			'curimg' => $_GPC['curimg'],
			'oldimg' => $_GPC['oldimg'],
			'starttime' => $_GPC['starttime'],
			'share_url' => $_GPC['share_url'],
			'endtime' => $_GPC['endtime'],
			'ad_title' => $_GPC['ad_title'],
			'ad_img' => $_GPC['ad_img'],
			'ad_url' => $_GPC['ad_url'],
			'dengji' => $_GPC['dengji'],
		);
		if (empty($id)) {
	
			pdo_insert($this->tablename, $insert);
		} else {
			pdo_update($this->tablename, $insert, array('id' => $id));
		}
		return true;
	}

	public function ruleDeleted($rid = 0) {
		pdo_delete('ruifan_diandengpao_reply', array('rid' => $rid));
	}

}
