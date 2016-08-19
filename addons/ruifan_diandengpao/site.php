<?php
defined('IN_IA') or exit('Access Denied');

class Ruifan_diandengpaoModuleSite extends WeModuleSite
{

    public $tablename = 'ruifan_diandengpao_reply';

    public function getItemTiles()
    {
        global $_W;
        $articles = pdo_fetchall("SELECT id,rid, title FROM " . tablename($this->tablename) . " WHERE weid = '{$_W['uniacid']}'");
        if (!empty($articles)) {
            foreach ($articles as $row) {
                $urls[] = array('title' => $row['title'], 'url' => $this->createMobileUrl('index', array('id' => $row['rid'])));
            }
            return $urls;
        }
    }


    public function doMobileindex()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            message('抱歉，参数错误！', '', 'error');
        }

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            message('本页面仅支持微信访问!非微信浏览器禁止浏览!', '', 'error');
        }

        $reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $id));
        if ($reply == false) {
            message('抱歉，活动已经结束，下次再来吧！', '', 'error');
        }

       
       

        include $this->template('index');
    }



}
