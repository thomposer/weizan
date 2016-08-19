<?php
defined('IN_IA') or exit('Access Denied');
class Haoman_cdzfModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        global $_W;
        $rid = $this->rule;
        $sql = "SELECT * FROM " . tablename('haoman_cdzf_reply') . " WHERE `rid`=:rid LIMIT 1";
        $row = pdo_fetch($sql, array(
            ':rid' => $rid
        ));
        if ($row == false) {
            return $this->respText("活动已取消...");
        }
        return $this->respNews(array(
            'Title' => $row['title'],
            'Description' => $row['description'],
            'PicUrl' => toimage($row['ad_urlimg']),
            'Url' => $this->createMobileUrl('index', array(
                'id' => $rid
            ))
        ));
    }
}