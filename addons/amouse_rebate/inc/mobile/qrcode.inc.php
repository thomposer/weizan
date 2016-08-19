<?php
/**
 * Created by IntelliJ IDEA.
 * User: shizhongying
 * Date: 1/11/16
 * Time: 5:20 下午
 */

global $_W, $_GPC;
$weid=$_W['uniacid'];
$set= $this->getSysset($weid);
$set['needfriend']= trim($set['needfriend']) ? trim($set['needfriend']) :0;
 
$acid=$_W['acid'];

$account = $uniaccount = array();
$uniaccount = pdo_fetch("SELECT * FROM ".tablename('uni_account')." WHERE uniacid = :uniacid", array(':uniacid' => $weid));
$acid = !empty($acid) ? $acid : $uniaccount['default_acid'];
$account = account_fetch($acid);

include $this->template('mp_qrcode');