<?php
defined('IN_IA') or exit('Access Denied');
class Aki_yzmyeModule extends WeModule
{
    public function fieldsFormDisplay($rid = 0)
    {
        load()->func('logging');
        logging_run('嵌入一个规则111111111', '', 'rule1');
    }
    public function fieldsFormValidate($rid = 0)
    {
        load()->func('logging');
        logging_run('嵌入一个规则22222222222', '', 'rule1');
        return '';
    }
    public function fieldsFormSubmit($rid)
    {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        if (empty($uniacid)) {
            exit();
        }
        $indata = array(
            'uniacid' => $uniacid,
            'rid' => $rid,
            'time' => time('Ymd')
        );
        $sql    = 'select id from ' . tablename('aki_yzmye') . ' where rid =:rid';
        $ds     = intval(pdo_fetchcolumn($sql, array(
            ':rid' => $rid
        )));
        if ($ds > 0)
            exit();
        else
            pdo_insert('aki_yzmye', $indata);
    }
    public function ruleDeleted($rid)
    {
        load()->func('logging');
        logging_run('嵌入一个规则', '', 'rule4');
    }
}