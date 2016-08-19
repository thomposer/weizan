<?php
defined('IN_IA') or exit('Access Denied');
class Cgc_addr_forwardModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        $content = $this->message['content'];
    }
}