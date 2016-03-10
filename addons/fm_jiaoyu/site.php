<?php
/**
 * 微教育模块
 *
 */
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
class Fm_jiaoyuModuleSite extends WeModuleSite {
	
	// ===============================================
	public $m = 'wx_school';
	public $table_cat = 'wx_school_cat';
	public $table_classify = 'wx_school_classify';
	public $table_score = 'wx_school_score';
	public $table_index = 'wx_school_index';
	public $table_students = 'wx_school_students';
	public $table_tcourse = 'wx_school_tcourse';
	public $table_teachers = 'wx_school_teachers';
	public $table_area = 'wx_school_area';
    public $table_type = 'wx_school_type';	
    public $table_kcbiao = 'wx_school_kcbiao';	
	public $table_cook = 'wx_school_cookbook';	
	public $table_reply = 'wx_school_reply';	
	public $table_banners = 'wx_school_banners';
	public $table_bbsreply = 'wx_school_bbsreply';	
	// ===============================================
		
	// public function doWebUpgrade(){
		// global $_W, $_GPC;
		// include_once 'sys/upgrade.php';
		// echo 'upgraded';
	// }
	
	// 载入逻辑方法
	private function getLogic($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'web') {
			checkLogin ();
			include_once 'inc/web/' . strtolower ( substr ( $_name, 5 ) ) . '.php';
		} else if ($type == 'mobile') {
			// if ($auth) {
				 // include_once 'inc/func/isauth.php';
			 // }
			include_once 'inc/mobile/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		} else if ($type == 'func') {
			//checkAuth ();
			include_once 'inc/func/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

	// ====================== Web =====================
	
	// 学校管理
	public function doWebSchool() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	
	
	// 分类管理
	public function doWebSemester() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 教师管理
	public function doWebAssess() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 学员管理
	public function doWebStudents() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 成绩查询
	public function doWebChengji() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
    // 课程安排
	public function doWebKecheng() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	

	// 课表安排
	public function doWebKcbiao() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	
	
	// 课程预约
	public function doWebSubscribe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 食谱安排
	public function doWebCookBook() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 首页导航
	public function doWebNave() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//班级管理
	public function doWebTheclass() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//成绩管理
	public function doWebScore() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	//科目管理
	public function doWebSubject() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
    //时段管理
	public function doWebTimeframe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	
	
	//星期管理
	public function doWebWeek() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	

	//区域管理
	public function doWebArea() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//学校类型管理
	public function doWebType() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	//分校幻灯片
	public function doWebBanner() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	

    public function doWebQuery() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }
	
