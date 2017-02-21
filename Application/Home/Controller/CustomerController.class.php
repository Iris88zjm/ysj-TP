<?php
namespace Home\Controller;
use Think\Controller;
class CustomerController extends BaseController {
    public function index() {
        $_customer_model = D('customer');
        $_condition['id'] = array();
        $_list = $_customer_model->gets($_condition, 'uid desc', 10);
        $this->assign('list', $_list['list']);
        $this->assign('page', $_list['page']);
        $this->display();
    }
    public function edit() {
        if($_GET['id'] && $_GET['id'] > 0){
            $_customer_model = D('customer');
            $_result = $_customer_model->get(array('uid' => $_GET['id']));
            if(count($_result) > 0){
                $this->assign('customer', $_result);
                $this->display();
            }else{
                $this->redirect('/customer');
            }
        }else{
            $this->redirect('/customer');
        }
    }
}