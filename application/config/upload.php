<?php
/**
 * 上传文件配置
 * upload.php
 * User: wlq314@qq.com
 * Date: 16/9/12 Time: 13:55
 */

$uploadPath = '/data/www/uploads/' . date('Y-m') . '/' . date('d') . '/';

if (!is_dir($uploadPath)){
    mkdir($uploadPath, 0777, TRUE);
}

$config['upload_path'] = $uploadPath;

$config['allowed_types'] = 'gif|jpg|png|pdf';

$config['file_name'] = '';

$config['file_ext_tolower'] = FALSE;

$config['overwrite'] = FALSE;

$config['max_size'] = 0;

$config['max_width'] = 0;

$config['max_height'] = 0;

$config['min_width'] = 0;

$config['min_height'] = 0;

$config['max_filename'] = 0;

$config['max_filename_increment'] = 100;

$config['encrypt_name'] = TRUE;

$config['remove_spaces'] = TRUE;

$config['detect_mime'] = TRUE;

$config['mod_mime_fix'] = TRUE;

