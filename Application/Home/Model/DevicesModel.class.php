<?php
namespace Home\Model;
use Think\Model;
class DevicesModel extends Model{

    protected $_validate = array(
            array('uuid', 'require', 'uuid is required.', 1),
            array('uuid', '', 'Device is existed.', 0, 'unique', 1),
        );
    // protected $_auto = array(
    //         array('password', 'md5', 3, 'function'),
    //         array('user_registered', 'time', 1, 'function'),
    //     );

    public function deviceCreate($_device) {
        $this->setProperty('error','');
        if(!$this->create($_device)){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_result = $this->add();
            if($_result > 0){
                $_params['table_name'] = 'devices';
                $_params['curd'] = 1;
                $_params['before_handle'] = json_encode(array());
                $_params['after_handle'] = json_encode($this->find($_result));
                addHistory($_params);
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => $_result
                    );
            }else{
                return array(
                        'success' => false,
                        'message' => '',
                        'data' => array()
                    );
            }
        }
    }

    public function deviceUpdate($_device){
        $this->setProperty('error','');
        $rules = array(
                array('id', 'require', 'ID is required.', 1),
            );
        $_create = $this->validate($rules)->create($_device);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_before_handle = $this->find($_device['id']);
            $_result = $this->save($_create);
            if($_result > 0){
                $_params['table_name'] = 'devices';
                $_params['curd'] = 2;
                $_params['before_handle'] = json_encode($_before_handle);
                $_params['after_handle'] = json_encode($this->find($_device['id']));
                addHistory($_params);
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => $_result
                    );
            }else{
                return array(
                        'success' => false,
                        'message' => '',
                        'data' => array()
                    );
            }
        }
    }

    public function gets($_condition, $_order, $_is_paged = false) {
        if($_is_paged !== false && $_is_paged > 0){
            $_count = $this->where($_condition)->count();
            $_page = new \Org\Util\Page($_count, $_is_paged);
            $_page->setConfig('theme','%HEADER%<div class="link-page">%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%</div>');
            $_page->setConfig('header','<span class="records"> %TOTAL_ROW% 条记录 </span>');
            $_page->setConfig('first', '首页');
            $_page->setConfig('last', '末页');
            $_show = $_page->show();
            $_list = $this->where($_condition)->order($_order)->limit($_page->firstRow.','.$_page->listRows)->join('yh_customer ON yh_devices.lock_user = yh_customer.uid', 'LEFT')->field('yh_customer.username, yh_devices.*')->select();
            return array(
                    'list' => $_list,
                    'page' => $_show
                );
        }else{
            $_list = $this->where($_condition)->order($_order)->join('yh_customer ON yh_devices.lock_user = yh_customer.uid', 'LEFT')->field('yh_customer.username, yh_devices.*')->select();
            return $_list;
        }
    }

    public function get($_where) {
        $_device = $this->where($_where)->find();
        return $_device;
    }

}
?>