<?php
namespace Mapi\Controller;
use Think\Controller;
class CustomerController extends Controller {

    // public function _initialize() {
        
    // }

    protected function _empty(){
        $this->ajaxReturn(
            array(
                'success' => false,
                'message' => 'Nothing data.',
                'data' => array(),
            ),
            'json'
        );
    }

    public function isexisted() {
        if(!IS_POST || preg_match('/^1[3|4|5|7|8]\d{9}$/', $_POST['username']) === 0){
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => '',
                    'data' => array(),
                ),
                'json'
            );
        }
        $_customer_model = M('customer');
        $_result = $_customer_model->where(array('username' => $_POST['username']))->find();
        if($_result && $_result['uid'] > 0){
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => '手机号已经注册',
                    'data' => array(),
                ),
                'json'
            );
        }
        $this->ajaxReturn(
            array(
                'success' => true,
                'message' => '',
                'data' => $_POST,
            ),
            'json'
        );
    }

    public function loginPost() {
        // if(session('uid') && session('uid') > 0 && session('lock_in') == 1){
        //     $this->ajaxReturn(
        //         array(
        //             'success' => true,
        //             'message' => 'you have already logged.',
        //             'data' => array(),
        //         ),
        //         'json'
        //     );
        // }
        if(IS_POST){
            $_customer_model = D('customer');
            if(isset($_POST['uid']) === true && isset($_POST['token']) === true && $_POST['uid'] > 0 && strlen($_POST['token'] == 32 )){
                $_result = $_customer_model->loginToken($_POST);
            }else{
                $_result = $_customer_model->logIn($_POST);
                $this->ajaxReturn($_result, 'json');
            }
        }else{
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => 'Nothing request data.',
                    'data' => array(),
                ),
                'json'
            );
        }
    }

    public function sendCode() {
        // $_params['telephone'] = 1354785247;
        if(!IS_POST || preg_match('/^1[3|4|5|7|8]\d{9}$/', $_POST['username']) === 0){
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => '',
                    'data' => array(),
                ),
                'json'
            );
        }
        $_code = rand(111111, 999999);
        // var_dump($_code);
        $username = "lkxx";
        $pwd = "aum1azdf";
        $password = md5($username."".md5($pwd));
        // $mobile = $_GET['mobile'];
        $content = "验证码：".$_code."，您正在注册洛酷信息账号，如非您本人操作请忽略";
        $url = "http://www.jc-chn.cn/smsSend.do?";
        $param = http_build_query(
            array(
                'username'=>$username,
                'password'=>$password,
                'mobile'=>$_POST['username'],
                // 'content'=>iconv("GB2312","UTF-8",$content)
                'content' => $content
            )
        );
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$param);
        $result = curl_exec($ch);
        curl_close($ch);
        
        // echo $result;
        if($result > 0){
            S('code_'.$_POST['username'], $_code, 600);
            $this->ajaxReturn(
                array(
                    'success' => true,
                    'message' => '',
                    'data' => array(),
                ),
                'json'
            );
        }
        $this->ajaxReturn(
            array(
                'success' => false,
                'message' => '',
                'data' => array(),
            ),
            'json'
        );
    }

    private function verifyCode($_params) {
        if(preg_match('/^1[3|4|5|7|8]\d{9}$/', $_params['username']) === 0 || !$_params['code']){
            return false;
        }
        if($_params['code'] == S('code_'.$_params['username'])){
            S('code_'.$_params['username'], null);
            return true;
        }
        return false;
    }

    public function createPost() {
        $_customer_model = D('customer');
        if(IS_POST){
            $_verify = $this->verifyCode(array('username' => $_POST['username'], 'code' => $_POST['code']));
            if($_verify === false){
                $this->ajaxReturn(
                    array(
                        'success' => false,
                        'message' => '验证码错误',
                        'data' => array(),
                    ),
                    'json'
                );
            }
            unset($_POST['code']);
            $_result = $_customer_model->customerCreate($_POST);
            $this->ajaxReturn($_result, 'json');
        }else{
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => 'Nothing request data.',
                    'data' => array(),
                ),
                'json'
            );
        }
    }

    public function wxPost() {
        $_customer_model = M('customer');
        if(IS_POST && isset($_POST['openid']) === true && $_POST['openid'] != ''){
            $_log = $_customer_model->where(array('openid' => $_POST['openid']))->find();
            if($_log && $_log['uid'] > 0){
                $token = md5(uniqid().time());
                $_save['token'] = $token;
                if($_POST['username']!= '' &&$_POST['username'] != $_log['username']){
                    $_save['username'] = $_POST['username'];
                }
                $_result = $_customer_model->where(array('uid' => $_log['uid']))->save($_save);
                if($_result > 0){
                    $customer = $_customer_model->find($_log['uid']);
                    $this->ajaxReturn(array(
                            'success' => true,
                            'message' => '',
                            'data' => array('uid' => $customer['uid'], 'username' => $customer['username'], 'token' => $customer['token'])
                        ));
                }else{
                    $this->ajaxReturn(
                        array(
                            'success' => false,
                            'message' => '登录失败',
                            'data' => array(),
                        ),
                        'json'
                    );
                }
            }else{
                $_result = $_customer_model->add(array('openid' => $_POST['openid'], 'username' => $_POST['username'], 'user_type' => 1, 'user_registered' => time()));
                if($_result && $_result > 0){
                    $token = md5(uniqid().time());
                    $_customer_model->where(array('uid' => $_result))->save(array('token' => $token));
                    $customer = $_customer_model->find($_result);
                    $this->ajaxReturn(array(
                            'success' => true,
                            'message' => '',
                            'data' => array('uid' => $customer['uid'], 'username' => $customer['username'], 'token' => $customer['token'])
                        ));
                }else{
                    $this->ajaxReturn(
                        array(
                            'success' => false,
                            'message' => '登录失败',
                            'data' => array(),
                        ),
                        'json'
                    );
                }
            }
        }else{
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => 'Nothing request data.',
                    'data' => array(),
                ),
                'json'
            );
        }
    }

    public function updatePost() {
        $_customer_model = D('customer');
        $_where['uid'] = $_POST['uid'];
        $_where['token'] =  $_POST['token'];
        $_where['password'] = md5($_POST['oldpassword']);
        $_save['uid'] = $_POST['uid'];
        $_save['password'] = $_POST['password'];
        $_save['repassword'] = $_POST['repassword'];
        // $_verify = $this->verifyCode(['telephone' => $_POST['telephone'], 'code' => $_POST['code']]);
        // if($_verify === false){
        //     $this->ajaxReturn(
        //         array(
        //             'success' => false,
        //             'message' => '验证码错误',
        //             'data' => array(),
        //         ),
        //         'json'
        //     );
        // }
        $_is_login = $_customer_model->get($_where);
        if($_is_login && $_is_login['uid'] > 0){
            $_result = $_customer_model->passwordUpdate($_where, $_save);
            $this->ajaxReturn($_result, 'json');
        }else{
            $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => 'you have to login.',
                    'data' => array(),
                ),
                'json'
            );
        }
    }

    public function forgot() {
        $_customer_model = D('customer');
        if(IS_POST && preg_match('/^1[3|4|5|7|8]\d{9}$/', $_POST['username']) === 1){
            $_verify = $this->verifyCode(array('username' => $_POST['username'], 'code' => $_POST['code']));
            if($_verify === false){
                $this->ajaxReturn(
                        array(
                            'success' => false,
                            'message' => '验证码错误',
                            'data' => array(),
                        ),
                        'json'
                );
            }
            $_result = $_customer_model->passwordUpdate(array('username' => $_POST['username']), array('password' => $_POST['password'], 'repassword' => $_POST['repassword']));
            if($_result['success'] === true){
                $_result = $_customer_model->where(array('username' => $_POST['username']))->find();
                    $this->ajaxReturn(
                        array(
                        'success' => true,
                        'message' => '',
                        'data' => array('uid' => $_result['uid'], 'username' => $_result['username'], 'token' => $_result['token'])
                        ),
                        'json'
                    );
            }
        }
        $this->ajaxReturn(
                array(
                    'success' => false,
                    'message' => '',
                    'data' => array(),
                ),
                'json'
        );
    }

    public function logOut() {
        $_customer_model = D('customer');
        $_is_login = $_customer_model->get(array('uid' => $_POST['uid'], 'token' => $_POST['token']));
        if($_is_login && $_is_login['uid'] > 0){
            $_customer_model->save(array('uid' => $_POST['uid'], 'token' => ''));
            $this->ajaxReturn(
                    array(
                        'success' => true,
                        'message' => '',
                        'data' => array(),
                    ),
                    'json'
            );
        }else{
            $this->ajaxReturn(
                    array(
                        'success' => -1,
                        'message' => '',
                        'data' => array(),
                    ),
                    'json'
            );
        }
    }
}