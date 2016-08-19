<?php
defined('IN_IA') or exit('Access Denied');

class Haoman_cdzfModuleSite extends WeModuleSite
{

    public $tablename = 'haoman_cdzf_reply';
    public $tablefans = 'haoman_cdzf_fans';

    public function getItemTiles()
    {
        global $_W;
        $articles = pdo_fetchall("SELECT id,rid, title FROM " . tablename('haoman_cdzf_reply') . " WHERE weid = '{$_W['uniacid']}'");
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
        $from_user = $_W['openid'];
        $uniacid = $_W['uniacid'];
        load()->model('mc');

        if (empty($id)) {
            message('抱歉，参数错误！', '', 'error');
        }

//         $user_agent = $_SERVER['HTTP_USER_AGENT'];
//         if (strpos($user_agent, 'MicroMessenger') === false) {
//             message('本页面仅支持微信访问!非微信浏览器禁止浏览!', '', 'error');
//         }

        //读取配置信息数据库
        $reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid=:rid ",array(':rid'=>$id));



            if (empty($from_user)) {
                //301跳刮
                if (!empty($reply['share_url'])) {
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: " . $reply['gzurl'] . "");
                    exit();
                }

            } else {
                //查询是否为关注用户
                $follow = pdo_fetchcolumn("select follow from " . tablename('mc_mapping_fans') . " where openid=:openid and uniacid=:uniacid order by `fanid` desc", array(":openid" => $from_user, ":uniacid" => $uniacid));
                if ($follow == 0) {
                    if (!empty($reply['share_url'])) {
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: " . $reply['gzurl'] . "");
                        exit();
                    }
                }
            }




        if ($reply == false) {
            message('抱歉，活动已经结束，下次再来吧！', '', 'error');
        }

        //读取所有添加祝福语的内容，再前端模板用{$fans['centent']}显示
        $fans = pdo_fetchall("SELECT * FROM " . tablename($this->tablefans) . " WHERE rid = " . $id . "");

        include $this->template('index');



    }

    public function doMobilesetzf()
    {
        //前端祝福的信息通过ajax提交到这个方法来
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $from_user = $_W['fans']['from_user'];
        $uniacid = $_W['uniacid'];
        load()->model('mc');
        $reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid=:rid ",array(':rid'=>$id));
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->tablefans) . " WHERE rid = " . $id . " and from_user='" . $from_user . "'");
        if ($fans == false) {
            $insert = array(
                'rid' => $id,
                'from_user' => $from_user,
                'content' => $_GPC['content'],
                'uniacid' => $uniacid,
                'visitorstime' => time(),
            );
            $temp = pdo_insert($this->tablefans, $insert);
            if ($temp == false) {
                $data = array(
                    'success' => '100',
                  'msg' => '保存数据错误！'
                );
            }else{
                $data = array(
                  'success' => '1',
                    'msg' => '成功提交数据'
                );
                //增加人数和浏览次数
                pdo_update($this->tablename, array('totalnum' => $reply['totalnum'] + 1), array('id' => $reply['id']));
            }
            
        }else{
            $temp = pdo_update($this->tablefans, array('content' => $_GPC['content']), array('rid' => $id, 'from_user' => $from_user));

            if ($temp == false) {

                $data = array(
                 'success' => 100,
                    'msg' => '保存数据错误！'
                );
            } else {
                $data = array(
                  'success' => 1,
                    'msg' => '成功提交数据'
                );
            }
        }
            
        echo json_encode($data);
    }

}
