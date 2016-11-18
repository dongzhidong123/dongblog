<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_admin extends MY_Controller
{
    /*
     * 后台默认控制器
     */
    public function index(){
    /*
    * 默认方法
    */
        $this->load->view('admin/index.html');
    }
    /**
     * 默认欢迎
     */
    public function copy(){
        $this->load->view('admin/copy.html');
    }
    /**
     *修改密码
     */
    public function change(){
        $this->load->view('admin/change_passwd.html');
    }
    /**
     * 修改动作
     */
    public function change_passwd(){
        $this->load->model('admin_model','admin');
        $username=$this->session->userdata('username');
        $userData=$this->admin->check($username);
        $passwd= $this->input->post('passwd');
        if(md5($passwd)!=$userData[0]['passwd'])
            error('原始密码错误');
        $uid = $this->session->userdata('uid');
        $passwdF = $this->input->post('passwdF');
        $passwdS = $this->input->post('passwdS');
        if($passwdS!=$passwdF)
            error('两次密码不一致');
       $data =array(
         'passwd' => md5($passwdF)
       );
       $this->admin->change($uid,$data);
       success('admin_admin/change','修改成功');
    }
}