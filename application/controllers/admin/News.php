<?php
/**
 * News.php
 * User: wlq314@qq.com
 * Date: 16/9/14 Time: 16:36
 */

class News extends ADMIN_Controller{
    
    /** @var  News_model */
    public $news_model;
    
    public function __construct(){
        parent::__construct(true);
        $this->load->model('news_model');
    }

    /**
     * 资讯列表
     * TODO 分页,分条件查询
     */
    public function index(){
        $data['newsList'] = $this->news_model->getNews(0, 9999999);
        $this->load->view('admin/news.html', $data);
    }

    /**
     * 添加资讯
     */
    public function add(){
        $this->load->view('admin/new_edit.html');
    }

    /**
     * @param $id
     */
    public function edit($id){
        $data['newInfo'] = $this->news_model->getNewById($id);
        $this->load->view('admin/new_edit.html', $data);
    }

    /**
     * 保存
     */
    public function save(){
        $title = $this->input->post('title') ? $this->input->post('title', true) : "";
        $img = $this->input->post('img') ? trim($this->input->post('img', true)) : "";
        $order = $this->input->post('order') ? (int)$this->input->post('order', true) : 0;
        $content = $this->input->post('content');
        $id = $this->input->post('id');
        if ($id){
            $this->news_model->updateNewById($id, $title, $img, $order, $content);
            
        }else{
            $this->news_model->addNew($title, $img, $order, $content);
        }
        $this->redirect('/admin/news/index');
    }

    /**
     * 删除
     * @param $id
     */
    public function delete($id){
        $this->news_model->deleteNewById($id);
        $this->redirect('/admin/news/index');
    }

    /**
     * 重新发布资讯
     * @param $id
     */
    public function active($id){
        $this->news_model->activeNewById($id);
        $this->redirect('/admin/news/index');
    }
    
}