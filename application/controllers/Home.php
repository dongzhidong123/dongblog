<?php

/**
 * Created by PhpStorm.
 * User: dong
 * Date: 16-11-4
 * Time: 下午5:54
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
    /**
     * 构造函数
     */
    public $category;
    public $title;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model','art');
        $this->load->model('category_model','cate');
        $this->category =$this->cate->limit_category(10);
    }

    /**
     * 默认首页显示方法
     */

    public function index(){
        $data = $this->art->check();
        $data['category'] = $this->category;
        $this->load->view("index/home.html",$data);
    }

    /**
     * 分类页显示方法
     */

    public function category(){
        $data['category'] = $this->category;
        $cid=$this->uri->segment(2);
        $data['article']=$this->art->category_article($cid);
        $this->load->view('index/category.html',$data);
    }

    /**
     * 文章阅读页显示方法
     */

    public function article(){

        $aid = $this->uri->segment(2);

        $data['category'] = $this->category;

        $data['article']=$this->art->aid_article($aid);

        $this->load->helper('parsedown');

        $this->load->view('index/article.html',$data);

    }
    /*
     * 显示个人介绍
     */
    public function menu(){
        $data['category'] = $this->category;
        $this->load->view('index/menu.html',$data);

    }
    /**
     * 搜索
     */
    public function search(){
        $data['category'] = $this->category;
        $seo = $this->input->post('seo');
        $data['title'] =$this->art->search($seo);
        $this->load->view('index/search.html',$data);
    }

}