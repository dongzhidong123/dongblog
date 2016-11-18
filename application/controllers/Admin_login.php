<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台登录控制器
 */

class Admin_login extends CI_Controller{
    /**
     * 登录默认方法
     */
    public function index(){
        //载入验证码辅助函数
        //  $this->load->helper('captcha');
        //配置项

        //$speed = 'sfljlwjqrljlfafasdfasldfj1231443534507698';
        // $word = '';
        // for($i = 0; $i < 4; $i++){
        //	$word .= $speed[mt_rand(0, strlen($speed) - 1)];
        // }

        //配置项
        // $vals = array(
        // 	'word'	=> $word,
        // 	'img_path' => './captcha/',
        //	'img_url'  => base_url() . '/captcha/',
        // 	'img_width'=> 80,
        //	'img_height'=>25,
        // 	'expiration'=>60
        //	);
        //创建验证码
        // $cap = create_captcha($vals);

        // if(!isset($_SESSION)){
        // 	session_start();
        // }
        // $_SESSION['code'] = $cap['word'];
        // $data['captcha'] = $cap['image'];
        // print_const();die;

        $this->load->view('admin/login.html');
    }

    /**
     *验证码
     */
    public function code(){
        $config =array(
         'width'=>86,
         'height'=>36,
         'fontSize'=>16
        );
        $this->load->library('code',$config);
        $this->code->show();

    }
    /**
     * 登录
     */
    public function login_in(){
        $code = $this->input->post('captcha');
        $username = $this->input->post('username');
        $passwd = $this->input->post('passwd');
        if(!isset($_SESSION)){
             session_start();
        }
        if(strtoupper($code)!=$_SESSION['code'])
            error('验证码错误');
        $this->load->model('admin_model','admin');
        $userData=$this->admin->check($username);
        if(!$userData || $userData[0]['passwd']!=md5($passwd))
            error('用户名或者密码不正确');

        $sessionData =array(
            'username' =>$username,
            'uid' => $userData[0]['uid'],
            'logintime' => time()
        );
        $this ->session->set_userdata($sessionData);
        success('admin_admin/index','登录成功');
    }
    /**
     * 退出登录
     */
    public function login_out(){
        $this->session->sess_destroy();
        success('home/index','退出成功');
    }
}