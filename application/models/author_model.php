<?php

class Author_model extends CI_Model {



  function get_id($_author_name)
  {
    $this->db->where('abauthor', $_author_name);
    $query = $this->db->get('authors');
    
    $return_arr = $query->result();    
    return $return_arr[0]->id; 	
  }

  function get_name($_author_id)
  {
    $this->db->where('abauthor', $_author_id);
    $query = $this->db->get('authors');
    
    $return_arr = $query->result();    
    return $return_arr[0]->name; 	
  }



  function get_fid($_author_id)
  {
    $this->db->where('id', $_author_id) ;
    $query = $this->db->get('abauthor');
    $return_arr = $query->result();
    return $return_arr[0]->fid;   
  }
    
  function get_researches($_author_id)
  {
    // returns a list of researches ids for the given author
     return $this->db->get_where('abbookauth', array('idauth'=>$_author_id) );
  }
  function get_research_name($_research_id)
  {
    $this->db->select('title');
    $query = $this->db->get_where('abbook', array('id'=>$_research_id) );
    if($query->num_rows == 1)
    {
      return $query;
    }
    else
    {
      return "XXX";
    }
    //return $this->db->last_query();
  }

  function get_authors($fid)
  {
    //$this->db->select('id, name');    
    
    $this->db->where('fid', $fid);    
    
    $this->db->order_by('name', 'asc');
    return $this->db->get('abauthor');
  }

  function get_faculty_authors($_fid)
  {
    $book      = $this->db->dbprefix('abbook');
    $bookauth  = $this->db->dbprefix('abbookauth');
    $author    = $this->db->dbprefix('abauthor');
    $book_spec = $this->db->dbprefix('alexu_bookspecification');

    $query = $this->db->query(
      "select a.* from $author a where a.fid=$_fid" );
   // echo $this->db->last_query();
      return $query;
  }
  
  function get_faculty_name($_faculty_id)
  {
    $this->db->where('id', $_faculty_id) ;
    $query = $this->db->get('aau_Helpers_faculties');
    $return_arr = $query->result();
    return $return_arr[0]->arabic;   

  }



  function get_author_name($_author_id)
  {
    $this->db->where('id', $_author_id);
    $query = $this->db->get('abauthor');
    $return_arr = $query->result();
    return $return_arr[0]->name;   

  }

  function get_res_authors($_res_id)
  {
    // return the authors of thhe given research id
    //return $this->db->get_where('abbookauthor', array('idbook'=>$_res_id));
    $book      = $this->db->dbprefix('abbook');
    $bookauth  = $this->db->dbprefix('abbookauth');
    $author    = $this->db->dbprefix('abauthor');
    //$book_spec = $this->db->dbprefix('alexu_bookspecification');

    $query = "SELECT group_concat( a.name separator '__') authors, b.id 
      FROM `$author` a
      inner join $bookauth ba on ba.idauth=a.id
      inner join $book b on b.id=ba.idbook 
      WHERE b.id=$_res_id
      group by b.id";
    return $this->db->query($query);
  }


	function create_member()
	{
		
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),			
			'authorname' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))						
		);
		
		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}
}
