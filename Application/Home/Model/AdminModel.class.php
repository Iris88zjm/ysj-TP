<?php
namespace Home\Model;
use Think\Model;
class AdminModel extends Model{
    private function _login($_uid) {
        if (isset($_uid) === true && $_uid > 0) {
            $_customer = M('admin');
            $customer = $_customer->where(array('id' => $_uid))->find();
            session('uid', $_uid);
            session('username', $customer['username']);
            session('group', $customer['group']);
            return array(
                    'success' => true,
                    'message' => '',
                    'data' => array('uid' => session('uid'), 'username' => session('username'))
                );
        }
    }

    public function logIn($_customer) {
        $rules = array(
                array('email', 'require', 'Email is required.', 1),
                array('email', 'email', 'Email is error.', 1),
                array('password', 'require', 'Password is required.', 1),
                array('password', '/^.{5,30}.*[^ ].*$/', 'Password length must be between 6 and 30 .', 0, 'regex', 1),
            );
        $auto = array(
                array('password', 'md5', 3, 'function'),
            );
        $_create = $this->validate($rules)->auto($auto)->create($_customer);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_result = $this->where($_create)->find();
            if(isset($_result) === true && $_result['id'] > 0){
                return $this->_login($_result['id']);
                // return array(
                //         'success' => true,
                //         'message' => '',
                //         'data' => $_result
                //     );
            }else{
                return array(
                        'success' => false,
                        'message' => 'Incorrect Email or Password.',
                        'data' => array()
                    );
            }
        }
    }

}
?>