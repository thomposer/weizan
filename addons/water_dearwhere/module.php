<?php

defined('IN_IA') or exit('Access Denied');
class water_dearwhereModule extends WeModule
{
    public $fanstable = 'water_repair_fans';
    public function settingsDisplay($system)
    {
        global $_W, $_GPC;
        load()->func('tpl');
        $simgs = unserialize($system['simgs']);
        if (checksubmit()) {
            $input           = array();
            $input['mapkey'] = trim($_GPC['mapkey']);
            $input['msgid']  = trim($_GPC['msgid']);
            $input['theme']  = trim($_GPC['theme']);
            $input['tips']   = trim($_GPC['tips']);
            $img             = serialize($_GPC['simgs']);
            $input['simgs']  = $img;
            if ($this->saveSettings($input)) {
                message('保存参数成功', 'refresh');
            }
        }
        include $this->template('system');
    }
}
