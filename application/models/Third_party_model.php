<?php
/**
 * Third_party_model.php
 * User: wlq314@qq.com
 * Date: 16/9/13 Time: 14:16
 */

class Third_party_model extends MY_Model{
    
    public function setTableName()
    {
        return 'third_party';
        // TODO: Implement setTableName() method.
    }
    
    public function setPrimary()
    {
        return 'id';
        // TODO: Implement setPrimary() method.
    }
    
    public function all(){
        return $this->getAll();
    }
    
}