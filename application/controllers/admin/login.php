<?php
/**
 * Login.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 14:34
 */

class Login extends ADMIN_Controller{
    
    /** @var  Admin_model */
    public $admin_model;
    
    public function __construct(){
        parent::__construct(false);
        $this->load->model('admin_model');
    }

    /** 登录页面 */
    public function index(){
        if ($this->session->user)
            $this->redirect('/admin/index/home');
        
        if (isset($_POST['submit'])){
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            $userInfo = $this->admin_model->getInfoByName($username);
            if ($userInfo && $userInfo['password'] === md5(md5($password) . $userInfo['salt'])){
                $this->session->user = $username;
                if (isset($_POST['remember']))
                    $this->session->user = $username;
                $this->redirect('/admin/index/home');
            }
        }
        
        $this->load->view('admin/login.html');
    }

}