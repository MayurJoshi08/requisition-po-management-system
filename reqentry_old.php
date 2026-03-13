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

        
    $pkg_per = $row['pkg_per'];
$pkg_amt = $row['pkg_amt'];
$fwd_per = $row['fwd_per'];
$fwd_amt = $row['fwd_amt'];
$dis_per = $row['dis_per'];
$dis_amt = $row['dis_amt'];
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

        $pkg_per = $row['pkg_per'];
        $pkg_amt = $row['pkg_amt'];
        $fwd_per = $row['fwd_per'];
        $fwd_amt = $row['fwd_amt'];
        $dis_per = $row['dis_per'];
        $dis_amt = $row['dis_amt'];
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
														$qr1=mysqli_query($con,"select distinct code,name from vendormst");
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
					
							<table border=1 id="item_table">
                  <thead>
                    <tr>
                      	<th style="width: 10px">Sr No.</th>
                      	<th style="width:250px">Item</th>
						<th style="width:300px">Description</th>
						<!--<th style="width:100px">HSN</th>-->
						<th style="width:80px">Qty</th>
						<th style="width:140px">Rate</th>
						<th style="width:150px">Amt</th>
            <th style="width:180px">L. P. Dt.</th>
            <th style="width:200px">Reason</th>
            
						<th style="width:20px"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>	
                          <?php 
if(isset($_GET['edit']) || isset($_GET['rev'])){
    $code = isset($_GET['edit']) ? $_GET['edit'] : $_GET['rev'];

$sql="SELECT srno,item,qty,rate,amt,lpdt,descr,reason  FROM reqchild WHERE code='$code'";
$data=mysqli_query($con,$sql);

$x=1;
while($row=mysqli_fetch_assoc($data)){

$item = $row['item'];   // ✅ correct
?>
<tr id="row_<?php echo $x; ?>">
<td><?php echo $x; ?></td>

<td>
<select class="select2" id="item_<?php echo $x; ?>" name="item[]" style="width:100%;" onchange="getItemData(<?php echo $x; ?>)">
<option value="">~~SELECT~~</option>

<?php
$res = mysqli_query($con,"SELECT DISTINCT item FROM reqchild");
while($row1=mysqli_fetch_assoc($res)){
?>
<option value="<?php echo $row1['item']; ?>"
<?php if($item == $row1['item']) echo "selected"; ?>>
<?php echo $row1['item']; ?>
</option>
<?php } ?>

</select>
</td>

<td>
<textarea name="descr[]" id="descr_<?php echo $x; ?>" class="form-control"><?php echo $row['descr']; ?></textarea>
</td>

						  <!-- <td><input type="text" name="hsn[]" id="hsn_<?php echo $x; ?>"  value="<?php echo $row['hsn'];?>"class="form-control"></td>-->
						   <td><input type="text" name="qty[]" id="qty_<?php echo $x; ?>" onkeyup="qtykeyup(<?php echo $x; ?>)"  value="<?php echo $row['qty'];?>"class="form-control"></td>
						   <td><input type="text" name="rate[]" id="rate_<?php echo $x; ?>" onkeyup="qtykeyup(<?php echo $x; ?>)"  value="<?php echo $row['rate'];?>"class="form-control"></td>
                        
						  <td><input type="text" name="amt[]" id="amt_<?php echo $x; ?>" value="<?php echo $row['amt'];?>"class="form-control"></td>
              <td>
    <input type="text"
           name="lpdt[]"
           id="lpdt_<?php echo $x; ?>"
           value="<?php echo $row['lpdt'];?>"
           class="form-control">
</td>

<td>
<textarea name="reason[]" id="reason_<?php echo $x; ?>" class="form-control"><?php echo $row['reason']; ?></textarea>
</td>
						
					<td><button type="button" class="btn btn-default" onclick="removeRow(<?php echo $x; ?>)"><i class="fa fa-minus"></i></button></td>
                    </tr>
                       <?php $x++; ?>
                     <?php } ?>
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
        $qry = mysqli_query($con, "SELECT DISTINCT payment_term FROM reqentry WHERE payment_term != ''");
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

    <div class="col-md-6">
    <h6 class="fw-bold">Prepared By</h6>

   <select id="prepared_by" name="prepared_by" class="form-control select2" style="width:100%">
<option value="">Select or Type Name</option>

<?php
$qry = mysqli_query($con, "SELECT DISTINCT prepared_by FROM reqentry WHERE prepared_by != ''");
while ($row = mysqli_fetch_assoc($qry)) {
?>
<option value="<?php echo htmlspecialchars($row['prepared_by']); ?>"
<?php echo ($prepared_by == $row['prepared_by']) ? 'selected' : ''; ?>>
<?php echo htmlspecialchars($row['prepared_by']); ?>
</option>
<?php } ?>
</select>


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
    <strong>Copyright &copy; 2025 <a href="" style="color:#007cbc">Mayur Joshi</a>.</strong> All rights reserved.
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
        url: 'getitemmst.php', // must return DISTINCT items from reqchild
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

            // Select2 with tags enabled
            $("#item_" + row_id).select2({
                tags: true,
                width: '100%'
            });
        }
    });

    return false;
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

/* TOTAL CALCULATION (ONLY TOTAL) */
function subAmount() {
    var ttl = 0;

    $("#item_table tbody tr").each(function () {
        var id = $(this).attr('id').replace('row_', '');

        var qty  = parseFloat($("#qty_" + id).val()) || 0;
        var rate = parseFloat($("#rate_" + id).val()) || 0;
        var amt  = parseFloat($("#amt_" + id).val()) || 0;

        if (qty > 0 && rate > 0) {
            amt = qty * rate;
            $("#amt_" + id).val(amt.toFixed(2));
        }

        ttl += amt;
    });

    $("#ttl").val(ttl.toFixed(2));

    calcExtra('pkg');
    calcExtra('fwd');
    calcExtra('dis');
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

    var grand = ttl + pkg + fwd - dis;

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
