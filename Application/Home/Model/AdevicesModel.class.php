<?php
namespace Home\Model;
use Think\Model;
class AdevicesModel extends Model{

    public function gets($_condition, $_order = '', $_is_paged = false) {
        if($_is_paged !== false && $_is_paged > 0){
            $_count = $this->where($_condition)->count();
            $_page = new \Org\Util\Page($_count, $_is_paged);
            $_page->setConfig('theme','%HEADER%<div class="link-page">%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%</div>');
            $_page->setConfig('header','<span class="records"> %TOTAL_ROW% 条记录 </span>');
            $_page->setConfig('first', '首页');
            $_page->setConfig('last', '末页');
            $_show = $_page->show();
            $_list = $this->where($_condition)->order($_order)->limit($_page->firstRow.','.$_page->listRows)->join('yh_devices ON yh_adevices.did = yh_devices.id')->field('yh_devices.*')->select();
            return array(
                    'list' => $_list,
                    'page' => $_show
                );
        }else{
            $_list = $this->where($_condition)->order($_order)->join('yh_devices ON yh_adevices.did = yh_devices.id')->select();
            return $_list;
        }
    }

    public function get($_condition) {
        $_list = $this->where($_condition)->order($_order)->join('yh_devices ON yh_adevices.did = yh_devices.id')->find();
        return $_list;
    }

    public function adeviceCreate($_condition) {
        $this->setProperty('error','');
        $rules = array(
                array('did', 'require', 'did is required.', 1),
                array('did', 'number', 'did is error.', 1),
            );
        $auto = array(
            array('aid', 'getUid', 1, 'callback'),
        );
        $_create = $this->validate($rules)->create($_condition);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_create = $this->auto($auto)->create($_condition);
            $_is_existed = $this->where(array('aid' => session('uid'), 'did' => $_create['did']))->count();
            if($_is_existed > 0){
                return array(
                        'success' => false,
                        'message' => 'Is existed',
                        'data' => array()
                    );
            }
            $_result = $this->add($_create);
            if($_result > 0){
                $_params['table_name'] = 'adevices';
                $_params['curd'] = 1;
                $_params['before_handle'] = '{}';
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

    protected function getUid() {
        return session('uid');
    }
    // public function cdeviceUpdate($_where, $_save) {
    //     $rules = array(
    //             array('device_name', 'require', 'device_name is required.', 1),
    //         );
    //     $_create = $this->validate($rules)->create($_save);
    //     if(!$_create){
    //         return array(
    //                 'success' => false,
    //                 'message' => $this->getError(),
    //                 'data' => array()
    //             );
    //     }else{
    //         $_result = $this->where($_where)->save($_create);
    //         return array(
    //                 'success' => true,
    //                 'message' => '',
    //                 'data' => $_result
    //             );
    //     }
    // }

}
?>