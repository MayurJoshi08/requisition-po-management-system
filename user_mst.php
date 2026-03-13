<?php
session_start(); 

if ($_SESSION['dcname']==''){header("Location:login.php");}else{
$username=$_SESSION['dcname'];
$type=$_SESSION['dctype'];
   
define('DB_SERVER', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');    // lanuser password
    define('DB_NAME', 'receptionlg1');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
	
}
	 include('header.php');
	include('sidemenu.php');

}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<style>
.password-container{
  width: 400px;
  position: relative;
}
.password-container input[type="password"],
.password-container input[type="text"]{
  width: 100%;
  padding: 12px 36px 12px 12px;
  box-sizing: border-box;
}
.fa-eye{
  position: absolute;
  top: 28%;
  right: 4%;
  cursor: pointer;
  color: lightgray;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 >User Master</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="index.php" style="color:#0151b4;">Home</a></li>
              <li class="breadcrumb-item" >User Master</li>
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
          <div class="col-md-12">
           
                      <!-- Horizontal Form -->
            <div class="card">
              <div class="card-header" style="background-color:#007cbc;color:white;">
          <h3 class="card-title" ><b>User Master</b></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="post" action="userinput.php">
          <?php
          //include('config.php');
          $query = mysqli_query($con,"SELECT MAX( cast(code as decimal)) as code1 FROM login");
          $results = mysqli_fetch_array($query);
          $cur_auto_id1 = $results['code1'] + 1;            
            //$cur_auto_id1='TS-'.$cur_auto_id1;                  
            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date( 'Y-m-d', time ());
      $update= false;
      if(isset($_GET['edit'])){
          $code=$_GET['edit'];
          //echo $code;
        $update= true;
        $qry="SELECT * FROM `login` WHERE `code` = '$code'";
        $result=mysqli_query($con,$qry);
        if(count($result==1)){
          $row=mysqli_fetch_array($result);
              $code1=$row['code'];
              $name=$row['unm'];
              $pwd=$row['pwd'];
              $type=$row['type'];
		
								
              }  
          }   
          
          ?>
       <div class="card-body">
          <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Code</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="code" name="code" value="<?php if(isset($_GET['edit'])){ echo $code1;} else{ echo $cur_auto_id1;} ?>" placeholder="code" class="form-control" readonly>
                                                    
                                                </div>
                                            </div>
                         <div class="row form-group">
                           <div class="col col-md-3">
                            <label for="hf-password" class=" form-control-label">User Name</label>
                             </div>
                             <div class="col-12 col-md-9">
                           <!--<input type="text" id="unm" name="unm" value="<?php if(isset($_GET['edit'])){ echo $unm;}?>"  class="form-control" placeholder="Username"  >-->
							  <input type="text" id="unm" name="unm" value="<?php if(isset($_GET['edit'])){echo $name;} ?>" placeholder="Username" class="form-control">

                            </div>
                       </div>
            <div class="row form-group">
                           <div class="col col-md-3">
                            <label for="hf-password" class=" form-control-label">Password</label>
                             </div>
                             <div class="col-12 col-md-9" class="password-container">
                             <input type="password" id="pwd" name="pwd" value="<?php if(isset($_GET['edit'])){ echo $pwd;}?>"  class="form-control" Placeholder="Password"><i class="fa-solid fa-eye" id="eye"></i>
                            </div>
                       </div>
         <div class="row form-group">
                           <div class="col col-md-3">
                            <label for="hf-password" class=" form-control-label">Type</label>
                             </div>
                             <div class="col-12 col-md-9">
                            <select id="type" name="type" class="form-control">
                  <?php if($type<>''){ ?><option><?php echo $type; ?></option><?php } ?>
                  <option value="">~~SELECT~~</option>
                  <option>admin</option>
                  <option>Plant</option>
                  <option>Office</option>
								
                 </select>
                            </div>
                       </div>
		    
		   
                           
                             
                       </div>
        
         <!-----footer----->
                                <div class="card-footer">
                <?php if($update=="true"): ?>
                                        <button type="submit" name="update" value="Update" class="btn btn-primary">
                      Update
                    </button>
                    <?php else : ?> 
                  <button type="submit" name="save" value="Save" class="btn btn-success">Save</button>
                  <?php endif; ?>
                  <a href="user_mst.php"><button type="button" class="btn btn-danger float-right">Quit</button></a>
                </div>
                 <a id="back-to-top" href="#" class="btn back-to-top" style="background-color:#0151b4;; color:white" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
                <!-- /.card-footer -->
              </form>
           </div>
          <!--/.col (left) -->
      </div>
          <!--/.col (right) -->
      
    <div class="col-md-12">
            <div class="card">
              <div class="card-header" style="background-color:#007cbc;color:white;">
          <h3 class="card-title"><b>User Master</b></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height:300px">
      
                <table class="table table-hover table-bordered table-head-fixed text-nowrap table-striped">
                  <thead>
                    <tr>
                        <th>Sr No</th>
						 <th>Code</th>
                        <th>Username</th>
                        <th>Type</th>
                         
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php  //include('config.php');
              $curdate=date( 'Y-m-d', time () );
              
              $sql="select * from login where 1=1";
              
              if(mysqli_query($con,$sql)){
            $data =mysqli_query($con,$sql);
                $srno=0;
            while ($row = mysqli_fetch_array($data))
            { 
              $srno=$srno+1;
              ?>
  
                      
                      <tr style="color:black">
                        <td><?php echo $srno; ?></td>
						  <td><?php echo $row['code']; ?></td>
                        <td><?php echo $row['unm']; ?></td>
                        <td><?php echo $row['type']; ?></td>
           
                        <td style="color:black"><a href ="user_mst.php?edit=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="far fa-edit"></i>
                  </button></a></td>
                <td style="color:black"><a href="userinput.php?delete=<?php echo $row['code'];?>"><button class="btn btn-default btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this entry ?')">
                                                            <i class="far fa-trash-alt"></i>
                  </button></a></td>
                      </tr>
           
            <?php  }} ?>
           </tbody>
                </table>
         </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
    <strong>Copyright &copy; 2026 <a href="" style="color:#0151b4;;">Mayur Joshi</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

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
$( document ).ready(function() {
$("#mst").addClass("menu-open");
$("#msta").css('background-color','#0151b4;');
$("#msta").css('color','white');
$("#umst").addClass("active");
$("#usermst").addClass("active");
const passwordInput = document.querySelector("#pwd");
const eye = document.querySelector("#eye");
eye.addEventListener("click", function(){
  this.classList.toggle("fa-eye-slash");
  const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
  passwordInput.setAttribute("type", type);
})
});
</script>
<script>
$( document ).ready(function() {
$("#masters").addClass("menu-open");
$("#mastera").addClass("active");
$("#mastera").css("background-color","#006699");
$("#usermst").addClass("active");

});
</script>
</body>
</html>

