<?php
/**
 * 帖子表
 *
 * Topic_model.php
 * User: wlq314@qq.com
 * Date: 16/9/27 Time: 15:44
 */

class Topic_model extends MY_Model{

    /** 正常状态 */
    const ACTIVE_TYPE = 1;

    /** 逻辑删除状态 */
    const DELETE_TYPE = 2;

    /** 普通社区 */
    const TYPE_COMMUNITY = 1;

    /** 心灵社区 */
    const TYPE_PSYCHOLOGY = 2;

    protected function setTableName(){
        return 'topic';
    }

    protected function setPrimary(){
        return 'id';
    }

    /**
     * 判断是否存在指定分类ID的帖子
     * 
     * @param $cid
     * @return mixed
     */
    public function checkExistByClassifyId($cid){
        $cond = ['cid' => $cid, 'type' => self::TYPE_COMMUNITY, 'delete' => self::ACTIVE_TYPE];
        return parent::countByCond($cond);
    }
    
}