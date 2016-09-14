<?php
/**
 * News.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 16:36
 */

class News extends ADMIN_Controller{

    /**
     * 资讯列表
     */
    public function index(){
        $this->load->view('admin/news.html');
    }
    
}