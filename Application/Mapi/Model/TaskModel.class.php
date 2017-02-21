<?php
namespace Mapi\Model;
use Think\Model;
class TaskModel extends Model{

    public function createTask($_condition) {
        $this->setProperty('error','');
        $rules = array(
                array('cid', 'require', 'cid is required.', 1),
                array('cid', 'number', 'cid is error.', 1),
                array('did', 'require', 'did is required.', 1),
                array('did', 'number', 'did is error.', 1),
                array('start_time', 'require', 'start time is required.', 1),
                array('config', 'require', 'config is required.', 1),
            );
        $_is_start = $this->where(array('cid' => $_condition['uid'], 'did' => $_condition['did']))->order('id desc')->limit(1)->select();;
        if($_is_start && $_is_start[0]['status'] == 0){
            return array(
                    'success' => false,
                    'message' => 'Is started.',
                    'data' => array()
                );
        }else{
            $_condition['status'] = 0;
            $_create = $this->validate($rules)->create($_condition);
            if(!$_create){
                return array(
                        'success' => false,
                        'message' => $this->getError(),
                        'data' => array()
                    );
            }else{
                $_result = $this->add($_create);
                if($_result && $_result > 0){
                    return array(
                            'success' => true,
                            'message' => '',
                            'data' => $this->find($_result),
                        );
                }
                return array(
                        'success' => false,
                        'message' => 'Create failure.',
                        'data' => array()
                    );
            }
        }
    }

    public function stopTask($_where, $_save) {
        $this->setProperty('error','');
        $rules = array(
                array('stop_time', 'require', 'stop time is required.', 1),
            );
        $_save['status'] = 1;
        $_create = $this->validate($rules)->create($_save);

        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            //test
            $_res = $this->where($_where)->order('id desc')->limit(1)->select();
            $_result = $this->where($_where)->save($_create);
            if($_result && $_result > 0){
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => $this->find($_res[0]['id'])
                    );
            }
            return array(
                    'success' => false,
                    'message' => 'Update failure.',
                    'data' => array()
                );
        }
    }

    public function updateTask($_where, $_save) {
        $this->setProperty('error','');
        $rules = array(
                array('config', 'require', 'stop time is required.', 1),
            );
        // $_save['status'] = 1;
        $_create = $this->validate($rules)->create($_save);

        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            //test
            $_res = $this->where($_where)->order('id desc')->limit(1)->select();
            $_result = $this->where($_where)->save($_create);
            if($_result && $_result > 0){
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => $this->find($_res[0]['id'])
                    );
            }
            return array(
                    'success' => false,
                    'message' => 'Update failure.',
                    'data' => array()
                );
        }
    }

    public function gets($_where, $_order = '') {
        $_result = $this->where($_where)->order($_order)->select();
        return $_result;
    }

    public function get($_where) {
        $_result = $this->where($_where)->find();
        return $_result;
    }

}
?>