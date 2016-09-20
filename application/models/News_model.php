<?php
/**
 * 资讯
 * News_model.php
 * User: wlq314@qq.com
 * Date: 16/9/19 Time: 14:47
 */

class News_model extends MY_Model{

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;
    
    protected function setTableName()
    {
        return 'news';
        // TODO: Implement setTableName() method.
    }
    
    protected function setPrimary()
    {
        return 'id';
        // TODO: Implement setPrimary() method.
    }

    /**
     * 添加资讯
     * @param $title
     * @param $img
     * @param $order
     * @param $content
     * @return bool
     */
    public function addNew($title, $img, $order, $content){
        $data = [
            'title' => $title,
            'img' => $img,
            'order' => $order,
            'content' => $content
        ];
        return $this->insertData($data);
    }

    /**
     * 根据资讯ID更新信息
     * @param $id
     * @param $title
     * @param $img
     * @param $order
     * @param $content
     * @return mixed
     */
    public function updateNewById($id, $title, $img, $order, $content){
        $data = [
            'title' => $title,
            'img' => $img,
            'order' => $order,
            'content' => $content
        ];
        return $this->updateById($id, $data);
    }

    /**
     * 获得资讯列表
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getNews($limit, $offset){
        $field = '*';
        $cond = [];
        $order = ['status' => 'ASC', 'order' => 'DESC', 'createtime' => 'DESC'];
        return $this->getAllByCond($field, $cond, $order, $limit, $offset);
    }

    /**
     * 根据ID获得资讯信息
     * @param $id
     * @return array|bool
     */
    public function getNewById($id){
        return $this->getById($id);
    }

    /**
     * 状态删除资讯
     * @param $id
     * @return mixed
     */
    public function deleteNewById($id){
        $data = ['status' => self::STATUS_DELETE];
        return $this->updateById($id, $data);
    }

    /**
     * 重新发布已删除的资讯
     * @param $id
     * @return mixed
     */
    public function activeNewById($id){
        $data = ['status' => self::STATUS_ACTIVE];
        return $this->updateById($id, $data);
    }
    
}