<?php
/**
 * MY_Model.php
 * User: wlq314@qq.com
 * Date: 16/9/7 Time: 10:40
 */

abstract class MY_Model extends CI_Model{

    //表名
    protected $_table;

    //主键名
    protected $_primary;

    //主数据库
    protected $mdb;

    //从数据库
    protected $sdb;

    public function __construct(){
        parent::__construct();
        $this->mdb = $this->load->database('master', true);
        $this->sdb = $this->load->database('slave', true);
        $this->_table = $this->setTableName();
        $this->_primary = $this->setPrimary();
    }

    abstract protected function setTableName();

    abstract protected function setPrimary();

    /**
     * 插入数据方法
     * @param array $data 要插入的数据数组 字段=>值
     * @return bool
     */
    protected function insertData(array $data){
        if (empty($data)) return FALSE;
        $this->mdb->insert($this->_table, $data);
        return ( $result_id = $this->mdb->insert_id() ) ? $result_id : false;
    }

    /**
     * 删除方法,支持多条件删除
     * @param array $cond  数组格式  key代表字段名称  value代表字段值
     * @return bool
     */
    protected function deleteByCond(array $cond){
        if (!is_array($cond)) return FALSE;
        foreach ($cond as $k => $v){
            $this->mdb->where($k, $v);
        }
        return $this->mdb->delete($this->_table);
    }

    /**
     * @param $id  待删除主键id
     * @return bool  成功删除返回被删除的行号,失败返回false
     */
    protected function deleteById($id){
        $this->mdb->where($this->_primary, $id)->delete($this->_table);
        $rows = $this->mdb->affected_rows();
        if ($rows > 0){
            return $rows;
        }
        return false;
    }

    /**
     * 更新方法,支持多条件更新
     * @param array $cond  更新限制条件 如: WHERE status = 1  写成  ['status' => 1]
     * @param array $data  
     * @param array $condIn  如: WHERE id IN (1, 3, 5) 写成  ['id' => '1, 3, 5']
     * @return bool
     */
    protected function updateByCond(array $cond, array $data, array $condIn = []){
        if (empty($cond) && empty($condIn)) return FALSE;
        foreach ($cond as $k => $v){
            $this->mdb->where($k, $v);
        }
        if(is_array($condIn) && count($condIn) > 0 ){
            foreach ($condIn as $field => $inArray){
                $this->mdb->where_in($field, $inArray);
            }
        }
        return $this->mdb->update($this->_table, $data);
    }

    /**
     * 根据主键更新数据
     * @param $id  主键
     * @param array $data  要修改的数据
     * @return mixed
     */
    protected function updateById($id, array $data=[]){
        return $this->mdb->update($this->_table, $data, [$this->_primary => $id]);
    }

    /**
     * 根据条件获得指定数据
     * @param string $field  需要查询的字段 如 'id, name, sex'
     * @param array $cond  查询的限制条件 如 ['id' => '1', 'name' => 'wlq']
     * @param array $order  排序条件 如 ['id' => 'DESC', 'name' => 'ASC']
     * @param string $limit  limit 5  写成  5
     * @param string $offset  limit 10, 5  写成 $limit = 10 , $offset = 5
     * @param array $keyWord  模糊查询 如: name LIKE '%wlq%' 写成 ['name' => 'wlq']
     * @return mixed
     */
    protected function getAllByCond($field = '*', array $cond = [], array $order = [], $limit = '', $offset = '', array $keyWord = []){
        $db = $this->sdb;  //查询使用从服务器
        $db->select($field);
        $db->from($this->_table);
        if (!empty($cond)){
            $db->where($cond);
        }
        if (!empty($keyWord) && is_array($keyWord)){
            foreach ($keyWord as $k => $v){
                $db->like($k, $v, 'both');
            }
        }
        if ($limit != '' || $offset != ''){
            if ($offset == ''){
                $db->limit($limit);
            }else{
                $db->limit($offset, $limit);
            }
        }
        if (!empty($order) && is_array($order)){
            foreach ($order as $k => $v){
                $db->order_by($k, $v);
            }
        }
        return $db->get()->result_array();
    }

    /**
     * 根据ID查询
     * @param int $id  要查询的主键ID
     * @return array|boolean
     */
    protected function getById($id){
        $query = $this->sdb->get_where($this->_table, [$this->_primary => $id]);
        return $query->row_array();
    }

    /**
     * 根据条件获得一列数据
     * @param string $field  需要查询的字段 如 'id, name, sex'
     * @param array $cond  查询的限制条件 如 ['id' => '1', 'name' => 'wlq']
     * @param bool $master
     * @return mixed
     */
    protected function getRowByCond($field = '*', array $cond = [], $master = false){
        $db = $this->sdb;  //查询使用从服务器
        if ($master)
            $db = $this->mdb;
        $db->from($this->_table);
        $db->select($field);
        if (!empty($cond)){
            $db->where($cond);
        }
        return $db->get()->row_array();
    }

    /**
     * 按SQL的查询方法
     * @param string $sql
     * @return bool
     * @throws Exception
     */
    protected function query($sql){
        if (empty($sql)) return false;
        return $this->sdb->query($sql)->result_array();
    }

    /**
     * 查询数据库全部信息,支持LIMIT查询
     * @param int $limit
     * @param int $offset
     * @param string $fields
     * @param array $orderBy
     * @param bool $master
     * @return mixed
     */
    protected function getAll($limit = 0, $offset = 99999, $fields = '*', $orderBy = [], $master = false){
        $db = $this->sdb;
        if ($master)
            $db = $this->mdb;
        $db->select($fields);
        if (!empty($orderBy) && is_array($orderBy)){
            foreach ($orderBy as $k => $v){
                $db->order_by($k, $v);
            }
        }
        return $db->get($this->_table, $offset, $limit)->result_array();
    }

    /**
     * 根据条件统计数据条数
     * @param array $cond  查询条件,默认不传表示查询所有数据数目
     * @return int
     */
    protected function countByCond(array $cond = []){
        if (!empty($this->_primary))
            $this->sdb->select($this->_primary);
        $this->sdb->from($this->_table);
        if (!empty($cond)){
            $this->sdb->where($cond);
        }
        return $this->sdb->count_all_results();
    }

}
