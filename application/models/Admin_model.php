<?php
/**
 * 管理员表
 * Admin_model.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 14:25
 */

class Admin_model extends MY_Model{
    
    protected function setPrimary(){
        return 'id';
        // TODO: Implement setPrimary() method.
    }
    
    protected function setTableName(){
        return 'admin';
        // TODO: Implement setTableName() method.
    }

    /**
     * 根据用户名获得管理员信息
     * @param $name
     * @return mixed
     */
    public function getInfoByName($name){
        $field = 'username, password, salt, last_time';
        $cond = ['username' => $name];
        return $this->getRowByCond($field, $cond);
    }
    
}