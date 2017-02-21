<?php
namespace Mapi\Model;
use Think\Model;
class DevicesModel extends Model{

    public function deviceUpdate($_params){
        $this->setProperty('error','');
        $rules = array(
                array('id', 'require', 'id is required.', 1),
                array('status', 'require', 'status is required.', 1),
            );
        $_create = $this->validate($rules)->create($_params);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_result = $this->save();
            return array(
                    'success' => true,
                    'message' => '',
                    'data' => $_result
                );
        }
    }

    // public function gets($_condition) {
    //     $_list = $this->where($_condition)->select();
    //     return $_list;
    // }

    public function get($_id) {
        $_device = $this->find($_id);
        return $_device;
    }

}
?>