<?php
namespace Home\Model;
use Think\Model;
class HistoryModel extends Model{
    // protected $_auto = array(
    //         array('admin_id', 'getUid', 1, 'callback'),
    //         array('username', 'getUsername', 1, 'callback'),
    //         array('ip', 'get_client_ip', 1, 'function'),
    //     );


    public function historyCreate($_history) {
        $this->setProperty('error','');
        $auto = array(
            array('admin_id', 'getUid', 1, 'callback'),
            array('username', 'getUsername', 1, 'callback'),
            array('ip', 'get_client_ip', 1, 'function'),
        );
        $_create = $this->create($_history);
        if(!$_create){
            return false;
        }else{
            $this->auto($auto)->create($_history);
            $_result = $this->add();
            if($_result > 0){
                return true;
            }else{
                return false;
            }
        }
    }

    public function gets($_condition, $_order, $_is_paged = false) {
        if($_is_paged !== true && $_is_paged > 0){
            $_count = $this->where($_condition)->count();
            $_page = new \Org\Util\Page($_count, $_is_paged);
            $_page->setConfig('theme','%HEADER%<div class="link-page">%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%</div>');
            $_page->setConfig('header','<span class="records"> %TOTAL_ROW% 条记录 </span>');
            $_page->setConfig('first', '首页');
            $_page->setConfig('last', '末页');
            $_show = $_page->show();
            $_list = $this->where($_condition)->order($_order)->limit($_page->firstRow.','.$_page->listRows)->select();
            return array(
                    'list' => $_list,
                    'page' => $_show
                );
        }else{
            $_list = $this->where($_condition)->select();
            return $_list;
        }
    }

    protected function getUid() {
        return session('uid');
    }

    protected function getUsername() {
        return session('username');
    }

}
?>