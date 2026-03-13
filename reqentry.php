<?php
session_start(); 

if ($_SESSION['dcname']==''){header("Location:login.php");}else{
$username=$_SESSION['dcname'];
$type=$_SESSION['dctype'];
include('header.php');
	include('sidemenu.php');
	include('config.php');
}

?>

<?php
$mainCon = mysqli_connect('127.0.0.1', 'root', '', 'Reception');

if (!$mainCon) {
    die('Main Reception DB connection failed');
}
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
<!----------SWEETALERT--------->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Requisition Entry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item" >Requisition Entry</li>
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
              <div class="card-header" style="background-color:#007cbc;color:white">
				  <h3 class="card-title"><b>Requisition Entry</b></h3>
              </div>
			<!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="post" action="reqinput.php">
				<?php
date_default_timezone_set('Asia/Kolkata');

$curdt = date('Y-m-d');
$ctime = date("h:i:s A");
$cmonth = date('M');

/* -------- FINANCIAL YEAR -------- */
$year = date('Y');
$month = date('m');


if ($month >= 4) {
    $fy = substr($year, 2, 2) . substr($year + 1, 2, 2);
} else {
    $fy = substr($year - 1, 2, 2) . substr($year, 2, 2);
}

$checked_by='';
/* -------- CODE GENERATION -------- */
$q = mysqli_query($con,"
    SELECT MAX(CAST(SUBSTRING_INDEX(code,'-',1) AS UNSIGNED)) AS last_no
    FROM reqentry
    WHERE code LIKE '%-$fy'
");

$r = mysqli_fetch_assoc($q);
$next_no = ($r['last_no'] ?? 0) + 1;
$code = $next_no . '-' . $fy;

/* -------- EDIT MODE -------- */
/* -------- EDIT MODE -------- */
$selCategory = [];
$prepared_by = '';

if (isset($_GET['edit'])) {

    $code = $_GET['edit'];
    $update = true;

    $qry = mysqli_query($con, "SELECT * FROM reqentry WHERE code='$code'");
    if ($row = mysqli_fetch_assoc($qry)) {

        $code1 = $row['code'];
        $dt = $row['dt'];
        $vendorcode = $row['vendor'];
        $ttl = $row['ttl'];

        
        // NEW FOR EDIT
        $selCategory = explode(',', $row['category']);
        $payment_term = $row['payment_term'];
        $freight_term = $row['freight_term'];
        $delivery_term = $row['delivery_term'];
        $prepared_by = $row['prepared_by'];
 $checked_by = $row['checked_by'];
        
    $pkg_per = $row['pkg_per'];
$pkg_amt = $row['pkg_amt'];
$fwd_per = $row['fwd_per'];
$fwd_amt = $row['fwd_amt'];
$dis_per = $row['dis_per'];
$dis_amt = $row['dis_amt'];

$cgst_per = $row['cgst_per'];
$cgst_amt = $row['cgst_amt'];

$sgst_per = $row['sgst_per'];
$sgst_amt = $row['sgst_amt'];

$igst_per = $row['igst_per'];
$igst_amt = $row['igst_amt'];

$grandttl = $row['grandttl'];

        $q1 = mysqli_query($con, "SELECT name FROM vendormst WHERE code='$vendorcode'");
        $vendor = mysqli_fetch_assoc($q1)['name'] ?? '';
    }
}
/* -------- REV MODE -------- */
if (isset($_GET['rev'])) {

    $oldCode = $_GET['rev'];

    // Fetch original entry
    $qry = mysqli_query($con, "SELECT * FROM reqentry WHERE code='$oldCode'");
    if ($row = mysqli_fetch_assoc($qry)) {

        // 🔥 NEW CODE = REV-OLD_CODE
        $code1 = 'REV-' . $oldCode;
        $update = false; // IMPORTANT: new insert, not update

        // Copy values
        $dt = date('Y-m-d'); // you may keep original date if needed
        $vendorcode = $row['vendor'];
        $ttl = $row['ttl'];

        $selCategory = explode(',', $row['category']);
        $payment_term = $row['payment_term'];
        $freight_term = $row['freight_term'];
        $delivery_term = $row['delivery_term'];
        $prepared_by = $row['prepared_by'];
         $checked_by = $row['checked_by'];

        $pkg_per = $row['pkg_per'];
        $pkg_amt = $row['pkg_amt'];
        $fwd_per = $row['fwd_per'];
        $fwd_amt = $row['fwd_amt'];
        $dis_per = $row['dis_per'];
        $dis_amt = $row['dis_amt'];

        $cgst_per = $row['cgst_per'];
$cgst_amt = $row['cgst_amt'];

$sgst_per = $row['sgst_per'];
$sgst_amt = $row['sgst_amt'];

$igst_per = $row['igst_per'];
$igst_amt = $row['igst_amt'];
        $grandttl = $row['grandttl'];

        // Vendor name
        $q1 = mysqli_query($con, "SELECT name FROM vendormst WHERE code='$vendorcode'");
        $vendor = mysqli_fetch_assoc($q1)['name'] ?? '';
    }
}


?>

	
			 <div class="card-body">
				<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Code</label>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" id="code" name="code" value="<?php if((isset($_GET['edit']) || isset($_GET['rev']))||(isset($_GET['view']))){ echo $code1;} else{ echo $code;} ?>" class="form-control" >
                                                    
                                                </div>
				 						</div>
							
                                            <div class="row form-group"> 
    <div class="col col-md-3">
        <label for="hf-password" class="form-control-label">Date</label>
    </div>
    <div class="col-12 col-md-9">
        <input type="date" id="dt" name="dt" class="form-control" 
            value="<?php echo (isset($_GET['edit']) || isset($_GET['rev'])) && !empty($dt) ? $dt : $curdt; ?>">
    </div>
</div>

				 					 
				 						<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Vendor</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                   <select id="vendor" name="vendor"  class="select2" style="width:100%">
														<?php if(isset($_GET['edit']) || isset($_GET['rev'])){?><option value="<?php echo $vendorcode; ?>"><?php echo $vendor; ?></option><?php } ?>
														<option value="">~~SELECT~~</option>
														<?php
														$qr1=mysqli_query($mainCon,"select distinct code,name from vendormst");
														while($row1=mysqli_fetch_array($qr1)){
														?>
														<option value="<?php echo $row1['code']; ?>"><?php echo $row1['name']; ?></option>
														<?php } ?>
													</select>
                                                    
                                                </div>
                                            </div>


	 							  <div class="col-md-12">
        			<div class="card">
              			<div class="card-header" style="background-color:#007cbc;color:white">
				  			<h3 class="card-title"><b>ITEM DETAILS</b></h3>
              			</div>
						<div class="card-body">
					
<table border="1" id="item_table">
<thead>
<tr>
    <th>Sr</th>
    <th style="width:250px">Item</th>
    <th style="width:300px">Description</th>
    <th style="width:80px">Qty</th>
    <th style="width:140px">Rate</th>
    <th style="width:150px">Amt</th>
    <th style="width:180px">L.P.Dt</th>
    <th style="width:200px">Reason</th>
    <th>
        <button type="button" id="add_row" class="btn btn-default">
            <i class="fa fa-plus"></i>
        </button>
    </th>
</tr>
</thead>

<tbody>
<?php
if(isset($_GET['edit']) || isset($_GET['rev'])){
$code = isset($_GET['edit']) ? $_GET['edit'] : $_GET['rev'];

$sql="SELECT * FROM reqchild WHERE code='$code'";
$data=mysqli_query($con,$sql);
$x=1;

while($row=mysqli_fetch_assoc($data)){
?>
<tr id="row_<?php echo $x; ?>">

<td><?php echo $x; ?></td>

<td>
<select name="item[]" id="item_<?php echo $x; ?>" class="form-control">
<option value="">~~SELECT~~</option>
<?php
$res=mysqli_query($mainCon,"SELECT DISTINCT item FROM reqchild");
while($r=mysqli_fetch_assoc($res)){
?>
<option value="<?php echo $r['item']; ?>"
<?php if($r['item']==$row['item']) echo "selected"; ?>>
<?php echo $r['item']; ?>
</option>
<?php } ?>
</select>
</td>

<td><textarea name="descr[]" id="descr_<?php echo $x; ?>" class="form-control"><?php echo $row['descr']; ?></textarea></td>

<td><input type="text" name="qty[]" id="qty_<?php echo $x; ?>" value="<?php echo $row['qty']; ?>" class="form-control"></td>
<td><input type="text" name="rate[]" id="rate_<?php echo $x; ?>" value="<?php echo $row['rate']; ?>" class="form-control"></td>
<td><input type="text" name="amt[]" id="amt_<?php echo $x; ?>" value="<?php echo $row['amt']; ?>" class="form-control"></td>
<td><input type="text" name="lpdt[]" id="lpdt_<?php echo $x; ?>" value="<?php echo $row['lpdt']; ?>" class="form-control"></td>
<td><textarea name="reason[]" id="reason_<?php echo $x; ?>" class="form-control"><?php echo $row['reason']; ?></textarea></td>



<td>

<button type="button" class="btn btn-danger btn-xs" onclick="removeRow(<?php echo $x; ?>)">
-
</button>
</td>

</tr>

<?php
if(($row['row_type'] ?? '')=='TEXT'){
echo "<script>$(function(){ makeTextRow($x); });</script>";
}
$x++;
}
}
?>
</tbody>
</table>


<h4>Grouping (For Print)</h4>

<table border="1" width="50%" id="group_table">
    <thead>
        <tr>
            <th style="width:100px">Group</th>
            <th style="width:250px">Row Nos (comma separated)</th>
            <th style="width:50px">
                <button type="button" id="add_group" class="btn btn-default">
                    <i class="fa fa-plus"></i>
                </button>
            </th>
        </tr>
    </thead>
    <tbody>

<?php
if (isset($_GET['edit']) || isset($_GET['rev'])) {

    $code = isset($_GET['edit']) ? $_GET['edit'] : $_GET['rev'];

    $gq = mysqli_query($con, "SELECT * FROM req_grouping WHERE code='$code'");

    if (mysqli_num_rows($gq) > 0) {

        while ($g = mysqli_fetch_assoc($gq)) {
?>
        <tr>
            <td>
                <input type="text"
                       name="grp_name[]"
                       class="form-control"
                       value="<?php echo htmlspecialchars($g['grp_name']); ?>">
            </td>

            <td>
                <input type="text"
                       name="grp_rows[]"
                       class="form-control"
                       value="<?php echo htmlspecialchars($g['rowws']); ?>">
            </td>

            <td>
                <button type="button" class="btn btn-default remove_group">
                    <i class="fa fa-minus"></i>
                </button>
            </td>
        </tr>
<?php
        }

    } else {
        // No grouping exists → show one empty row
?>
        <tr>
            <td><input type="text" name="grp_name[]" class="form-control" placeholder="A"></td>
            <td><input type="text" name="grp_rows[]" class="form-control" placeholder="1,2,3"></td>
            <td></td>
        </tr>
<?php
    }

} else {
    // New entry
?>
        <tr>
            <td><input type="text" name="grp_name[]" class="form-control" placeholder="A"></td>
            <td><input type="text" name="grp_rows[]" class="form-control" placeholder="1,2,3"></td>
            <td></td>
        </tr>
<?php } ?>

    </tbody>
</table>


					</div></div></div>
				 <div class="row">
				<div class="col-md-6">
			  <div class="card-body">
					</div>
					</div>
					  <div class="col-md-6">
			  <div class="card-body float-right">
				  <div class="row form-group">
					<div class="col col-md-5">
              			<label for="hf-password" class=" form-control-label">Total</label>
					  </div>
					  <div class="col-12 col-md-7">
            				<input type="text" id="ttl" name="ttl" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $ttl;} ?>"  class="form-control" >
					 </div>
				  </div>
				  	
