<?php
/**
 * 帖子分类
 * Classify.php
 * User: wlq314@qq.com
 * Date: 16/9/22 Time: 15:49
 */

class Classify extends ADMIN_Controller{
    
    /** @var  Classify_model */
    public $classify_model;
    
    /** @var  Topic_model */
    public $topic_model;

    public function __construct(){
        parent::__construct();
        $this->load->model('classify_model');
    }

    /**
     * 帖子分类列表
     */
    public function index(){
        $data['classifyList'] = $this->classify_model->classifyList();
        $this->load->view('admin/classify.html');
    }
    
    public function ajaxDelete($id){
        $data = ['code' => -1, 'msg' => ''];
        $this->load->model('topic_model');
        if ($this->topic_model->checkExistByClassifyId($id)){
            $data['msg'] = '存在该分类的帖子,无法删除';
        }else{
            if ($this->classify_model->delete($id)){
                $data['code'] = 0;
            }else{
                $data['msg'] = '请重试';
            }
        }
        echo json_encode($data);
    }

}