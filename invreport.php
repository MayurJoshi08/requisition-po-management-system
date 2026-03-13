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
    const htmlTable = document.getElementById('tbl1');

    // Company name and report title (center aligned)
    const companyName = '<div style="font-weight:bold; font-size:18px; text-align:center;">Zetts Cosmetic Pvt. Ltd.</div>';
    const reportTitle = '<div style="font-weight:bold; font-size:16px; text-align:center;">Invoice REPORT</div>';
    const blankLine = '<br>';
    const tableHTML = htmlTable.outerHTML;

    // Combine content
    const fullContent = companyName + reportTitle + blankLine + tableHTML;

    // Create download link
    const a = document.createElement('a');
    const data_type = 'data:application/vnd.ms-excel';
    a.href = data_type + ', ' + encodeURIComponent(fullContent);
    a.download = 'Invoice REPORT.xls';

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
            <h1>Invoice Search</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item">Invoice Search</li>
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
				  <h3 class="card-title"><b>Invoice Search</b></h3>
				  <div class="card-tools">
                  <div class="input-group input-group-sm">
                   <a href="inventry.php"><button  name="add" id="add"  class="btn btn-default" style="color:#007cbc;font-weight:bold">+ ADD NEW</button></a>
					  <button type="button" name="dwnld" id="dwnld" onclick="ExportToExcel()" class="btn btn-default" style="margin-left:7px;color:#007cbc;font-weight:bold">DOWNLOAD</button>
					   <!--<button type="button" name="pdf" id="pdf" class="btn btn-default" style="color:#17a2b8;font-weight:bold">To pdf</button>-->
					  
                  </div>
				</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height:900px">
				  <?php
include('config.php');

$frmdt = '';
$todt  = '';
$exp   = '';

if (isset($_POST['search'])) {
    $frmdt = $_POST['frmdt'] ?? '';
    $todt  = $_POST['todt'] ?? '';
    $exp   = $_POST['exp'] ?? '';
}
?>

				   <form action="" method="post">
				  <div class="row form-group">
					  				<div class="col col-md-2">
                                                    <label for="hf-password" class=" form-control-label" style="margin-left:25px;margin-right:0px">From Date</label>
                                                
                                                   <input type="date" class="form-control" name="frmdt" style="margin-left:25px" value="<?php echo $frmdt; ?>">
                                                </div>
					  <div class="col col-md-2">
                                                    <label for="hf-password" class=" form-control-label" style="margin-left:25px;margin-right:0px">To Date</label>
                                                
                                                   <input type="date" name="todt" id="todt" class="form-control" style="margin-left:25px" value="<?php echo $todt; ?>">
                                                </div>
					  
                                                <div class="col col-md-3" style="margin-left:25px">
                                                    <label for="hf-password" class=" form-control-label" style="margin-right:0px">PO</label>
                                                
                                                   <select id="exp" name="exp"  class="select2" style="width:100%;margin-left:25px">
														<?php if($exp<>''){ ?><option><?php echo $exp; ?></option><?php } ?>
														<option value="">~~SELECT~~</option>
														<?php $sql2=mysqli_query($con,"select distinct pocode from inventry");
														while($res2=mysqli_fetch_array($sql2)){
														?>
														<option><?php echo $res2['pocode']; ?></option>
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
												<th style="width:10px">Sr No</th>
                     						   	<th>Date</th>
												<th>Description</th>
												<th>Total</th>
												<th>Remarks</th>
												<th style="width:100px">Options</th>
                    </tr>
                  </thead>
                  
                     <?php  include('config.php');
							//ini_set("display_errors",1);
							//error_reporting(E_ALL);
							$srno=0;
							$sql="select * from inventry where 1=1";
							if($exp<>""){
								$sql=$sql." and pocode='$exp'";
							}
					  		if(($frmdt<>"")){
							$sql=$sql." and dt between '$frmdt' and '$todt'";
							}
					  		$sql=$sql." order by dt desc";
						
							if(mysqli_query($con,$sql)){
						$data = mysqli_query($con,$sql); ?>
						<tbody>
							<?php
								$ttlamt=0;
								$tcamt=0;
								$tsamt=0;
								$tiamt=0;
								$gttl=0;
								$tpay=0;
						while ($row = mysqli_fetch_array($data))
						{ 
							?>
										<tr style="color:black">
												<td><?php echo $srno=$srno+1; ?></td>
												<td><?php $dt=$row['dt'];
													$date=date("d-m-Y",strtotime($dt));
													echo $date;
													?></td>

												<td><?php echo $row['descr']; ?></td>
												<td><?php echo $row['total_amt']; ?></td>
												<td><?php echo $row['rem']; ?></td>
												<td style="color:black"><a href ="inventry.php?edit=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-right:5px">
                                                            <i class="far fa-edit"></i>
									</button></a><a href="invinput.php?delete=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this entry ?')">
                                                            <i class="far fa-trash-alt"></i>
									</button></a></td>
											</tr>
					 
					  <?php //$ttlamt=$ttlamt+$row['amt'];
							$tcamt=$tcamt+$row['total_amt'];
							
						}} ?>
					<tr style="color:black">
												<td style="font-weight:bold">TOTAL</td>
												<td></td>

												

												<td style="font-weight:bold"><?php echo $tcamt; ?></td>
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
    <strong>Copyright &copy; 2023 <a href="http://www.mksoftservice.com" style="color:#007cbc">M.K.Softservice</a>.</strong> All rights reserved.
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
$("#expreport").addClass("active");
//$("#rcptsrch").css("background-color","#006699");
});
</script>

</body>
</html>