<!-- Packaging -->
<div class="row form-group">
    <div class="col-md-5"><label>Packaging</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="pkg_per" name="pkg_per"
               class="form-control" placeholder="%" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $pkg_per;} ?>" onkeyup="calcExtra('pkg')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="pkg_amt" name="pkg_amt"
               class="form-control" placeholder="Amt" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $pkg_amt;} ?>" onkeyup="calcExtraAmt('pkg')">
    </div>
</div>

<!-- Forwarding -->
<div class="row form-group">
    <div class="col-md-5"><label>Forwarding</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="fwd_per" name="fwd_per"
               class="form-control" placeholder="%" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $fwd_per;} ?>" onkeyup="calcExtra('fwd')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="fwd_amt" name="fwd_amt"
               class="form-control" placeholder="Amt" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $fwd_amt;} ?>" onkeyup="calcExtraAmt('fwd')">
    </div>
</div>


<div class="row form-group">
    <div class="col-md-5"><label>CGST</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="cgst_per" name="cgst_per"
               class="form-control" placeholder="%" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $cgst_per;} ?>" onkeyup="calcExtra('cgst')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="cgst_amt" name="cgst_amt"
               class="form-control" placeholder="Amt" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $cgst_amt;} ?>" onkeyup="calcExtraAmt('cgst')">
    </div>
