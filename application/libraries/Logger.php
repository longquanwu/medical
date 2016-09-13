<?php
/**
 * 日志类 服务器需编译SeasLog拓展
 * Logger.php
 * User: wlq314@qq.com
 * Date: 16/9/7 Time: 09:53
 */

class Logger{

    /**
     * Logger constructor.
     * @param array $dir
     */
    public function __construct(array $dir = []){
        $ci = &get_instance();
        $conf = $ci->config->item('seasLog');
        SeasLog::setBasePath($conf['basePath']);
        empty($dir) ? SeasLog::setLogger($conf['logger']) : SeasLog::setLogger($dir['dir']);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function debug($message, array $content = [], $module = ''){
        return SeasLog::debug($message."\n", $content, $module);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function info($message, array $content = [], $module = ''){
        return SeasLog::info($message."\n", $content, $module);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function notice($message, array $content = [], $module = ''){
        return SeasLog::notice($message."\n", $content, $module);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function warning($message, array $content = [], $module = ''){
        return SeasLog::warning($message."\n", $content, $module);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function error($message, array $content = [], $module = ''){
        return SeasLog::error($message."\n", $content, $module);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function critical($message, array $content = [], $module = ''){
        return SeasLog::critical($message."\n", $content, $module);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function alert($message, array $content = [], $module = ''){
        return SeasLog::alert($message."\n", $content, $module);
    }

    /**
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function emergency($message, array $content = [], $module = ''){
        return SeasLog::emergency($message."\n", $content, $module);
    }

    /**
     * @param $level
     * @param $message
     * @param array $content
     * @param string $module
     */
    public function log($level, $message, array $content = [], $module = ''){
        return SeasLog::log($level, $message."\n", $content, $module);
    }

}