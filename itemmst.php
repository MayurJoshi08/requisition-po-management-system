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
<style>
.select2-selection--single {
  height: 100% !important;
}
.select2-selection__rendered{
  word-wrap: break-word !important;
  text-overflow: inherit !important;
  white-space: normal !important;
	}</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Item Master</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item">Item Master</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-9">
           
                      <!-- Horizontal Form -->
            <div class="card">
              <div class="card-header" style="background-color:#007cbc;color:white">
				  <h3 class="card-title"><b>Item Master</b></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="post" action="itemmstinput.php" id="yourFormId">
				  <?php
				
		$query = mysqli_query($con,"SELECT MAX(cast(code as decimal)) as code1 FROM itemmst");
		$results = mysqli_fetch_array($query);
		$code = $results['code1']+1;
		
		date_default_timezone_set('Asia/Kolkata');
		$currentTime = date( 'Y-m-d', time ());
				 
			if(isset($_GET['edit'])){
					$code=$_GET['edit'];
					//echo $code;
					$update= true;
					$qry="SELECT * FROM `itemmst` WHERE `code` = '$code'";
					//echo $qry;
	
						$result=mysqli_query($con,$qry);
						if(count($result==1)){

								$row=mysqli_fetch_array($result);
									
									$code1=$row['code'];
									$name=$row['name'];
									$size=$row['size'];
									$typ=$row['type'];
									$unit=$row['unit'];
									$prate=$row['prate'];
									$srate=$row['srate'];
									$opnqty=$row['opnqty'];
							$minqty=$row['minqty'];
									$dt=$row['dt'];
							}  
						}	 
		
				  ?>
	
			 <div class="card-body">
					<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Code</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="code" name="code" value="<?php if((isset($_GET['edit']))||(isset($_GET['view']))){ echo $code1;} else{ echo $code;} ?>" placeholder="code" class="form-control" readonly>
                                                    
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" autofocus required>
                                                </div>
                                            </div>
				
				
				 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Unit</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="unit" name="unit" class="form-control" value="<?php echo $unit; ?>" >
                                                </div>
                                            </div>
				 
				 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Purchase Rate</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="prate" name="prate" value="<?php if(isset($_GET['edit'])){echo $prate;}?>" placeholder="Purchase Rate" class="form-control">
                                                    
                                                </div>
                                            </div>
				 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Sales Rate</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="srate" name="srate" value="<?php if(isset($_GET['edit'])){echo $srate;}?>" placeholder="Sales Rate" class="form-control">
                                                    
                                                </div>
                                            </div>
				  <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Opn. Qty</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="opnqty" name="opnqty" value="<?php if(isset($_GET['edit'])){echo $opnqty;}?>" class="form-control">
                                                    
                                                </div>
                                            </div>
				 
				  <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Min Qty</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="minqty" name="minqty" value="<?php if(isset($_GET['edit'])){echo $minqty;}?>" class="form-control">
                                                    
                                                </div>
                                            </div>
				 
				 
				 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Dt</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="date" id="dt" name="dt" value="<?php if(isset($_GET['edit'])){echo $dt;}?>"  class="form-control">
                                                    
                                                </div>
                                            </div>
					
				
				 	  </div>
	
			 <!-----footer----->
                                <div class="card-footer">
								<?php if(isset($_GET['edit'])){ ?>
                                        <button type="submit" name="update" value="Update" class="btn btn-primary float-right" style="margin-left:6px">
											Update
										</button>
										<?php }if((!isset($_GET['view']))&&(!isset($_GET['edit']))){ ?>	
                  <button type="submit" name="save" value="Save" class="btn btn-success float-right" style="margin-left:6px">Save</button>
									<?php } ?>
                  <a href="itemmstreport.php"><button type="button" class="btn btn-danger float-right">Back</button></a>
                </div>
                 <a id="back-to-top" href="#" class="btn back-to-top" style="background-color:#007cbc" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
                <!-- /.card-footer -->
              </form>
		  </div>
		</div>
	
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
	
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <!--<b>Version</b> 3.1.0-rc-->
    </div>
    <strong>Copyright &copy; 2023 <a href="https://www.mksoftservice.com" style="color:#007cbc">M.K.Softservice</a>.</strong> All rights reserved.
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
	
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })  
	$('#type').select2({tags:true})
	})
		  		$('#cgst').keyup(function(){
			    
				var cgst= $('#cgst').val();
							    
					if(cgst==""){
					cgst=0;
					}
					
				$('#sgst').val(parseFloat(cgst));	
			$('#igst').val(parseFloat(cgst)*parseFloat(2));
			
					});
</script>
<script>
    // Function to validate before saving
    function validateBeforeSave() {
        var type = document.getElementById("type").value; // Get the selected type
        var packSize = document.getElementById("size").value; // Get the value of the pack size field

        if (type === "FG" && packSize.trim() === "") { // If FG is selected and pack size is empty
            alert("Please enter a pack size."); // Show alert message
            document.getElementById("size").focus(); // Focus on the pack size field
            return false; // Prevent form submission
        }
        return true; // Continue with form submission
    }

    // Event listener for form submission
    document.getElementById("yourFormId").addEventListener("submit", function(event) {
        // Call the validation function before saving
        if (!validateBeforeSave()) {
            event.preventDefault(); // Prevent default form submission if validation fails
        }
    });
</script>

<script>
$( document ).ready(function() {
$("#masters").addClass("menu-open");
$("#mastera").addClass("active");
$("#mastera").css("background-color","#006699");
$("#itemmst").addClass("active");
//$("#shiplinemst").css("background-color","#006699");
});
</script>
</body>
</html>

