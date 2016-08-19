<?php
class slider {


    public function __construct()
    {
        if(!pdo_){

        }
        $sql = "CREATE TABLE `ims_site_slide` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `uniacid` int(10) unsigned NOT NULL,
          `title` varchar(255) NOT NULL,
          `url` varchar(255) NOT NULL,
          `thumb` varchar(255) NOT NULL,
          `displayorder` tinyint(4) NOT NULL,
          `multiid` int(10) unsigned NOT NULL,
          PRIMARY KEY (`id`),
          KEY `uniacid` (`uniacid`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
    }
}