</div>


<div class="row form-group">
    <div class="col-md-5"><label>SGST</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="sgst_per" name="sgst_per"
               class="form-control" placeholder="%" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $sgst_per;} ?>" onkeyup="calcExtra('sgst')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="sgst_amt" name="sgst_amt"
               class="form-control" placeholder="Amt" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $sgst_amt;} ?>" onkeyup="calcExtraAmt('sgst')">
    </div>
</div>


<div class="row form-group">
    <div class="col-md-5"><label>IGST</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="igst_per" name="igst_per"
               class="form-control" placeholder="%" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $igst_per;} ?>" onkeyup="calcExtra('igst')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="igst_amt" name="igst_amt"
               class="form-control" placeholder="Amt" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $igst_amt;} ?>" onkeyup="calcExtraAmt('igst')">
    </div>
</div>



<!-- Discount -->
<div class="row form-group">
    <div class="col-md-5"><label>Discount</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="dis_per" name="dis_per"
               class="form-control" placeholder="%" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $dis_per;} ?>" onkeyup="calcExtra('dis')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="dis_amt" name="dis_amt"
               class="form-control" placeholder="Amt" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $dis_amt;} ?>" onkeyup="calcExtraAmt('dis')">
    </div>
</div>

<!-- Grand Total -->
<div class="row form-group">
    <div class="col-md-5"><label><b>Grand Total</b></label></div>
    <div class="col-md-7">
        <input type="text"
               id="grandttl" name="grandttl" value="<?php if(isset($_GET['edit']) || isset($_GET['rev'])){echo $grandttl;} ?>"
               class="form-control" readonly>
    </div>
