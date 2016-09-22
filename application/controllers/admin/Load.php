<?php
/**
 * 引导广告图
 * Load.php
 * User: wlq314@qq.com
 * Date: 16/9/21 Time: 14:28
 */

class Load extends ADMIN_Controller{
    
    /** @var  Banner_model */
    public $banner_model;

    /** @var array 跳转分类 */
    private $skip_type = [
        '1' => '资讯',
        '2' => '病情百科',
        '3' => '药物百科',
        '4' => '帖子',
    ];
    
    public function __construct(){
        parent::__construct();
        $this->load->model('banner_model');
    }

    /**
     * 引导图列表页面
     */
    public function index(){
        $data['loadList'] = $this->banner_model->loadList();
        $this->load->view('admin/load.html', $data);
    }

    /**
     * 添加引导图
     */
    public function add(){
        $data['skip_type'] = $this->skip_type;
        $this->load->view('admin/load_edit.html', $data);
    }

    /**
     * 编辑引导图
     * @param $id
     */
    public function edit($id){
        $data['skip_type'] = $this->skip_type;
        $data['loadInfo'] = $this->banner_model->getInfoById($id);
        $this->load->view('admin/load_edit.html', $data);
    }

    /**
     * 保存编辑的信息
     */
    public function save(){
        $id = $this->input->post('id', true);
        $img = $this->input->post('img') ? trim($this->input->post('img', true)) : '';
        $skipType = $this->input->post('skipType') ? trim($this->input->post('skipType', true)) : 1;
        $skipInfo = $this->input->post('skipInfo') ? trim($this->input->post('skipInfo', true)) : '';
        
        if (empty($id)){
            $this->logger->info("添加新Load图, IMG: {$img} , Type: {$skipType} , Info: {$skipInfo} " );
            $this->banner_model->addLoad($img, $skipType, $skipInfo);
        }else{
            $this->logger->info("修改Load图 ID: {$id}, IMG: {$img} , Type: {$skipType} , Info: {$skipInfo} " );
            $this->banner_model->updateInfoById($id, $img, $skipType, $skipInfo);
        }
        $this->redirect('/admin/load/index');
    }

    /**
     * 根据ID删除对应LOAD
     * @param $id
     */
    public function delete($id){
        $this->logger->info("删除Load图 ID: {$id}" );
        $this->banner_model->delete($id);
        $this->redirect('/admin/load/index');
    }
    
}
