<?php
namespace Mapi\Controller;
use Think\Controller;
class TaskController extends Controller {

    // public function gets() {
    //     if(IS_POST){
    //         $_order_model = D('order');
    //         $_result = $_order_model->gets(array('cid' => $_POST['uid'], 'status' => $_POST['status']));
    //         $this->ajaxReturn(
    //             array(
    //                 'success' => true,
    //                 'message' => '',
    //                 'data' => $_result,
    //             ),
    //             'json'
    //         );
    //     }else{
    //         $this->ajaxReturn(
    //             array(
    //                 'success' => false,
    //                 'message' => 'Nothing request data.',
    //                 'data' => array(),
    //             ),
    //             'json'
    //         );
    //     }
    // }

    // public function get() {
    //     if(IS_POST){
    //         $_order_model = D('order');
    //         $_result = $_order_model->get(array('cid' => $_POST['uid'], 'id' => $_POST['id']));
    //         $this->ajaxReturn(
    //             array(
    //                 'success' => true,
    //                 'message' => '',
    //                 'data' => $_result,
    //             ),
    //             'json'
    //         );
    //     }else{
    //         $this->ajaxReturn(
    //             array(
    //                 'success' => false,
    //                 'message' => 'Nothing request data.',
    //                 'data' => array(),
    //             ),
    //             'json'
    //         );
    //     }
    // }

    public function startPost() {
        if(IS_POST){
            $_task_model = D('task');
            $_devices_model = D('devices');
            $_is_existed = $_task_model->where(array('cid' => $_POST['uid'], 'did' => $_POST['did']))->order('id desc')->limit(1)->select();
            if($_is_existed[0]['id'] > 0 && $_is_existed[0]['status'] == 0 ){
                $this->ajaxReturn(
                    array(
                        'success' => false,
                        'message' => '已经开启',
                        'data' => array(),
                    ),
                    'json'
                );
            }else{
                $_result = $_task_model->createTask(array('cid' => $_POST['uid'], 'did' => $_POST['did'], 'start_time' => $_POST['start_time'], 'config' => json_encode($_POST['config'])));
                $_lock = $_devices_model->deviceUpdate(array('id' => $_POST['did'], 'lock_user' => $_POST['uid']));
                $this->ajaxReturn($_result, 'json');
            }
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

    public function stopPost() {
        if(IS_POST){
            $_task_model = D('task');
            $_devices_model = D('devices');
            $_result = $_task_model->stopTask(array('cid' => $_POST['uid'], 'did' => $_POST['did'], 'status' => 0), array('stop_time' => $_POST['stop_time'], 'status' => 1));
            $_lock = $_devices_model->deviceUpdate(array('id' => $_POST['did'], 'lock_user' => 0));
            $_bill = $_result['data']['stop_time'] - $_result['data']['start_time'];
            if($_bill == 0){
                $_bill = 1;
            }
            $_device = $_devices_model->get($_POST['did']);
            $_balance = $_device['balance'] - $_bill;
            $_devices_model->save(array('id' => $_POST['did'], 'balance' => $_balance));
            $_result['data']['bill'] = $_bill;
            $_result['data']['balance'] = $_balance;
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

    public function update() {
        if(IS_POST){
            $_task_model = D('task');
            $_devices_model = D('devices');
            $_result = $_task_model->updateTask(array('cid' => $_POST['uid'], 'did' => $_POST['did'], 'status' => 0), array('config' => json_encode($_POST['config'])));
            $_lock = $_devices_model->deviceUpdate(array('id' => $_POST['did'], 'lock_user' => 0));
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

    // public function pic() {
    //     $image = new \Think\Image();
    //     $image->open('./Public/images/123.png');
    //     // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
    //     $image->thumb(20, 47)->save('./Public/thumb1.png');
    // }

}