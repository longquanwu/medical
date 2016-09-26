<?php
/**
 * 百科表
 * Cyclopedia_model.php
 * User: wlq314@qq.com
 * Date: 16/9/26 Time: 14:26
 */

class Cyclopedia_model extends MY_Model{

    /** 药物百科 */
    const TYPE_MEDICINE = 1;

    /** 病情百科 */
    const TYPE_DISEASE = 2;

    /** 正常状态 */
    const ACTIVE_TYPE = 1;

    /** 逻辑删除状态 */
    const DELETE_TYPE = 2;

    /**
     * 设置表名
     * @return string
     */
    protected function setTableName(){
        return 'cyclopedia';
    }

    /**
     * 设置主键名
     * @return string
     */
    protected function setPrimary(){
        return 'id';
    }

    /**
     * 添加药物百科
     * @param $title  标题
     * @param $img  封面图片
     * @param $content  详情
     * @return bool
     */
    public function addMedicine($title, $img, $content){
        $data = [
            'type' => self::TYPE_MEDICINE,
            'title' => $title,
            'img' => $img,
            'content' => $content,
            'delete' => self::ACTIVE_TYPE,
        ];
        return $this->insertData($data);
    }

    /**
     * 添加病情百科
     * @param $title  标题
     * @param $img  封面图片
     * @param $content  详情
     * @return bool
     */
    public function addDisease($title, $img, $content){
        $data = [
            'type' => self::TYPE_DISEASE,
            'title' => $title,
            'img' => $img,
            'content' => $content,
            'delete' => self::ACTIVE_TYPE,
        ];
        return $this->insertData($data);
    }

    /**
     * 获得药物百科列表
     * @param int $begin
     * @param int $limit
     * @param string $search  搜索关键字,不传查询所有列表
     * @return mixed
     */
    public function medicineList($begin = 0, $limit = 10, $search = ''){
        $field = 'id, title, img, content, updatetime';
        $cond = ['delete' => self::ACTIVE_TYPE, 'type' => self::TYPE_MEDICINE];
        $order = ['convert(title using gbk)' => 'ASC', 'updatetime' => 'DESC'];
        $keyword = empty($search) ? [] : ['title' => $search];
        return $this->getAllByCond($field, $cond, $order, $begin, $limit, $keyword);
    }

    /**
     * 获得病情百科列表
     * @param int $begin
     * @param int $limit
     * @param string $search  搜索关键字,不传查询所有列表
     * @return mixed
     */
    public function diseaseList($begin, $limit, $search = ''){
        $field = 'id, title, img, content, updatetime';
        $cond = ['delete' => self::ACTIVE_TYPE, 'type' => self::TYPE_DISEASE];
        $order = ['convert(title using gbk)' => 'ASC', 'updatetime' => 'DESC'];
        $keyword = empty($search) ? [] : ['title' => $search];
        return $this->getAllByCond($field, $cond, $order, $begin, $limit, $keyword);
    }

    /**
     * 根据ID更新百科信息
     * @param $id  ID
     * @param $title  标题
     * @param $img  封面图片
     * @param $content  详情
     * @return mixed
     */
    public function update($id, $title, $img, $content){
        $data = [
            'title' => $title,
            'img' => $img,
            'content' => $content,
        ];
        return $this->updateById($id, $data);
    }

    /**
     * 根据ID获得详细的百科信息
     * @param $id
     * @return array|bool
     */
    public function get($id){
        return $this->getById($id);
    }

    /**
     * 逻辑删除
     * @param $id
     * @return mixed
     */
    public function delete($id){
        $data = ['delete' => self::DELETE_TYPE];
        return $this->updateById($id, $data);
    }

    /**
     * 根据关键字统计病情百科记录数
     * @param string $keyword
     * @return mixed
     */
    public function countDisease($keyword = ''){
        $cond = ['delete' => self::ACTIVE_TYPE, 'type' => self::TYPE_DISEASE];
        $keyword = empty($keyword) ? [] : ['title' => $keyword];
        return $this->countByCond($cond, $keyword);
    }

    /**
     * 根据关键字统计药物百科记录数
     * @param string $keyword
     * @return mixed
     */
    public function countMedicine($keyword = ''){
        $cond = ['delete' => self::ACTIVE_TYPE, 'type' => self::TYPE_MEDICINE];
        $keyword = empty($keyword) ? [] : ['title' => $keyword];
        return $this->countByCond($cond, $keyword);
    }

}