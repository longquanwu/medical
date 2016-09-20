<?php
/**
 * 后台管理员
 * User.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 15:43
 */

class User extends ADMIN_Controller{
    
    /** @var  Admin_model */
    public $admin_model;

    /**
     * 退出登录
     */
    public function logout(){
        $this->session->user = '';
        $this->redirect('/admin/login');
    }

    /**
     * 修改密码页面
     */
    public function modify(){
        $this->load->model('admin_model');
        $data = [];
        if(isset($_POST['submit'])){
            $password = $this->input->post('password', true);
            $newPassword = $this->input->post('newPassword', true);
            $confirmPassword = $this->input->post('confirmPassword', true);
            $username = $this->session->user;
            $userInfo = $this->admin_model->getInfoByName($username);
            if ($userInfo && $userInfo['password'] === md5(md5($password) . $userInfo['salt'])){
                if ($newPassword === $confirmPassword){
                    $pwd = md5(md5($newPassword) . $userInfo['salt']);
                    $this->admin_model->modifyPassword($username, $pwd);
                    $this->redirect('/admin/user/logout');
                }else{
                    $data['passwordConfirmError'] = true;
                }
            }else{
                $data['passwordError'] = true;
            }
        }
        $this->load->view('admin/user_modify.html', $data);
    }
    
}
