<?php
namespace Mapi\Controller;
use Think\Controller;
class BaseController extends Controller {
    protected function _empty(){
        $this->ajaxReturn(
            array(
                'success' => false,
                'message' => '非法请求',
                'data' => array(),
            ),
            'json'
        );
    }

    protected function _initialize(){
        // $_authorization = explode(":", base64_decode(substr($request->header('Authorization'), 6)));
        // $_params['uid'] = $_authorization[0];
        // $_params['token'] = $_authorization[1];
        if(isset($_POST['uid']) === true && isset($_POST['token']) === true && $_POST['uid'] > 0 && strlen($_POST['token']) == 32){
            $_customer_model = D('customer');
            $_result = $_customer_model->get(array('uid' => $_POST['uid'], 'token' => $_POST['token']));
            if(!$_result || $_result['uid'] < 1){
                $this->ajaxReturn(
                        array(
                            'success' => -1,
                            'message' => '账号已在其它地方登录',
                            'data' => array(),
                        ),
                        'json'
                    );
            }
        }else{
            $this->ajaxReturn(
                    array(
                        'success' => -1,
                        'message' => '账号未登录',
                        'data' => array(),
                    ),
                    'json'
                );
        }
    }
}