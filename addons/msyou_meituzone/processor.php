<?php
defined('IN_IA') or exit('Access Denied');
class Msyou_meituzoneModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        $content = $this->message['content'];
        $rid     = $this->rule;
        $sql     = "SELECT * FROM " . tablename('msyou_meituzone_reply') . " WHERE `rid`=:rid LIMIT 1";
        $row     = pdo_fetch($sql, array(
            ':rid' => $rid
        ));
        if ($row == false) {
            return $this->respText("活动不存在...");
        } else {
            if ($row['status']) {
                return $this->respNews(array(
                    'Title' => $row['title'],
                    'Description' => strip_tags($row['contact']),
                    'PicUrl' => tomedia($row['thumburl']),
                    'Url' => $this->createMobileUrl('index', array(
                        'id' => $row['id'],
                        'rid' => $row['rid']
                    ), true)
                ));
            } else {
                return $this->respText("活动未开始...");
            }
        }
    }
}