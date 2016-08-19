<?php
/**
 * User: cofan
 * qq:136670
 */

function upload_cert($fileinput){
    global $_W;
    $weid = $_W['uniacid'];
    $path = IA_ROOT . "/addons/amouse_rebate/cert";
    load()->func('file');
    mkdirs($path, '0777');
    $f           = $fileinput . '_' . $weid . '.pem';
    $outfilename = $path . "/" . $f;
    $filename    = $_FILES[$fileinput]['name'];
    $tmp_name    = $_FILES[$fileinput]['tmp_name'];
    if (!empty($filename) && !empty($tmp_name)) {
        $ext = strtolower(substr($filename, strrpos($filename, '.')));
        if ($ext != '.pem') {
            $errinput = "";
            if ($fileinput == 'weixin_cert_file') {
                $errinput = "CERT证书文件";
            } else if ($fileinput == 'weixin_key_file') {
                $errinput = 'KEY密钥文件';
            } else if ($fileinput == 'weixin_root_file') {
                $errinput = 'ROOT文件';
            }
            message($errinput . '格式错误!', '', 'error');
        }
        return file_get_contents($tmp_name);
    }
    return "";
}

function decode_html_images($detail = ''){
    $detail = htmlspecialchars_decode($detail);
    preg_match_all("/<img.*?src=[\'| \"](.*?(?:[\.gif|\.jpg|\.png|\.jpeg]?))[\'|\"].*?[\/]?>/", $detail, $imgs);
    $images = array();
    if (isset($imgs[1])) {
        foreach ($imgs[1] as $img) {
            $im= array(
                "old" => $img,
                "new" => tomedia($img)
            );
            $images[] = $im;
        }
    }
    foreach ($images as $img) {
        $detail = str_replace($img['old'], $img['new'], $detail);
    }
    return $detail;
}