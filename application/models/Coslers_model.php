<?php
/**
 * Coslers_model.php
 * User: wlq314@qq.com
 * Date: 16/9/7 Time: 11:25
 */

class Coslers_model extends MY_Model{

    public function setTableName()
    {
        return 't_coslers';
        // TODO: Implement setTableName() method.
    }

    public function setPrimary()
    {
        return 'id';
        // TODO: Implement setPrimary() method.
    }

    public function getAllInfo(){
        return $this->getAll();
    }

}