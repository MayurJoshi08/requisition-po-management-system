<?php

//include('config.php');
$cmpny=$_SESSION['dccmpny'];
//$year=$_SESSION['dcyear'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
  <link rel="icon" type="image/jpeg" href="img/zetts_cosmetics_logo.jpg">

  <title>Zetts Cosmetics Pvt. Ltd.</title>
<!-- DataTables -->
  <link rel="stylesheet" href="../admintemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../admintemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../admintemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admintemplate/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admintemplate/dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admintemplate/plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../admintemplate/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../admintemplate/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../admintemplate/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../admintemplate/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../admintemplate/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../admintemplate/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../admintemplate/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../admintemplate/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../admintemplate/plugins/dropzone/min/dropzone.min.css">
  <!-- Jquery JS-->
    <script src="../admintemplate/vendor/jquery-3.2.1.min.js"></script>
	<!-- Theme style -->
  <link rel="stylesheet" href="../admintemplate/dist/css/adminlte.min.css">
	
	<!-- jQuery -->
<script src="../admintemplate/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
<script src="../admintemplate/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../admintemplate/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../admintemplate/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../admintemplate/plugins/moment/moment.min.js"></script>
<script src="../admintemplate/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="../admintemplate/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../admintemplate/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../admintemplate/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../admintemplate/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="../admintemplate/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="../admintemplate/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="../admintemplate/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../admintemplate/dist/js/demo.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<!----------SWEETALERT--------->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'> 
	<script src="../admintemplate/plugins/select2/js/select2.full.min.js"></script>
	<!-- Bootstrap CSS-->
    <link href="../admintemplate/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
	<!-- DataTables  & Plugins -->
<script src="../admintemplate/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../admintemplate/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../admintemplate/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../admintemplate/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../admintemplate/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../admintemplate/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../admintemplate/plugins/jszip/jszip.min.js"></script>
<script src="../admintemplate/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../admintemplate/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../admintemplate/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../admintemplate/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../admintemplate/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<!----------------------------->
	<style>
	a.disabled {
  pointer-events: none;
  cursor: default;
}
	</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand  navbar-light" style="background-color:#007cbc">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
		<li class="nav-item">
			<h3 style="color:white;padding-top:5px;font-weight:bold;padding-left:7px">Zetts Cosmetics Pvt. Ltd.</h3>
		</li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
		<li class="nav-item" style="color:white;padding-right:5px">
		<?php 
			  date_default_timezone_set('Asia/Kolkata');
			  echo date('l jS M Y,',time()); ?>
		 </li>
		<li class="nav-item" style="color:white" id="demo">
			</li>
 		</ul>
  </nav>

  <!-- /.navbar -->
<script>
setInterval(myTimer, 1000);

function myTimer() {
  const date = new Date();
  document.getElementById("demo").innerHTML = date.toLocaleTimeString();
}
	</script>
	