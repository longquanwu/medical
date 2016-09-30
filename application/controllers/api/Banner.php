<?php
/**
 * Banner.php
 * User: wlq314@qq.com
 * Date: 16/9/29 Time: 16:24
 */

class Banner extends API_Controller{
    
    /** @var  Banner_model */
    public $banner_model;
    
    public function __construct(){
        parent::__construct();
        $this->load->model('banner_model');
    }

    /**
     * Banner列表
     */
    public function index(){
        $res['datalist'] = [];
        $bannerList = $this->banner_model->bannerList();
        if (!empty($bannerList) && is_array($bannerList)){
            foreach ($bannerList as $item) {
                $row['img'] = $item['img'];
                $row['type'] = $item['skip_type'];
                $row['info'] = $item['skip_info'];
                $res['datalist'][] = $row;
            }
        }
        $this->output($res);
    }

}