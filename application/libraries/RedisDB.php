<?php
/**
 * Redis操作类
 * RedisDB.php
 * User: wlq314@qq.com
 * Date: 16/9/8 Time: 09:30
 */

class RedisDB{

    /** @var  CI */
    private $CI;

    /** @var  Redis */
    private $redis;

    /** @var  类的实例 */
    private static $_instance = null;

    /** @var  错误信息 */
    private $lastError = null;
    
    /** @var string KEY的前缀 */
    private $prefix = '';
    
    /**
     * 单例连接Redis,连接成功返回实例,失败返回False
     * @return RedisCache 类的实例|False
     */
    public static function getInstance(){
        if (self::$_instance === null){
            $class = __CLASS__;
            self::$_instance = new $class;
            if (self::$_instance->connectRedis() !== true)
                return false;
            self::$_instance->prefix = self::$_instance->CI->config->item('redis')['prefix'];
        }
        return self::$_instance;
    }

    /**
     * 连接Redis
     * @return bool
     */
    private function connectRedis(){
        $this->CI = &get_instance();
        $conf = $this->CI->config->item('redis');
        $this->redis = new Redis();
        try{
            if (!$this->redis->connect($conf['host'], $conf['port'], $conf['timeout'])){
                $this->lastError = 'Connect Redis Fail';
                return false;
            }
            if (!empty($conf['auth']) && !$this->redis->auth($conf['auth'])){
                $this->lastError = 'Redis Password Error';
                return false;
            }
        }catch (Exception $e){
            $this->lastError = $e->getMessage();
            return false;
        }
        return true;
    }
    
    /**
     * 获得错误信息
     * @return mixed
     */
    public static function getError(){
        return self::$_instance->lastError;
    }

    /**
     * 添加KEY => VALUE, 默认过期时间为1800秒. 
     * 当Redis中已存在KEY且为String类型时候会覆盖,其它类型则不会覆盖 返回False
     * @param $key
     * @param $value
     * @param int $timeout  0表示永久
     * @return bool
     */
    public function set($key, $value, $timeout = 1800){
        if ($this->exists($key) && $this->getKeyType($key) !== Redis::REDIS_STRING)
            return false;
        $key = $this->generateKeyName($key);
        if ($this->redis->set($key, $value) != true)
            return false;
        (int)$timeout > 0 && $this->redis->expire($key, $timeout);
        return true;
    }

    /**
     * 根据KEY获得Value
     * @param $key
     * @return bool|string
     */
    public function get($key){
        $key = $this->generateKeyName($key);
        return $this->redis->get($key);
    }

    /**
     * @param $keys
     * @return int
     */
    public function del($keys){
        if (is_array($keys)){
            foreach ($keys as &$key){
                $key = $this->generateKeyName($key);
            }
        }
        return $this->redis->del($keys);
    }

    /**
     * 设置HASH中的字段值
     * @param $key
     * @param $field
     * @param $value
     * @return int
     */
    public function hSet($key, $field, $value){
        $key = $this->generateKeyName($key);
        return $this->redis->hSet($key, $field, $value);
    }

    /**
     * 设置多个HASH字段值
     * @param $key
     * @param $fields
     * @return bool
     */
    public function hMset($key, $fields){
        $key = $this->generateKeyName($key);
        return $this->redis->hMset($key, $fields);
    }

    /**
     * 根据KEY和FILED获得对应的HASH中的值
     * @param $key
     * @param $field
     * @return string
     */
    public function hGet($key, $field){
        $key = $this->generateKeyName($key);
        return $this->redis->hGet($key, $field);
    }

    /**
     * 根据KEY获得HASH中全部的字段和值
     * @param $key
     * @return array
     */
    public function hGetAll($key){
        $key = $this->generateKeyName($key);
        return $this->redis->hGetAll($key);
    }

    /**
     * 根据KEY和FIELD删除对应的值,支持单个删除和多个删除
     * @param $key
     * @param $fields  单个删除传字段名, 多个删除传入字段名的数组
     * @return int|mixed
     */
    public function hDel($key, $fields){
        $key = $this->generateKeyName($key);
        if (is_array($fields)){
            array_unshift($fields, $key);
            return call_user_func_array([$this->redis, 'hDel'], $fields);
        }
        return $this->redis->hDel($key, $fields);
    }

    /**
     * 检测一个KEY是否存在
     * @param $key
     * @return bool
     */
    public function exists($key){
        $key = $this->generateKeyName($key);
        return $this->redis->exists($key);
    }

    /**
     * 通过SCAN获得KEY
     * @param int $iterator
     * @param string $pattern
     * @param int $count
     * @return array|bool
     * TODO 待测,貌似有问题
     */
    public function scan($iterator, $pattern = '*', $count = 20){
        $pattern = $this->generateKeyName($pattern);
        return $this->redis->scan($iterator, $pattern, $count);
        
    }

    /**
     * 获得全部key,应避免推荐使用,数据多的时候易阻塞
     * @param string $pattern
     * @return array
     */
    public function keys($pattern = '*'){
        $pattern = $this->generateKeyName($pattern);
        return $this->redis->keys($pattern);
    }

    /**
     * 设置KEY的过期时间
     * @param $key
     * @param $ttl
     * @return bool
     */
    public function expire($key, $ttl){
        $key = $this->generateKeyName($key);
        return $this->redis->expire($key, $ttl);
    }

    /**
     * 获得KEY的类型
     * @param $key
     * @return int
     */
    private function getKeyType($key){
        $key = $this->generateKeyName($key);
        return $this->redis->type($key);
    }

    /**
     * 生成带前缀的KEY
     * @param $key
     * @return string
     */
    private function generateKeyName($key){
        return $this->prefix . ':' . $key;
    }

}