<?php
/**
 * MY_Controller.php
 * User: wlq314@qq.com
 * Date: 16/9/7 Time: 08:45
 */

/**
 * API父类控制器
 * Class API_Controller
 */
abstract class API_Controller extends CI_Controller{
    
    //加密串
    const KEY = 'qwerdfb';
    
    /** @var  Logger */
    public $logger;

    //用户登录状态 
    protected $isLogin = false;
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('string');
//        $this->checkDevice();
        $this->load->library('Logger', ['dir' => 'api']);
    }

    /**
     * 检测请求设备的合法性
     */
    private function checkDevice(){
        $data['DEVICEID'] = isset($_SERVER['HTTP_DEVICEID']) ? $_SERVER['HTTP_DEVICEID'] : '';
        $data['APPVERSION'] = isset($_SERVER['HTTP_APPVERSION']) ? $_SERVER['HTTP_APPVERSION'] : '';
        $data['SCREENWIDTH'] = isset($_SERVER['HTTP_SCREENWIDTH']) ? $_SERVER['HTTP_SCREENWIDTH'] : '';
        $data['SCREENHEIGHT'] = isset($_SERVER['HTTP_SCREENHEIGHT']) ? $_SERVER['HTTP_SCREENHEIGHT'] : '';
        $key = isset($_SERVER['HTTP_KEY']) ? $_SERVER['HTTP_KEY'] : '';
        if ($key !== md5($data['DEVICEID'] . $data['APPVERSION'] . self::KEY))
            $this->output([], -1000, '非法的设备请求');
    }

    /**
     * 输出方法
     * @param array $data  数据
     * @param int $code  返回码,0表示成功,非0表示错误
     * @param string $msg  提示信息
     */
    protected function output($data, $code = 0, $msg = ''){
        $data['code'] = (int)$code;
        $data['msg'] = $msg;
        if (isset($_GET["debug"])) {
            $debug = intval($_GET["debug"]);
            if ($debug == 1) {
                header("Content-type: text/html; charset=utf-8");
                print_r("<pre>");
                print_r($data);
                print_r("</pre>");
                exit;
            }
            if ($debug == 2) {
                header("Content-type: text/html; charset=utf-8");
                echo "<pre>";
                echo String_helper::formatJson($data);
                echo "</pre>";
                exit;
            }
        }
        header("Content-Type:application/json;charset=utf-8");
        echo json_encode($data);
        exit();
    }

}

/**
 * 后台父类控制器
 * Class ADMIN_Controller
 */
abstract class ADMIN_Controller extends CI_Controller{
    
    /** @var  Logger */
    public $logger;

    /** @var  CI_Session */
    public $session;
    
    public function __construct($check = true){
        parent::__construct();
        $this->load->library('Logger', ['dir' => 'admin']);
        $this->load->library('session');
        $check && $this->checkLogin();
    }
    
    /**
     * 控制器跳转
     * @param $url
     */
    protected function redirect($url){
        header('location:' . $url);
        exit;
    }

    /**
     * 检查是否登录
     */
    private function checkLogin(){
        empty($this->session->user) && $this->redirect('/admin/Login');
    }

}