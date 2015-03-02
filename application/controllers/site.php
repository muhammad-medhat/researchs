<?php

class Site extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
	}

	function members_area()
	{
    $this->load->model('user_model');
    $this->load->model('author_model');

    $UID = $this->session->userdata('user_id');
    $faculty_id = $this->user_model->get_fid($UID);
    $faculty_name = $this->user_model->get_faculty_name($faculty_id );
    $faculty_specifications = $this->user_model->get_faculty_specifications($faculty_id);
    $faculty_specifications_id = $faculty_specifications->result();

    $data['faculty_name'] = $faculty_name;
    $data['main_content'] = 'logged_in_area';
    $data['researches'] = $this->user_model->get_faculty_researches($faculty_id);   
    
    $data['specifications'] = $this->user_model->get_sub_specifications($faculty_specifications_id[0]->id);

    //$data['authors'] = $this->author_model->get_authors();


    $this->load->view('includes/template', $data);
	}

  function getAllSpecifications(){}
    
  function getSubSpecifications( $_parent_ID){}

  function get_book_authors($_book_id)
  {
    $books_table     = $this->db->dbprefix('abbook');
    $book_auth_table = $this->db->dbprefix('abbookauth');
    $authors_table   = $this->db->dbprefix('abauthor');
    $query = "
        SELECT 
         
          a.id as author_id
        
        FROM `$books_table` b 
          inner join $book_auth_table ba on ba.idbook=b.id
          inner join $authors_table a on ba.idauth=a.id 
        WHERE b.id=$_book_id ";
   // echo "query is " .$query;
    return $this->db->query($query);
    
  }

  function assign_auth($_book_id, $_spec_id)
  {
//     $_book_id = $this->input->post('books');

//     $_spec_id = $this->input->post('specs');


     $_authors = $this->get_book_authors($_book_id);
   //n echo"authors query: " .$this->db->last_query();

          
     $this->load->library('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('specs', "asdf",  'trim|required');
		$this->form_validation->set_rules('books', "Books",  'trim|required');
			


    //if( $this->form_validation->run() == TRUE)
    foreach($_authors->result() as $a)
    {

      // var_dump($a);
      // print_r($a);
      // echo $a;

       $array = array(
         'idauth'=>$a->author_id, 
         'spec_id'=>$_spec_id
       );
       $this->db->set($array);
       // TODO
       // if not exists idauth and spec_id
       if( !$this->check_existence($a->author_id, $_spec_id) ) {
         $this->db->insert('alexu_authorspecification');
       }
       else return false;

    } // end foreach
  }

  function check_existence($author, $spec)
  {
		$this->db->where('idauth', $author);
		$this->db->where('spec_id', $spec);

		$query = $this->db->get('alexu_authorspecification');


		
		if($query->num_rows >= 1)
		{
			return true;
		}
    else
      return false;
		
	}
  
  function assign_spec()
  {
    $_book_id = $this->input->post('books');

    $selected_specs = $this->input->post('specs');


    $_user_id = $this->session->userdata('user_id');


   	$this->load->library('form_validation');
    $this->lang->load('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('specs[]', "Specs",  'trim|required');
		$this->form_validation->set_rules('books', "Books",  'trim|required');
			


    if( $this->form_validation->run() == TRUE)
    {
      foreach($selected_specs as $_spec_id){
        $array = array(
          'book_id'=>$_book_id, 
          'spec_id'=>$_spec_id, 
          'user_id'=>$_user_id
        );
        $this->db->set($array);
        $this->db->insert('alexu_bookspecification');
        echo "<br>book query is " .$this->db->last_query();
        $this->assign_auth($_book_id, $_spec_id);
        echo "<br>auth query is " .$this->db->last_query();
      } 
    }
//`    $this->load->view('includes/template' );
       $this->members_area();

  }
	

  function show_authors()
  {
    $this->load->model('author_model');
    $this->load->model('user_model');



    $UID = $this->session->userdata('user_id');
    $faculty_id = $this->user_model->get_fid($UID);
    $faculty_name = $this->user_model->get_faculty_name($faculty_id );


    $data['researches_num'] = $this->user_model->get_faculty_researches_num($faculty_id);   
   
    $data['specifications'] = $this->user_model->get_sub_specifications(0);



    
    $data['faculty_name'] = $faculty_name;
    $data['authors'] = $this->author_model->get_authors($faculty_id);
    $data['main_content'] = 'authors';
    
    //echo $this->db->last_query();

    $this->load->view('includes/template', $data);


  }

  function show_totals()
  {
    $this->load->model('author_model');
    $this->load->model('user_model');

    $uid = $this->session->userdata('user_id');
    $faculty_id = $this->user_model->get_fid($uid);
    $faculty_name = $this->user_model->get_faculty_name($faculty_id );
########################################################################################
    $UID = $this->session->userdata('user_id');
    $faculty_id = $this->user_model->get_fid($UID);
    $faculty_name = $this->user_model->get_faculty_name($faculty_id );
    $faculty_specifications = $this->user_model->get_faculty_specifications($faculty_id);
    $faculty_specifications_id = $faculty_specifications->result();
########################################################################################








    $specs =  $this->user_model->get_sub_specifications($faculty_specifications_id[0]->id);

    $_finished = $this->user_model->get_finished_researches($uid);

    $data['done'] = $_finished;
    $data['report'] = $this->user_model->spec_report($uid);
    $data['specs'] = $specs;

    $data['main_content'] = 'reports';
    
    //echo $this->db->last_query();

    $this->load->view('includes/template', $data);


  }

  function get_author_name($_author_id)
  {
    $this->load->model('author_model');
    return $this->author_model->get_author_name($_author_id);
  }


	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
			die();		
			//$this->load->view('login_form');
		}		
    return 1;
	}	
}
