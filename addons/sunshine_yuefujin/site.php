<?php
defined('IN_IA') or exit('Access Denied');
class sunshine_yuefujinModuleSite extends WeModuleSite
{
    public $tree = array();
    static $signPackage;
    public $attention = false;
    public $baidu_key = '';
    public $oauth;
    public $userinfo;
    static $_SET;
    public function __construct()
    {
        global $_W;
        self::$_SET = self::readAllSettings();
        if (self::$_SET === false) {
            exit('load settings failure!');
        }
        if (self::$_SET['opengetuserinfo']['value'] == 'open') {
            $this->oauth['oauth_appid']     = self::$_SET['oauth_appid']['value'];
            $this->oauth['oauth_appsecret'] = self::$_SET['oauth_appsecret']['value'];
        } else {
            $this->oauth['oauth_appid']     = $_W['account']['key'];
            $this->oauth['oauth_appsecret'] = $_W['account']['secret'];
        }
        $this->baidu_key = self::$_SET['baidu_key']['value'];
    }
    public function doMobileIndex()
    {
        global $_GPC, $_W;
        $this->oauthInit($_GPC['sunshine_openid_nocookie']);
        $userinfo = array();
        $data     = $this->getLoginUserinfo($_GPC['sunshine_openid_nocookie']);
        if ($data['res'] == '100') {
            $userinfo = $data['data'];
        }
        $sunshine_openid_nocookie = $_GPC['sunshine_openid_nocookie'];
        pdo_update('sunshine_yuefujin_member', array(
            'update_time' => date('Y-m-d H:i:s')
        ), array(
            'openid' => $sunshine_openid_nocookie
        ));
        include $this->template('index');
    }
    public function doMobileUpdatelnglat()
    {
        global $_W, $_GPC;
        if (!$_GPC['sunshine_openid_nocookie']) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '获取不到你的openid'
            ));
        }
        if (!$_GPC['lng'] || !$_GPC['lat']) {
            self::echoJson(array(
                'res' => '101',
                'msg' => 'can not get your position,please retry!' . $_GPC['lng'] . $_GPC['lat']
            ));
        }
        $data        = array();
        $data['lng'] = $_GPC['lng'];
        $data['lat'] = $_GPC['lat'];
        $r           = pdo_update('sunshine_yuefujin_member', $data, array(
            'openid' => $_GPC['sunshine_openid_nocookie']
        ));
        if ($r === false) {
            self::echoJson(array(
                'res' => '101',
                'msg' => 'update error'
            ));
        }
        self::echoJson(array(
            'res' => '100',
            'msg' => 'success'
        ));
    }
    public function doMobileList()
    {
        global $_GPC, $_W;
        $sunshine_openid_nocookie = $_GPC['sunshine_openid_nocookie'];
        pdo_update('sunshine_yuefujin_member', array(
            'update_time' => date('Y-m-d H:i:s')
        ), array(
            'openid' => $sunshine_openid_nocookie
        ));
        include $this->template('list');
    }
    public function doMobileListload()
    {
        global $_W, $_GPC;
        $openid = $_GPC['sunshine_openid_nocookie'];
        if (!$openid) {
            self::echoJson(array(
                "res" => '101',
                'msg' => 'openid is empty'
            ));
        }
        $info = pdo_fetch("select * from " . tablename('sunshine_yuefujin_member') . " where openid='{$openid}'");
        if (!$info) {
            self::echoJson(array(
                'res' => '101',
                'msg' => 'info empty'
            ));
        }
        pdo_update('sunshine_yuefujin_member', array(
            'update_time' => date('Y-m-d H:i:s')
        ), array(
            'openid' => $sunshine_openid_nocookie
        ));
        $page = $_GPC['page'];
        $page || $page = 1;
        $pagesize = 5;
        $begin    = ($page - 1) * $pagesize;
        $keyword  = $_GPC['keyword'];
        $where    = '';
        if ($keyword) {
            $where = " and (address like '%$keyword%' or name like '%$keyword%')";
        }
        $list      = pdo_fetchall("select * from " . tablename('sunshine_yuefujin_member') . " where openid<>'{$openid}' and sex='{$info['choose_sex']}' order by update_time desc limit $begin,$pagesize");
        $list_sort = array();
        foreach ($list as $key => $value) {
            $l                  = self::GetShortDistance($value['lng'], $value['lat'], $info['lng'], $info['lat']);
            $convert_l          = self::ConvertDistance($l);
            $value['distance']  = $convert_l['distance'];
            $value['unit']      = $convert_l['unit'];
            $last_time          = time() - strtotime($value['update_time']);
            $last_time          = self::GetLastTime($last_time);
            $value['last_time'] = $last_time['str'] . $last_time['unit'];
            $list_sort[$l]      = $value;
        }
        ksort($list_sort);
        $list_sort = array_slice($list_sort, $begin, $pagesize);
        if (empty($list_sort)) {
            self::echoJson(array(
                'res' => '102',
                'msg' => 'empty'
            ));
        }
        self::echoJson(array(
            'res' => '100',
            'msg' => 'success',
            'list' => $list_sort
        ));
    }
    public function doMobileDistance()
    {
        global $_GPC, $_W;
        $lng_1 = $_GPC['lng_1'];
        $lat_1 = $_GPC['lat_1'];
        $lng_2 = $_GPC['lng_2'];
        $lat_2 = $_GPC['lat_2'];
        if (!$lng_1 || !$lat_1 || !$lng_2 || !$lat_2) {
            self::echoJson(array(
                'res' => 101,
                'msg' => 'param error'
            ));
        }
        $l   = self::GetShortDistance($lng_1, $lat_1, $lng_2, $lat_2);
        $res = self::ConvertDistance($l);
        self::echoJson(array(
            'res' => 100,
            'msg' => 'success',
            'data' => $res
        ));
    }
    public function oauthInit($openid)
    {
        global $_W, $_GPC;
        if ($openid) {
            $res = pdo_fetch("select * from " . tablename('sunshine_yuefujin_member') . " where openid = :openid", array(
                ':openid' => $openid
            ));
            if (!$res) {
            } else {
                return $res;
            }
        }
        $REDIRECT_URI = urlencode($_W['siteroot'] . 'app/' . $this->createMobileUrl('oauthhandle'));
        $SCOPE        = 'snsapi_userinfo';
        $STATE        = 'sunshine' . time();
        $url          = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->oauth['oauth_appid']}&redirect_uri={$REDIRECT_URI}&response_type=code&scope={$SCOPE}&state={$STATE}#wechat_redirect";
        header('Location: ' . $url);
    }
    public function doMobileOauthhandle()
    {
        global $_W, $_GPC;
        load()->func('communication');
        $url      = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->oauth['oauth_appid']}&secret={$this->oauth['oauth_appsecret']}&code={$_GPC['code']}&grant_type=authorization_code";
        $response = ihttp_get($url);
        if (is_error($response)) {
            exit('2 error');
        }
        $oauth = @json_decode($response['content'], true);
        if (is_array($oauth) && !empty($oauth['openid'])) {
        } else {
            exit('2.5 error');
        }
        $url      = "https://api.weixin.qq.com/sns/userinfo?access_token={$oauth['access_token']}&openid={$oauth['openid']}&lang=zh_CN";
        $response = ihttp_get($url);
        if (is_error($response)) {
            exit('4 error');
        }
        $userinfo = array();
        $userinfo = @json_decode($response['content'], true);
        if (!$userinfo) {
            exit('4.5 error');
        }
        $data               = array();
        $data['openid']     = $userinfo['openid'];
        $data['nickname']   = $userinfo['nickname'];
        $data['sex']        = $userinfo['sex'];
        $data['province']   = $userinfo['province'];
        $data['city']       = $userinfo['city'];
        $data['country']    = $userinfo['country'];
        $data['headimgurl'] = $userinfo['headimgurl'];
        $data['privilege']  = $userinfo['privilege'];
        $data['headimgurl'] = $userinfo['headimgurl'];
        $data['unionid']    = $userinfo['unionid'];
        $data['account']    = $_W['account']['name'];
        $data['add_time']   = date("Y-m-d H:i:s");
        $info               = pdo_fetch("select * from " . tablename('sunshine_yuefujin_member') . " where openid=:openid", array(
            ':openid' => $userinfo['openid']
        ));
        if ($info) {
            $new_info = array();
            foreach ($date as $key => $value) {
                if ($info[$key] == $value) {
                    unset($data[$key]);
                }
            }
            $r = pdo_update('sunshine_yuefujin_member', $data, array(
                'openid' => $userinfo['openid']
            ));
            if ($r === false) {
                exit('update error');
            }
        } else {
            $res = pdo_insert('sunshine_yuefujin_member', $data);
            if ($res === false) {
                exit(' insert error');
            }
        }
        setcookie('sunshine_openid', $userinfo['openid'], time() + 3600 * 24 * 7);
        header('Location: ' . $this->createMobileUrl('index', array(
            'sunshine_openid_nocookie' => $userinfo['openid']
        )));
    }
    public function getLoginUserinfo($openid)
    {
        if (!$openid) {
            return array(
                'res' => '101',
                'msg' => '用户未登录'
            );
        }
        $userinfo = pdo_fetch('select * from ' . tablename('sunshine_yuefujin_member') . " where openid = '{$openid}'");
        if ($userinfo === false) {
            return array(
                'res' => '102',
                'msg' => '获取用户信息失败'
            );
        }
        return array(
            'res' => '100',
            'msg' => 'success',
            'data' => $userinfo
        );
    }
    public function doMobileUsercenter()
    {
        global $_GPC, $_W;
        if (!$_GPC['sunshine_openid_nocookie']) {
            exit("非法访问，不存在的用户");
        }
        $sunshine_openid_nocookie = $_GPC['sunshine_openid_nocookie'];
        $userinfo                 = pdo_fetch('select * from ' . tablename('sunshine_yuefujin_member') . " where openid = '{$_GPC['sunshine_openid_nocookie']}'");
        if (!$userinfo) {
            exit("访问错误，用户信息error");
        }
        include $this->template('usercenter');
    }
    public function doMobileUserupdate()
    {
        global $_GPC, $_W;
        $nickname   = $_GPC['nickname'];
        $sign       = $_GPC['usersign'];
        $age        = $_GPC['age'];
        $sex        = $_GPC['sex'];
        $choose_sex = $_GPC['choose_sex'];
        if (!$_GPC['sunshine_openid_nocookie']) {
            self::echoJson(array(
                'res' => '101',
                'msg' => 'openid is error'
            ));
        }
        $sunshine_openid_nocookie = $_GPC['sunshine_openid_nocookie'];
        if (!$nickname) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '昵称不能为空'
            ));
        }
        if (!$age) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '年龄不能为空'
            ));
        }
        if (!$sex) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '性别不能为空'
            ));
        }
        if (!$choose_sex) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '请选择查看对象'
            ));
        }
        if (!is_numeric($age)) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '年龄必须微数字'
            ));
        }
        if (!in_array($sex, array(
            '男',
            '女'
        ))) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '请选择性别'
            ));
        }
        if ($sex == '男') {
            $sex = 1;
        } elseif ($sex == '女') {
            $sex = 0;
        }
        if (!in_array($choose_sex, array(
            '男生',
            '女生'
        ))) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '请选择查看性别'
            ));
        }
        if ($choose_sex == '男生') {
            $choose_sex = 1;
        } elseif ($choose_sex == '女生') {
            $choose_sex = 0;
        }
        $data               = array();
        $data['nickname']   = trim($nickname);
        $data['sign']       = trim($sign);
        $data['age']        = $age;
        $data['sex']        = $sex;
        $data['choose_sex'] = $choose_sex;
        $res                = pdo_update("sunshine_yuefujin_member", $data, array(
            'openid' => $sunshine_openid_nocookie
        ));
        if ($res === false) {
            self::echoJson(array(
                'res' => '101',
                'msg' => '更新数据库失败'
            ));
        }
        self::echoJson(array(
            'res' => '100',
            'msg' => 'success'
        ));
    }
    public function doMobileDetail()
    {
        global $_GPC, $_W;
        $sunshine_openid_nocookie = $_GPC['sunshine_openid_nocookie'];
        if (!$sunshine_openid_nocookie) {
            exit('非法访问');
        }
        $info = pdo_fetch("select * from " . tablename('sunshine_yuefujin_member') . " where openid='{$sunshine_openid_nocookie}'");
        if (!$info) {
            exit('不存在的用户');
        }
        $info['address'] = $info['country'] . $info['province'] . $info['city'];
        $commentlist     = $this->loadCommentList($info['openid'], 1, 20, 'openid');
        $commentcount    = pdo_fetch("select count(*) as num from " . tablename("sunshine_yuefujin_comment") . " where comment_openid='{$info['openid']}' and is_del='n'");
        include $this->template('detail');
    }
    public function loadCommentList($comment_openid, $page, $pagesize, $type)
    {
        switch ($type) {
            case 'openid':
                $offset = ($page - 1) * $pagesize;
                $list   = pdo_fetchall("select * from " . tablename('sunshine_yuefujin_comment') . " where is_del='n' and comment_openid='{$comment_openid}' order by add_time desc limit $offset,$pagesize");
                break;
            default:
                $list = array();
                break;
        }
        $u_arr = array();
        foreach ($list as $item) {
            if (!isset($u_arr[$item['comment_openid']])) {
                $userinfo                       = pdo_fetch('select * from ' . tablename('sunshine_yuefujin_member') . " where openid = '{$item['comment_openid']}'");
                $u_arr[$item['comment_openid']] = $userinfo;
            }
        }
        foreach ($list as $key => $item) {
            if (isset($u_arr[$item['comment_openid']])) {
                $list[$key]['usericon'] = $u_arr[$item['user_openid']]['headimgurl'];
                $list[$key]['username'] = $u_arr[$item['user_openid']]['nickname'];
            }
        }
        return $list;
    }
    public function doMobileCommentlist()
    {
        global $_W, $_GPC;
        if (!$_GPC['comment_openid'] || !$_GPC['user_openid']) {
            exit('非法访问');
        }
        $sunshine_openid_nocookie = $_GPC['user_openid'];
        $comment_openid           = $_GPC['comment_openid'];
        $commentlist              = $this->loadCommentList($_GPC['comment_openid'], 1, 50, 'openid');
        $info                     = pdo_fetch("select * from " . tablename('sunshine_yuefujin_comment') . " where comment_openid='{$comment_openid}' ");
        include $this->template('commentlist');
    }
    public function doMobiledocomment()
    {
        global $_W, $_GPC;
        $res = $this->getLoginUserinfo($_GPC['user_openid']);
        if ($res['res'] == '100') {
            $userinfo = $res['data'];
        } elseif ($res['res'] == '101') {
            self::echoJson(array(
                "res" => "101",
                'msg' => 'unlogin'
            ));
        } elseif ($res['res'] == '102') {
            self::echoJson(array(
                "res" => "102",
                'msg' => 'get userinfo fail'
            ));
        }
        $content        = $_GPC['comment_content'];
        $user_openid    = $_GPC['user_openid'];
        $comment_openid = $_GPC['comment_openid'];
        if (!$user_openid || !$comment_openid) {
            self::echoJson(array(
                "res" => "103",
                'msg' => 'openid is error'
            ));
        }
        if (!$content) {
            self::echoJson(array(
                "res" => "103",
                'msg' => '点评内容不能为空'
            ));
        }
        $data                   = array();
        $data['comment_openid'] = $comment_openid;
        $data['content']        = $content;
        $data['user_openid']    = $user_openid;
        $data['add_time']       = date("Y-m-d H:i:s");
        $r                      = pdo_insert('sunshine_yuefujin_comment', $data);
        if ($r === false) {
            self::echoJson(array(
                "res" => "102",
                'msg' => '点评发布失败'
            ));
        }
        self::echoJson(array(
            'res' => '100',
            'msg' => 'success'
        ));
    }
    public function doWebManage()
    {
        global $_W, $_GPC;
        include $this->template('manage');
    }
    public function doWebSettings()
    {
        global $_W, $_GPC;
        $settings = self::$_SET;
        include $this->template('settings');
    }
    public function doWebSettingform()
    {
        global $_GPC, $_W;
        if ($_GPC['dataType'] == 'baidu_key') {
            if (!$_GPC['baidu_key']) {
                self::echoJson(array(
                    'res' => '101',
                    'msg' => 'param error'
                ));
            }
            $n = pdo_fetch("select count(*) as num from " . tablename('sunshine_yuefujin_setting') . " where name='baidu_key'");
            if ($n['num']) {
                $info = pdo_update("sunshine_yuefujin_setting", array(
                    'value' => $_GPC['baidu_key']
                ), array(
                    'name' => 'baidu_key'
                ));
                if ($info !== false) {
                    self::echoJson(array(
                        'res' => '100',
                        'msg' => 'success'
                    ));
                } else {
                    self::echoJson(array(
                        'res' => '102',
                        'msg' => 'update error'
                    ));
                }
            } else {
                $data             = array();
                $data['name']     = 'baidu_key';
                $data['value']    = $_GPC['baidu_key'];
                $data['add_time'] = date("Y-m-d H:i:s");
                $info             = pdo_insert("sunshine_yuefujin_setting", $data, array(
                    'name' => 'baidu_key'
                ));
                if ($info) {
                    self::echoJson(array(
                        'res' => '100',
                        'msg' => 'success'
                    ));
                } else {
                    self::echoJson(array(
                        'res' => '103',
                        'msg' => 'insert error'
                    ));
                }
            }
        }
        if ($_GPC['dataType'] == 'oauth') {
            if (!$_GPC['oauth_appid'] || !$_GPC['oauth_appsecret']) {
                self::echoJson(array(
                    'res' => '102',
                    'msg' => 'param error'
                ));
            }
            pdo_begin();
            $r1 = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'oauth_appid'
            ));
            $r2 = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'oauth_appsecret'
            ));
            if ($r1 === false || $r2 === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '初始化数据失败'
                ));
            }
            $data_appid                 = array();
            $data_appid['name']         = 'oauth_appid';
            $data_appid['value']        = $_GPC['oauth_appid'];
            $data_appid['add_time']     = date("Y-m-d H:i:s");
            $info_appid                 = pdo_insert("sunshine_yuefujin_setting", $data_appid);
            $data_appsecret             = array();
            $data_appsecret['name']     = 'oauth_appsecret';
            $data_appsecret['value']    = $_GPC['oauth_appsecret'];
            $data_appsecret['add_time'] = date("Y-m-d H:i:s");
            $info_appsecret             = pdo_insert("sunshine_yuefujin_setting", $data_appsecret);
            if ($info_appid === false || $info_appsecret === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '写入数据失败'
                ));
            } else {
                pdo_commit();
                self::echoJson(array(
                    'res' => '100',
                    'msg' => 'insert success'
                ));
            }
        }
        if ($_GPC['dataType'] == 'opengetuserinfo') {
            if ($_GPC['opengetuserinfo'] != 'open' && $_GPC['opengetuserinfo'] != 'close') {
                self::echoJson(array(
                    'res' => '101',
                    'msg' => 'error'
                ));
            }
            pdo_begin();
            $r = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'opengetuserinfo'
            ));
            if ($r === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '初始化数据失败'
                ));
            }
            $data_key             = array();
            $data_key['name']     = 'opengetuserinfo';
            $data_key['value']    = $_GPC['opengetuserinfo'];
            $data_key['add_time'] = date("Y-m-d H:i:s");
            $info_key             = pdo_insert("sunshine_yuefujin_setting", $data_key);
            if ($info_key === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '写入数据失败'
                ));
            } else {
                pdo_commit();
                self::echoJson(array(
                    'res' => '100',
                    'msg' => 'insert success'
                ));
            }
        }
        if ($_GPC['dataType'] == 'merchantsallow') {
            if ($_GPC['merchantsallow'] != 'open' && $_GPC['merchantsallow'] != 'close') {
                self::echoJson(array(
                    'res' => '101',
                    'msg' => 'error'
                ));
            }
            pdo_begin();
            $r = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'merchantsallow'
            ));
            if ($r === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '初始化数据失败'
                ));
            }
            $data_key             = array();
            $data_key['name']     = 'merchantsallow';
            $data_key['value']    = $_GPC['merchantsallow'];
            $data_key['add_time'] = date("Y-m-d H:i:s");
            $info_key             = pdo_insert("sunshine_yuefujin_setting", $data_key);
            if ($info_key === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '写入数据失败'
                ));
            } else {
                pdo_commit();
                self::echoJson(array(
                    'res' => '100',
                    'msg' => 'insert success'
                ));
            }
        }
        if ($_GPC['dataType'] == 'qiniuallow') {
            if ($_GPC['qiniuallow'] != 'open' && $_GPC['qiniuallow'] != 'close') {
                self::echoJson(array(
                    'res' => '101',
                    'msg' => 'error'
                ));
            }
            pdo_begin();
            $r = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'qiniuallow'
            ));
            if ($r === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '初始化数据失败'
                ));
            }
            $data_key             = array();
            $data_key['name']     = 'qiniuallow';
            $data_key['value']    = $_GPC['qiniuallow'];
            $data_key['add_time'] = date("Y-m-d H:i:s");
            $info_key             = pdo_insert("sunshine_yuefujin_setting", $data_key);
            if ($info_key === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '写入数据失败'
                ));
            } else {
                pdo_commit();
                self::echoJson(array(
                    'res' => '100',
                    'msg' => 'insert success'
                ));
            }
        }
        if ($_GPC['dataType'] == 'qiniu_info') {
            if (!$_GPC['qiniu_ak'] || !$_GPC['qiniu_sk'] || !$_GPC['qiniu_bucket'] || !$_GPC['qiniu_domain']) {
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '请填写完整信息ak,sk,bucket'
                ));
            }
            pdo_begin();
            $r1 = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'qiniu_ak'
            ));
            $r2 = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'qiniu_sk'
            ));
            $r3 = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'qiniu_bucket'
            ));
            $r4 = pdo_delete('sunshine_yuefujin_setting', array(
                'name' => 'qiniu_domain'
            ));
            if ($r1 === false || $r2 === false || $r3 === false || $r4 === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '初始化数据失败'
                ));
            }
            $data_ak                 = array();
            $data_ak['name']         = 'qiniu_ak';
            $data_ak['value']        = $_GPC['qiniu_ak'];
            $data_ak['add_time']     = date("Y-m-d H:i:s");
            $info_ak                 = pdo_insert("sunshine_yuefujin_setting", $data_ak);
            $data_sk                 = array();
            $data_sk['name']         = 'qiniu_sk';
            $data_sk['value']        = $_GPC['qiniu_sk'];
            $data_sk['add_time']     = date("Y-m-d H:i:s");
            $info_sk                 = pdo_insert("sunshine_yuefujin_setting", $data_sk);
            $data_bucket             = array();
            $data_bucket['name']     = 'qiniu_bucket';
            $data_bucket['value']    = $_GPC['qiniu_bucket'];
            $data_bucket['add_time'] = date("Y-m-d H:i:s");
            $info_bucket             = pdo_insert("sunshine_yuefujin_setting", $data_bucket);
            $data_domain             = array();
            $data_domain['name']     = 'qiniu_domain';
            $data_domain['value']    = $_GPC['qiniu_domain'];
            $data_domain['add_time'] = date("Y-m-d H:i:s");
            $info_domain             = pdo_insert("sunshine_yuefujin_setting", $data_domain);
            if ($info_ak === false || $info_sk === false || $info_bucket == false || $info_domain === false) {
                pdo_rollback();
                self::echoJson(array(
                    'res' => '102',
                    'msg' => '写入数据失败'
                ));
            } else {
                pdo_commit();
                self::echoJson(array(
                    'res' => '100',
                    'msg' => 'insert success'
                ));
            }
        }
    }
    public static function echoJson($arr)
    {
        if (!is_array($arr)) {
            echo $arr;
        } else {
            header('content-type:application/json');
            echo json_encode($arr);
        }
        exit;
    }
    public static function readAllSettings()
    {
        $list = pdo_fetchall("select * from " . tablename('sunshine_yuefujin_setting'));
        if ($list === false) {
            return false;
        }
        foreach ($list as $key => $value) {
            $settings[$value['name']] = $value;
        }
        return $settings;
    }
    static function GetLastTime($time)
    {
        $unit = '秒';
        if ($time >= 0 && $time < 60) {
            $str = $time;
        } elseif ($time >= 60 && $time < 60 * 60) {
            $str  = ceil($time / 60);
            $unit = '分钟';
        } elseif ($time >= 60 * 60 && $time < 24 * 60 * 60) {
            $str_h = floor($time / 60 / 60);
            $str_i = ceil(($time - $str_h * 60 * 60) / 60);
            $str   = $str_h . "小时" . $str_i . "分钟";
            $unit  = '';
        } elseif ($time >= 24 * 60 * 60) {
            $str_d = floor($time / 60 / 60 / 24);
            $str_h = ceil(($time - $str_d * 60 * 60 * 24) / 60 / 60);
            $str   = $str_d . "天" . $str_h . "小时";
            $unit  = '';
        }
        return array(
            'str' => $str,
            'unit' => $unit
        );
    }
    static function GetShortDistance($lng1, $lat1, $lng2, $lat2)
    {
        define('DEF_PI', 3.14159265359);
        define('DEF_2PI', DEF_PI * 2);
        define('DEF_PI180', DEF_PI / 180);
        define('DEF_R', 6370693.5);
        $ew1 = $lng1 * DEF_PI180;
        $ns1 = $lat1 * DEF_PI180;
        $ew2 = $lng2 * DEF_PI180;
        $ns2 = $lat2 * DEF_PI180;
        $dew = $ew1 - $ew2;
        if ($dew > DEF_PI) {
            $dew = DEF_2PI - $dew;
        } else if ($dew < -DEF_PI) {
            $dew = DEF_2PI + $dew;
        }
        $dx       = DEF_R * cos($ns1) * $dew;
        $dy       = DEF_R * ($ns1 - $ns2);
        $distance = sqrt($dx * $dx + $dy * $dy);
        return $distance;
    }
    static function ConvertDistance($distance)
    {
        if ($distance < 1500) {
            $distance = floor($distance);
            $unit     = '米';
        } elseif ($distance > 1500) {
            $distance = round($distance / 1000, 2);
            $unit     = '千米';
        }
        return array(
            'distance' => $distance,
            'unit' => $unit
        );
    }
}