<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends BaseController {
    public function dashboard(){
        $this->display();
    }

    public function logOut() {
        $_uid = session('uid');
        if(isset($_uid) === true && $_uid > 0){
            session(null);
            session('[destroy]');
            $this->redirect('/');
        }
        // $this->ajaxReturn(
        //         array(
        //             'success' => true,
        //             'message' => '',
        //             'data' => array(),
        //         ),
        //         'json'
        // );
    }
}