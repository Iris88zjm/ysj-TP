<?php
namespace Mapi\Controller;
use Think\Controller;
class EmptyController extends Controller{
    public function index(){
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
?>