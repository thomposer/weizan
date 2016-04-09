<?php
global $_W, $_GPC;
include MODULE_ROOT . '/inc/mobile/common/global.func.php';
include MODULE_ROOT . '/inc/core/model.php';
include MODULE_ROOT . '/inc/mobile/common/install.php';
$template = $this->getTemplate();
load()->model('mc');
$uid  = mc_openid2uid($_W['openid']);
$user = mc_fetch($uid, array(
    'nickname',
    'avatar',
    'realname',
    'mobile',
    'gender',
    'residecity',
    'resideprovince'
));
if (empty($user['nickname'])) {
    $user = mc_oauth_userinfo();
}
$sql    = "SELECT * FROM " . tablename('imeepos_runner3_member') . " WHERE uniacid = :uniacid AND openid = :openid";
$params = array(
    ':uniacid' => $_W['uniacid'],
    ':openid' => $_W['openid']
);
$member = pdo_fetch($sql, $params);
if (empty($member)) {
    $data             = array();
    $data['uniacid']  = $_W['uniacid'];
    $data['openid']   = $_W['openid'];
    $data['nickname'] = $user['nickname'];
    $data['avatar']   = tomedia($user['avatar']);
    $data['time']     = time();
    $data['gender']   = $user['gender'];
    $data['city']     = $user['residecity'];
    $data['provice']  = $user['resideprovince'];
    $data['status']   = $_W['fans']['follow'];
    $data['uid']      = $uid;
    pdo_insert('imeepos_runner3_member', $data);
} else {
    $data             = array();
    $data['nickname'] = $user['nickname'];
    $data['avatar']   = tomedia($user['avatar']);
    $data['time']     = time();
    $data['status']   = $_W['fans']['follow'];
    $data['uid']      = $uid;
    pdo_update('imeepos_runner3_member', $data, array(
        'id' => $member['id']
    ));
}
$sql    = "SELECT * FROM " . tablename('imeepos_runner3_member') . " WHERE uniacid = :uniacid AND openid = :openid";
$params = array(
    ':uniacid' => $_W['uniacid'],
    ':openid' => $_W['openid']
);
$member = pdo_fetch($sql, $params);
$user   = array_merge($user, $member);
$share  = array();