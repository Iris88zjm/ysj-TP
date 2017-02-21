<?php
namespace Home\Controller;
use Think\Controller;
use Think\Auth;
class BaseController extends Controller {
    protected function _empty(){
        $this->redirect('/');
    }

    protected function _initialize(){
        if(session('uid') < 0 || !session('uid')){
            $this->redirect('/');
        }
        // $auth = new Auth();
        // $rule_name = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        // $result=$auth->check($rule_name, 1);
        // if(!$result){
        //     $this->error('您没有权限访问');
        // }
    }

}