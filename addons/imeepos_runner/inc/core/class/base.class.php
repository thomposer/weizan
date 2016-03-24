<?php
abstract class MeBase {
    public $modulename;
    public $module;
    public $weid;
    public $uniacid;
    public $__define;
    //修复卸载重装后配置丢失问题 ims_imeepos_***_settings
    public function saveSettings($settings = array(),$fields = 'settings') {
        global $_W;
        $table = $this->modulename.'_settings';
        $sql = "SELECT * FROM ".tablename($table)." WHERE uniacid = :uniacid";
        $params = array(':uniacid'=>$_W['uniacid']);
        $row = pdo_fetch($sql,$params);
        if(!pdo_tableexists($table)){
            return error('-1','数据库'.$tablename.'不存在');
        }
        if(empty($row)){
            $data = array();
            $data['uniacid'] = $_W['uniacid'];
            $data[$fields] = iserializer($settings);
            pdo_insert($table,$data);
            $id = pdo_insertid();
        }else{
            $data = array();
            $data[$fields] = iserializer($settings);
            pdo_update($table,$data,array('uniacid'=>$_W['uniacid']));
            $id = $row['id'];
        }
        return $id;
    }
    //生成前台会员唯一链接
    protected function createMobileUrl($do, $query = array(), $noredirect = true) {
        global $_W;
        $uid = $_W['member']['uid'];
		$query['do'] = $do;
		$query['m'] = strtolower($this->modulename);
        if(!empty($uid)){
            $query['u'] = $uid;
        }else{
            $query['u'] = $_W['openid'];
        }
		return murl('entry', $query, $noredirect);
    }
    //生成后台管理员唯一链接
    protected function createWebUrl($do, $query = array()) {
        global $_W;
        $uid = $_W['uid'];
		$query['do'] = $do;
		$query['m'] = strtolower($this->modulename);
        if(!empty($uid)){
            $query['u'] = $uid;
        }
		return wurl('site/entry', $query);
	}
    //无改动
    protected function template($filename) {
		global $_W;
		$name = strtolower($this->modulename);
		$defineDir = dirname($this->__define);
		if(defined('IN_SYS')) {
			$source = IA_ROOT . "/web/themes/{$_W['template']}/{$name}/{$filename}.html";
			$compile = IA_ROOT . "/data/tpl/web/{$_W['template']}/{$name}/{$filename}.tpl.php";
			if(!is_file($source)) {
				$source = IA_ROOT . "/web/themes/default/{$name}/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = $defineDir . "/template/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = IA_ROOT . "/web/themes/{$_W['template']}/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = IA_ROOT . "/web/themes/default/{$filename}.html";
			}
		} else {
			$source = IA_ROOT . "/app/themes/{$_W['template']}/{$name}/{$filename}.html";
			$compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$name}/{$filename}.tpl.php";
			if(!is_file($source)) {
				$source = IA_ROOT . "/app/themes/default/{$name}/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = $defineDir . "/template/mobile/{$filename}.html";
			}
			if(!is_file($source)) {
				$source = IA_ROOT . "/app/themes/{$_W['template']}/{$filename}.html";
			}
			if(!is_file($source)) {
				if (in_array($filename, array('header', 'footer', 'slide', 'toolbar', 'message'))) {
					$source = IA_ROOT . "/app/themes/default/common/{$filename}.html";
				} else {
					$source = IA_ROOT . "/app/themes/default/{$filename}.html";
				}
			}
		}
		if(!is_file($source)) {
			exit("Error: template source '{$filename}' is not exist!");
		}
		$paths = pathinfo($compile);
		$compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
		if (DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
			template_compile($source, $compile, true);
		}
		return $compile;
	}
}

abstract class MeModule extends MeBase {

	public function fieldsFormDisplay($rid = 0) {
		return true;
	}

	public function fieldsFormValidate($rid = 0) {
		return true;
	}

	public function fieldsFormSubmit($rid) {
        return true;
    }

	public function ruleDeleted($rid) {
		return true;
	}

	public function settingsDisplay($settings) {
        return true;
    }
}

abstract class MeModuleProcessor extends MeBase {
    public $priority;
	public $message;
	public $inContext;
	public $rule;
    public $scan;

