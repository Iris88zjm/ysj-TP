<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {

    protected function _initialize(){
        if(session('uid') && session('uid') > 0){
            $this->redirect('/admin/dashboard');
        }
    }

    public function index(){
        $this->display();
    }

    public function loginPost() {
        if(session('uid') && session('uid') > 0){
            $this->ajaxReturn(
                array(
                    'success' => true,
                    'message' => 'you have already logged.',
                    'data' => array(),
                ),
                'json'
            );
        }
        if(IS_POST){
            $_customer = D('admin');
            // $_customer_data['email'] = '12345678@qq.com';
            // $_customer_data['password'] = '1q2w3e4r';
            $_customer_data = $_POST;
            $_result = $_customer->logIn($_customer_data);
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