<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Article_model extends CI_Model{
    /**
     * 发表文章
     */
    public function add($data){
        $this->db->insert('article',$data);
    }

    /*
     *查找文章
     */

    public function article_category(){
       $data= $this->db->select('aid,title,cname,time')->from('article')->join('category
        ','article.cid=category.cid')->order_by('aid','asc')->get()->result_array();
        return $data;
    }


    /**
     * 首页查询文章
     */

    public function check(){
        $data['hot']=$this->db->select('aid,title,cname,info,time')->join('category
        ','article.cid=category.cid')->order_by('time','desc')->get('article')->result_array();
        return $data;
    }

    /**
     * 通过cid调取文章
     */
    public function category_article($cid){
        $data =$this->db->select('aid,title,cname,info,time')->join('category','article.cid=category.cid')->order_by('time','desc')->get_where('article',array('article.cid'=>$cid))->result_array();
        return $data;
    }
    /**
     * 通过aid调取文章
     */
    public function aid_article($aid){
        $data =$this->db->join('category','article.cid = category.cid')->get_where('article',array('aid'=>$aid))->result_array();
        return $data;
    }
    /*
     * 通过title模糊查询
     */
    public function search($seo){
       $data= $this->db->select('aid,title,cname,info,time')->join('category','article.cid=category.cid')->like('title', $seo, 'both')->order_by('time','desc')->get('article')->result_array();
       return $data;
    }
    /*
     * 通过aid删除文章
     */
    public function del($aid){
        $this->db->delete('article',array('aid'=>$aid));
    }
    /**
     * 编辑文章
     */
    public function update($aid,$data){
        $this->db->update('article',$data,array('aid'=>$aid));
    }
}