<?php 
session_start();

define('DB_SERVER', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'receptionlg1');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $pass = $_POST['password'];
    $year = $_POST['year'];

    $query = mysqli_query(
        $con,
        "SELECT unm, pwd, type FROM login WHERE unm='$name' AND pwd='$pass'"
    );

    if (!$query) {
        die(mysqli_error($con));
    }

    // ✅ CORRECT CHECK
    if (mysqli_num_rows($query) > 0) {

        $num = mysqli_fetch_assoc($query);

        $_SESSION['dcname']  = $num['unm'];
        $_SESSION['dctype']  = $num['type'];
        $_SESSION['dccmpny'] = $_POST['cmpny'] ?? '';
        $_SESSION['dcyear']  = $year;

        date_default_timezone_set('Asia/Kolkata');

        header("Location: index.php");
        exit;

    } else {
        $error = "Login Failed!!!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/jpeg" href="img/zetts_cosmetics_logo.jpg">

  <title>Login</title>
<!----------SWEETALERT--------->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'> 
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admintemplate/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../admintemplate/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admintemplate/dist/css/adminlte.min.css">
	<style>
		@media (min-width: 1024px) {
    .some-rule {  }
	}
		::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: white;
  opacity: 1; /* Firefox */
}
</style>
</head>
<body class="hold-transition login-page" >
<div class="login-box" >
  <!-- /.login-logo -->
	 <div class="card card-outline card-primary">
	<div class="card-header text-center" style="background-color:white">
		<!--<h2>VIMLA FUEL & METALS</h2>-->
		<a href="" class="h1"><img src="img/zetts_cosmetics_logo.jpg" style="height:180px;width:180px"></a>
    </div>
 
 <div class="card-body"style="background-color:white">
		<p class="login-box-msg">Sign In To Start Your Session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required >
          <div class="input-group-append">
            <div class="input-group-text" >
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
	 <!--<div class="input-group mb-3">
          <select class="form-control" name="cmpny" id="companySelect" onchange="displayCompanyInfo()" required >
			  <option value="">~~COMPANY~~</option>
			  <option>GOKUL FURNISHING</option>
			  <option>GOKUL FURNITURE INDUSTRIES</option>
			  </select>
          <div class="input-group-append">
            <div class="input-group-text" >
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>-->
		  <div class="input-group mb-3">
			 <select class="form-control" name="year" required>
				   <?php $q1=mysqli_query($con,"select yr from year");
				 		while($r1=mysqli_fetch_array($q1)){
				 ?>
				 		<option><?php echo $r1[0]; ?></option>
				 <?php } ?>
		  </select>
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <div class="col-4">
            <button type="submit" name="submit" value="Submit" class="btn  btn-block" style="background-color:#542372;color:white;border:1px solid white">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../admintemplate/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../admintemplate/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../admintemplate/dist/js/adminlte.min.js"></script>

</body>
</html>
