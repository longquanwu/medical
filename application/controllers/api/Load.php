<?php
/**
 * Load.php
 * User: wlq314@qq.com
 * Date: 16/9/30 Time: 09:48
 */

class Load extends API_Controller{
    
    /** @var  Banner_model */
    public $banner_model;
    
    public function __construct(){
        parent::__construct();
        $this->load->model('banner_model');
    }

    /**
     * Load图
     */
    public function index(){
        $res['datalist'] = [];
        $loadList = $this->banner_model->loadList();
        if (!empty($loadList) && is_array($loadList)){
            foreach ($loadList as $item) {
                $row['img'] = $item['img'];
                $row['type'] = $item['skip_type'];
                $row['info'] = $item['skip_info'];
                $res['datalist'][] = $row;
            }
        }
        $this->output($res);
    }
    
}