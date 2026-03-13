<?php
session_start(); 

if ($_SESSION['dcname']==''){header("Location:login.php");}else{
$username=$_SESSION['dcname'];
$type=$_SESSION['dctype'];
include('header.php');
	include('sidemenu.php');
	include('config.php');
}

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>
<script type="text/javascript">
function ExportToExcel() {
    const htmlTable = document.getElementById('mainTable');

    // Company name and report title (center aligned)
    const companyName = '<div style="font-weight:bold; font-size:18px; text-align:center;">Zetts Cosmetic Pvt. Ltd.</div>';
    const reportTitle = '<div style="font-weight:bold; font-size:16px; text-align:center;">Master REPORT</div>';
    const blankLine = '<br>';
    const tableHTML = htmlTable.outerHTML;

    // Combine content
    const fullContent = companyName + reportTitle + blankLine + tableHTML;

    // Create download link
    const a = document.createElement('a');
    const data_type = 'data:application/vnd.ms-excel';
    a.href = data_type + ', ' + encodeURIComponent(fullContent);
    a.download = 'Master REPORT.xls';

    // Trigger file download
    a.click();
    return a;
}
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Search</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item">Master Search</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      
		<div class="col-md-12">
            <div class="card">
              <div class="card-header" style="background-color:#007cbc;color:white;margin-bottom:10px">
				  <h3 class="card-title"><b>Master Search</b></h3>
				  <div class="card-tools">
                  <div class="input-group input-group-sm">
                   
					  <button type="button" name="dwnld" id="dwnld" onclick="ExportToExcel()" class="btn btn-default" style="margin-left:7px;color:#007cbc;font-weight:bold">DOWNLOAD</button>
					   <!--<button type="button" name="pdf" id="pdf" class="btn btn-default" style="color:#17a2b8;font-weight:bold">To pdf</button>-->
					  
                  </div>
				</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height:900px">
				 <?php
include('config.php');

$frmdt = $_POST['frmdt'] ?? '';
$todt  = $_POST['todt'] ?? '';
$exp   = $_POST['exp'] ?? '';
?>

<form action="" method="post">
    <div class="row form-group">
        <div class="col col-md-2">
            <label>From Date</label>
            <input type="date" class="form-control" name="frmdt" value="<?= $frmdt ?>">
        </div>
        <div class="col col-md-2">
            <label>To Date</label>
            <input type="date" class="form-control" name="todt" value="<?= $todt ?>">
        </div>

        <div class="col col-md-3" style="margin-top:25px;">
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>

<table id="mainTable" class="table table-bordered table-striped" border="1">
    <thead>
        <tr>
          <th>Action</th>
            <th>Sr No.</th>
            <th>REQ. NO.</th>
            <th>REQ. DATE</th>
            <th>P.O. / W.O. NO.</th>
            <th>P.O. / W.O Date</th>
            <th>P.O. / W.O Amount</th>
            <th>Pay terms</th>
            <th>Supplier Name</th>
            <th>Goods Description</th>
            <th>INVOICE NO.</th>
            <th>INVOICE DATE</th>
            <th>INVOICE AMOUNT</th>
            <th>Status</th>
            <th>Material Status</th>
        </tr>
    </thead>
    <tbody>
<?php
$srno = 0;

// Build WHERE clause for date filter on reqentry
$where = "WHERE 1=1";
if($frmdt != '' && $todt != '') $where .= " AND dt BETWEEN '$frmdt' AND '$todt'";

// Get all requests
$sqlReq = "SELECT * FROM reqentry $where ORDER BY code DESC";

$resReq = mysqli_query($con, $sqlReq);

