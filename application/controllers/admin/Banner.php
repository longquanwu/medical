<?php
/**
 * Banner.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 16:31
 */

class Banner extends ADMIN_Controller{
    
    public function index(){
        $this->load->view('admin/banner.html');
        
    }
    
}