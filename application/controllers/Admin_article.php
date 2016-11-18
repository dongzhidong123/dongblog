<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_article extends MY_Controller{
    /**
     * Admin_category constructor.
     * 构造函数
     */
    public function __construct(){
        parent::__construct();
        $this->load->model('article_model', 'art');
        $this->load->model('category_model', 'cate');
    }
    /*
     * 查看文章
     */
    public function index(){
        //后台设置后缀为空，否则分页出错
        $this->config->set_item('url_suffix', '');
        //载入分页类
        $this->load->library('pagination');
        $perPage = 3;
        //配置项设置
        $config['base_url'] = site_url('admin_article/index');
        $config['total_rows'] = $this->db->count_all_results('article');
        $config['per_page'] = $perPage;
        $config['uri_segment'] = 3;
        $config['first_link'] = '第一页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['last_link'] = '最后一页';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $offset = $this->uri->segment(3);
        $this->db->limit($perPage, $offset);
        $data['article'] = $this->art->article_category();
        $this->load->view('admin/check_article.html',$data);
    }
    /**
     * 发表文章模板显示
     */
    public function send_article(){
        $data['category'] = $this->cate->check();
        $this->load->helper('form');
        $this->load->view('admin/article.html',$data);
    }
    /**
     * 发表文章动作
     */
    public function send(){
        $this->load->library('form_validation');
        $status = $this->form_validation->run('article');
        if($status){
            $data = array(
                'title' => $this->input->post('title'),
                'cid' => $this->input->post('cid'),
                'info' => $this->input->post('info'),
                'content'=>$this->input->post('content'),
                'time' =>time()
            );

            $this->art->add($data);
            success('admin_article/index','发表文章成功');
        }else{
            $this->load->helper('form');
            $data['category'] = $this->cate->check();
            $this->load->view('admin/article.html',$data);
        }
    }
    /**
     * 编辑文章
     */
    public function edit_article(){
        $aid = $this->uri->segment(3);
        $this->load->helper('form');
        $data['article']=$this->art->aid_article($aid);
        $data['category'] = $this->cate->check();
        $this->load->view('admin/edit_article.html',$data);
    }

    /**
     * 编辑动作
     */

    public function edit(){
        $this->load->library('form_validation');
        $status = $this->form_validation->run('article');
        if($status){
            $aid = $this->input->post('aid');
            $data = array(
                'title' => $this->input->post('title'),
                'cid' => $this->input->post('cid'),
                'info' => $this->input->post('info'),
                'content'=>$this->input->post('content'),
                'time' =>time()
            );
            $this->art->update($aid,$data);
            success('admin_article/index','编辑文章成功');
        }else{

            $this->load->helper('form');
            $aid = $this->input->post('aid');
            $data['article']=$this->art->aid_article($aid);
            $data['category'] = $this->cate->check();
            $this->load->view('admin/edit_article.html',$data);
        }
    }
    /*
     * 删除文章
     */
    public function del(){
        $aid = $this->uri->segment(3);
        $this->art->del($aid);
        success('admin_article','删除文章成功');
    }

}