</div>


				 
				 </div>
				</div>
		  </div>

      <div class="row mt-4">
  <div class="col-md-12">
    <h6 class="fw-bold">Category</h6>
    <table class="table table-bordered">
<tr>
<td>1</td><td>M/c Spares</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="M/c Spares"
<?php echo in_array('M/c Spares',$selCategory)?'checked':''; ?>>
</td>

<td>5</td><td>AMC / Service Contract / Yearly</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="AMC"
<?php echo in_array('AMC',$selCategory)?'checked':''; ?>>
</td>
</tr>

<tr>
<td>2</td><td>Stationary</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="Stationary"
<?php echo in_array('Stationary',$selCategory)?'checked':''; ?>>
</td>

<td>6</td><td>Capital Expenditure</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="Capital"
<?php echo in_array('Capital',$selCategory)?'checked':''; ?>>
</td>
</tr>

<tr>
<td>3</td><td>Cleaning</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="Cleaning"
<?php echo in_array('Cleaning',$selCategory)?'checked':''; ?>>
</td>

<td>7</td><td>General Office Expense</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="Office"
<?php echo in_array('Office',$selCategory)?'checked':''; ?>>
</td>
</tr>

<tr>
<td>4</td><td>General Maintenance</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="Maintenance"
<?php echo in_array('Maintenance',$selCategory)?'checked':''; ?>>
</td>

<td>8</td><td>Miscellaneous / Others</td>
<td class="text-center">
<input type="checkbox" name="category[]" value="Misc"
<?php echo in_array('Misc',$selCategory)?'checked':''; ?>>
</td>
</tr>
</table>

  </div>
</div>

