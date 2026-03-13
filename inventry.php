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
            <h1>Invoice Entry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item">Invoice Entry</li>
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
				  <h3 class="card-title"><b>Invoice Entry</b></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="post" action="invinput.php">
<?php
// --------------------
// TIMEZONE
// --------------------
date_default_timezone_set('Asia/Kolkata');
$curdt = date('Y-m-d');

// --------------------
// INITIALIZE VARIABLES
// --------------------
$code               = '';
$code1              = '';
$dt                 = '';
$pocode             = '';
$selectedpocodes    = [];
$rem                = '';
$descr              = '';
$total_amt          = 0;
$approved           = 'No';
$received           = 'No';
$update             = false;

// --------------------
// EDIT MODE
// --------------------
if (!empty($_GET['edit'])) {

    $code   = $_GET['edit'];
    $update = true;

    $qry = mysqli_query($con, "SELECT * FROM inventry WHERE code='$code'");

    if ($qry && mysqli_num_rows($qry) == 1) {

        $row = mysqli_fetch_assoc($qry);

        $code1     = $row['code'];
        $dt        = $row['dt'];
        $pocode    = $row['pocode'];
        $rem       = $row['rem'];
        $descr     = $row['descr'];
        $total_amt = $row['total_amt'];
        $approved  = $row['approved'] ?? 'No';
        $received  = $row['received'] ?? 'No';

        $selectedpocodes = array_filter(array_map('trim', explode(',', $pocode)));
    }
}

// --------------------
// NEW MODE (AUTO CODE)
// --------------------
else {
    $query = mysqli_query(
        $con,
        "SELECT IFNULL(MAX(CAST(SUBSTRING(code,6) AS UNSIGNED)),0) AS code1 FROM inventry"
    );
    $result   = mysqli_fetch_assoc($query);
    $nextCode = $result['code1'] + 1;
    $code     = 'ZCPL-' . $nextCode;
}

// PO passed from report page
if (!empty($_GET['po'])) {
    $selectedpocodes[] = $_GET['po'];
}

?>



	
			 <div class="card-body">
					<div class="row form-group" hidden>
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Code</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="code" name="code" value="<?php if(isset($_GET['edit'])){ echo $code1;} else{ echo $code;} ?>" placeholder="code" class="form-control" readonly>
                                                    
                                                </div>
                                            </div>
                                            <div class="row form-group" hidden>
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Date</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="date" id="dt" name="dt" value="<?php if(isset($_GET['edit'])){echo $dt;} else {echo $curdt;}?>" class="form-control" autofocus>
                                                    
                                                </div>
                                            </div>
<?php
$reqFilter = '';
if (!empty($selectedpocodes)) {
    $reqFilter = " OR r.code IN ('" . implode("','", $selectedpocodes) . "')";
}

