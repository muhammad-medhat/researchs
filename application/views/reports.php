<div id="main_content">
<?php
if ($report->num_rows == 0) { ?>
<div class="warning" style="text-align: center;border: solid;font-size: 20px;margin: 50px 506px">
لا يوجد ابحاث
</div>
<?php } else { ?>
  <table id='reports'>
    <tr class='head'>
      <td>المجال</td>
      <td>عدد الابحاث</td>
    </tr>
      <?php

   $report_result = $report->result();
   $num = 0;

      foreach ($report_result as $r) {
        echo"<tr>";
        echo" <td>$r->nameAr</td>";
        echo" <td style='text-align:center'>$r->num</td>";      
        echo"</tr>";
        $num += $r->num;
      }
      ?>
      <tr colspan='2' style="text-align:left;font-weight: bold;">
        <td>عدد الابحاث <?php echo $num?> </td>
      </tr>
  </table>
  <table id="res_list">
    <tr class='head'>
      <td></td>      
      <td>عنوان البحث</td>
      <td>المجال</td>
    </tr>
      <?php
        $this->load->model('user_model');

        $finished_result = $done->result();
        // var_dump($done);
        $i = 1;
        foreach ($finished_result as $d) {
          $_class = ($i % 2 == 0 )? "even" : "odd";
          echo "<tr class='$_class'>";
            echo"<td>$i</td>";
            echo "<td>" .$this->user_model->get_res_title($d->book_id) ."</td>";
            ?>
              <td>
                   <select name="specs">

         
<?php
            $specs_result = $specs->result();
            foreach($specs_result as $s){
              $selected = ($s->id == $d->spec_id)? 'selected="true"' : '';
              echo"<option value='$s->id' $selected>" .$s->nameAr ."</option>";
            }
?>
              </select>
</td>
            <?php
            //echo "<td>" .$this->user_model->get_spec_title($d->spec_id) ."</td>";
            echo "</tr>";
            $i++;
        }
      ?>
  </table>
<?php
}
?>
</div>
