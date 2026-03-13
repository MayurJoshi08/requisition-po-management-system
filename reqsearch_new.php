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
    const htmlTitle = document.getElementById('title');
    const htmlTable = document.getElementById('tbl1');

    // Define first and second line headers
    const companyName = '<div style="font-weight:bold; font-size:18px; text-align:center">Demo Trading Company</div>';
    const reportTitle = htmlTitle ? htmlTitle.outerHTML : '';
    const blankLine = '<br>';

    // Table HTML
    const tableHTML = htmlTable.outerHTML;

    // Final combined HTML
    const fullContent = companyName + reportTitle + blankLine + tableHTML;

    // Prepare Excel download
    const data_type = 'data:application/vnd.ms-excel';
    const a = document.createElement('a');
    a.href = data_type + ', ' + encodeURIComponent(fullContent);
    a.download = 'Reqchase Report.xls';
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
            <h1>Reqchase Search</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item" >Reqchase Search</li>
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
				  <h3 class="card-title" id="title"><b>Reqchase Search</b></h3>
				  <div class="card-tools">
                  <div class="input-group input-group-sm">
                   <a href="reqentry.php"><button  name="add" id="add"  class="btn btn-default" style="color:#007cbc;font-weight:bold">+ ADD NEW</button></a>
					  <button type="button" name="dwnld" id="dwnld" onclick="ExportToExcel()" class="btn btn-default" style="margin-left:7px;color:#007cbc;font-weight:bold">DOWNLOAD</button>
					  
                  </div>
				</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height:900px">
				  <?php if(isset($_POST['search'])){$frmdt=$_POST['frmdt'];$todt=$_POST['todt'];$vendor=$_POST['vendor'];} 
				  date_default_timezone_set('Asia/Kolkata');
				  $curdt=date('Y-m-d',time());
				  ?>
				   <form action="" method="post">
				  <div class="row form-group">
					  				<div class="col col-md-2">
                                                    <label for="hf-password" class=" form-control-label" style="margin-left:25px;margin-right:0px">From Date</label>
                                                
                                                   <input type="date" class="form-control" name="frmdt" style="margin-left:25px" value="<?php if($frmdt<>""){echo $frmdt;}else{echo $curdt;} ?>">
                                                </div>
					  <div class="col col-md-2">
                                                    <label for="hf-password" class=" form-control-label" style="margin-left:25px;margin-right:0px">To Date</label>
                                                
                                                   <input type="date" name="todt" id="todt" class="form-control" style="margin-left:25px" value="<?php if($todt<>""){echo $todt;}else{echo $curdt;} ?>">
                                                </div>
					  
                                               <div class="col col-md-3" style="margin-left:25px">
                                                    <label for="hf-password" class=" form-control-label" style="margin-right:0px">Vendor</label>
                                                
                                                   <select id="vendor" name="vendor"  class="select2" style="width:100%;margin-left:25px">
														<?php if($vendor<>''){ ?><option><?php echo $vendor; ?></option><?php } ?>
														<option value="">~~SELECT~~</option>
														<?php $sql2=mysqli_query($con,"select distinct name from vendormst");
														while($res2=mysqli_fetch_array($sql2)){
														?>
														<option><?php echo $res2['name']; ?></option>
														<?php } ?>
													</select>
                                                </div>
					  				
						
					   <div style="margin-top:30px">
					   <button type="submit" name="search" id="search" class="btn btn-primary" style="color:white;background-color:#007cbc;font-weight:bold;margin-left:25px">Search</button></div>
					   </div>                 
				  </form>

                <table class="table table-bordered text-nowrap table-striped" id="tbl1" border="1">
<thead>
<tr>
<th style="width:30px">Sr No</th>
<th>Date</th>
<th>Code</th>
<th>Vendor</th>
<th>Total</th>
<th style="width:100px">Options</th>
<th>Print</th>
<th>Status</th>
<th>Send</th>
</tr>
</thead>

<?php
include('config.php');

date_default_timezone_set('Asia/Kolkata');

$curdt = date('Y-m-d');
$curMon = date('m');
$curYr  = date('Y');

