<?php
/**
 * 极简便利签模块微站定义
 *
 * @author 汪宝宝
 */
defined('IN_IA') or exit('Access Denied');

class W_bianliqianModuleSite extends WeModuleSite {

	public function doMobileIndex() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$accs = pdo_fetchall("select * from ".tablename('account_wechats'));
		include $this->template('index');
	}
	public function doWebList() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;

			load()->func('tpl');
			load()->model('account');
			$accounts = uni_owned();
			$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			if ($operation == 'display') {
				$accs = pdo_fetchall("select * from ".tablename('account_wechats'));
				//导出数据
				if(!empty($_GPC['daochu'])){
					$filename = "公众号大集合";
					if($_GPC['daochu']!=1){
						$acid=$_GPC['acid'];
						$accs = pdo_fetchall("select * from ".tablename('account_wechats')." where acid = ".$acid);
						$filename = $accs[0]['name'];
					}
					/* 输入到CSV文件 */
	                $html = "\xEF\xBB\xBF";
	                /* 输出表头 */
	                $filter = array(
	                    'aa' => '微信公众号名称',
	                    'bb' => '专属ID',
	                    'cc' => 'token',
	                    'dd' => '微信号',
	                    'ee' => '原始ID',
	                    'ff'=>'AppID(应用ID)',
	                    'gg'=>'AppSecret(应用密钥)',
	                    'hh'=>'公众号类型（level）',
	                    );
	                foreach ($filter as $key => $title) {
	                    $html .= $title . "\t,";
	                }
	                $html .= "\n";
	                foreach ($accs as $k => $v) {
	                    $shuju[$k]['aa'] = $v['name'];
	                    $shuju[$k]['bb'] = $v['acid'];
	                    $shuju[$k]['cc'] = $v['token']; 
	                    $shuju[$k]['dd'] = $v['account'];
	                    $shuju[$k]['ee'] = $v['original'];
	                    $shuju[$k]['ff'] = $v['key'];
	                    $shuju[$k]['gg'] = $v['secret'];
	                    if($v['level']==1){
	                       $shuju[$k]['hh'] = '订阅号'; 
	                   }else if($v['level']==2){
	                        $shuju[$k]['hh'] = '服务号';
	                   }else if($v['level']==3){
	                        $shuju[$k]['hh'] = '认证订阅号';
	                   }else {
	                        $shuju[$k]['hh'] = '认证服务号';
	                   }
	                    
	                    
	                    foreach ($filter as $key => $title) {
	                        $html .= $shuju[$k][$key] . "\t,";
	                    }
	                    $html .= "\n";
	                }
	                /* 输出CSV文件 */
	                header("Content-type:text/csv");
	                header("Content-Disposition:attachment; filename=".$filename.".csv");
	                echo $html;
	                exit();
				}
				include $this->template('list');
			}elseif($operation == 'detail'){
				$id = intval($_GPC['id']);
				if(empty($id)){
					message('您访问公众号的不存在',$this->createWebUrl('list'),'info');
				}
				$acc = pdo_fetch("select * from ".tablename('account_wechats')." where acid =".$id);
				include $this->template('detail');
			}
		}

	}