<div class="row mt-3">
  <div class="col-md-6">
    <h6 class="fw-bold">Terms & Conditions</h6>

    <div class="form-group mb-2">
    <label>Payment</label>

    <select id="payment_term" name="payment_term" class="form-control select2" style="width:100%">
        <option value="">Select or Type Payment Term</option>

        <?php
        $qry = mysqli_query($mainCon, "SELECT DISTINCT payment_term FROM reqentry WHERE payment_term != ''");
        while ($row = mysqli_fetch_assoc($qry)) {
        ?>
            <option value="<?php echo htmlspecialchars($row['payment_term']); ?>"
            <?php echo (($payment_term ?? '') == $row['payment_term']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($row['payment_term']); ?>
            </option>
        <?php } ?>
    </select>
</div>


    <div class="form-group mb-2">
      <label>Freight</label>
      <input type="text" name="freight_term" class="form-control" value="<?php echo $freight_term ?? ''; ?>">
    </div>

    <div class="form-group">
      <label>Delivery</label>
      <input type="text" name="delivery_term" class="form-control" value="<?php echo $delivery_term ?? ''; ?>">
    </div>
  </div>
 <!-- RIGHT COLUMN -->
  <div class="col-md-6">

    <h6 class="fw-bold">Prepared By</h6>
    <div class="form-group mb-3">
      <select id="prepared_by" name="prepared_by" class="form-control select2" style="width:100%">
        <option value="">Select or Type Name</option>
        <?php
        $qry = mysqli_query($mainCon, "SELECT DISTINCT prepared_by FROM reqentry WHERE prepared_by != ''");
        while ($row = mysqli_fetch_assoc($qry)) {
        ?>
          <option value="<?php echo htmlspecialchars($row['prepared_by']); ?>"
            <?php echo ($prepared_by == $row['prepared_by']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($row['prepared_by']); ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <h6 class="fw-bold">Checked By</h6>
    <div class="form-group">
      <select id="checked_by" name="checked_by" class="form-control select2" style="width:100%">
        <option value="">Select or Type Name</option>
        <?php
        $qry11 = mysqli_query($mainCon, "SELECT DISTINCT checked_by FROM reqentry WHERE checked_by != ''");
        while ($row11 = mysqli_fetch_assoc($qry11)) {
        ?>
          <option value="<?php echo htmlspecialchars($row11['checked_by']); ?>"
            <?php echo ($checked_by == $row11['checked_by']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($row11['checked_by']); ?>
          </option>
        <?php } ?>
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
                <!--  <input type="button"  class="btn btn-success " id="submitBtn" data-toggle="modal" data-target="#confirm-submit"  value="Save" name="send" />-->
				<button type="submit" name="save" value="Save" id="submitbtn" class="btn btn-success float-right" style="margin-left:6px">Save</button>
									<?php } ?>
                  <a href="reqsearch.php"><button type="button" class="btn btn-danger float-right">Back</button></a>
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
 <script src="../admintemplate/plugins/select2/js/select2.full.min.js"></script>

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


	  <script>
	$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
		  $('.select2').select2()
	
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    }) 
  $('#prepared_by').select2({tags:true})
  $('#checked_by').select2({tags:true})  
	//$('#vendor').select2({tags:true})
	$('#payment_term').select2({tags:true})
	})
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })  
</script>
<script>
$("#add_row").off('click').on('click', function () {

    var count_table_tbody_tr = $("#item_table tbody tr").length;
    var row_id = count_table_tbody_tr + 1;
    var vendor = $('#vendor').val();

    if (vendor == '') {
        swal('Please Select The Vendor..!');
        return false;
    }

    $.ajax({
        url: 'getitemmst.php',
        type: 'post',
        dataType: 'json',
        success: function (response) {

            var html = '<tr id="row_' + row_id + '">' +
                '<td>' + row_id + '</td>' +

                '<td style="width:250px">' +
                '<select class="form-control item" id="item_' + row_id + '" name="item[]" style="width:100%" onchange="getLastPurchaseDate(' + row_id + ')">' +
                '<option value="">~~SELECT~~</option>';

            $.each(response, function (index, value) {
                html += '<option value="' + value.item + '">' + value.item + '</option>';
            });

            html += '</select></td>' +

            '<td><textarea name="descr[]" id="descr_' + row_id + '" class="form-control"></textarea></td>' +

                '<td><input type="number"  step="any" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="qtykeyup(' + row_id + ')"></td>' +

                '<td><input type="number"  step="any" name="rate[]" id="rate_' + row_id + '" class="form-control" onkeyup="qtykeyup(' + row_id + ')"></td>' +

                '<td><input type="text" name="amt[]" id="amt_' + row_id + '" class="form-control" onkeyup="qtykeyup(' + row_id + ')" ></td>' +

                '<td><input type="text" name="lpdt[]" id="lpdt_' + row_id + '" class="form-control" ></td>' +

                '<td><textarea name="reason[]" id="reason_'+row_id+'" class="form-control"></textarea></td>' +


                '<td><button type="button" class="btn btn-default" onclick="removeRow(' + row_id + ')"><i class="fa fa-minus"></i></button></td>' +
                '</tr>';

            if (count_table_tbody_tr >= 1) {
                $("#item_table tbody tr:last").after(html);
            } else {
                $("#item_table tbody").html(html);
            }

            $("#item_" + row_id).select2({
                tags: true,
                width: '100%'
            });
        }
    });

    return false;
});