    public function doWebBasic() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }

    public function doWebCook() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }	
		
	// ====================== Mobile =====================
	
	// 授权验证
	public function doMobileAuth() {
		$this->getLogic ( __FUNCTION__, 'func' );
	}
	
	public function doMobileWapindex() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileDetail() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileJianjie() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileKc() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileKcinfo() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileKcdg() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileTeachers() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTcinfo() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileChaxun() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileChengji() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCooklist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCook() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	// ====================== FUNC =====================	
	
    public function getNaveMenu()
    {
        global $_W, $_GPC;
        $do = $_GPC['do'];
        $navemenu = array();
        $navemenu[0] = array(
            'title' => '微教育',
            'items' => array(
                0 => array('title' => '学校管理', 'url' => $do != 'school' ? $this->createWebUrl('school', array('op' => 'display')) : ''),
                1 => array('title' => '校区设置', 'url' => $do != 'area' ? $this->createWebUrl('area', array('op' => 'display')) : ''),
                2 => array('title' => '分类设置', 'url' => $do != 'type' ? $this->createWebUrl('type', array('op' => 'display')) : ''),
                3 => array('title' => '基本设置', 'url' => $do != 'basic' ? $this->createWebUrl('basic', array('op' => 'display')) : ''),
            )
        );


        return $navemenu;
    }	

    public function set_tabbar1($action, $schoolid)
    {
        $actions_titles1 = $this->actions_titles1;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles1 as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public $actions_titles1 = array(
	    'semester' => '分类管理',
        'assess' => '教师管理',
        'students' => '学员管理',
        'chengji' => '成绩查询',
        'kecheng' => '课程安排',
		'kcbiao' => '课表设置',
		'cook' => '食谱管理',
		'banner' => '幻灯片管理',		
    );	
	
    public function set_tabbar($action, $schoolid)
    {
        $actions_titles = $this->actions_titles;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
	
    public $actions_titles = array(
	    'semester' => '年级管理',
        'theclass' => '班级管理',
        'score' => '成绩管理',
        'subject' => '科目管理',
        'timeframe' => '时段管理',
        'week' => '星期管理',

    );	
	
    public function showMessageAjax($msg, $code = 0)
    {
        $result['code'] = $code;
        $result['msg'] = $msg;
        message($result, '', 'ajax');
    }	

    protected function exportexcel($data = array(), $title = array(), $filename = 'report')
    {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);

            }
            echo implode("\n", $data);
        }
    }

    function uploadFile($file, $filetempname, $array)
    {
        //自己设置的上传文件存放路径
        $filePath = '../addons/fm_jiaoyu/public/upload/';

        include 'inc/func/phpexcelreader/reader.php';

        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');

        //设置时区
        $time = date("y-m-d-H-i-s"); //去当前上传的时间
        $extend = strrchr($file, '.');
        //上传后的文件名
        $name = $time . $extend;
        $uploadfile = $filePath . $name; //上传后的文件名地址

        if (copy($filetempname, $uploadfile)) {
            if (!file_exists($filePath)) {
                echo '文件路径不存在.';
                return;
            }
            if (!is_readable($uploadfile)) {
                echo ("文件为只读,请修改文件相关权限.");
                return;
            }
            $data->read($uploadfile);
            error_reporting(E_ALL ^ E_NOTICE);
            $count = 0;
            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { //$=2 第二行开始
                //以下注释的for循环打印excel表数据
                for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                    //echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
                }

                $row = $data->sheets[0]['cells'][$i];
                //message($data->sheets[0]['cells'][$i][1]);

                if ($array['ac'] == "assess") {
                    $count = $count + $this->upload_assess($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "students") {
                    $count = $count + $this->upload_students($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "chengji") {
                    $count = $count + $this->upload_chengji($row, TIMESTAMP, $array);
                }
            }
        }
        if ($count == 0) {
            $msg = "名字有重复哦！";
        } else {
            $msg = 1;
        }

        return $msg;
    }

    function upload_assess($strs, $time, $array)
    {
        global $_W;
        $insert = array();
		//时间处理
		$t = $strs[2]; //读取到的值
		$j = $strs[6];
        $birthdate = intval(($t - 25569) * 24*60*60); //转换成1970年以来的秒数	
		$jiontime = intval(($j - 25569) * 24*60*60); 
		//年级处理
		$xueqi1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[10], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$xueqi2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[11], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$xueqi3 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[12], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[13], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		$banji2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[14], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		$banji3 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[15], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//科目处理
		$kemu1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[16], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));   
        $kemu2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[17], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'])); 		
		$insert['weid'] = $_W['uniacid'];
        $insert['tname'] = $strs[1];  
        $insert['birthdate'] = $birthdate;
        $insert['tel'] = $strs[3];
        $insert['mobile'] = $strs[4];
        $insert['email'] = $strs[5];
        $insert['jiontime'] = $jiontime;
        $insert['headinfo'] = $strs[7];
        $insert['info'] = $strs[8];
        $insert['sex'] = $strs[9];
        $insert['xq_id1'] = empty($xueqi1) ? 0 : intval($xueqi1['sid']);
        $insert['xq_id2'] = empty($xueqi2) ? 0 : intval($xueqi2['sid']);
        $insert['xq_id3'] = empty($xueqi3) ? 0 : intval($xueqi3['sid']);		
        $insert['bj_id1'] = empty($banji1) ? 0 : intval($banji1['sid']);	
        $insert['bj_id2'] = empty($banji2) ? 0 : intval($banji2['sid']);
        $insert['bj_id3'] = empty($banji3) ? 0 : intval($banji3['sid']);
        $insert['km_id1'] = empty($kemu1) ? 0 : intval($kemu1['sid']);
        $insert['km_id2'] = empty($kemu2) ? 0 : intval($kemu2['sid']);		
		$insert['schoolid'] = $array['schoolid'];
        $insert['status'] = 1;
        $insert['sort'] = '';
		$insert['thumb'] = 'images/global/avatars/avatar_3.jpg';

        $assess = pdo_fetch("SELECT * FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':tname' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        if (empty($assess)) {
            return pdo_insert('wx_school_teachers', $insert);
        } else {
            return 0;
        }
    }
	
    function upload_students($strs, $time, $array)
    {
        global $_W;
        $insert = array();
        //时间处理
		$b = $strs[3]; //读取到的值
		$s = $strs[6];
		$e = $strs[7];
        $birthdate = intval(($b - 25569) * 24*60*60); //转换成1970年以来的时间戳
		$start = intval(($s - 25569) * 24*60*60); 
		$end = intval(($e - 25569) * 24*60*60); 
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[9], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[10], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $insert['weid'] = $_W['uniacid'];
        $insert['s_name'] = $strs[1];
        $insert['sex'] = $strs[2];
        $insert['birthdate'] = $birthdate;
        $insert['mobile'] = $strs[4];
        $insert['homephone'] = $strs[5];
        $insert['seffectivetime'] = $start;
        $insert['stheendtime'] = $end;
        $insert['area_addr'] = $strs[8];
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
		$insert['schoolid'] = $array['schoolid'];
		$insert['createdate'] = '';		
		$insert['jf_statu'] = '';
		$insert['localdate_id'] = '';
		$insert['note'] = '';
		$insert['amount'] = '';
		$insert['area'] = '';
		$insert['wecha_id'] = '';

        $students = pdo_fetch("SELECT * FROM " . tablename('wx_school_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':s_name' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        if (empty($students)) {
            return pdo_insert('wx_school_students', $insert);
        } else {
            return 0;
        }
    }	

    function upload_chengji($strs, $time, $array)
    {
        global $_W;	
        $insert = array();
		//名字处理
		$sid = pdo_fetch("SELECT id FROM " . tablename('wx_school_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid ", array(':s_name' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[2], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//期号处理
		$qihao = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[3], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[4], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//科目处理
		$kemu = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[5], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
        $insert['sid'] = empty($sid) ? 0 : intval($sid['id']);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
		$insert['qh_id'] = empty($qihao) ? 0 : intval($qihao['sid']);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
        $insert['km_id'] = empty($kemu) ? 0 : intval($kemu['sid']);		
        $insert['my_score'] = $strs[6];
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_score', $insert);
    }	

    private function checkUploadFileMIME($file)
    {
        // 1.through the file extension judgement 03 or 07
        $flag = 0;
        $file_array = explode(".", $file ["name"]);
        $file_extension = strtolower(array_pop($file_array));

        // 2.through the binary content to detect the file
        switch ($file_extension) {
            case "xls" :
                // 2003 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 8);
                fclose($fh);
                $strinfo = @unpack("C8chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                if ($typecode == "d0cf11e0a1b11ae1") {
                    $flag = 1;
                }
                break;
            case "xlsx" :
                // 2007 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 4);
                fclose($fh);
                $strinfo = @unpack("C4chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                echo $typecode . 'test';
                if ($typecode == "504b34") {
                    $flag = 1;
                }
                break;
        }

        // 3.return the flag
        return $flag;
    }

    public function doWebUploadExcel()
    {
        global $_GPC, $_W;

        if ($_GPC['leadExcel'] == "true") {
            $filename = $_FILES['inputExcel']['name'];
            $tmp_name = $_FILES['inputExcel']['tmp_name'];

            $flag = $this->checkUploadFileMIME($_FILES['inputExcel']);
            if ($flag == 0) {
                message('文件格式不对.');
            }

            if (empty($tmp_name)) {
                message('请选择要导入的Excel文件！');
            }

            $msg = $this->uploadFile($filename, $tmp_name, $_GPC);

            if ($msg == 1) {
                message('导入成功！', referer(), 'success');
            } else {
                message($msg, '', 'error');
            }
        }
    }	
	
}