<?php
/**
 * paging_helper.php
 * User: wlq314@qq.com
 * Date: 16/9/23 Time: 09:19
 */

class paging_helper{

    /** @var string 分页标识,即在URL中的位置 */
    static public $flag = '{page}';
    
    /** @var int 分页栏最长个数 */
    static public $long = 10;

    /**
     * 分页方法
     * @param $url  分页URL
     * @param $count  总记录数
     * @param int $page  当前页
     * @param int $pageSize  每页显示数目
     * @return string
     */
    static public function run($url, $count, $page = 1, $pageSize = 10){
        if ($count < $pageSize || $pageSize < 1){
            return false;
        }
        
        $page = (int)$page;
        if ($page <= 1){
            $page = 1;
        }
        if ((int)self::$long < 3){
            self::$long = 3;
        }
        
        /** @var 总页数 $totalPage */
        $totalPage = ceil($count/$pageSize);
        
        /** @var 当前列 $row */
        $row = ceil($page/self::$long);
        
        $result = "<nav style='text-align: center'><ul class=\"pagination\">";
        
        if ($page > self::$long){
            $result .= "<li><a href='" . str_replace(self::$flag, 1, $url) . "'>首页</a><li>
                        <a href='" . str_replace(self::$flag, ($row - 1) * self::$long, $url) . "'><<</a></li></li>";
        }
        
        for ($start = ($row * self::$long - self::$long + 1); ($start <= $row * self::$long) && ($start <= $totalPage); $start ++){
            if ($start == $page){
                $result .= "<li class='active'><a href='" . str_replace(self::$flag, $start, $url) . "'>{$start}</a></li>";
            }else{
                $result .= "<li><a href='" . str_replace(self::$flag, $start, $url) . "'>{$start}</a></li>";
            }
        }
        
        if ($row * self::$long < $totalPage){
            $result .= "<li><a href='" . str_replace(self::$flag, $row * self::$long + 1, $url) . "'>>></a></li>
                        <li><a href='" . str_replace(self::$flag, $totalPage, $url) . "'>末页</a></li>";
        }

        $result .= "</ul></nav>";
        
        return $result;
    }

}