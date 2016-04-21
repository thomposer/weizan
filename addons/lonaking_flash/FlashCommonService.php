<?php
error_reporting(0);
abstract class FlashCommonService
{
    
    public $table_name;
    public $columns;
    public $plugin_name;
    private $flashVersion = "5.5";
    public function getByIdOrObj($objOrId)
    {
        if (is_numeric($objOrId)) {
            return $this->selectById($objOrId);
        } else {
            if (is_array($objOrId)) {
                return $objOrId;
            }
        }
    }
    public function selectById($id)
    {
        global $_W;
        $sql          = null;
        $select_param = array(
            ':id' => $id
        );
        $sql          = "SELECT " . $this->columns . " FROM " . tablename($this->table_name) . " WHERE id =:id";
        $result       = pdo_fetch($sql, $select_param);
        return $result;
    }
    public function selectByIds($ids)
    {
        if (!is_array($ids)) {
            throw new Exception('查询参数异常', 404);
        }
        if (sizeof($ids) <= 0) {
            throw new Exception('参数为空', 404);
        }
        $ids       = array_unique($ids);
        $idsStr    = implode(",", $ids);
        $in        = "(" . $idsStr . ")";
        $data_list = pdo_fetchall("SELECT " . $this->columns . " FROM " . tablename($this->table_name) . " WHERE id in {$in}");
        return $data_list;
    }
    public function selectAllIn($column, $list, $where = "")
    {
        if (empty($column)) {
            $column = "id";
        }
        $list = array_unique($list);
        if (!is_array($list)) {
            throw new Exception('查询参数异常', 404);
        }
        if (sizeof($list) <= 0) {
            throw new Exception('参数为空', 404);
        }
        $columnArr = explode(",", $this->columns);
        if (!in_array($column, $columnArr)) {
            throw new Exception("不存在的属性", 404);
        }
        $inStr = implode(",", $list);
        $in    = "(" . $inStr . ")";
        $sql   = "SELECT " . $this->columns . " FROM " . tablename($this->table_name) . " WHERE {$column} in {$in} and 1=1 {$where}";
        $this->log($sql, "select all in sql is ");
        $data_list = pdo_fetchall($sql);
        return $data_list;
    }
    public function selectAll($where = '')
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $sql     = "SELECT " . $this->columns . " FROM " . tablename($this->table_name) . " WHERE uniacid={$uniacid} AND 1=1 {$where}";
        $this->log($sql, "select all sql is :");
        $data_list = pdo_fetchall($sql);
        return $data_list;
    }
    public function selectAllMap($where = '')
    {
        $all    = $this->selectAll($where);
        $newAll = array();
        foreach ($all as $d) {
            $newAll[$d['id']] = $d;
        }
        return $newAll;
    }
    public function selectOne($where = '')
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $sql     = "SELECT " . $this->columns . " FROM " . tablename($this->table_name) . " WHERE uniacid={$uniacid} AND 1=1 {$where}";
        $this->log($sql, "selectOne sql");
        $result = pdo_fetch($sql);
        $this->log($result, "selectOne result");
        return $result;
    }
    public function selectAllOrderBy($where = '', $order_by = '')
    {
        global $_W;
        $uniacid   = $_W['uniacid'];
        $data_list = pdo_fetchall("SELECT " . $this->columns . " FROM " . tablename($this->table_name) . " WHERE 1=1 AND uniacid={$uniacid} {$where} ORDER BY {$order_by}id ASC");
        return $data_list;
    }
    public function deleteById($id)
    {
        $item = $this->selectById($id);
        if (empty($item)) {
            throw new Exception("无法删除，因为这条数据不存在", 402);
        }
        pdo_delete($this->table_name, array(
            'id' => $id
        ));
    }
    public function insertData($param)
    {
        pdo_insert($this->table_name, $param);
        $param['id'] = pdo_insertid();
        return $this->selectById($param['id']);
    }
    public function updateData($param)
    {
        $id   = $param['id'];
        $data = $this->selectById($id);
        if (empty($data)) {
            throw new Exception("更新失败,数据不存在", 403);
        }
        pdo_update($this->table_name, $param, array(
            'id' => $id
        ));
        return $this->selectById($id);
    }
    public function updateColumn($column_name, $value, $id)
    {
        if (pdo_fieldexists($this->table_name, $column_name)) {
            pdo_update($this->table_name, array(
                $column_name => $value
            ), array(
                'id' => $id
            ));
        } else {
            throw new Exception('表不存在[' . $column_name . "]属性", 405);
        }
    }
    public function updateColumnByWhere($column_name, $value, $where = "")
    {
        global $_W;
        if (pdo_fieldexists($this->table_name, $column_name)) {
            $sql = "UPDATE " . tablename($this->table_name) . " SET {$column_name}={$value} WHERE uniacid={$_W['uniacid']} AND 1=1 {$where}";
            pdo_query($sql);
        } else {
            throw new Exception('表不存在[' . $column_name . "]属性", 405);
        }
    }
    public function columnAddCount($column_name, $add_count, $id)
    {
        if (pdo_fieldexists($this->table_name, $column_name)) {
            $data = $this->selectById($id);
            if (empty($data)) {
                throw new Exception("更新失败,数据不存在", 403);
            }
            $data[$column_name] = $data[$column_name] + $add_count;
            $new_data           = $this->updateData($data);
            return $new_data;
        } else {
            throw new Exception('表不存在[' . $column_name . "]属性", 405);
        }
    }
    public function columnReduceCount($column_name, $reduce_count, $id)
    {
        if (pdo_fieldexists($this->table_name, $column_name)) {
            $data = $this->selectById($id);
            if (empty($data)) {
                throw new Exception("更新失败,数据不存在", 403);
            }
            $data[$column_name] = $data[$column_name] - $reduce_count;
            $new_data           = $this->updateData($data);
            return $new_data;
        } else {
            throw new Exception('表不存在[' . $column_name . "]属性", 405);
        }
    }
    public function insertOrUpdate($param)
    {
        if ($param['id']) {
            return $this->updateData($param);
        } else {
            return $this->insertData($param);
        }
    }
    public function count($where = '')
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        $count   = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_name) . " WHERE uniacid={$uniacid} AND 1=1  {$where}");
        return $count;
    }
    public function selectPageAdmin($where = '', $page_index = '', $page_size = '')
    {
        $this->checkRegister();
        return $this->selectPage($where, $page_index, $page_size);
    }
    public function selectPage($where = '', $page_index = '', $page_size = '')
    {
        global $_W, $_GPC;
        if (empty($page_index)) {
            $page_index = max(1, intval($_GPC['page']));
        }
        if (empty($page_size)) {
            $page_size = (is_null($_GPC['size']) || $_GPC['size'] <= 0) ? 20 : $_GPC['size'];
        }
        $count_where = $where;
        $where       = $where . " LIMIT " . ($page_index - 1) * $page_size . ',' . $page_size;
        $data        = $this->selectAll($where);
        $count       = $this->count($count_where);
        $pager       = pagination($count, $page_index, $page_size);
        return array(
            'data' => $data,
            'count' => $count,
            'pager' => $pager,
            'page_index' => $page_index,
            'page_size' => $page_size
        );
    }
    public function rankOne($id, $where = "", $referToColumn = "")
    {
        $baseWhere = "r.id={$id}";
        if (!empty($referToColumn)) {
            $baseWhere = "r.{$referToColumn}={$id}";
        }
        $columnsArr  = explode(",", $this->columns);
        $rColumnsArr = array();
        $aColumnsArr = array();
        foreach ($columnsArr as $f) {
            $rColumnsArr[] = "r." . $f;
            $aColumnsArr[] = "a." . $f;
        }
        $rColumnsString = implode(",", $rColumnsArr);
        $aColumnsString = implode(",", $aColumnsArr);
        $result         = pdo_fetch("select {$rColumnsString},r.rank from (select {$aColumnsString},(@rowNum:=@rowNum+1) as rank from " . tablename($this->table_name) . " a,(select (@rowNum :=0)) b where 1=1 {$where}) as r where {$baseWhere} AND 1=1 ");
        return $result['rank'];
    }
    public function selectPageOrderByAdmin($where = '', $order_by = '', $page_index = '', $page_size = '')
    {
        $this->checkRegister();
        return $this->selectPageOrderBy($where, $order_by, $page_index, $page_size);
    }
    public function selectPageOrderBy($where = '', $order_by = '', $page_index = '', $page_size = '')
    {
        global $_W, $_GPC;
        if (!empty($order_by)) {
            if (substr($order_by, -1) == ",") {
                $order_by = substr($order_by, 0, strlen($order_by) - 1);
            }
        }
        if (empty($page_index)) {
            $page_index = max(1, intval($_GPC['page']));
        }
        if (empty($page_size)) {
            $page_size = (is_null($_GPC['size']) || $_GPC['size'] <= 0) ? 20 : $_GPC['size'];
        }
        $count_where = $where;
        $where       = $where . " ORDER BY {$order_by} LIMIT " . ($page_index - 1) * $page_size . ',' . $page_size;
        $data        = $this->selectAll($where);
        $count       = $this->count($count_where);
        $pager       = pagination($count, $page_index, $page_size);
        return array(
            'data' => $data,
            'count' => $count,
            'pager' => $pager,
            'page_index' => $page_index,
            'page_size' => $page_size
        );
    }
    public function checkObjOrId($objOrId)
    {
        if (is_array($objOrId)) {
            if (!empty($objOrId['id'])) {
                return $objOrId;
            }
            throw new Exception('非法的字段', 404);
        } else {
            if (is_numeric($objOrId)) {
                return $this->selectById($objOrId);
            }
            throw new Exception('非法的字段', 404);
        }
    }
    public function log($content, $desc = "")
    {
        load()->func('logging');
        $log  = json_encode($content);
        $log  = $desc . ":" . $log;
        $date = date('Y-m-d', time());
        logging_run($log, $type = 'trace', $filename = $this->plugin_name . $date);
    }
    public function createWexinAccount()
    {
        global $_W;
        load()->classs('weixin.account');
        $acid    = $_W['account']['acid'];
        $uniacid = $_W['uniacid'];
        $account = null;
        if (!empty($acid) && $acid != $uniacid) {
            $account = WeiXinAccount::create($_W['account']['acid']);
        }
        if (empty($account)) {
            $account = WeiXinAccount::create($_W['uniacid']);
        }
        return $account;
    }
    public function getUniacid()
    {
        global $_W;
        load()->classs('weixin.account');
        $acid    = $_W['account']['acid'];
        $uniacid = $_W['uniacid'];
        if (!empty($acid) && $acid != $uniacid) {
            return $acid;
        } else {
            return $uniacid;
        }
    }
    public function sendTextMessage($toUserOpenid, $content)
    {
        global $_W;
        $send    = array(
            'msgtype' => 'text',
            'touser' => $toUserOpenid,
            'text' => array(
                'content' => urlencode($content)
            )
        );
        $account = $this->createWexinAccount();
        return $account->sendCustomNotice($send);
    }
    public function sendImageMessage($toUserOpenid, $mediaId)
    {
        global $_W;
        $send    = array(
            'msgtype' => 'image',
            'touser' => $toUserOpenid,
            'image' => array(
                'media_id' => $mediaId
            )
        );
        $account = $this->createWexinAccount();
        return $account->sendCustomNotice($send);
    }
    public function httpPost($url, $postData = array())
    {
        load()->func('communication');
        $result = ihttp_post($url, $postData);
        return $result['content'];
    }
    public function httpGet($url, $param = array())
    {
        load()->func('communication');
        $api = $url;
        if (!empty($param)) {
            $first = $normal = strpos($api, "?");
            foreach ($param as $key => $value) {
                if ($first == false) {
                    $api .= "?" . $key . "=" . $value;
                    $first = true;
                } else {
                    $api .= "&" . $key . "=" . $value;
                }
            }
        }
        $result = ihttp_get($api);
        return $result['content'];
    }
    public function checkRegister($module = null)
    {
        
    }
    protected function createMobileUrl($do, $param = array(), $noredirect = true)
    {
        global $_W;
        $query['do'] = $do;
        $query['m']  = strtolower($this->plugin_name);
        return murl('entry', $query, $noredirect);
    }
    private function std2array($array)
    {
        if (is_object($array)) {
            $array = (array) $array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->std2array($value);
            }
        }
        return $array;
    }
    public function jsonString2Array($json)
    {
        $result = json_decode($json);
        $result = $this->std2array($result);
        return $result;
    }
}
?>