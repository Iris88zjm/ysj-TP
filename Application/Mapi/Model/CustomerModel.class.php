<?php
namespace Mapi\Model;
use Think\Model;
class CustomerModel extends Model{

    private function _login($_uid, $_token) {
        if (isset($_uid) === true && $_uid > 0) {
            $_customer = M('customer');
            $customer = $_customer->where(array('uid' => $_uid))->find();
            if($_token === true){
                $token = md5(uniqid().time());
                $_customer->where(array('uid' => $customer['uid']))->save(array('token' => $token));
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => array('uid' => $customer['uid'], 'username' => $customer['username'], 'token' => $token)
                    );
            }else{
                return array(
                        'success' => true,
                        'message' => '',
                        'data' => array('uid' =>$customer['uid'] , 'username' =>$customer['username'])
                    );
            }
        }
    }

    public function customerCreate($_customer) {
        $this->setProperty('error','');
        $rules = array(
                array('username', 'require', 'Username is required.', 1),
                array('username', '/^1[3|4|5|7|8]\d{9}$/', 'Username must be phone number .', 0, 'regex', 1),
                array('username', '', '账号已经存在', 0, 'unique', 1),
                array('password', 'require', 'Password is required.', 1),
                array('password', '/^[0-9a-zA-Z\s]{6,30}$/', 'Password length must be between 6 and 30 .', 0, 'regex', 1),
                array('repassword', 'require', 'Repassword is required.', 1),
                array('repassword', 'password', '两次密码不相同', 0 , 'confirm'),
        );
        $auto = array(
            array('password', 'md5', 3, 'function'),
            array('user_registered', 'time', 1, 'function'),
        );
        $_create = $this->validate($rules)->create($_customer);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $this->auto($auto)->create($_customer);
            $_result = $this->add();
            if($_result && $_result > 0){
                return $this->_login($_result, true);
            }else{
                return array(
                        'success' => false,
                        'message' => '',
                        'data' => array()
                    );
            }
        }
    }

    public function passwordUpdate($_where, $_save) {
        $this->setProperty('error','');
        $rules = array(
                // array('oldpassword', 'require', 'Oldpassword is required.', 1),
                array('password', 'require', 'Password is required.', 1),
                array('password', '/^.{5,30}.*[^ ].*$/', 'Password length must be between 6 and 30 .', 0, 'regex', 1),
                array('repassword', 'require', 'Repassword is required.', 1),
                array('repassword', 'password', 'Password is not match.', 0 , 'confirm'),
            );
        $auto = array(
                array('password', 'md5', 3, 'function'),
            );
        $_create = $this->validate($rules)->auto($auto)->create($_save);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_result = $this->where($_where)->save($_create);
            $token = md5(uniqid().time());
            $this->where($_where)->save(array('token' => $token));
            return array(
                    'success' => true,
                    'message' => '',
                    'data' => $_result
                );
        }
    }

    public function logIn($_customer) {
        $this->setProperty('error','');
        $rules = array(
                array('username', 'require', 'Username is required.', 1),
                array('username', '/^1[3|4|5|7|8]\d{9}$/', 'Username must be phone number .', 0, 'regex', 1),
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
            if(isset($_result) === true && $_result['uid'] > 0){
                return $this->_login($_result['uid'], true);
            }else{
                return array(
                        'success' => false,
                        'message' => 'Incorrect Email or Password.',
                        'data' => array()
                    );
            }
        }
    }

    public function loginToken($_customer) {
        $rules = array(
                array('uid', 'require', 'Uid is required.', 1),
                array('token', 'require', 'Token is required.', 1),
            );
        $_create = $this->validate($rules)->create($_customer);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            $_result = $this->where($_create)->find();
            if(isset($_result) === true && $_result['uid'] > 0){
                return $this->_login($_result['uid'], false);
            }else{
                return array(
                        'success' => false,
                        'message' => 'Incorrect uid or token.',
                        'data' => array()
                    );
            }
        }
    }

    public function get($_where) {
        $rules = array(
                array('uid', 'require', 'Uid is required.', 1),
                array('token', 'require', 'Token is required.', 1),
            );
        $_create = $this->validate($rules)->create($_where);
        if(!$_create){
            return array(
                    'success' => false,
                    'message' => $this->getError(),
                    'data' => array()
                );
        }else{
            return $this->where($_create)->find();
        }
    }

}
?>