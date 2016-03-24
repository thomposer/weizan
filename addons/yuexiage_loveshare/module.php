<?php
/**
 * 大爱分享社区模块定义
 *
 * @author yuexiage
 * @url http://test.lotbooking.com
 */
defined('IN_IA') or exit('Access Denied');

class Yuexiage_loveshareModule extends WeModule {

	public function settingsDisplay($settings) {
        global $_GPC, $_W;
		
        if (checksubmit()) {
            $cfg = array(
                'communityname' => $_GPC['communityname'],
                'officialweb' => $_GPC['officialweb'],
                'phone' => $_GPC['phone'],
                'description'=>  htmlspecialchars_decode($_GPC['description']),
                'filter' => $_GPC['filter'],
                'comment' => $_GPC['comment'],
                'public_member' => $_GPC['public_member']
            );
            if (!empty($_GPC['logo'])) {
                $cfg['logo'] = $_GPC['logo'];
            }
            if ($this->saveSettings($cfg)) {
                message('保存成功', 'refresh');
            }
        }
        include $this->template('setting');
    }

}