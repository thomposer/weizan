<?php
global $_W,$_GPC;

$params = $_GPC['params'];
$params = @base64_decode($params);
$params = json_encode(iunserializer($params));

if(!empty($params)) {
	include IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
	QRcode::png($params, false, QR_ECLEVEL_Q, 4);
}