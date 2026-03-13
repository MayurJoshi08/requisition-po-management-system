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

    // Company name with center alignment
    const companyName = '<div style="font-weight:bold; font-size:18px; text-align:center;">Demo Trading Company</div>';
    
    // Title from the page with center alignment
    const reportTitle = htmlTitle ? 
        '<div style="font-weight:bold; font-size:16px; text-align:center;">' + htmlTitle.innerText + '</div>' 
        : '';

    // Blank line for spacing
    const blankLine = '<br>';

    // Table HTML
    const tableHTML = htmlTable.outerHTML;

    // Combine all content
    const fullContent = companyName + reportTitle + blankLine + tableHTML;

    // Create download link
    const a = document.createElement('a');
    const data_type = 'data:application/vnd.ms-excel';
    a.href = data_type + ', ' + encodeURIComponent(fullContent);
    a.download = 'po Report.xls';
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
            <h1>Po Search</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item" >Po Search</li>
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
				  <h3 class="card-title" id="title"><b> Po Search</b></h3>
				  <div class="card-tools">
                  <div class="input-group input-group-sm">
                   <a href="poentry.php"><button  name="add" id="add"  class="btn btn-default" style="color:#007cbc;font-weight:bold">+ ADD NEW</button></a>
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
                                                    <label for="hf-password" class=" form-control-label" style="margin-right:0px">Billing To</label>
                                                
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
				<form method="post" id="formfield">
                <table class="table table-bordered text-nowrap table-striped" id="tbl1" border="1">
                  <thead>
                    <tr>
												<th style="width:30px">Sr No</th>
												<th>Date</th>
												<th>PO No</th>
												<th>vendor</th>
												<th>Total</th>
												<th style="width:100px">Options</th>
												<th>PO Print</th>
												                    </tr>
                  </thead>
                  
                     <?php  include('config.php');
							//ini_set("display_errors",1);
							//error_reporting(E_ALL);
              							date_default_timezone_set('Asia/Kolkata');
							$curdt = date( 'Y-m-d', time ());
$curMon = date('m');
$curYr  = date('Y');
							if(isset($_POST['search'])){
							$sql="select * from poentry where 1=1";
							 if(($frmdt<>"")&&($todt<>"")){
							 	$sql=$sql." and `dt` between '$frmdt' and '$todt'";
							 }
							 if($vendor<>""){
							 	$query1=mysqli_query($con,"select code from vendormst where name='$vendor'");
							 	$r1=mysqli_fetch_array($query1);
							 	$cncode=$r1[0];
							 $sql=$sql." and vendor='$cncode'";
							 }
					  		$sql=$sql." order by cast(MID(`code`,4) as decimal)";
							}else{
								$sql="select * from poentry where MONTH(`dt`)='$curMon' AND YEAR(`dt`)='$curYr' order by `dt`";
							}
							//echo $sql;
							if(mysqli_query($con,$sql)){
						$data = mysqli_query($con,$sql);
								?>
					<tbody>
						<?php
								$totcont=0;
								$rowid=1;
								$subttl=0;
								$srno=0;
						while ($row = mysqli_fetch_array($data))
						{ 
							   $gttl=$row['gttl'];
                    			$subttl=$subttl+$gttl;
							
							?>
										<tr style="color:black" id="row_<?php echo $rowid; ?>">
												<td><?php echo $srno=$srno+1; ?></td>
												<td><?php $dt=$row['dt']; 
													$date=date("d-m-Y",strtotime($dt));
													echo $date;
													?></td>
												<td><?php echo $row['code']; ?></td>
												
												<td><?php 
													$vendorcode=$row['vendor'];
													$qr1=mysqli_query($con,"select name from vendormst where code='$vendorcode'");
													$res1=mysqli_fetch_array($qr1);
													echo $res1['name'];
													?></td>
												<td><?php echo $row['gttl']; ?></td>
												
												<td style="color:black">
                        <!-- REV BUTTON -->
<a href="poentry.php?rev=<?php echo $row['code']; ?>">
    <button class="btn btn-warning btn-sm" type="button"
        data-toggle="tooltip" title="Reverse Entry"
        style="margin-right:5px">
        REV
    </button>
</a>    
                        
                        <a href ="poentry.php?edit=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-right:5px">
                                                            <i class="far fa-edit"></i>
									</button></a><a href="poinput.php?delete=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this entry ?')">
                                                            <i class="far fa-trash-alt"></i>
									</button></a>
											</td>
											 <td>
											<a href="poprint2.php?code=<?php echo $row['code'];?>" target="_blank"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Print" >
                                                            <i class="fas fa-print"></i>
									</button></a></td>
											</tr>
					
					  <?php
					$rowid++;	}} ?>
<tr style="color:black">

      		<td></td>
            <td></td>
			<td></td>
            
            <td><b>Total</b></td>
            <td><?php echo $subttl; ?></td>
	<td></td>
			<td></td>
      		
           
     </tr>
</tbody>
</table>
				  </form>
				  
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
  bsvendoromFileInput.init();
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
$("#pos").addClass("menu-open");
$("#poaa").addClass("active");
$("#poa").css("background-color","ofwhite");
$("#invchallreport").addClass("active");
$('body').addClass('sidebar-collapse');
});
	  
</script>
	
</body>
</html>
