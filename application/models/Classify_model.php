<?php
/**
 * 帖子分类表
 *
 * Classify_model.php
 * User: wlq314@qq.com
 * Date: 16/9/27 Time: 14:49
 */

class Classify_model extends MY_Model{

    /** 正常状态 */
    const ACTIVE_TYPE = 1;

    /** 逻辑删除状态 */
    const DELETE_TYPE = 2;
    
    protected function setTableName(){
        return 'classify';
    }
    
    protected function setPrimary(){
        return 'id';
    }

    /**
     * 获得分类列表
     * 
     * @return mixed
     */
    public function classifyList(){
        $field = 'id, name, order, update_time';
        $cond = ['delete' => self::ACTIVE_TYPE];
        $order = ['order' => 'DESC'];
        return parent::getAllByCond($field, $cond, $order);
    }

    /**
     * 添加新分类
     *
     * @param $name
     * @param string $order
     * @return bool
     */
    public function add($name, $order = ''){
        if (empty($name))
            return false;
        $data['name'] = $name;
        empty($order) || $data['order'] = $order;
        return parent::insertData($data);
    }

    /**
     * 根据ID删除分类
     *
     * @param $id
     * @return bool
     */
    public function delete($id){
        return parent::deleteById($id);
    }

    /**
     * 判断分类名是否存在
     *
     * @param $name
     * @return mixed
     */
    public function checkExistByName($name){
        $cond = ['name' => $name, 'delete' => self::ACTIVE_TYPE];
        return parent::countByCond($cond);
    }

    /**
     * 更新分类信息
     * 
     * @param $id
     * @param string $name
     * @param string $order
     * @return mixed
     */
    public function update($id, $name = '', $order = ''){
        empty($name) || $data['name'] = $name;
        empty($order) || $data['order'] = $order;
        return parent::updateById($id, $data);
    }

}