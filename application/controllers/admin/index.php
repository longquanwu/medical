<?php
/**
 * Index.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 11:13
 */

class Index extends ADMIN_Controller{
    
    public function home(){
        $this->load->view('admin/home.html');
    }

}