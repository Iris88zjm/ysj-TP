<?php
namespace Home\Controller;
use Think\Controller;
class AdevicesController extends BaseController {
    //分销商导入设备
    public function import() {
        $_devices_model = D('devices');
        $_adevices_model = D('adevices');
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => './Uploads/csv/',
            'savePath' => '',
            // 'mimes' => 'csv',
            'saveName' => array('uniqid','csv_'),
            'exts' => array('csv'),
            'autoSub' => true,
            'subName' => array('date','Ym'),
        );
        $upload = new \Think\Upload($config);
        $info   =   $upload->uploadOne($_FILES['csv_file']);
        if(!$info){
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => '',
                    'data' => array()
                ),
                'json'
            );
        }else{
            $_is_insert = 0;
            $file_path = './Uploads/csv/'.$info['savepath'].'/'.$info['savename'];
            if(file_exists($file_path)){
                $_handle = fopen($file_path,'r');
                while ($_data = fgetcsv($_handle)) {
                    $devices[] = $_data;
                }
                foreach ($devices as $key => $value) {
                    if($key != 0){
                        foreach ($devices['0'] as $k => $v) {
                            $_devices[$key-1][$v] = $value[$k];
                        }
                    }
                }
                foreach ($_devices as $value) {
                    $_result = $_devices_model->get($value);
                    if($_result && $_result['id'] > 0){
                        $_new = $_adevices_model->adeviceCreate(array('did' => $_result['id']));
                        if($_new['success'] === true && $_new['data'] > 0){
                            $_is_insert++;
                        }
                    }
                }
            }
            $this->ajaxReturn(array(
                    'success' => true,
                    'message' => '',
                    'data' => $_is_insert
                ),
                'json'
            );
        }
    }

    public function newPost() {
        if(IS_POST){
            $_devices_model = D('devices');
            $_adevices_model = D('adevices');
            $_result = $_devices_model->deviceCreate($_POST);
            if($_result && $_result['id'] > 0){
                $_adevices_model->adeviceCreate(array('did' => $_result['id']));
                $this->ajaxReturn($_result, 'json');
            }
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => '',
                    'data' => array(),
                ),
                'json'
            );
        }else{
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => 'Nothing request data.',
                    'data' => array(),
                ),
                'json'
            );
        }
    }
}