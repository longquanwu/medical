<?php
/**
 * User.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 15:43
 */

class User extends ADMIN_Controller{

    public function logout(){
        $this->session->user = '';
        $this->redirect('/admin/login');
    }
}
