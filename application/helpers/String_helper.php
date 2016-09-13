<?php
/**
 * String_helper.php
 * User: wlq314@qq.com
 * Date: 16/9/7 Time: 16:58
 */

class String_helper{

    /**
     * 格式化JSON串,并且按特定格式排列
     * @param $data
     * @return string
     */
    static public function formatJson($data){
        array_walk_recursive($data, function(&$val){
            $val !== true && $val !== false && $val !== null && $val = urlencode($val);
        });
        $data = json_encode($data);
        $data = urldecode($data);
        
        //缩进处理
        $ret = '';
        $pos = 0;
        $prevChar = '';
        $flag = true;
        
        for ($i = 0; $i <= strlen($data); $i++){
            $char = substr($data, $i, 1);
            if ($char == '"' && $prevChar != '\\'){
                $flag = !$flag;
            } else if (($char == '}' || $char == ']') && $flag){
                $ret .= "\n";
                $pos--;
                for ($j = 0; $j < $pos; $j++){
                    $ret .= '    ';
                }
            }
            $ret .= $char;
            if (($char == ',' || $char == '{' || $char == '[') && $flag){
                $ret .= "\n";
                if ($char == '{' || $char == '[')
                    $pos++;
                for ($j = 0; $j < $pos; $j++){
                    $ret .= '    ';
                }
            }
            $prevChar = $char;
        }
        return $ret;
    }
    
}