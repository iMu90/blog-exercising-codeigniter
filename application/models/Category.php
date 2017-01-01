<?php
class Category extends CI_Model{
	
    public $title;
    
    public function add_category(){
        $this->title = $_POST['category_id'];
        $this->db->insert('blog_categories', $this);
	}
	
	public function get_categories(){
	    return $this->db->query("SELECT category FROM blog_posts")->result();
	}
}
?>