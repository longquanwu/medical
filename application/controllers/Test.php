<?php
/**
 * Test.php
 * User: wlq314@qq.com
 * Date: 16/9/7 Time: 11:31
 */

class Test extends MY_Controller{
    
    public function coslers(){
        $this->load->model('coslers_model', 'coslers');
        $res = $this->coslers->getAllInfo();
        print_r($res);
    }
    
    public function mail(){
        echo 1234;
        $this->load->library('Phpmail');
        $this->phpmail->send('wlq314@qq.com', '千杯注册验证码', '您好,您的千杯验证码为 233333');
    }
    
}