while($req = mysqli_fetch_assoc($resReq)) {
    $srno++ ;

    // ------------------
    // Fetch PO for this request (if any)
    // ------------------
    $po_code = '';
    $po_date = '';
    $po_amt = '';
    $po_payment = '';
    $po_vendor_code = '';
    $po_vendor_name = '';
    $sqlPO = "SELECT * FROM poentry WHERE reqcode='{$req['code']}' LIMIT 1";
    $resPO = mysqli_query($con, $sqlPO);
    if($resPO && mysqli_num_rows($resPO) > 0) {
        $po = mysqli_fetch_assoc($resPO);
        $po_code = $po['code'];
        $po_date = $po['dt'];
        $po_amt = $po['ttl'];
        $po_payment = $po['payment_term'];
        $po_vendor_code = $po['vendor'];

        // Get vendor name from vendormst
        if($po_vendor_code != '') {
            $resVend = mysqli_query($con, "SELECT name FROM vendormst WHERE code='$po_vendor_code' LIMIT 1");
            if($resVend && mysqli_num_rows($resVend) > 0) {
                $vend = mysqli_fetch_assoc($resVend);
                $po_vendor_name = $vend['name'];
            }
        }
    }

    // ------------------
    // Fetch Invoice for this request (if any)
    // ------------------
    $inv_no = '';
    $inv_date = '';
    $inv_amt = '';
    $sqlInv = "SELECT * FROM invchild WHERE code='{$req['code']}' LIMIT 1";
    $resInv = mysqli_query($con, $sqlInv);
    if($resInv && mysqli_num_rows($resInv) > 0) {
        $inv = mysqli_fetch_assoc($resInv);
        $inv_no = $inv['invno'];
        $inv_date = $inv['invdate'];
        $inv_amt = $inv['amt'];
    }

    // ------------------
    // Fetch Inventory for this request (if any)
    // ------------------
    $inv_descr = '';
    $inv_total = '';
    $inv_rem = '';
    $inv_status = '';
    $inv_matstatus = '';
    $sqlInvt = "SELECT * FROM inventry WHERE pocode='$po_code' LIMIT 1";
    $resInvt = mysqli_query($con, $sqlInvt);
    if($resInvt && mysqli_num_rows($resInvt) > 0) {
        $invt = mysqli_fetch_assoc($resInvt);
        $inv_descr = $invt['descr'];
        $inv_total = $invt['total_amt'];
        $inv_rem = $invt['rem'];
        $inv_status = $invt['approved'];
        $inv_matstatus = $invt['received'];
    }
?>
    <tr>
      <td>
<?php if ($po_code != '') { ?>
    <a href="inventry.php?po=<?php echo $po_code; ?>" >
      <button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-right:5px">
                                                            <i class="far fa-edit"></i>
									</button>
    </a>
<?php } ?>
</td>

        <td><?= $srno ?></td>
        <td><?= $req['code'] ?></td>
        <td><?= date('d-m-Y', strtotime($req['dt'])) ?></td>
        <td><?= $po_code ?></td>
        <td><?= $po_date ? date('d-m-Y', strtotime($po_date)) : '' ?></td>
        <td><?= $po_amt ?></td>
        <td><?= $po_payment ?></td>
        <td><?= $po_vendor_name ?></td> <!-- vendor name -->
        <td><?= $inv_descr ?></td>
        <td><?= $inv_no ?></td>
        <td><?= $inv_date ? date('d-m-Y', strtotime($inv_date)) : '' ?></td>
        <td><?= $inv_amt ?></td>
        <td><?= $inv_status ?></td>
        <td><?= $inv_matstatus ?></td>
    </tr>
<?php
}
?>
</tbody>


</table>
<!-- Include DataTables for universal search -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    $('#mainTable').DataTable({
        "paging": false,          // Disable paging
        "ordering": true,         // Enable column ordering
        "info": false,            // Hide "Showing X of Y entries"
        "searching": true,        // Enable universal search
        "order": [[1, "desc"]]    // Default order by 2nd column (index 1)
    });
});
</script>


				  <a id="back-to-top" href="#" class="btn  back-to-top" style="background-color:#007cbc" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <!--<b>Version</b> 3.1.0-rc-->
    </div>
    <strong>Copyright &copy; 2026 <a href="" style="color:#007cbc">Mayur Joshi</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
		   // $("#billto").select2().on('select2-focus',function(){ $(this).select2('open'); });
		   var tabPressed = false;

    $(document).keydown(function (e) {
        // Listening tab button.
        if (e.which == 9) {
            tabPressed = true;
        }
    });

    $(document).on('focus', '.select2', function() {
        if (tabPressed) {
            tabPressed = false;
            $(this).siblings('select').select2('open');
        }
    });
	  </script>

	   <script src="../admintemplate/plugins/select2/js/select2.full.min.js"></script>
	  <script>
	$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
	})
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })  
			
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
     // "buttons": ["excel"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
	<script>
$( document ).ready(function() {
$("#reports").addClass("menu-open");
$("#reportsa").addClass("active");
$("#reportsa").css("background-color","#006699");
$("#mstreport").addClass("active");
//$("#rcptsrch").css("background-color","#006699");
});
</script>

</body>
</html>
