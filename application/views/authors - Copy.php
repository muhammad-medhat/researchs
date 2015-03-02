
  <?php 
   $this->load->model('author_model');

    $UID = $this->session->userdata('user_id');

    echo "number " .$authors->num_rows();

  ?>
  <div id="res_div">
        <ul>
          <?php 
               foreach( $authors->result() as $a )
               {           
                 echo "<li class='author'> $a->name";  
                 $auth_res = $this->author_model->get_researches( $a->id );

                     echo "<ol class='researches' id='res_$a->id'>";
                         foreach($auth_res->result() as $ar)
                         {

                           $res_name = $this->author_model->get_research_name($ar->idbook);
                           $res_name_result = $res_name->result();
                            
                            echo"<li class='research'>";
                            echo   $res_name_result[0]->title;                        
                            echo"</li>";
                         }
                     echo "</ol>";
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

