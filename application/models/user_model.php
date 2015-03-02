<?php

class User_model extends CI_Model {

	function validate()
	{
		//$this->db->where('username', $this->input->post('username'));
		//$this->db->where('password',);

    $users_table = $this->db->dbprefix('users');
    $username =  $this->input->post('username');

    $password = md5( $this->input->post('password')) ;

    $query = $this->db->query("
       select * from $users_table where 
       username='$username' and
       (password='$password' or my_password='$password')

    ");

    //$this->db->or_where('my_password', md5($this->input->post('password')));
    // $where = array(
    //   'password'=> md5($this->input->post('password')), 
    //   'my_password'=>  md5($this->input->post('password'))
    // );

	//	$query = $this->db->get_where('users', $where);

  $this->db->query( $query );
    echo $this->db->last_query();

		
		if($query->num_rows == 1)
		{
			return true;
		}
    else
      return false;
		
	}

  function get_id()
  {
    $this->db->where('username', $this->input->post('username') );
    $query = $this->db->get('users');
    $return_arr = $query->result();

    
    return $return_arr[0]->id; 	
  }

  function get_fid($_user_id)
  {
    $this->db->where('user_id', $_user_id) ;
    $query = $this->db->get('aau_helpers_facultiesusers');
    $return_arr = $query->result();

          

    return $return_arr[0]->faculty_id;   
  }
    
  function get_researches($_user_id)
  {
     return $this->db->get_where('abbook', array('user_id'=>$_user_id, 'published'=>1) );
  }

  function get_faculty_researches_num($_fid)
  {
    $book      = $this->db->dbprefix('abbook');
    $bookauth  = $this->db->dbprefix('abbookauth');
    $author    = $this->db->dbprefix('abauthor');
    $book_spec = $this->db->dbprefix('alexu_bookspecification');

    $query = $this->db->query(
      "select count(*) as number from $book b
        where b.fid=$_fid and b.published=1  
        and b.id not in 
        (select book_id from $book_spec) 
      ");
      return $query;

  }



  function get_faculty_researches($_fid)
  {
    $book      = $this->db->dbprefix('abbook');
    $bookauth  = $this->db->dbprefix('abbookauth');
    $author    = $this->db->dbprefix('abauthor');
    $book_spec = $this->db->dbprefix('alexu_bookspecification');

    $query = $this->db->query(
      "select b.* from $book b
        inner join $bookauth ba on b.id = ba.idbook
        inner join $author  a on a.id = ba.idauth
        where b.fid=$_fid and b.published=1  and b.id not in 
        (select book_id from $book_spec) 
        group by b.id
      ");
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

  function get_all_specifications()
  {
     return $this->db->get('alexu_DepAsFieldsOfStudies'); 
  }
  
  function get_faculty_specifications($_faculty_id)
  {
    $this->db->select('d.*');
    $this->db->from('alexu_DepAsFieldsOfStudies d');
    $this->db->join('aau_Helpers_faculties f', 'f.name=d.name');
    $this->db->where('f.id', $_faculty_id);

    return $this->db->get();
  }

  function get_sub_specifications($_parent_id)
  {
    return $this->db->get_where( 'alexu_DepAsFieldsOfStudies', array('parent'=>$_parent_id) );
  }

 

  function get_spec_researches($_spec_id){}

  function get_finished_researches($_user_id)
  {
    $this->db->order_by('spec_id');
    return $this->db->get_where('alexu_bookspecification', array('user_id'=> $_user_id));
  }


  function get_res_title($_res_id)
  {
    //returns a string that contains the title
    //$this->db->select('title');
    //$ret = $this->db->get_where('abbook', array('id'=>$_res_id));
    //var_dump($ret);
//echo    $this->db->last_query();
    //returns a string that contains the title
    $this->db->select('title');
    $ret_arr = $this->db->get_where('abbook', array('id'=>$_res_id) );
    $result_arr =  $ret_arr->result();
    return $result_arr[0]->title;

  }


  function get_spec_title($_spec_id)
  {
    $this->db->select('nameAr');

    $ret_arr = $this->db->get_where('alexu_DepAsFieldsOfStudies', array('id'=>$_spec_id) );
    $result_arr =  $ret_arr->result();
    return $result_arr[0]->nameAr;
 
  }




  function spec_report($_user_id)
  {
    $this->db->select("count('b.id') as num, s.nameAr");
    $this->db->from("alexu_bookspecification bs");
    $this->db->where('user_id', $_user_id);
    $this->db->join('alexu_DepAsFieldsOfStudies s', 'bs.spec_id=s.id');
    $this->db->group_by('spec_id');
    return $this->db->get();

  }
}