$("#add_group").on("click", function () {

    let html = `
    <tr>
        <td><input type="text" name="grp_name[]" class="form-control"></td>
        <td><input type="text" name="grp_rows[]" class="form-control" placeholder="e.g. 4,5"></td>
        <td>
            <button type="button" class="btn btn-default remove_group">
                <i class="fa fa-minus"></i>
            </button>
        </td>
    </tr>`;

    $("#group_table tbody").append(html);
});

$(document).on("click", ".remove_group", function () {
    $(this).closest("tr").remove();
});




function getLastPurchaseDate(row_id) {

    var item = $("#item_" + row_id).val();

    if (item == '') {
        $("#lpdt_" + row_id).val('');
        return;
    }

    $.ajax({
        url: 'get_last_po_date.php',
        type: 'POST',
        dataType: 'json',
        data: { item: item },
        success: function (res) {
            if (res.status == 'success') {
                $("#lpdt_" + row_id).val('L. P. Dt. ' + res.date);
            } else {
                $("#lpdt_" + row_id).val('');
            }
        }
    });
}


/* REMOVE ROW */
function removeRow(row_id) {
    $("#row_" + row_id).remove();
    subAmount();
}

$(document).on('input', '[id^=qty_], [id^=rate_], [id^=amt_]', function () {
    subAmount();
});

/* TOTAL CALCULATION (ONLY TOTAL) */
function subAmount() {
    var ttl = 0;
    $("#item_table tbody tr").each(function () {
        var id = this.id.replace('row_', '');

        var qty  = parseFloat($("#qty_" + id).val()) || 0;
        var rate = parseFloat($("#rate_" + id).val()) || 0;
        var amtInput = parseFloat($("#amt_" + id).val()) || 0;

        var amt = 0;

        // If user entered AMT directly
        if (amtInput > 0 && (qty === 0 || rate === 0)) {
            amt = amtInput;
        } 
        // Else calculate from qty & rate
        else {
            amt = qty * rate;
            $("#amt_" + id).val(amt.toFixed(2));
        }

        ttl += amt;
    });

    $("#ttl").val(ttl.toFixed(2));

    calcExtra('pkg');
    calcExtra('fwd');
    calcExtra('dis');
    calcExtra('cgst');
    calcExtra('sgst');
    calcExtra('igst');
    calcGrandTotal();
}

function calcExtra(type) {

    var ttl = parseFloat($("#ttl").val()) || 0;
    var per = parseFloat($("#" + type + "_per").val()) || 0;

    var amt = (ttl * per) / 100;

    $("#" + type + "_amt").val(amt.toFixed(2));

    calcGrandTotal();
}
function calcExtraAmt(type) {

    var ttl = parseFloat($("#ttl").val()) || 0;
    var amt = parseFloat($("#" + type + "_amt").val()) || 0;

    var per = ttl > 0 ? (amt * 100 / ttl) : 0;

    $("#" + type + "_per").val(per.toFixed(2));

    calcGrandTotal();
}
function calcGrandTotal() {

    var ttl = parseFloat($("#ttl").val()) || 0;
    var pkg = parseFloat($("#pkg_amt").val()) || 0;
    var fwd = parseFloat($("#fwd_amt").val()) || 0;
    var dis = parseFloat($("#dis_amt").val()) || 0;
    var cgst = parseFloat($("#cgst_amt").val()) || 0;
    var sgst = parseFloat($("#sgst_amt").val()) || 0;
    var igst = parseFloat($("#igst_amt").val()) || 0;

    var grand = ttl + pkg + fwd + cgst + sgst + igst - dis;

    $("#grandttl").val(grand.toFixed(2));
}


/* QTY / RATE KEYUP */
function qtykeyup(id) {
    subAmount();
}
</script>

  <script>
$( document ).ready(function() {
$("#entries").addClass("menu-open");
$("#entriesa").addClass("active");
$("#entriesa").css("background-color","#007cbc");
$("#reqchs").addClass("menu-open");
$("#reqcha").addClass("active");
$("#reqcha").css("background-color","ofwhite");
$("#reqchenty").addClass("active");

});
</script> 
</body>
</html>