if(isset($_POST['search']))
{

$sql="SELECT * FROM reqentry_new WHERE 1=1";

if(($frmdt<>"") && ($todt<>""))
{
$sql.=" AND dt BETWEEN '$frmdt' AND '$todt'";
}
else
{
$sql.=" AND MONTH(dt)='$curMon' AND YEAR(dt)='$curYr'";
}

if($vendor<>"")
{
$query1=mysqli_query($con,"SELECT code FROM vendormst WHERE name='$vendor'");
$r1=mysqli_fetch_array($query1);
$vendorcode=$r1[0];

$sql.=" AND vendor='$vendorcode'";
}

$sql.=" ORDER BY dt";

}
else
{
$sql="SELECT * FROM reqentry_new 
WHERE MONTH(dt)='$curMon' 
AND YEAR(dt)='$curYr' 
ORDER BY dt";
}

$data=mysqli_query($con,$sql);
?>

<tbody>

<?php

$subttl=0;
$srno=0;

while($row=mysqli_fetch_array($data))
{

$srno++;

$gttl=$row['grandttl'];
$subttl += $gttl;

$status=$row['approval_status'];

if($status=="")
$status="Draft";

?>

<tr style="color:black">

<td><?php echo $srno; ?></td>

<td>
<?php
$dt=$row['dt'];

if($dt!='' && $dt!='0000-00-00')
$date=date("d-m-Y",strtotime($dt));
else
$date="";

echo $date;
?>
</td>

<td><?php echo $row['code']; ?></td>

<td>

<?php

$vendorcode=$row['vendor'];

$qr1=mysqli_query($con,"SELECT name FROM vendormst WHERE code='$vendorcode'");

$res1=mysqli_fetch_array($qr1);

echo $res1['name'];

?>

</td>

<td><?php echo number_format($gttl,2,'.',''); ?></td>

<td>

<!-- REV -->
<a href="reqentry.php?rev=<?php echo $row['code']; ?>">
<button class="btn btn-warning btn-sm" title="Reverse Entry">
REV
</button>
</a>

<!-- EDIT -->
<a href="reqentry.php?edit=<?php echo $row['code']; ?>">
<button class="btn btn-default btn-sm" title="Edit">
<i class="far fa-edit"></i>
</button>
</a>

<!-- DELETE -->
<a href="reqinput.php?delete=<?php echo $row['code']; ?>">
<button class="btn btn-default btn-sm"
onclick="return confirm('Are you sure you want to delete this entry ?')"
title="Delete">
<i class="far fa-trash-alt"></i>
</button>
</a>

</td>

<td>

<a href="reqprint.php?code=<?php echo $row['code']; ?>" target="_blank">
<button class="btn btn-default btn-sm" title="Print">
<i class="fas fa-print"></i>
</button>
</a>

</td>

<td>

<?php

if($status=="Draft")
echo "<span class='badge badge-secondary'>Draft</span>";

elseif($status=="Pending_Preparer")
echo "<span class='badge badge-warning'>Pending Prepare</span>";

elseif($status=="Pending_Manager")
echo "<span class='badge badge-info'>Pending Manager</span>";

elseif($status=="Approved")
echo "<span class='badge badge-success'>Approved</span>";

elseif($status=="Rejected")
echo "<span class='badge badge-danger'>Rejected</span>";

?>

</td>

<td>

<?php if($status=="Draft"){ ?>

<a href="sendapproval.php?code=<?php echo $row['code']; ?>">
<button class="btn btn-primary btn-sm">
Send
</button>
</a>

<?php } ?>

</td>

</tr>

<?php } ?>

<tr>

<td></td>
<td></td>
<td></td>

<td><b>Total</b></td>

<td><b><?php echo number_format($subttl,2,'.',''); ?></b></td>

<td></td>
<td></td>
<td></td>
<td></td>

</tr>

</tbody>

</table>
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
      //"buttons": ["excel"]
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
$("#reportss").addClass("menu-open");
$("#reportaa").addClass("active");
$("#reportaa").css("background-color","#007cbc");
$("#reqchss").addClass("menu-open");
$("#reqchaa").addClass("active");
$("#reqchaa").css("background-color","ofwhite");
$("#reqchreport").addClass("active");

});
</script>
</body>
</html>
