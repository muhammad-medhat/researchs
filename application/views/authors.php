
  <?php 
    $this->load->model('author_model');

    $UID = $this->session->userdata('user_id');
  ?>
   <div class='summary'>
    
        <table cellspacing=0>
          <tr class='head'>
            <td class="right">عدد الابحاث</td>
            <td class="left">الكلية</td>
          </tr>
          <tr class=''>
             <!-- <td class="right"><?php print_r( $researches_num )?></td>-->
             <td class="right"><?php echo $researches_num->result()[0]->number?></td>
             <td class="left"><b><?php echo $faculty_name?></b></td>
          </tr>  
        </table>

  </div>

  <div id="res_div">
        <ul>
          <?php 
               foreach( $authors->result() as $a )
               {           
                 echo "<li class='author'> $a->name";  
                 $auth_res = $this->author_model->get_researches( $a->id );
                  $size = $auth_res->num_rows + 1;
                     echo "<br><select class='researches' id='res_$a->id' size='$size'>";
                            echo"<option></option>";
                         foreach($auth_res->result() as $ar)
                         {

                           $res_name = $this->author_model->get_research_name($ar->idbook);
                           $res_name_result = $res_name->result();
                            
                            echo"<option class='research'>";

                            echo   $res_name_result[0]->title;                        
                            echo"</option>";
                         }
                     echo "</select>";
                 echo "</li>";
               }
            ?>
        </ul>
  </div>

<script type="text/javascript" charset="utf-8">
       function get_author_name(_idauth)
       {
          $.ajax({
            url: "<?php echo $this->base_url ."/site/get_author_name/"?>" + idauth,
             context: document.body
           }).done(function() {
            alert("done"); 
           });
       }

       function author_selected(_auth)
       {
         auth_name = get_author_name(_auth);   
         alert(_auth + "");
       } 
</script>

