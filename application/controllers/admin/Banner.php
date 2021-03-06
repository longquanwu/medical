<?php
/**
 * Banner.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 16:31
 */

class Banner extends ADMIN_Controller{

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
     * Banner列表页面
     */
    public function index(){
        $data['bannerList'] = $this->banner_model->bannerList();
        $this->load->view('admin/banner.html', $data);
    }

    /**
     * 添加Banner
     */
    public function add(){
        $data['skip_type'] = $this->skip_type;
        $this->load->view('admin/banner_edit.html', $data);
    }

    /**
     * 编辑Banner
     * @param $id
     */
    public function edit($id){
        $data['skip_type'] = $this->skip_type;
        $data['bannerInfo'] = $this->banner_model->getInfoById($id);
        $this->load->view('admin/banner_edit.html', $data);
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
            $this->logger->info("添加新Banner图, IMG: {$img} , Type: {$skipType} , Info: {$skipInfo} " );
            $this->banner_model->addBanner($img, $skipType, $skipInfo);
        }else{
            $this->logger->info("修改Banner图 ID: {$id}, IMG: {$img} , Type: {$skipType} , Info: {$skipInfo} " );
            $this->banner_model->updateInfoById($id, $img, $skipType, $skipInfo);
        }
        $this->redirect('/admin/banner/index');
    }

    /**
     * 根据ID删除对应Banner
     * @param $id
     */
    public function delete($id){
        $this->logger->info("删除Banner图 ID: {$id}" );
        $this->banner_model->delete($id);
        $this->redirect('/admin/banner/index');
    }

}
