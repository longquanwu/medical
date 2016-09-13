<?php
/**
 * Img.php
 * User: wlq314@qq.com
 * Date: 16/9/12 Time: 14:05
 */

class Img extends CI_Controller{
    
    /** @var  CI_Upload */
    public $upload;
    
    /** @var  CI_Image_lib */
    public $image_lib;

    public function index(){
        echo "
        <form method='post' action='/img/index' enctype='multipart/form-data'>
            <input type='file' name='file'>
            <input type='submit'>
        </form>
        ";
        if (isset($_FILES['file'])){
            $this->load->library('upload');
            if ($this->upload->do_upload('file')){
                print_r($this->upload->data());
                $config = [
                    'source_image' => $this->upload->data()['full_path'],
                    'width' => '50',
                    'height' => '50',
                    'new_image' => $this->upload->data()['file_path'] . $this->upload->data()['raw_name'] . '_small' . $this->upload->data()['file_ext'],
                ];
                $this->load->library('image_lib');
                $this->image_lib->source_image = $this->upload->data()['full_path'];
                $this->image_lib->initialize();
                print_r($this->image_lib);
                if (!$this->image_lib->resize())
                    echo $this->image_lib->display_errors();
            }else{
                var_dump($this->upload->display_errors());
            }
        }
    }
    
    public function small(){
        
    }
}