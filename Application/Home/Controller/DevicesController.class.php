<?php
namespace Home\Controller;
use Think\Controller;
class DevicesController extends BaseController {
    public function index(){
        $_devices_model = D('adevices');
        $_condition = array('aid' => session('uid'));
        $_list = $_devices_model->gets($_condition, 'yh_adevices.id desc', 10);
        $this->assign('list', $_list['list']);
        $this->assign('page', $_list['page']);
        $this->display();
    }

    public function newpage() {
        $this->display();
    }
    //厂家导入设备
    public function newPost() {
        if(IS_POST){
            $_devices_model = D('devices');
            $_adevices_model = D('adevices');
            $_result = $_devices_model->deviceCreate($_POST);
            if($_result['success'] === true && $_result['data'] > 0){
                //关联用户与设备
                $_adevices_model->adeviceCreate(array('did' => $_result['data']));
            }
            $this->ajaxReturn($_result, 'json');
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
                    $_result = $_devices_model->deviceCreate($value);
                    if($_result['success'] === true && $_result['data'] > 0){
                        //关联用户与设备
                        $_adevices_model->adeviceCreate(array('did' => $_result['data']));
                        $_is_insert++;
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

    public function edit() {
        if($_GET['id'] && $_GET['id'] > 0){
            $_devices_model = D('devices');
            $_result = $_devices_model->get(array('id' => $_GET['id']));
            if(count($_result) > 0){
                $this->assign('device', $_result);
                $this->display();
            }else{
                $this->redirect('/devices');
            }
        }else{
            $this->redirect('/devices');
        }
    }

    public function editPost() {
        $_devices_model = D('devices');
        $_result = $_devices_model->deviceUpdate($_POST);
        $this->ajaxReturn($_result, 'json');
    }

    public function history() {
        if($_GET['id'] && $_GET['id'] > 0){
            $_devices_model = D('devices');
            $_count = $_devices_model->where(array('yh_devices.id' => $_GET['id']))->join('RIGHT JOIN yh_cdevices ON yh_devices.id = yh_cdevices.did')->join('RIGHT JOIN yh_task ON yh_cdevices.cid = yh_task.cid AND yh_cdevices.did = yh_task.did')->count();
            $_page = new \Org\Util\Page($_count, 333);
            $_page->setConfig('theme','%HEADER%<div class="link-page">%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%</div>');
            $_page->setConfig('header','<span class="records"> %TOTAL_ROW% 条记录 </span>');
            $_page->setConfig('first', '首页');
            $_page->setConfig('last', '末页');
            $_show = $_page->show();
            $_list = $_devices_model->where(array('yh_devices.id' => $_GET['id']))->join('RIGHT JOIN yh_cdevices ON yh_devices.id = yh_cdevices.did')->join('RIGHT JOIN yh_task ON yh_cdevices.cid = yh_task.cid AND yh_cdevices.did = yh_task.did')->limit($_page->firstRow.','.$_page->listRows)->select();

            // $_result = $_devices_model->get(array('id' => $_GET['id']));
            // if(count($_result) > 0){
            //     $this->assign('device', $_result);
            //     $this->display();
            // }else{
            //     $this->redirect('/devices');
            // }
            var_dump($_list);
        }else{
            // $this->redirect('/devices');
        }
    }
}