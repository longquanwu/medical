<?php
/**
 * 病情百科
 * Disease.php
 * User: wlq314@qq.com
 * Date: 16/9/22 Time: 15:49
 */

class Disease extends ADMIN_Controller{
    
    /** @var  Cyclopedia_model */
    public $cyclopedia_model;
    
    public function __construct(){
        parent::__construct();
        $this->load->model('cyclopedia_model');
    }

    /**
     * 病情百科列表
     * @param int $page
     */
    public function index($page = 1){
        $search = empty($_GET['search']) ? '' : $_GET['search'];
        if (!empty($_POST['search'])){
            $page = 1;
            $search = $_POST['search'];
        }
        $pageSize = 10;
        
        $this->load->helper('paging');
        $count = $this->cyclopedia_model->countDisease($search);
        $data['pageString'] = paging_helper::run('/admin/disease/index/{page}?search=' . $search, $count, $page, $pageSize);
        
        $begin = ($page - 1) * $pageSize;
        $data['diseaseList'] = $this->cyclopedia_model->diseaseList($begin, $pageSize, $search);
        $this->load->view('admin/disease.html', $data);
    }

    /**
     * 添加新的病情百科
     */
    public function add(){
        $this->load->view('admin/disease_edit.html');
    }

    /**
     * 编辑信息
     * @param $id
     */
    public function edit($id){
        $data['info'] = $this->cyclopedia_model->get($id);
        $this->load->view('admin/disease_edit.html', $data);
    }

    /**
     * 保存信息
     */
    public function save(){
        $title = $this->input->post('title') ? $this->input->post('title', true) : "";
        $img = $this->input->post('img') ? trim($this->input->post('img', true)) : "";
        $content = $this->input->post('content');
        $id = $this->input->post('id');
        if (empty($id)){
            $this->logger->info("添加病情百科 title:{$title}, img:{$img}, content:{$content}");
            if ($this->cyclopedia_model->addDisease($title, $img, $content)){
                $this->logger->info("添加病情百科 title:{$title}, img:{$img}, content:{$content}");
            }else{
                $this->logger->error("添加病情百科 title:{$title}, img:{$img}, content:{$content}");
            }
        }else{
            if ($this->cyclopedia_model->update($id, $title, $img, $content)){
                $this->logger->info("修改病情百科 ID:{$id}, img:{$img}, content:{$content}");
            }else{
                $this->logger->error("修改病情百科 ID:{$id}, img:{$img}, content:{$content}");
            }
        }
        $this->redirect('/admin/disease/index');
    }

    /**
     * 根据ID删除对应病情百科
     * @param $id
     */
    public function delete($id){
        $this->cyclopedia_model->delete($id);
        $this->redirect('/admin/disease/index');
    }

}