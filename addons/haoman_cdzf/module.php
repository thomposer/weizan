<?php
defined('IN_IA') or exit('Access Denied');

class Haoman_cdzfModule extends WeModule {

	public $tablename = 'haoman_cdzf_reply';

	public function fieldsFormDisplay($rid = 0) {
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];


		if (!empty($rid)) {
			$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
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

		if(empty($_GPC['gzurl'])){
			message("转发引导链接不能为空！",referer(),"error");
		}

		$insert = array(
			'rid' => $rid,
			'weid' => $_W['uniacid'],
			'title' => $_GPC['title'],
			'way' => $_GPC['way'],
			'description' => $_GPC['description'],
			'ad_urlimg' => $_GPC['ad_urlimg'],
			'isgz' => $_GPC['isgz'],
			'xunimun' => $_GPC['xunimun'],
			'gzurl' => $_GPC['gzurl'],
			'bgimg' => $_GPC['bgimg'],
			'backmusic' => $_GPC['backmusic'],
			'top_banner1' => $_GPC['top_banner1'],

		);
		if (empty($id)) {
			pdo_insert($this->tablename, $insert);
		} else {
			pdo_update($this->tablename, $insert, array('id' => $id));
		}
		return true;
	}

	public function ruleDeleted($rid) {
		pdo_delete('haoman_cdzf_reply', array('rid' => $rid));
		pdo_delete('haoman_cdzf_fans', array('rid' => $rid));
	}

}
