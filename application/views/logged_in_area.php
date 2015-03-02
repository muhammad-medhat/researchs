
  <?php 
    $UID = $this->session->userdata('user_id');
$this->load->model('author_model');
  ?>
	<h2>مرحبا, <?php echo $this->session->userdata('username'); ?>!</h2>

  
<?php //var_dump($researches);?>
  <div class='summary'>
    
    <table cellspacing=0>
      <tr class='head'>
        <td class="right">عدد الابحاث</td>
        <td class="left">الكلية</td>
      </tr>
      <tr class=''>
         <td class="right"><?php echo $researches->num_rows?></td>
         <td class="left"><b><?php echo $faculty_name?></b></td>
      </tr>  
   
    </table>

  </div>
  <?php if (validation_errors()) { ?>
     <div class="errors">
      <?php echo validation_errors(); ?>
     </div>
   <?php }?>
       <div id="main">
      <?php echo form_open('site/assign_spec')?>
        <table class="main_table">
          <tr class='head' style='border:solid 1px'>
            <td style='text-align:center'>الأقسام</td>
            <td style='text-align:right'>الابحاث</td>
          </tr>
          <tr>
            <td>
<?php $specs_size = $specifications->num_rows + 10 ?>
              <div id="side">
                       <select name="specs[]" size="<?php echo($specs_size ) ; ?>" multiple="multiple">
  
                       <?php 
                           foreach($specifications->result() as $s){
                         //echo "<td>" .$r->user_id ."</td>";
                         echo "<option value='" .$s->id ."'>" .$s->nameAr .": " .$s->name."</option>";
  
                   }
                ?>
  
                       </select>
                </div>
              </td>
              <td>
                <select id="books_list" name="books" size=<?php echo $researches->num_rows; ?>" >
                <?php 
                    $i = 1;
                    foreach($researches->result() as $r){
                      $_authors_list = $this->author_model->get_res_authors($r->id);

                      $title ="";
                      foreach ($_authors_list->result() as $al) {
                        $title .= $al->authors ."";
                      }
                           echo "<option title='$title' value='" .$r->id ."'>[$i]: " .$r->title ."</option>";
                           //echo "<option value='" .$r->id ."'>" .$r->user_id ."| " .$r->fid .": " .$r->title ."</option>";
                           $i++;
  
                    }
                 ?>
                  <option></option>
                </select>
              </td>
            </tr>
            <tr><td colspan="2"><?php  echo form_submit('assign', 'OK', 'class="submit"'); ?></td></tr>
        </table>
        <?php echo form_close();?>
     </div>




<script type="text/javascript">
    $( "#books_list option" ).tooltip({
      show: {
        effect: "slideDown",
        delay: 250
      }
    });
</script>
