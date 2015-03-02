<?php

class Search extends CI_Controller {
  function index()
  {
    $this->load->model('user_model');
    $this->load->model('author_model');
    $this->load->model('search_model');


    $data['specs'] = $this->user_model->get_all_specifications();
    $data['page_title']="Search";
    $data['main_content']   = "search";


    $this->load->view('includes/search/template', $data);		
  }
  //end of index


  function perform_search()
  {
    $this->load->model('search_model');

    $this->load->library('form_validation');
    $this->lang->load('form_validation');
   
		// field name, error message, validation rules
		$this->form_validation->set_rules('specId','lang:error_search_specid' ,  'trim|required');
		$this->form_validation->set_rules('title', 'lang:error_search_title',  'trim|required');


    //$form_validation_var = ;



    if( $this->form_validation->run() == TRUE)
    {

                   $_search_type = $this->input->post('search_type');
                   $_search_term = ($this->input->post('title')!="") ?$this->input->post('title')  :"";

                   $data['search_type'] = $_search_type;
                   $data['search_term'] = $_search_term;

                   $specId = $this->input->post('specId');

                   switch($_search_type)
                   {
                     case "researches":
                       if($_search_term !=""){
                         //$search_results = $this->search_model->get_researches_term($specId, $_search_term);
                         $search_results = $this->search_model->get_researches_term($specId, $_search_term);
                       }
                       else
                         $search_results = $this->search_researches($specId);
                       
                       $spec_name = $this->search_model->get_dept_name($specId);

                       $data['search_results'] = $search_results;
                       $data['field'] = $spec_name;
                       $data['page_title'] = "Results";

                      //$this->pagination();


                       $data['records'] = $search_results;
                       $data['main_content'] = 'search_results';
                       $this->load->view('includes/search/template', $data);            
                     
                     break;

                     case "staff":
                       if($_search_term !="")
                         $search_results = $this->search_model->get_staff_term($specId, $_search_term);
                       else
                         $search_results = $this->search_staff($specId);
                      $spec_name = $this->search_model->get_dept_name($specId);
                      
                      $data['search_results'] = $search_results;
                      $data['field'] = $spec_name;
                      $data['page_title'] = "Results";
                      $data['main_content'] = 'search_results';

                      $this->load->view('includes/search/template', $data);
                    break;

                    default:
                       if($_search_term !="")
                         $search_results = $this->search_model->get_researches_term($specId, $_search_term);
                       else
                         $search_results = $this->search_researches($specId);

                       if($_search_term !="")
                         $search_results1 = $this->search_model->get_staff_term($specId, $_search_term);
                       else
                         $search_results1 = $this->search_staff($specId);

                      $spec_name = $this->search_model->get_dept_name($specId);
                      $data['search_type'] = $_search_type;
                      $data['search_results'] = $search_results;
                      $data['search_results1'] = $search_results1;//??????????
                      $data['field'] = $spec_name;
                      $data['page_title'] = "Results";
                      $data['main_content'] = 'search_results';

                      $this->load->view('includes/search/template', $data);

                  }
    // end of switch
    }
    else
    {
      $this->index();
    }

 }


  function search_researches($_spec_id)
  {
   $res_list = $this->search_model->get_researches($_spec_id);  
   return $res_list;
  }

  function search_staff($_spec_id)
  {
    $res_list = $this->search_model->get_staff($_spec_id);
    return $res_list;
  }

  function pagination($num_rows)
  {
    $config = array();
    $config["base_url"]       = base_url() . "index.php/search/perform_search";
    $config["total_rows"]     = $num_rows;
    $config["per_page"]       = 1;
    $config["uri_segment"]    = 3;
    $config['full_tag_open']  = "<div class='paging'>";
    $config['full_tag_close'] = "</div>";
  
    $this->pagination->initialize($config);
  
  }


}

