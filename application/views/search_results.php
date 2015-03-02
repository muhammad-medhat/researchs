<hr>
<div class='header' style='font-weight: bold;font-size: 18px;text-align: center;'>
	نتائج البحث في
	<?php echo $field?> 
</div>
<title><?php echo $page_title?></title>

<table class='results' dir="rtl" border="1"
    style="margin: auto; 
    width: 100%; right: auto; left: auto; 
    clip: rect(auto, auto, auto, auto); color: #000000; font-size: medium;" > 

	<?php if($search_type=="researches") {?>
		<tr style='font-weight: bold;font-size: 18px;text-align: right;'>
	    <td> الأبحاث في هذا المجال </td>
		</tr>
		
		<tr class='head' id='results_table'>
		  <td>العنوان باللغة العربية</td>
		  <td>العنوان باللغة الانجليزية</td>
		  <td>مزيد من التفاصيل</td>
		</tr> 
	
<?php foreach($search_results->result() as $result)	{ ?>
			<tr>
        <td><?php echo $result->title ?> </td>
        <td><?php echo$result->title ?></td>
			  <td> 
          <a href='http://www.portal.alexu.edu.eg/index.php/ar/alexu-publications/<?php echo $result->res_id ?>' target='_blank'>
           ...
          </a> 
			</td>
		</tr>
<?php } //end of foreach ?>

		<hr>
		<br>
<?php }
	elseif ($search_type=="staff")  { ?>
		<tr style='font-weight: bold;font-size: 18px;text-align: right;'>
		  <td>
		الباحثون في هذا المجال
		  </td>
		</tr>
		
		<tr class='head' id='results_table'>
		  <td>الاسم باللغة العربية</td>
		  <td>الاسم باللغة الإنجليزية</td>
		  <td>المزيد</td>
		</tr> 
  <?php foreach($search_results->result() as $result) { ?>
		<tr>
      <td><?php echo $result->name ?></td>
      <td><?php echo $result->name ?></td>
		  <td> 
			  <a href='http://www.portal.alexu.edu.eg/index.php/ar/alexu-publications/author/" . $result->auth_id ."' target='_blank'>
         ... 
        </a> 
			</td>
		</tr>
<?php }// end of foreach ?>


		<hr>
		<br>
<?php }//end elseif
	else
	{
		echo"<tr style='font-weight: bold;font-size: 18px;text-align: right;'>";
		echo "  <td>";
		echo "الأبحاث في هذا المجال";
		echo "  </td>";
		echo"</tr>";
		echo"
		<tr class='head' id='results_table'>
		<td>العنوان باللغة العربية</td>
		<td>العنوان باللغة الانجليزية</td>
		<td>المزيد</td>
		</tr> 
		";
		foreach($search_results->result() as $result)
		{
			echo "<tr>";
			echo "  <td>" .$result->title." </td>";
			echo "  <td>" .$result->title."</td>";
			echo "  <td>" 
			."<a href='http://www.portal.alexu.edu.eg/index.php/ar/alexu-publications/" . $result->res_id ."' target='_blank'>...</a>" 
			."</td>";
			echo"</tr>";
		}
		echo"<hr>";
		echo"<br>";


		echo"<tr style='font-weight: bold;font-size: 18px;text-align: right;'>";
		echo "  <td>";
		echo "الباحثون في هذا المجال";
		echo "  </td>";
		echo"</tr>";
		echo"
		<tr class='head' id='results_table'>
		<td>الاسم باللغة العربية</td>
		<td>الاسم باللغة الإنجليزية</td>
		<td>المزيد</td>
		</tr> 
		";
		foreach($search_results1->result() as $result)
		{
			echo "<tr>";
			echo "  <td>" .$result->name."</td>";
			echo "  <td>" .$result->name."</td>";
			echo "  <td>" 
			."<a href='http://www.portal.alexu.edu.eg/index.php/ar/alexu-publications/author/" . $result->auth_id ."' target='_blank'>...</a>" 
			."</td>";
			echo"</tr>";
		}
		echo"<hr>";
		echo"<br>";
	}
	?>
</table>
<?php echo $this->pagination->create_links()?>
