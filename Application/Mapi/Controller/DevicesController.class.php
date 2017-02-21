<?php
namespace Mapi\Controller;
use Think\Controller;
class DevicesController extends BaseController {

    public function gets() {
        $_cdevices_model = D('cdevices');
        $_result = $_cdevices_model->gets(array('yh_cdevices.cid' => $_POST['uid'], 'yh_cdevices.status' => 1));
        foreach ($_result as $key => $value) {
            $_task = M('task')->where(array('cid' => $_POST['uid'], 'did' => $value['id']))->order('id desc')->limit(1)->select();
            $_result[$key]['status'] = $_task['0']['status'];
            $_result[$key]['config'] = json_decode($_task['0']['config'], true);
        }
        $this->ajaxReturn(
            array(
                'success' => true,
                'message' => '',
                'data' => $_result,
            ),
            'json'
        );
    }

    public function get() {
        $_cdevices_model = D('cdevices');
        $_result = $_cdevices_model->get(array('yh_cdevices.cid' => $_POST['uid'], 'yh_cdevices.did' => $_POST['did']));
        $_task = M('task')->where(array('cid' => $_POST['uid'], 'did' => $_result['id']))->order('id desc')->limit(1)->select();
        $_result['status'] = $_task[0]['status'];
        $_result['config'] = json_decode($_task[0]['config'], true);
        $this->ajaxReturn(
            array(
                'success' => true,
                'message' => '',
                'data' => $_result,
            ),
            'json'
        );
    }


}