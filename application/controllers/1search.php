<?php

class Search extends CI_Controller {
  function index()
	{
    $this->load->model('user_model');
    $this->load->model('author_model');
    $this->load->model('search_model');

    $data['specs'] = $this->user_model->get_all_specifications();


    //pagination configuration
    //
   
    ##########################################33


		$data['main_content']   = 'search';

		$this->load->view('includes/template', $data);		
	}//end of index


  function perform_search()
  {
    $this->load->model('search_model');

    $_search_type = $this->input->post('search_type');
    $specId = $this->input->post('specId');
    echo "XXXXXXX" .$_search_type; 
    echo "<br> and specid is $specId";

     switch($_search_type)
     {
        case "researches":
          if ( !empty($specId) )
          {
            $search_results = $this->search_researches($specId);
            $spec_name = $this->search_model->get_dept_name($specId);
            
            $data['search_results'] = $search_results;
            $data['field'] = $spec_name;
            $this->configure_pagination($data['search_results']->num_rows); 
            $data['main_content']   = 'search_results';

		        $this->load->view('includes/template', $data);            
            
            // echo $this->db->last_query();
            // $p = $this->search_model->is_parent($specId);
            // $r = $p->result();
            // var_dump( $r[0]->parent);
          }
        break;

        case 'staff':
         $search_results = $this->search_staff();
        break;

        default:
          $this->default_function();
    
     }// end of switch

  }


  function search_researches($_spec_id)
  {
      $res_list = $this->search_model->get_researches($_spec_id);  
      return $res_list;
  }
	
  function search_staff($_spec_id)
  {
    return $this->search_model->get_staff($_sped_id);
  }

  function default_function()
  {
    echo "the default function"; 
    var_dump($_POST);
  }


  function configure_pagination($num_rows)
  {
    $pagination_config['base_url'] = $this->config->base_url() .'search';
    $pagination_config['total_rows'] = $num_rows;
    $pagination_config['per_page'] =  10;
    $pagination_config['num_links'] = 5;

    $this->pagination->initialize($pagination_config);
    echo "pagination initialized with $num_rows rows";

  }


}
	
	


