<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function index()
	{
        $page = $this->uri->segment(3, 1);

        $perpage = 3;

        $data['posts'] = array();
       
        $this->load->model('blogpost');
        $results = $this->blogpost->get_listing($page);

        foreach($results as $row)
            $data['posts'][] = array('id' => $row->id, 'title' => $row->title, 'body' => strlen($row->body) > 100 ? substr($row->body, 0, 97) . "..." : $row->body, 'postedat' => date('M d, Y -g:ia', $row->postedat));

        $this->load->library('pagination');
        $pgconfig = array('base_url' => site_url('blog/index/'), 'total_rows' => $this->blogpost->get_num_posts(), 'per_page' => $perpage, 'use_page_numbers' => TRUE);
        $this->pagination->initialize($pgconfig);
        $data['pagination'] = $this->pagination->create_links();

		$this->load->view('posts', $data);
	}

    public function newpost(){
        $this->load->view('newpost');
    }

    public function submitnewpost(){
        $this->load->model('blogpost');
        $this->blogpost->add_entry();
        $this->load->view('newpostsubmitted');
    }

    public function viewpost() {
        
        $post_id = $this->uri->segment(3);
        $this->load->model('blogpost');
        $post_data = $this->blogpost->get_post($post_id);

        $data['title'] = $post_data->title;
        $data['body'] = $post_data->body;
        $data['postedat'] = date('M d, Y -g:ia', $post_data->postedat);
        
        $this->load->view('viewpost', $data);
        
    }
    
    public function newcategory(){
        $this->load->view('newcategory');
    }
    public function submitnewcate() {
        $this->load->model('category');
        $this->category->add_category();
        $this->load->view('submitnewcate');
    }

    public function category(){
        $cateId = $this->uri->segment(3);
        $this->load->model('blogpost');
        $post = $this->blogpost->get_category_posts($cateId);
        $data['title'] = $post->title;
        $data['body'] = $post->body;
        $data['postedat'] = date('M d, Y -g:ia', $post->postedat);

        $this->load->view('categoryposts', $data);
    }

    /* public function _category_header(){
        $thelinks['postcate'] = array();
        $title ="";
        $theID;
        $this->load->model('category');
        $cate = $this->category->get_category();
        $thelinks['id'] = $cate->id;
        $thelinks['title'] = $cate->title;
        //$$thelinks['links'] = "<a class=\"blog-nav-item\" href=\"<?= site_url('blog/viewpost/'.$thID) ?>\">$title</a>";

        foreach($cate as $row){
            $thelinks['postcate'][] = array('id' => $row->id, 'title' => $row->title);
        }
        /*  $query = $this->db->query("SELECT * FROM blog_categories;");
        foreach($query->result() as $row){
            $title = $row->title;
            $theID = $row->id;
           $thelinks['links'] = "<a class=\"blog-nav-item\" href=\"<?= site_url('blog/viewpost/'.$thID) ?>\">$title</a>";
           }
        $this->load->view('posts', $thelinks);
        }*/
}
