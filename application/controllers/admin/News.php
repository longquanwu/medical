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
     * @param int $page  分页
     */
    public function index($page = 1){
        $keyword = empty($_GET['keyword']) ? NULL : $_GET['keyword'];
        if (!empty($_POST['search'])){
            $page = 1;
            $keyword = $_POST['keyword'];
        }
        
        $pageSize = 10;
        $this->load->helper('paging');
        $count = $this->news_model->countAll($keyword);
        $data['pageString'] = paging_helper::run('/admin/news/index/{page}?keyword=' . $keyword, $count, $page, $pageSize);
        $begin = ($page - 1) * $pageSize;
        $data['newsList'] = $this->news_model->getNews($begin, $pageSize, $keyword);
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
            $this->logger->info("修改新闻 ID:{$id}, title:{$title}, img:{$img}, order:{$order}, content:{$content}");
            $this->news_model->updateNewById($id, $title, $img, $order, $content);
        }else{
            $newId = $this->news_model->addNew($title, $img, $order, $content);
            $this->logger->info("添加新闻 ID:{$newId}, title:{$title}, img:{$img}, order:{$order}, content:{$content}");
        }
        $this->redirect('/admin/news/index');
    }

    /**
     * 删除
     * @param $id
     */
    public function delete($id){
        $this->logger->info('状态删除新闻 ID:' . $id);
        $this->news_model->deleteNewById($id);
        $this->redirect('/admin/news/index');
    }

    /**
     * 重新发布资讯
     * @param $id
     */
    public function active($id){
        $this->logger->info('重新发布新闻 ID:' . $id);
        $this->news_model->activeNewById($id);
        $this->redirect('/admin/news/index');
    }
    
}