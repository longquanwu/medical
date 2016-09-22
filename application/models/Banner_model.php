<?php
/**
 * Banner_model.php
 * User: wlq314@qq.com
 * Date: 16/9/21 Time: 14:42
 */

class Banner_model extends MY_Model{
    
    const TYPE_BANNER = 1;
    const TYPE_LOAD = 2;
    
    const ACTIVE_TYPE = 1;
    const DELETE_TYPE = 2;

    protected function setTableName(){
        return 'banner';
    }
    
    protected function setPrimary(){
        return 'id';
    }

    /**
     * 添加Load
     * @param $img
     * @param $skip_type
     * @param $skip_info
     * @return bool
     */
    public function addLoad($img, $skip_type, $skip_info){
        $data = [
            'type' => self::TYPE_LOAD,
            'img' => $img,
            'skip_type' => $skip_type,
            'skip_info' => $skip_info,
        ];
        return $this->insertData($data);
    }

    /**
     * 添加Banner
     * @param $img
     * @param $skip_type
     * @param $skip_info
     * @return bool
     */
    public function addBanner($img, $skip_type, $skip_info){
        $data = [
            'type' => self::TYPE_BANNER,
            'img' => $img,
            'skip_type' => $skip_type,
            'skip_info' => $skip_info,
        ];
        return $this->insertData($data);
    }

    /**
     * 获得Banner列表
     * @return mixed
     */
    public function bannerList(){
        $field = 'id, img, skip_type, skip_info, update_time';
        $cond = ['type' => self::TYPE_BANNER, 'delete' => self::ACTIVE_TYPE];
        $order = ['update_time' => 'DESC'];
        return $this->getAllByCond($field, $cond, $order);
    }

    /**
     * 获得Load列表
     * @return mixed
     */
    public function loadList(){
        $field = 'id, img, skip_type, skip_info, update_time';
        $cond = ['type' => self::TYPE_LOAD, 'delete' => self::ACTIVE_TYPE];
        $order = ['update_time' => 'DESC'];
        return $this->getAllByCond($field, $cond, $order);
    }

    /**
     * 根据ID获得Banner或Load的信息
     * @param $id
     * @return array|bool
     */
    public function getInfoById($id){
        return $this->getById($id);
    }

    /**
     * 修改信息
     * @param $id
     * @param $img  图片地址
     * @param $skipType  跳转类型
     * @param $skipInfo  跳转关联信息
     * @return mixed
     */
    public function updateInfoById($id, $img, $skipType, $skipInfo){
        $data = [
            'img' => $img,
            'skip_type' => $skipType,
            'skip_info' => $skipInfo,
        ];
        return $this->updateById($id, $data);
    }

    /**
     * 根据ID删除对应Banner或Load  逻辑删除
     * @param $id
     * @return mixed
     */
    public function delete($id){
        $data = ['delete' => self::DELETE_TYPE];
        return $this->updateById($id, $data);
    }
    
}
