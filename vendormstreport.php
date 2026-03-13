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
//ini_set('display_errors', 1);==

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vendor Master Search</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item" >Vendor Master Search</li>
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
				  <h3 class="card-title"><b>Vendor Master Search</b></h3>
				  <div class="card-tools">
                  <div class="input-group input-group-sm" style="width:120px;">
                   <a href="vendormst.php"><button  name="add" id="add"  class="btn btn-default" style="color:#007cbc;font-weight:bold">+ ADD NEW</button></a>
					   <!--<button type="button" name="pdf" id="pdf" class="btn btn-default" style="color:#17a2b8;font-weight:bold">To pdf</button>-->
					  
                  </div>
				</div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height:900px">
				  
                <table class="table table-bordered text-nowrap table-striped" id="example1">
                  <thead>
                    <tr>
												<th style="width:10px">Sr No</th>
                     						   	<th>Name</th>
												<th>City</th>
												<th>Mobile</th>
												<th>Email</th>
												<th style="width:100px">Options</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php  include('config.php');
							//ini_set("display_errors",1);
							//error_reporting(E_ALL);
							
							$sql="select * from vendormst order by name";
						
              $srno=0;
							if(mysqli_query($con,$sql)){
						$data = mysqli_query($con,$sql);
						while ($row = mysqli_fetch_array($data))

						{ 
							?>
										<tr style="color:black">
												<td><?php echo $srno=$srno+1; ?></td>
												<td><?php echo $row['name']; ?></td>
												<td><?php echo $row['city']; ?></td>
												<td><?php echo $row['mobile']; ?></td>
												<td><?php echo $row['email']; ?></td>
										
												<td style="color:black"><a href ="vendormst.php?edit=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" style="margin-right:5px" >
                                                            <i class="far fa-edit"></i>
									</button></a><a href="vendormstinput.php?delete=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this entry ?')" <?php if($type!='admin'){echo "Disabled";}?>>
                                                            <i class="far fa-trash-alt"></i>
									</button></a></td>
											</tr>
					 
					  <?php  }} ?>
					
											
					  

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
$("#masters").addClass("menu-open");
$("#mastera").addClass("active");
$("#mastera").css("background-color","#006699");
$("#vendormst").addClass("active");
//$("#shiplinemst").css("background-color","#006699");
});
</script>

</body>
</html>
