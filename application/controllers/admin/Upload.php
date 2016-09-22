<?php
/**
 * Upload.php
 * User: wlq314@qq.com
 * Date: 16/9/19 Time: 11:06
 */

class Upload extends ADMIN_Controller{

    /** @var  CI_Upload */
    public $upload;

    /** @var  CI_Image_lib */
    public $image_lib;

    /**
     * 上传图片,并生成缩略图,返回缩略图
     * @param bool $thumb  为False 返回原图, True 返回缩略图
     * @param string $file  文件字段名
     */
    public function index($thumb = true, $file = 'file_data'){
        
        $code = -1;
        $msg = '未找到上传的文件';

        if (isset($_FILES[$file])){
            $this->load->library('upload');
            if ($this->upload->do_upload($file)){
                $this->load->library('image_lib');
                $this->image_lib->source_image = $this->upload->data()['full_path'];
                $this->image_lib->initialize();
                if (!$this->image_lib->resize()){
                    $msg = $this->image_lib->display_errors();
                }else{
                    $code = 0;
                    if ($thumb === true){
                        $msg = str_replace(UPLOAD_PATH, UPLOAD_URL, $this->image_lib->full_dst_path);
                    }else{
                        $msg = str_replace(UPLOAD_PATH, UPLOAD_URL, $this->image_lib->full_src_path);
                    }
                }
            }else{
                $msg = $this->upload->display_errors();
            }
        }
        echo json_encode(['code' => $code, 'msg' => $msg], true);
    }
    
}