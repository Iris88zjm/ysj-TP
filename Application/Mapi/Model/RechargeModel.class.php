<?php
namespace Mapi\Model;
use Think\Model;
class RechargeModel extends Model{

    // public function deviceUpdate($_device){
    //     if(!$this->create($_device)){
    //         return array(
    //                 'success' => false,
    //                 'message' => $this->getError(),
    //                 'data' => array()
    //             );
    //     }else{
    //         $_result = $this->save();
    //         return array(
    //                 'success' => true,
    //                 'message' => '',
    //                 'data' => $_result
    //             );
    //     }
    // }

    // public function gets($_condition) {
    //     $_list = $this->where($_condition)->select();
    //     return $_list;
    // }

    // public function get($_condition) {
    //     $_device = $this->where($_condition)->find();
    //     return $_device;
    // }

    public function createRecharge($_condition) {
        $this->setProperty('error','');
        $rules = array(
                array('cid', 'require', 'cid is required.', 1),
                array('cid', 'number', 'cid is error.', 1),
                array('did', 'require', 'did is required.', 1),
                array('did', 'number', 'did is error.', 1),
            );
        $_create = $this->validate($rules)->create($_condition);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_result = $this->add();
            if($_result && $_result > 0){
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => array()
                    );
            }
            return array(
                    'success' => false,
                    'message' => '',
                    'data' => array()
                );
        }
    }

}
?>