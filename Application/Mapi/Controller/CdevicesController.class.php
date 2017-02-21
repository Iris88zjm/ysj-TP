<?php
namespace Mapi\Controller;
use Think\Controller;
class CdevicesController extends BaseController {

    public function createPost() {
        $_cdevices_model = D('cdevices');
        $_devices_model = M('devices');
        $_device = $_devices_model->where(array('uuid' => $_POST['uuid']))->find();
        if(isset($_device) === false || $_device['id'] < 1){
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => 'Without the device.',
                    'data' => array(),
                ),
                'json'
            );
        }
        $_is_existed = $_cdevices_model->where(array('cid' => $_POST['uid'], 'did' => $_device['id']))->order('id desc')->limit(1)->select();
        if($_is_existed[0]['id'] > 0 && $_is_existed[0]['status'] == 1 ){
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => 'Already created.',
                    'data' => array()
                ), 
                'json'
            );
        }elseif($_is_existed[0]['id'] > 0 && $_is_existed[0]['status'] == 0 ){
            $_result = $_cdevices_model->cdeviceUpdate(array('id' => $_is_existed[0]['id'], 'cid' => $_POST['uid'], 'did' => $_device['id']), array('status' => 1));
            $this->ajaxReturn($_result, 'json');
        }
        $_create['cid'] = $_POST['uid'];
        $_create['did'] = $_device['id'];
        $_result = $_cdevices_model->cdeviceCreate($_create);
        $this->ajaxReturn($_result, 'json');
    }

    public function updatePost() {
        if(IS_POST){
            $_cdevices_model = D('cdevices');
            $_where['cid'] = $_POST['uid'];
            $_where['did'] = $_POST['did'];
            $_save['device_name'] = $_POST['device_name'];
            $_result = $_cdevices_model->cdeviceUpdate($_where, $_save);
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

    public function delPost() {
        if(IS_POST){
            $_cdevices_model = D('cdevices');
            $_del['cid'] = $_POST['uid'];
            $_del['did'] = $_POST['did'];
            $_result = $_cdevices_model->cdeviceDel($_del);
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

}