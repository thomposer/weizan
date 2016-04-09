<?php
defined('IN_IA') or exit('Access Denied');
class wdl_autorobotModule extends WeModule
{
    public function settingsDisplay($settings)
    {
        global $_GPC, $_W;
        if (checksubmit()) {
            $autorobot_flag = $_GPC['autorobot_flag'] ? $_GPC['autorobot_flag'] : 'N';
            $dat            = array(
                'autorobot_flag' => $autorobot_flag,
                'autorobot_key' => $_GPC['autorobot_key'],
                'autorobot_welcome' => $_GPC['autorobot_welcome'],
                'autorobot_close' => $_GPC['autorobot_close'],
                'autorobot_close_bf' => $_GPC['autorobot_close_bf']
            );
            $this->saveSettings($dat);
            $weid      = $_W['uniacid'];
            $rule_arr  = pdo_fetch("SELECT name FROM " . tablename('rule') . " WHERE uniacid = '$weid' and module='wdl_autorobot' order by displayorder desc limit 1");
            $rule_data = $rule_arr['name'];
            if (empty($rule_data)) {
                message('机器客服未设置关键词！', referer(), 'error');
            }
            $api_php_file = '../api.php';
            $api_content  = file_get_contents($api_php_file);
            if (!strstr($api_content, 'robotsetfinish')) {
                $api_content_arr = explode('if(empty($keywords)) {', $api_content, 2);
                if (count($api_content_arr) < 2 && !strstr($api_content_arr[0], 'robot首次机套人修复问题')) {
                    message('api.php文件无匹配项！', referer(), 'error');
                }
                if (!strstr($api_content, 'robot首次机套人修复问题')) {
                    $api_content_new = $api_content_arr[0];
                    $api_content_new .= 'if(empty($keywords)) {';
                } else {
                    $api_content_arr = explode('if(empty($keywords) || !$robot_empty_con) {', $api_content, 2);
                    $api_content_new = $api_content_arr[0];
                    $api_content_new .= 'if(empty($keywords) || !$robot_empty_con) {';
                }
                if (!strstr($api_content, '已经退出聊天机器人对话')) {
                    $api_content_new .= '
                                    $autorobot_flag="' . $autorobot_flag . '";
                                    if ($autorobot_flag == \'Y\' && !$_SESSION[\'__contextmodule\']) {//已经退出聊天机器人对话
                                        $rule_robot_keyword="' . $rule_data . '";
                                        $message[\'content\'] = $rule_robot_keyword;
                                        return $this->analyzeText($message, $order);                        
                                    }';
                } else {
                    preg_match('/$autorobot_flag='(.*)'\;/', $api_content_arr[1], $res);
                    if ($res[0]) {
                        $api_content_arr[1] = str_replace($res[0], '$autorobot_flag="' . $autorobot_flag . '";', $api_content_arr[1]);
                    }
                    unset($res);
                    preg_match("/$rule_robot_keyword="(.*)"\;/", $api_content_arr[1], $res);
                    if ($res[0]) {
                        $api_content_arr[1] = str_replace($res[0], '$rule_robot_keyword="' . $rule_data . '";', $api_content_arr[1]);
                    }
                }
                $api_content_new .= $api_content_arr[1];
                if (!strstr($api_content_new, 'robot首次机套人修复问题')) {
                    $api_content_new = str_replace('if(empty($keywords)) {', '$robot_empty_con = "";//robot首次机套人修复问题
                            foreach($keywords as $keyword) {
                                $robot_empty_con .= $keyword[\'content\'];
                                if ($keyword[\'content\']) {
                                    break;
                                }
                            }
                            if(empty($keywords) || !$robot_empty_con) {', $api_content_new);
                }
                $find_str = '$autorobot_flag="' . $autorobot_flag . '";';
                $rep_str  = '';
                $rep_str  = '$para_data = pdo_fetch(\'SELECT * FROM \'.tablename("uni_account_modules").\' WHERE module="wdl_autorobot" AND uniacid="\'.$GLOBALS[\'_W\'][\'uniacid\'].\'"\');';
                $rep_str .= "\n" . '$para_data = unserialize($para_data["settings"]);';
                $rep_str .= "\n" . '$autorobot_flag = $para_data["autorobot_flag"] ? $para_data["autorobot_flag"] : "N";//robotsetfinish';
                $api_content_new = str_replace($find_str, $rep_str, $api_content_new);
                $fp              = fopen($api_php_file, 'w+');
                fwrite($fp, $api_content_new);
                fclose($fp);
            }
            message('保存成功！', referer(), 'success');
        }
        include $this->template('setting');
    }
}