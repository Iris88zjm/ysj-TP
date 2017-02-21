<?php
namespace Mapi\Controller;
use Think\Controller;
class RechargeController extends BaseController {

    public function createPost() {
        if(IS_POST){
            $_recharge_model = D('recharge');
            $_result = $_recharge_model->createRecharge($_POST);
            $this->ajaxReturn($_result, 'json');
        }
        $this->ajaxReturn(
            array(
                'success' => false,
                'message' => '非法请求',
                'data' => array(),
            ),
            'json'
        );
    }

}