$q = mysqli_query($con, "
    SELECT r.code
    FROM poentry r
    WHERE 
        NOT EXISTS (
            SELECT 1
            FROM inventry p
            WHERE FIND_IN_SET(r.code, p.pocode)
        )
        $reqFilter
    ORDER BY r.code DESC
");
?>

<div class="row form-group">
  <div class="col-md-3">
    <label>PO Code</label>
  </div>

  <div class="col-md-9">
    <select id="pocode" name="pocode[]" class="select2 form-control" multiple style="width:100%">
      <?php
      while ($r = mysqli_fetch_assoc($q)) {

          $selected = in_array($r['code'], $selectedpocodes) ? 'selected' : '';

          echo "<option value='{$r['code']}' $selected>{$r['code']}</option>";
      }
      ?>
    </select>
  </div>
</div>




                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Description</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="descr" class="form-control"><?php if(isset($_GET['edit'])){echo $descr;} ?></textarea> 
                                                    
                                                </div>
                                            </div>

				 
                                          <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Remarks</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="rem" class="form-control"><?php if(isset($_GET['edit'])){echo $rem;} ?></textarea> 
                                                    
                                                </div>
                                            </div>  

                                             <div class="col-md-12">
        			<div class="card">
              			<div class="card-header" style="background-color:#007cbc;color:white">
				  			<h3 class="card-title"><b>ITEM DETAILS</b></h3>
              			</div>
						<div class="card-body">
					
<table border="1" id="item_table" class="table table-bordered">
<thead>
<tr>
    <th>Sr</th>
    <th style="width:250px">Inv. No.</th>
    <th style="width:300px">Inv. Date</th>
    <th style="width:250px">Amt</th>
    <th>
        <button type="button" id="add_row" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
        </button>
    </th>
</tr>
</thead>

<tbody>
<?php
$x = 1;

if(isset($_GET['edit']) || isset($_GET['rev'])){
    $code = isset($_GET['edit']) ? $_GET['edit'] : $_GET['rev'];

    $sql = "SELECT * FROM invchild WHERE code='$code'";
    $data = mysqli_query($con,$sql);

    while($row = mysqli_fetch_assoc($data)){
?>
<tr id="row_<?php echo $x; ?>">
    <td class="sr"><?php echo $x; ?></td>

    <td>
        <input type="text" name="invno[]" value="<?php echo $row['invno']; ?>" class="form-control">
    </td>

    <td>
        <input type="date" name="invdate[]" value="<?php echo $row['invdate']; ?>" class="form-control">
    </td>

    <td>
        <input type="text" step="0.01" name="amt[]" value="<?php echo $row['amt']; ?>" class="form-control amt">
    </td>

    <td>
        <button type="button" class="btn btn-danger btn-sm remove_row">
            <i class="fa fa-minus"></i>
        </button>
    </td>
</tr>
<?php
$x++;
    }
}
else{
?>
<tr id="row_1">
    <td class="sr">1</td>
    <td><input type="text" name="invno[]" class="form-control"></td>
    <td><input type="date" name="invdate[]" class="form-control"></td>
    <td><input type="text"  name="amt[]" class="form-control amt"></td>
    <td></td>
</tr>
<?php } ?>
</tbody>
</table>


					</div></div></div>

          <div class="row mt-3">
    <div class="col-md-3">
        <label><b>Total Amount</b></label>
        <input type="text" id="total_amt" name="total_amt"
               class="form-control" readonly
               value="<?php if(isset($_GET['edit'])){echo $total_amt;} ?>">    </div>

    <div class="col-md-3">
        <label><b>Approved</b></label>
        <!-- Approved -->
<select name="approved" class="select2 form-control">
    <option value="No" <?= ($approved=='No') ? 'selected' : '' ?>>No</option>
    <option value="Yes" <?= ($approved=='Yes') ? 'selected' : '' ?>>Yes</option>
</select>   
    </div>

    <div class="col-md-3">
        <label><b>Received</b></label>
        <!-- Received -->
<select name="received" class="select2 form-control">
    <option value="No" <?= ($received=='No') ? 'selected' : '' ?>>No</option>
    <option value="Yes" <?= ($received=='Yes') ? 'selected' : '' ?>>Yes</option>
</select>
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
                  <a href="expreport.php"><button type="button" class="btn btn-danger float-right">Back</button></a>
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
	    $('#reqcode').select2({
    placeholder: "Select Req Code(s)"
});
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })  
	
	})
</script>

<script>
let rowCount = $('#item_table tbody tr').length || 1;

/* ADD ROW */
$('#add_row').click(function () {
    rowCount++;

    let row = `
    <tr id="row_${rowCount}">
        <td class="sr">${rowCount}</td>
        <td><input type="text" name="invno[]" class="form-control"></td>
        <td><input type="date" name="invdate[]" class="form-control"></td>
        <td><input type="text"  name="amt[]" class="form-control amt"></td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove_row">
                <i class="fa fa-minus"></i>
            </button>
        </td>
    </tr>`;

    $('#item_table tbody').append(row);
});

/* REMOVE ROW */
$(document).on('click', '.remove_row', function () {
    $(this).closest('tr').remove();
    updateSr();
    calculateTotal();
});

/* AUTO TOTAL */
$(document).on('input', '.amt', function () {
    calculateTotal();
});

function calculateTotal(){
    let total = 0;
    $('.amt').each(function(){
        total += parseFloat($(this).val()) || 0;
    });
    $('#total_amt').val(total.toFixed(2));
}

function updateSr(){
    $('.sr').each(function(index){
        $(this).text(index + 1);
    });
}
</script>

<script>
$( document ).ready(function() {
$("#entry").addClass("menu-open");
$("#entrya").addClass("active");
$("#entrya").css("background-color","#006699");
$("#inventry").addClass("active");
//$("#rcptentry").css("background-color","#006699");
});

</script>
</body>
</html>
