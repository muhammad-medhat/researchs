<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title><?php echo $page_title?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
  <script src="<?php echo base_url()  ?>js/jquery.min.js" type="text/javascript" charset="utf-8"></script>  
	<script src="<?php echo base_url()	?>js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>	
</head>
<body>
  <div id='nav_links'>
    <?php
      $ci =& get_instance();
      $class = $ci->router->fetch_class();
       if ($class != 'login') {
        echo anchor('site/members_area', 'الرئيسية');

        echo " | " .anchor('site/show_totals', 'مراجعة');
        echo " | " .anchor('login/logout', 'تسجيل الخروج');

       }
         ?>
  </div>