    public function __construct(){
		global $_W;
		$_W['member'] = array();
		if(!empty($_W['openid'])){
			load()->model('mc');
			$_W['member'] = mc_fetch($_W['openid']);
		}
        $this->scan = $this->setFather();
	}
    protected function getFather(){
        //获取上级id
        global $_W;
        $sql = "SELECT * FROM ".tablename('meepo_sub_log')." WHERE uniacid = :uniacid AND uid = :uid AND level = 1";
        $params = array(':uniacid'=>$_W['uniacid'],':uid'=>$_W['member']['uid']);
        $log = pdo_fetch($sql,$params);
        if(empty($log)){
            return false;
        }else{
            return $log['fid'];
        }
    }
    protected function updateFather($uid = 0,$level){
        //更新 上级 记录表
        if(empty($uid)){
            return '';
        }
        $fuid = $this->getFather();
        if(!empty($fuid)){
            $this->updateFather($fuid,$level+1);
        }
        $sql = "SELECT * FROM ".tablename('meepo_sub_log')." WHERE uniacid = :uniacid AND uid = :uid AND level = :level";
        $params = array(':uniacid'=>$_W['uniacid'],':fid'=>$uid,':level'=>$level);
        $log = pdo_fetch($sql,$params);
        if(empty($log)){
            $data = array();
            
            pdo_insert('meepo_sub_log',$data);
        }else{
            $data = array();

            pdo_update('meepo_sub_log',$data,array('id'=>$log['id']));
        }
    }
    protected function setFather(){
        global $_W;
        $uid = $_W['member']['uid'];
        if(!pdo_tableexists('father')){
            return error('-1','father表不存在');
        }
        if(!pdo_tableexists('meepo_sub_log')){
            return error('-1','meepo_sub_log 表不存在');
        }
        $sql = "SELECT * FROM ".tablename('meepo_sub_log')." WHERE uid = :uid AND uniacid = :uniacid";
        $params = array(':uid'=>$uid,':uniacid'=>$_W['uniacid']);
        $sub_log = pdo_fetch($sql,$params);

        if(empty($sub_log)){
            //新关注会员
            $scan = 0;
            $sql = "SELECT * FROM ".tablename('father')." WHERE openid = :openid AND uniacid = :uniacid";
            $params = array(':openid'=>$_W['openid'],':uniacid'=>$_W['uniacid']);
            $father = pdo_fetch($sql,$params);

            $data = array();
            $data['uniacid'] = $_W['uniacid'];
            $data['acid'] = $_W['acid'];
            $data['uid'] = $uid;
            $data['fid'] = $father['fid'];
            $data['createtime'] = time();
            $data['openid'] = $_W['openid'];
            $data['level'] = 1;

            pdo_insert('meepo_sub_log',$data);
        }else{
            //老会员
            $scan = 1;
        }

        return $scan;
    }

    protected function beginContext($expire = 1800) {
		if($this->inContext) {
			return true;
		}
		$expire = intval($expire);
		WeSession::$expire = $expire;
		$_SESSION['__contextmodule'] = $this->module['name'];
		$_SESSION['__contextrule'] = $this->rule;
		$_SESSION['__contextexpire'] = TIMESTAMP + $expire;
		$_SESSION['__contextpriority'] = $this->priority;
		$this->inContext = true;

		return true;
	}

    protected function refreshContext($expire = 1800) {
		if(!$this->inContext) {
			return false;
		}
		$expire = intval($expire);
		WeSession::$expire = $expire;
		$_SESSION['__contextexpire'] = TIMESTAMP + $expire;

		return true;
	}

    protected function endContext() {
		unset($_SESSION['__contextmodule']);
		unset($_SESSION['__contextrule']);
		unset($_SESSION['__contextexpire']);
		unset($_SESSION['__contextpriority']);
		unset($_SESSION);
		session_destroy();
	}

    abstract function respond();

    protected function respText($content) {
		if (empty($content)) {
			return error(-1, 'Invaild value');
		}
		if(stripos($content,'./') !== false) {
			preg_match_all('/<a .*?href="(.*?)".*?>/is',$content,$urls);
			if (!empty($urls[1])) {
				foreach ($urls[1] as $url) {
					$content = str_replace($url, $this->buildSiteUrl($url), $content);
				}
			}
		}
		$content = str_replace("\r\n", "\n", $content);
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'text';
		$response['Content'] = htmlspecialchars_decode($content);
		preg_match_all('/\[U\+(\\w{4,})\]/i', $response['Content'], $matchArray);
		if(!empty($matchArray[1])) {
			foreach ($matchArray[1] as $emojiUSB) {
				$response['Content'] = str_ireplace("[U+{$emojiUSB}]", utf8_bytes(hexdec($emojiUSB)), $response['Content']);
			}
		}
		return $response;
	}

    protected function respImage($mid) {
		if (empty($mid)) {
			return error(-1, 'Invaild value');
		}
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'image';
		$response['Image']['MediaId'] = $mid;
		return $response;
	}

    protected function respVoice($mid) {
		if (empty($mid)) {
			return error(-1, 'Invaild value');
		}
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'voice';
		$response['Voice']['MediaId'] = $mid;
		return $response;
	}

