<<style type="text/css" media="all">
  td{vertical-align:top}
  
</style>
<?php
$specs_size = $specs->num_rows;
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
      <td>المجال العلمي</td>
      <td> نوع البحث  </td>
  </tr>
 <tr>
    <td>
      <SELECT NAME="specId" size="<?php echo $specs_size ?>" id="specId" >
          <?php
          foreach ($specs->result() as $sp ) {
                   $is_parent = $sp->parent == 0; 
            ?>
            
            <option <?php if($is_parent) echo "class='parent'" ?> value="<?php echo $sp->id; ?>">
              <?php if(!$is_parent) {
                echo "________________";
              }
              echo $sp->nameAr." - ".$sp->name; 
              ?>
            </option>

            <?php

          }
          ?>
        </SELECT>      
    </td>
    
      <td>
        <select name="search_type" id="search_type" style="width:150px;">
          <option value="">أرغب في البحث عن:</option>
          <option value="researches">الأبحاث في هذا المجال</option>
          <option value="staff">الباحثون في هذا المجال</option>
        </select>
      </td>
 </tr>
<tr>
      <td>&nbsp;</td>
      <td style='text-align:left' >
        <input type="submit" name="search" value="بحث" id="search"  />            
      </td>
    </tr>

         

     </table>
<?php echo form_close(); ?> 
