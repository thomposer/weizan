<?php

defined('IN_IA') or exit('Access Denied');
class Water_dearwhereModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        global $_W, $_GPC;
        $content = $this->message['content'];
    }
}
