<?php
defined('IN_IA') or exit('Access Denied');
class wdl_autorobotModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        global $_GPC, $_W;
        $content            = $this->message['content'];
        $apiKey             = $this->module["config"]['autorobot_key'];
        $autorobot_welcome  = $this->module["config"]['autorobot_welcome'];
        $autorobot_close_bf = $this->module['config']['autorobot_close_bf'];
        $autorobot_close    = $this->module["config"]['autorobot_close'];
        $api_url            = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";
        load()->func('logging');
        logging_run('--robot---');
        if (!$this->inContext) {
            if (empty($autorobot_welcome)) {
                $replay = "我们开始聊天吧！结束请对我说：" . $autorobot_close;
            } else {
                $replay = $autorobot_welcome;
            }
            $this->beginContext("1800");
        } else {
            if ($content == $autorobot_close) {
                $this->endContext();
                if (empty($autorobot_close_bf)) {
                    return $this->respText("再见喽！");
                } else {
                    return $this->respText($autorobot_close_bf);
                }
            } else {
                $url  = str_replace("INFO", $content, str_replace("KEY", $apiKey, $api_url));
                $ress = json_decode(file_get_contents($url), 1);
                $code = $ress['code'];
                switch ($code) {
                    case 100000:
                        $replay = $ress['text'];
                        break;
                    case 200000:
                        $replay = $ress['text'] . "<a href='" . $ress['url'] . "'>请点击这里进入</a>";
                        break;
                    case 302000:
                        $istype = 1;
                        $news   = array();
                        foreach ($ress['list'] as $key => $v) {
                            if ($key < 9) {
                                $news[$key]["title"] = $v['article'];
                                if (empty($v['icon'])) {
                                    $news[$key]['picurl'] = "./addons/wdl_autorobot/template/images/news.jpg";
                                } else {
                                    $news[$key]['picurl'] = $v['icon'];
                                }
                                $news[$key]["url"] = $v['detailurl'];
                            }
                        }
                        break;
                    case 304000:
                        $istype = 1;
                        $news   = array();
                        foreach ($ress['list'] as $key => $v) {
                            if ($key < 9) {
                                $news[$key]["title"] = $v['name'] . "(" . $v['count'] . ")";
                                if (empty($v['icon'])) {
                                    $news[$key]['picurl'] = "./addons/wdl_autorobot/template/images/down.jpg";
                                } else {
                                    $news[$key]['picurl'] = $v['icon'];
                                }
                                $news[$key]["url"] = $v['detailurl'];
                            }
                        }
                        break;
                    case 305000:
                        $replay = "";
                        foreach ($ress['list'] as $key => $v) {
                            if ($key < 9) {
                                $replay .= $v['trainnum'] . "\n" . "起点:" . $v['start'] . "--终点:" . $v['terminal'];
                                $replay .= "\n" . "发车时间:" . $v['starttime'] . "\n到达时间:" . $v['endtime'];
                                $replay .= "\n-----------------\n";
                            }
                        }
                        break;
                    case 306000:
                        $replay = "";
                        foreach ($ress['list'] AS $key => $v) {
                            if ($key < 9) {
                                $replay .= $v['flight'] . "\n" . "起飞时间:" . $v['starttime'] . "\n到达时间:" . $v['endtime'];
                                $replay .= "\n-----------------\n";
                            }
                        }
                        break;
                    case 40001:
                    case 40003:
                    case 40004:
                    case 40005:
                    case 40006:
                    case 40007:
                        $replay = "聊天机器人异常，错误代码:" . $code . "！";
                        break;
                    case 40002:
                        $replay = "您什么都没有说啊！";
                        break;
                    default:
                        $replay = "无此功能呢！";
                }
            }
        }
        logging_run("--$replay---" . $replay);
        if ($istype == 1) {
            return $this->respNews($news);
        } else {
            $replay = strip_tags($replay, '<a><br>');
            $replay = str_replace('<br>', "\n", $replay);
            return $this->respText($replay);
        }
    }
}