<?php

session_start(); 

if ($_SESSION['dcname']==''){header("Location:login.php");}else{
$username=$_SESSION['dcname'];
$type=$_SESSION['dctype'];
$year = $_SESSION['dcyear'];
include('header.php');
	include('sidemenu.php');
	include('config.php');
}


//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>
<style>
	.disabled{
		pointer-events:none;
	}
</style>
<!----------SWEETALERT--------->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'> 
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>DASHBOARD</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="index.php" style="color:#007cbc">Home</a>
            </li>
            <li class="breadcrumb-item">DASHBOARD</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

<?php
date_default_timezone_set('Asia/Kolkata');

/* =========================
   COUNTS (CURRENT FY DB)
   ========================= */

$requisitionCount = mysqli_fetch_array(
    mysqli_query($con, "SELECT COUNT(code) FROM reqentry")
)[0];

$poCount = mysqli_fetch_array(
    mysqli_query($con, "SELECT COUNT(code) FROM poentry")
)[0];

/* =========================
   PREVIOUS FINANCIAL YEAR
   ========================= */

list($y1, $y2) = explode('-', $year);
$prevYear = ($y1 - 1) . '-' . ($y2 - 1);

/* =========================
   AMC DATABASE SELECTION
   ========================= */

$DB_SERVER = '127.0.0.1';
$DB_USER   = 'root';
$DB_PASS   = '';

$amcDbName = 'reception' . $prevYear;

/* =========================
   SAFE AMC DB CONNECTION
   ========================= */

$amcQuery = false; // default (important)

// Step 1: connect without DB
$tmpCon = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS);

if ($tmpCon) {

    // Step 2: check DB exists
    $dbCheck = mysqli_query(
        $tmpCon,
        "SHOW DATABASES LIKE '$amcDbName'"
    );

    if ($dbCheck && mysqli_num_rows($dbCheck) > 0) {

        // Step 3: connect to AMC DB
        $amcCon = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $amcDbName);

        if ($amcCon) {

            // Step 4: run AMC query
            $amcQuery = mysqli_query($amcCon, "
                SELECT 
                    r.code,
                    r.dt,
                    v.name AS vendor_name,
                    DATE_ADD(r.dt, INTERVAL 1 YEAR) AS expiry_date
                FROM reqentry r
                LEFT JOIN vendormst v ON v.code = r.vendor
                WHERE r.category = 'AMC'
                  AND CURDATE() BETWEEN
                      DATE_SUB(DATE_ADD(r.dt, INTERVAL 1 YEAR), INTERVAL 10 DAY)
                      AND DATE_ADD(r.dt, INTERVAL 1 YEAR)
                  AND NOT EXISTS (
                      SELECT 1
                      FROM reqentry r2
                      WHERE r2.vendor = r.vendor
                        AND r2.category = 'AMC'
                        AND r2.dt > r.dt
                  )
                ORDER BY expiry_date ASC
            ");
        }
    }
}

?>

<section class="content">
  <div class="container-fluid">

    <!-- ROW 1 -->
    <div class="row">

      <!-- LEFT SIDE BOXES -->
      <div class="col-lg-8">
        <div class="row">

          <div class="col-lg-5 col-6">
            <div class="small-box" style="height:160px;background:#ffe0b2;">
              <div class="inner">
                <h4 style="color:#bf360c;">Requisition Entry</h4>
                <p style="font-size:30px;font-weight:bold;color:#bf360c;">
                  <?= $requisitionCount ?>
                </p>
              </div>
              <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
              </div>
              <a href="reqentry.php" class="small-box-footer">
                Go to Entry <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-5 col-6">
            <div class="small-box" style="height:160px;background:#dcedc8;">
              <div class="inner">
                <h4 style="color:#33691e;">PO Entry</h4>
                <p style="font-size:30px;font-weight:bold;color:#33691e;">
                  <?= $poCount ?>
                </p>
              </div>
              <div class="icon">
                <i class="fas fa-file-signature"></i>
              </div>
              <a href="poentry.php" class="small-box-footer">
                Go to Entry <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>


        </div>
        <div class="row">

          <div class="col-lg-5 col-6">
            <div class="small-box" style="height:160px;background:#ffe082;">
              <div class="inner">
                <h4 style="color:#ff6f00;">Requisition Report</h4>
                <p style="color:#ff6f00;">View History</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="reqsearch.php" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-5 col-6">
            <div class="small-box" style="height:160px;background:#b2ebf2;">
              <div class="inner">
                <h4 style="color:#006064;">PO Report</h4>
                <p style="color:#006064;">View History</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <a href="posearch.php" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

        </div>
        <div class="row">

<div class="col-lg-5 col-6">
  <div class="small-box" style="height:160px;background:#f8bbd0;">
    <div class="inner">
      <h4 style="color:#880e4f;">Database Backup</h4>
      <p style="color:#880e4f;">Download .SQL File</p>
    </div>
    <div class="icon">
      <i class="fas fa-database"></i>
    </div>
    <a href="backup.php" class="small-box-footer">
      Download Backup <i class="fas fa-arrow-circle-right"></i>
    </a>
  </div>
</div>

        </div>
        
      </div>

      <!-- RIGHT SIDE AMC BOX -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header" style="background:#007cbc;color:white;">
            <h3 class="card-title">
              <i class="fas fa-bell"></i> AMC Expiry Alert
            </h3>
          </div>

          <div class="card-body p-0" style="max-height:260px;overflow:auto;">
            <table class="table table-bordered table-sm mb-0">
              <thead style="background:#e3f2fd;">
                <tr>
                  <th>Req No</th>
                  <th>Last Date</th>
                  <th>Vendor</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($amcQuery && mysqli_num_rows($amcQuery) > 0) { ?>
    <?php while ($row = mysqli_fetch_assoc($amcQuery)) { ?>
        <tr>
            <td><?= $row['code'] ?></td>
            <td style="color:red;font-weight:bold;">
                <?= date('d-m-Y', strtotime($row['expiry_date'])) ?>
            </td>
            <td><?= $row['vendor_name'] ?? 'N/A' ?></td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr>
        <td colspan="3" class="text-center text-muted">
            No AMC expiring in next 10 days
        </td>
    </tr>
<?php } ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<aside class="control-sidebar control-sidebar-dark"></aside>
</div>
         <!-- /.container-fluid -->
 
    <!-- /.content -->
 
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong style="margin-bottom:1000px">Copyright &copy; 2026 <a href="" style="color:#007cbc;">Mayur Joshi</a>.</strong> All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- ChartJS -->
<script src="../admintemplate/plugins/chart.js/Chart.min.js"></script>
	<link rel="stylesheet" href="../admintemplate/plugins/chart.js/Chart.min.css">
	<link rel="stylesheet" href="../admintemplate/plugins/chart.js/Chart.css">

<script>
$(function () {
  bsvendoromFileInput.init();
});
</script>

	
<script>
$( document ).ready(function() {
$("#index").addClass("active");
$("#index").css("background-color","#006699");
});
</script>


</body>
</html>