    protected function respVideo(array $video) {
		if (empty($video)) {
			return error(-1, 'Invaild value');
		}
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'video';
		$response['Video']['MediaId'] = $video['MediaId'];
		$response['Video']['Title'] = $video['Title'];
		$response['Video']['Description'] = $video['Description'];
		return $response;
	}
    protected function respMusic(array $music) {
		if (empty($music)) {
			return error(-1, 'Invaild value');
		}
		global $_W;
		$music = array_change_key_case($music);
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'music';
		$response['Music'] = array(
			'Title' => $music['title'],
			'Description' => $music['description'],
			'MusicUrl' => tomedia($music['musicurl'])
		);
		if (empty($music['hqmusicurl'])) {
			$response['Music']['HQMusicUrl'] = $response['Music']['MusicUrl'];
		} else {
			$response['Music']['HQMusicUrl'] = tomedia($music['hqmusicurl']);
		}
		if($music['thumb']) {
			$response['Music']['ThumbMediaId'] = $music['thumb'];
		}
		return $response;
	}

    protected function respNews(array $news) {
		if (empty($news) || count($news) > 10) {
			return error(-1, 'Invaild value');
		}
		$news = array_change_key_case($news);
		if (!empty($news['title'])) {
			$news = array($news);
		}
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'news';
		$response['ArticleCount'] = count($news);
		$response['Articles'] = array();
		foreach ($news as $row) {
			$response['Articles'][] = array(
				'Title' => $row['title'],
				'Description' => ($response['ArticleCount'] > 1) ? '' : $row['description'],
				'PicUrl' => tomedia($row['picurl']),
				'Url' => $this->buildSiteUrl($row['url']),
				'TagName' => 'item'
			);
		}
		return $response;
	}

    protected function respCustom() {
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'transfer_customer_service';
		return $response;
	}

    protected function buildSiteUrl($url) {
		global $_W;

		$mapping = array(
			'[from]' => $this->message['from'],
			'[to]' => $this->message['to'],
			'[rule]' => $this->rule,
			'[uniacid]' => $_W['uniacid'],
		);

		$url = str_replace(array_keys($mapping), array_values($mapping), $url);
		if(strexists($url, 'http://') || strexists($url, 'https://')) {
			return $url;
		}

		if (uni_is_multi_acid() && strexists($url, './index.php?i=') && !strexists($url, '&j=') && !empty($_W['acid'])) {
			$url = str_replace("?i={$_W['uniacid']}&", "?i={$_W['uniacid']}&j={$_W['acid']}&", $url);
		}

		static $auth;
		if(empty($auth)){
			$pass = array();
			$pass['openid'] = $this->message['from'];
			$pass['acid'] = $_W['acid'];

			$sql = 'SELECT `fanid`,`salt`,`uid` FROM ' . tablename('mc_mapping_fans') . ' WHERE `acid`=:acid AND `openid`=:openid';
			$pars = array();
			$pars[':acid'] = $_W['acid'];
			$pars[':openid'] = $pass['openid'];
			$fan = pdo_fetch($sql, $pars);
			if(empty($fan) || !is_array($fan) || empty($fan['salt'])) {
				$fan = array('salt' => '');
			}
			$pass['time'] = TIMESTAMP;
			$pass['hash'] = md5("{$pass['openid']}{$pass['time']}{$fan['salt']}{$_W['config']['setting']['authkey']}");
			$auth = base64_encode(json_encode($pass));
		}

		$vars = array();
		$vars['uniacid'] = $_W['uniacid'];
		$vars['__auth'] = $auth;
		$vars['forward'] = base64_encode($url);

		return $_W['siteroot'] . 'app/' . str_replace('./', '', url('auth/forward', $vars));
	}

    protected function extend_W(){
		global $_W;

		if(!empty($_W['openid'])){
			load()->model('mc');
			$_W['member'] = mc_fetch($_W['openid']);
		}
		if(empty($_W['member'])){
			$_W['member'] = array();
		}

		if(!empty($_W['acid'])){
			load()->model('account');
			if (empty($_W['uniaccount'])) {
				$_W['uniaccount'] = uni_fetch($_W['uniacid']);
			}
			if (empty($_W['account'])) {
				$_W['account'] = account_fetch($_W['acid']);
				$_W['account']['qrcode'] = "{$_W['attachurl_local']}qrcode_{$_W['acid']}.jpg?time={$_W['timestamp']}";
				$_W['account']['avatar'] = "{$_W['attachurl_local']}headimg_{$_W['acid']}.jpg?time={$_W['timestamp']}";
				$_W['account']['groupid'] = $_W['uniaccount']['groupid'];
			}
		}
	}
}
