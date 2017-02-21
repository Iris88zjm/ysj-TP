<?php
namespace Mapi\Model;
use Think\Model;
class CdevicesModel extends Model{

    public function gets($_condition, $_order = '') {
        $_list = $this->where($_condition)->order($_order)->join('LEFT JOIN yh_devices ON yh_cdevices.did = yh_devices.id')->field(array('yh_cdevices.device_name', 'yh_devices.*'))->select();
        return $_list;
    }

    public function get($_condition) {
        $_list = $this->where($_condition)->join('yh_devices ON yh_cdevices.did = yh_devices.id')->field(array('yh_cdevices.id'=> 'cdid', 'yh_cdevices.device_name', 'yh_devices.*'))->find();
        return $_list;
    }

    public function cdeviceCreate($_condition) {
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
            $_result = $this->add($_create);
            if($_result && $_result > 0){
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => $_result
                    );
            }
            return array(
                    'success' => false,
                    'message' => 'Create failure.',
                    'data' => array()
                );
        }
    }

    public function cdeviceUpdate($_where, $_save) {
        $this->setProperty('error','');
        $rules = array(
                array('cid', 'require', 'cid is required.', 1),
                array('cid', 'number', 'cid is error.', 1),
                array('did', 'require', 'did is required.', 1),
                array('did', 'number', 'did is error.', 1),
            );
        $_create = $this->validate($rules)->create($_where);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_result = $this->where($_where)->save($_save);
            if($_result && $_result > 0){
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => $this->where($_where)->find()
                    );
            }
            return array(
                    'success' => false,
                    'message' => 'Update failure.',
                    'data' => array()
                );
        }
    }

    public function cdeviceDel($_where) {
        $this->setProperty('error','');
        $rules = array(
                array('cid', 'require', 'cid is required.', 1),
                array('cid', 'number', 'cid is error.', 1),
                array('did', 'require', 'did is required.', 1),
                array('did', 'number', 'did is error.', 1),
            );
        $_create = $this->validate($rules)->create($_where);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_new = $this->where($_where)->find();
            $_result = $this->where($_where)->save(array('status' => 0));
            if($_result && $_result > 0){
                return array(
                        'success' => true,
                        'message' => 'Delete success.',
                        'data' => $_where
                    );
            }
            return array(
                    'success' => false,
                    'message' => $_where,
                    'data' => $_new
                );
        }
    }

}
?>