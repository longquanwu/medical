<?php
/**
 * Ad_model.php
 * User: wlq314@qq.com
 * Date: 16/9/7 Time: 11:20
 */

class Ad_model extends MY_Model{
    
    public function __construct(){
        parent::__construct();
    }

    public function setPrimary(){
        return 'ad_id';
    }
    
    public function setTableName(){
        return 't_coslers';
    }
    
}