<?php

class Search_model extends CI_Model {


  function get_researches($_spec_id)
  {
    // these lines are commented cuz of an error in the query
    //
    // $this->db->join('alexu_bookspecification as bs', 'bs.book_id=abbook.id');
    // $this->db->join('alexu_DepAsFieldsOfStudies as d', 'bs.spec_id=d.id');
    // $this->db->where('bs.spec_id', $spec_id);
    // return $this->db->get('abbook as b');
    //
    $books_table  = $this->db->dbprefix('abbook');

    $book_spec_table = $this->db->dbprefix('alexu_bookspecification');
    
    $departments_table = $this->db->dbprefix('alexu_DepAsFieldsOfStudies');

    $query = " SELECT b.id as res_id, b.title, d.nameAr, d.id as dept_id
    FROM  $books_table b
    inner join $book_spec_table bs on bs.book_id=b.id
    inner join $departments_table d on bs.spec_id=d.id
    where bs.spec_id=$_spec_id or d.parent=$_spec_id
    ";
    return $this->db->query($query);
  }

  function get_dept_name($specId)
  {
    $this->db->where('id', $specId);
    $query = $this->db->get('alexu_DepAsFieldsOfStudies');
    
    $return_arr = $query->result();    
    return $return_arr[0]->nameAr;
  }

  function is_parent($_department_id)
  {
    //checks if the given id has parent or not

    $result = $this->db->get_where( 'alexu_DepAsFieldsOfStudies', array('id'=>$_department_id) );
    $_result = $result->result();
    $_result = $_result[0];
    if($_result->parent == 0)
      return true;
    else
      return false;
  }


}
