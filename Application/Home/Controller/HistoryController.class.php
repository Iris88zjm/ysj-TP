<?php
namespace Home\Controller;
use Think\Controller;
class HistoryController extends BaseController {
    public function index(){
        $_history_model = D('history');
        $_condition = array();
        $_list = $_history_model->gets($_condition, 'id desc', 10);
        foreach ($_list['list'] as $key => $value) {
            $_list['list'][$key]['diff'] = array_diff_assoc(json_decode($value['after_handle'], true), json_decode($value['before_handle'], true));
            $_list['list'][$key]['after_handle'] = json_decode($value['after_handle'], true);
        }
        $this->assign('list', $_list['list']);
        $this->assign('page', $_list['page']);
        $this->display();
    }
}