<div class='head'> 
  تم العثور على <?php echo $search_results->num_rows ?> نتيجة لتخصص ( <?php echo $field?> )
</div>
<table> 
<?php
//var_dump($search_results->result());
  foreach($search_results->result() as $result){
    echo"<tr>";
    echo "  <td>";
    echo "    <a href='http://www.portal.alexu.edu.eg/index.php/ar/alexu-publications/" . $result->res_id ."' target='_blank'>";
    echo          $result->title;
    echo "    </a>";
    echo "  </td>";
    echo"</tr>";
  }  
?>
</table>

