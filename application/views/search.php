<<style type="text/css" media="all">
  td{vertical-align:top}
  
</style>
<?php if (validation_errors()) { ?>
     <div class="errors">
      <?php echo validation_errors(); ?>
     </div>
   <?php }?>

<?php
$specs_size = $specs->num_rows/4;
?>
  <div class="logo">

    <img src="http://www.portal.alexu.edu.eg/templates/portal_inner/images/logo_ar.png" alt="جامعة الاسكندرية" />
  </div>
  <div class='title'>
    <h1>
      خدمة البحث بالمجالات العلمية لجامعة الاسكندرية
    </h1>
  </div>
  <?php echo form_open('search/perform_search')?>
<table>
<tr>
  <td colspan="2">
<p>كلمات البحث</p>
<?php
$data = array(
              'name'        => 'title',
              'id'          => 'title',
              'value'       => '',
            );

echo form_input($data);
  
 ?>
  </td>
</tr>
  <tr>
      <td>المجال العلمي</td>
      <td> نوع البحث  </td>
  </tr>
 <tr>
    <td>
      <SELECT NAME="specId" size="<?php echo $specs_size ?>" id="specId" >
          
          <?php

             foreach ($specs->result() as $sp ) {

               ?>
               
               <option value="<?php echo $sp->id; ?>">
                 <?php if($sp->parent != 0) {
                   echo "____________";
                 }
                 echo $sp->nameAr." - ".$sp->name; 
                 ?>
               </option>

               <?php } ?>
        </SELECT>      
    </td>
    
      <td>
          <input value="researches" name="search_type" type="radio">الأبحاث في هذا المجال</option><br>
          <input value="staff" name="search_type" type="radio">الباحثون في هذا المجال</option>
      </td>
 </tr>
<tr>
      <td>&nbsp;</td>
      <td style='text-align:left' >
        <input style='font-family:tahoma;font-size:20px;width:100px' type="submit" name="search" value="بحث" id="search"  />            
      </td>
    </tr>

         

     </table>
<?php echo form_close(); ?> 
