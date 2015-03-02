<?php
class User extends CI_Controller {
	
	function index() {
		
		$data['main_content'] = 'contact_form';
		$this->load->view('includes/template', $data);
		
	}


  function load_researches($_user_id){
    $this->db->get_where('abbook', array('id'=>$_user_id) );
  }
	
	function submit() {
		
		$name = $this->input->post('name');
		
		$data['main_content'] = 'contact_submitted';
		
		if ($this->input->post('ajax')) {
			$this->load->view($data['main_content']);			
		} else {
			$this->load->view('includes/template', $data);
		}
	}
	
}
