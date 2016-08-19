<?php

defined('IN_IA') or exit('Access Denied');
class Xm_housekeep_we7ModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        $content = $this->message['content'];
        if ($content == '好') {
            $text = "好好好";
        }
        if ($content == '你好') {
            $text = "你也好";
        }
        return ($this->respText($text));
    }
}