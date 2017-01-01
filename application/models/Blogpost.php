<?php
class Blogpost extends CI_Model {
    public $id;
    public $title;
    public $body;
    public $postedat;
    public $category;

    public function add_entry(){
        $this->title = $_POST['title'];
        $this->body = $_POST['body'];
        $categoryid = $_POST['category_id'];
        $this->postedat = time();
        $this->db->select('id');
        $query = $this->db->query("SELECT id FROM blog_categories WHERE title = \"$categoryid\";");
        foreach($query->result() as $row){
            $this->category = $row->id;
        }

        if($this->category == NULL){
            $this->category = 1;
        }
        $this->db->insert('blog_posts', $this);
    }

    public function get_post($id){
        return $this->db->get_where('blog_posts',array('id' => $id))->row();
    }

    public function get_num_posts(){
        return $this->db->from('blog_posts')->count_all_results();
    }

    public function get_listing($page){
        $perpage = 3;
        $skip = ($page-1)*$perpage;
        return $this->db->order_by('id','DESC')->limit($perpage, $skip)->get('blog_posts')->result();
    }

    public function get_category_posts($cateId){
        return $this->db->get_where('blog_posts', array('category' => $cateId))->row();
    }
}
?>