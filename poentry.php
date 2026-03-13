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
            <h1>PO Entry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="index.php" style="color:#007cbc">Home</a></li>
              <li class="breadcrumb-item" >PO Entry</li>
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
				  <h3 class="card-title"><b>PO Entry</b></h3>
              </div>
			<!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="post" action="poinput.php" id="formfield">
<?php
include('config.php');
date_default_timezone_set('Asia/Kolkata');

$curdt = date('Y-m-d');

$month = date('n');   // 1 to 12
$year  = date('y');   // last 2 digits

if ($month >= 4) {
    // April to December
    $fy = $year . ($year + 1);
} else {
    // January to March
    $fy = ($year - 1) . $year;
}


/* ===============================
   DEFAULT VALUES (ADD MODE)
================================ */
$code      = '';
$potype    = '';
$invno     = '';
$dt        = $curdt;
$reqcode   = '';
$selectedReqCodes = [];
$reqdate   = '';
$cnor      = '';
$tqty      = 0;
$ttl       = 0;
$disc      = 0;
$gttl      = 0;
$sign = '';
$factory = '';

/* ===============================
   EDIT / VIEW MODE
================================ */
if (isset($_GET['edit']) || isset($_GET['view'])) {

    $code = $_GET['edit'] ?? $_GET['view'];

    $q = mysqli_query($con, "
        SELECT *
        FROM poentry
        WHERE code = '$code'
    ");

    if ($row = mysqli_fetch_assoc($q)) {

        $potype  = $row['potype'] ?? '';
        $invno   = $row['code'] ?? '';
        $dt      = $row['dt'] ?? $curdt;
        $reqcode = $row['reqcode'] ?? '';
        $reqdate = $row['reqdate'] ?? '';
        $vendorcode=$row['vendor'];
													$qr1=mysqli_query($con,"select name from vendormst where code='$vendorcode'");
													$res1=mysqli_fetch_array($qr1);
													$vendor= $res1['name'];
        $tqty    = $row['tqty'] ?? 0;
        $ttl     = $row['ttl'] ?? 0;
        $disc    = $row['disc'] ?? 0;
        $gttl    = $row['gttl'] ?? 0;

                $payment_term = $row['payment_term'];
        $freight_term = $row['freight_term'];
        $delivery_term = $row['delivery_term'];
$sign = $row['sign'];
        
    $pkg_per = $row['pkg_per'];
$pkg_amt = $row['pkg_amt'];
$fwd_per = $row['fwd_per'];
$fwd_amt = $row['fwd_amt'];
$dis_per = $row['dis_per'];
$dis_amt = $row['dis_amt'];

$factory = $row['factory'] ?? '';

// Convert reqcode to array
        $selectedReqCodes = array_filter(explode(',', $reqcode));
    }

}
/* ===============================
   REV MODE (PO ENTRY)
================================ */
if (isset($_GET['rev'])) {

    $oldCode = $_GET['rev'];

    $q = mysqli_query($con, "
        SELECT *
        FROM poentry
        WHERE code = '$oldCode'
    ");

    if ($row = mysqli_fetch_assoc($q)) {

        // 🔥 New revised PO code
        $code   = 'REV-' . $oldCode;
        $invno  = $code;          // show revised code
        $update = false;          // IMPORTANT → INSERT, not UPDATE

        // Copy values
        $potype  = $row['potype'] ?? '';
        $dt      = date('Y-m-d'); // or $row['dt'] if you want same date
        $reqcode = $row['reqcode'] ?? '';
        $reqdate = $row['reqdate'] ?? '';
        $vendorcode = $row['vendor'];

        // Vendor name
        $qr1 = mysqli_query($con,"SELECT name FROM vendormst WHERE code='$vendorcode'");
        $res1 = mysqli_fetch_assoc($qr1);
        $vendor = $res1['name'] ?? '';

        $tqty = $row['tqty'] ?? 0;
        $ttl  = $row['ttl'] ?? 0;
        $disc = $row['disc'] ?? 0;
        $gttl = $row['gttl'] ?? 0;

        $payment_term  = $row['payment_term'];
        $freight_term  = $row['freight_term'];
        $delivery_term = $row['delivery_term'];
        $sign = $row['sign'];

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
        $factory = $row['factory'];

        // Convert reqcode to array
        $selectedReqCodes = array_filter(explode(',', $reqcode));
    }
}

/* ===============================
   ADD MODE → AUTO INV NO
 */
if (!isset($_GET['edit']) && !isset($_GET['view']) && !isset($_GET['rev'])) {

    $q = mysqli_query($con, "
        SELECT MAX(CAST(SUBSTRING_INDEX(code,'-',1) AS UNSIGNED)) AS maxno
        FROM poentry
        WHERE code LIKE '%-$fy'
    ");

    $r = mysqli_fetch_assoc($q);
    $next = ($r['maxno'] ?? 0) + 1;
    $invno = $next . '-' . $fy;
}

$isAdd  = !isset($_GET['edit']) && !isset($_GET['view']) && !isset($_GET['rev']);
$isEdit = isset($_GET['edit']);
$isView = isset($_GET['view']);
$isRev  = isset($_GET['rev']);

?>


			<div class="card-body">
        <div class="row form-group">
  <div class="col-md-3">
    <label>Type</label>
  </div>
  <div class="col-md-9">
<select id="potype" name="potype" class="select2 form-control">
    <option value="">Select</option>
    <option value="PO" <?php if(empty($potype) || $potype=='PO') echo 'selected'; ?>>
        Purchase Order
    </option>
    <option value="WO" <?php if($potype=='WO') echo 'selected'; ?>>
        Work Order
    </option>
</select>

  </div>
</div>


        <div class="row form-group">
  <div class="col-md-3">
    <label>Factory</label>
  </div>
  <div class="col-md-9">
<select id="factory" name="factory" class="select2 form-control" required>
    <option value="">Select</option>

    <option value="KDL" <?php if(isset($factory) && $factory=='KDL') echo 'selected'; ?>>
        Kandla
    </option>

    <option value="AMD" <?php if(isset($factory) && $factory=='AMD') echo 'selected'; ?>>
        Ahmedabad
    </option>
</select>


  </div>
</div>
				<div class="row form-group">
          <div class="col col-md-3">
              <label for="hf-password" id="pono_label" class=" form-control-label">PO No</label>
        </div>
         <div class="col-12 col-md-4">
          <input type="text" id="invno" name="invno" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){ echo $invno;}else{echo $invno;}  ?>" class="form-control">
                                                    
        </div>
											</div>
							
                                            <div class="row form-group"> 
    <div class="col col-md-3">
        <label for="hf-password"  id="podate_label" class="form-control-label">PO Date</label>
    </div>
    <div class="col-12 col-md-9">
        <input type="date" id="dt" name="dt" class="form-control" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){ echo $dt;}else{ echo $curdt;} ?>">
    </div>
</div>


<?php
$reqFilter = '';
if (!empty($selectedReqCodes)) {
    $reqFilter = " OR r.code IN ('" . implode("','", $selectedReqCodes) . "')";
}

$q = mysqli_query($con, "
    SELECT r.code
    FROM reqentry r
    WHERE 
        NOT EXISTS (
            SELECT 1
            FROM poentry p
            WHERE FIND_IN_SET(r.code, p.reqcode)
        )
        $reqFilter
    ORDER BY r.code DESC
");
?>

<div class="row form-group">
  <div class="col-md-3">
    <label>Req Code</label>
  </div>

  <div class="col-md-9">
    <select id="reqcode" name="reqcode[]" class="select2 form-control" multiple style="width:100%">
      <?php
      while ($r = mysqli_fetch_assoc($q)) {

          $selected = in_array($r['code'], $selectedReqCodes) ? 'selected' : '';

          echo "<option value='{$r['code']}' $selected>{$r['code']}</option>";
      }
      ?>
    </select>
  </div>
</div>



				 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Req. Date</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                
           <input id="reqdate" type="date" name="reqdate" class="form-control" readonly value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){ echo $reqdate;}else{ echo '';}?>">  
                                          </div>
                                            </div>
				
<div class="row form-group">
    <div class="col col-md-3">
        <label class="form-control-label">Vendor</label>
    </div>

    <div class="col-12 col-md-9">

<?php if ($isEdit || $isView) { ?>

<input
    type="text"
    id="vendor_name"
    class="form-control"
    readonly
    value="<?php echo $vendor ?? ''; ?>"
>
<input
    type="hidden"
    name="cnor"
    id="cnor_hidden"
    value="<?php echo $vendorcode ?? ''; ?>"
>

<?php } else { ?>

<select
    name="cnor"
    id="cnor"
    class="select2 form-control"
    style="width:100%"
    required
>
    <option value="">-- Select Vendor --</option>

    <?php
    $vq = mysqli_query($con, "SELECT code, name FROM vendormst ORDER BY name");
    while ($v = mysqli_fetch_assoc($vq)) {

        $selected = (!empty($vendorcode) && $vendorcode == $v['code'])
            ? 'selected'
            : '';

        echo "<option value='{$v['code']}' $selected>{$v['name']}</option>";
    }
    ?>
</select>

<?php } ?>

    </div>
</div>




	 							  <div class="col-md-12">
        			<div class="card">
              			<div class="card-header" style="background-color:#007cbc;color:white">
				  			<h3 class="card-title"><b>ITEM DETAILS</b></h3>
              			</div>
						<div class="card-body">
					
							<table border=1 id="item_table" class="table">
                  <thead>
                    <tr>
						<th style="width:20px"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                      	<th style="width: 30px">Sr No.</th>
                      		<th style="width:250px">Item</th>
                            <th style="width:300px">Description</th>
						<th style="width:160px">Qty</th>
						<th style="width:200px">Rate</th>
						<th style="width:180px">Amt</th>
						
                    </tr>
                  </thead>
                             <tbody id="tbodyid">
<?php
$loadCode = '';

if (isset($_GET['edit'])) {
    $loadCode = $_GET['edit'];
}
elseif (isset($_GET['rev'])) {
    $loadCode = $_GET['rev'];   // 🔥 load items from old PO
}

if ($loadCode != '') {

    $sql = "SELECT item, descr, hsn, unit, qty, rate, amt 
            FROM pochild 
            WHERE code='$loadCode'";

    $data = mysqli_query($con, $sql);
    $x = 1;

    while ($row = mysqli_fetch_assoc($data)) {
        $item = $row['item'];
?>
    <tr id="row_<?php echo $x; ?>">
        <td>
            <button type="button" class="btn btn-default" onclick="removeRow(<?php echo $x; ?>)">
                <i class="fa fa-minus"></i>
            </button>
        </td>

        <td><?php echo $x; ?></td>

        <td>
            <select
                class="select2"
                data-row-id="row_<?php echo $x; ?>"
                id="item_<?php echo $x; ?>"
                name="item[]"
                style="width:100%;"
            >
                <option value="">~~SELECT~~</option>

                <?php
                $res = mysqli_query($con, "SELECT item FROM reqchild");
                while ($row1 = mysqli_fetch_array($res)) {
                    $sel = ($item == $row1[0]) ? "selected" : "";
                    echo "<option value='{$row1[0]}' $sel>{$row1[0]}</option>";
                }
                ?>
            </select>
        </td>

        <td>
            <textarea
                name="descr[]"
                id="descr_<?php echo $x; ?>"
                class="form-control"
            ><?php echo $row['descr']; ?></textarea>
        </td>

        <td>
            <input
                type="text"
                name="qty[]"
                id="qty_<?php echo $x; ?>"
                onkeyup="qtykeyup(<?php echo $x; ?>)"
                value="<?php echo $row['qty']; ?>"
                class="form-control"
            >
        </td>

        <td>
            <input
                type="text"
                name="rate[]"
                id="rate_<?php echo $x; ?>"
                onkeyup="qtykeyup(<?php echo $x; ?>)"
                value="<?php echo $row['rate']; ?>"
                class="form-control"
            >
        </td>

        <td>
            <input
                type="text"
                name="amt[]"
                id="amt_<?php echo $x; ?>"
                value="<?php echo $row['amt']; ?>"
                class="form-control"
            >
        </td>
    </tr>
<?php
        $x++;
    }
}
?>
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
              			<label for="hf-password" class=" form-control-label">Total Qty</label>
					  </div>
					  <div class="col-12 col-md-7">
            				<input type="text" id="tqty" name="tqty" value="<?php echo $tqty; ?>" class="form-control" readonly>
					 </div>
				  </div>
				  <div class="row form-group">
					<div class="col col-md-5">
              			<label for="hf-password" class=" form-control-label">Total</label>
					  </div>
					  <div class="col-12 col-md-7">
            				<input type="text" id="ttl" name="ttl" value="<?php echo $ttl; ?>"  class="form-control" readonly>
					 </div>
				  </div>
				  <!-- Packaging -->
<!-- Packaging -->
<div class="row form-group">
    <div class="col-md-5"><label>Packaging</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="pkg_per" name="pkg_per"
               class="form-control" placeholder="%" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){echo $pkg_per;} ?>" onkeyup="calcExtra('pkg')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="pkg_amt" name="pkg_amt"
               class="form-control" placeholder="Amt" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){echo $pkg_amt;} ?>" onkeyup="calcExtraAmt('pkg')">
    </div>
</div>

<!-- Forwarding -->
<div class="row form-group">
    <div class="col-md-5"><label>Forwarding</label></div>
    <div class="col-md-3">
        <input type="number" step="0.01"
               id="fwd_per" name="fwd_per"
               class="form-control" placeholder="%" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){echo $fwd_per;} ?>" onkeyup="calcExtra('fwd')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="fwd_amt" name="fwd_amt"
               class="form-control" placeholder="Amt" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){echo $fwd_amt;} ?>" onkeyup="calcExtraAmt('fwd')">
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
               class="form-control" placeholder="%" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){echo $dis_per;} ?>" onkeyup="calcExtra('dis')">
    </div>
    <div class="col-md-4">
        <input type="number" step="0.01"
               id="dis_amt" name="dis_amt"
               class="form-control" placeholder="Amt" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){echo $dis_amt;} ?>" onkeyup="calcExtraAmt('dis')">
    </div>
</div>


				  <div class="row form-group">
					  <div class="col col-md-5">
              			<label for="hf-password" class=" form-control-label">Total Payable</label>
					  </div>
					  <div class="col-12 col-md-7">
            				<input type="text" id="gttl" name="gttl" value="<?php echo $gttl; ?>"  class="form-control" readonly>
					<!--	  <input type="text" id="gttl" name="gttl" value="<?php if((isset($_GET['edit']))||(isset($_GET['rev']))){echo $gttl;} ?>"  class="form-control" readonly>-->
					 </div>
						</div>
			</div>
				</div>
		  </div>

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

    <div class="form-group">
      <label>Signature</label>
      <select id="sign" name="sign" class="form-control select2" style="width:100%">
        <option value="">Select or Type Name</option>
        <?php
        $qry11 = mysqli_query($mainCon, "SELECT DISTINCT sign FROM poentry WHERE sign != ''");
        while ($row11 = mysqli_fetch_assoc($qry11)) {
        ?>
          <option value="<?php echo htmlspecialchars($row11['sign']); ?>"
            <?php echo ($sign == $row11['sign']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($row11['sign']); ?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>


			 <!-----footer----->
<div class="card-footer">
   <?php if((isset($_GET['edit']))||(isset($_GET['view']))){ ?>
            <input type="submit" class="btn btn-primary float-left" id="updBtn" value="Update" name="upd" />
	<?php  }else{ ?>
   			<input type="submit" class="btn btn-success" id="submitBtn" value="Save" name="send" />
	<?php } ?>
       		<a href="posearch.php"><button type="button" class="btn btn-danger float-right">Back</button></a>
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
    $('#reqcode').select2({
    placeholder: "Select Req Code(s)"
});
	//$('#vehno').select2({tags:true})
	$('#shipfrom').select2({tags:true})
	$('#shipto').select2({tags:true})
    $('#sign').select2({tags:true})
	})
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })  
</script>


<script>


function changePOLabels(){
    let type = $('#potype').val();

    if(type === 'WO'){
        $('#pono_label').text('WO No');
        $('#podate_label').text('WO Date');
    } else {
        $('#pono_label').text('PO No');
        $('#podate_label').text('PO Date');
    }
}

// Trigger on change
$('#potype').on('change', function(){
    changePOLabels();
});

// Trigger on page load (edit/view mode)
$(document).ready(function(){
    changePOLabels();
});




let rowCount = 0;

/* =========================
   LOAD DATA ON REQ CODE
========================= */
$('#reqcode').on('change', function () {

    let codes = $(this).val();
    if (!codes || codes.length === 0) {
        $('#tbodyid').html('');
        $('#reqdate').val('');
        $('#cnor').html('');
        return;
    }

    $.ajax({
        url: 'get_req_data.php',
        type: 'POST',
        data: { codes: codes },
        dataType: 'json',
        success: function (data) {

            /* ---------- Req Dates ---------- */
            /* ---------- Req Date (First only) ---------- */
if (data.entry.length > 0) {
    $('#reqdate').val(data.entry[0].dt);
} else {
    $('#reqdate').val('');
}

if (data.entry.length > 0) {

    let vendorCodes = data.entry.map(e => e.vendor);
    let vendorNames = data.entry.map(e => e.vendor_name);

    let uniqueCodes = [...new Set(vendorCodes)];
    let uniqueNames = [...new Set(vendorNames)];

    if (uniqueCodes.length === 1) {

        if ($('#cnor').length) {
            // ADD / REV mode (Select2)
            $('#cnor')
                .val(uniqueCodes[0])
                .trigger('change');   // 🔥 REQUIRED
        } else {
            // EDIT / VIEW mode
            $('#vendor_name').val(uniqueNames[0]);
            $('#cnor_hidden').val(uniqueCodes[0]);
        }

    } else {
        alert('Different vendors found in selected Req Codes');

        if ($('#cnor').length) {
            $('#cnor').val('').trigger('change');
        } else {
            $('#vendor_name').val('Multiple Vendors');
            $('#cnor_hidden').val('');
        }
    }
}

/*if (data.entry.length > 0) {

    let vendorCodes = data.entry.map(e => e.vendor);
    let vendorNames = data.entry.map(e => e.vendor_name);

    let uniqueCodes = [...new Set(vendorCodes)];
    let uniqueNames = [...new Set(vendorNames)];

    if (uniqueCodes.length === 1) {
        $('#cnor').val(uniqueCodes[0]);        // SAVE CODE
        $('#cnor_name').val(uniqueNames[0]);  // SHOW NAME
    } else {
        $('#cnor').val('');
        $('#cnor_name').val('Multiple Vendors');
        alert('Different vendors found in selected Req Codes');
    }
}*/

if(data.entry.length > 0){

    let e = data.entry[0];   // only one req expected

    $('#pkg_per').val(e.pkg_per);
    $('#pkg_amt').val(e.pkg_amt);

    $('#fwd_per').val(e.fwd_per);
    $('#fwd_amt').val(e.fwd_amt);

    $('#dis_per').val(e.dis_per);
    $('#dis_amt').val(e.dis_amt);

    $('#cgst_per').val(e.cgst_per);
    $('#cgst_amt').val(e.cgst_amt);
    $('#sgst_per').val(e.sgst_per);
    $('#sgst_amt').val(e.sgst_amt);
    $('#igst_per').val(e.igst_per);
    $('#igst_amt').val(e.igst_amt);

    $('#gttl').val(e.grandttl);

        $('#payment_term').val(e.payment_term).trigger('change');
    $('input[name="freight_term"]').val(e.freight_term);
    $('input[name="delivery_term"]').val(e.delivery_term);
}


            /* ---------- Clear Table ---------- */
            $('#tbodyid').html('');
            rowCount = 0;

            /* ---------- Load Req Items ---------- */
            data.child.forEach(row => {
                rowCount++;

                let tr = `
                <tr id="row_${rowCount}">
                    <td>
                        <button type="button" class="btn btn-default"
                            onclick="removeRow(${rowCount})">
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>
                    <td>${rowCount}</td>

                    <!-- ITEM (TEXT, NOT DROPDOWN) -->
                    <td>
                        <input type="text" name="item[]" 
                            value="${row.item}" style="width:100%"
                            class="form-control" readonly>
                    </td>

                    <td>
                        <textarea name="descr[]" class="form-control" readonly>${row.descr ?? ''}</textarea>
                    </td>

                    <td>
                        <input type="text" name="qty[]" 
                            id="qty_${rowCount}" 
                            value="${row.qty}" 
                            onkeyup="qtykeyup(${rowCount})"
                            class="form-control">
                    </td>

                    <td>
                        <input type="text" name="rate[]" 
                            id="rate_${rowCount}" 
                            value="${row.rate}" 
                            onkeyup="qtykeyup(${rowCount})"
                            class="form-control">
                    </td>

                    <td>
                        <input type="text" name="amt[]" 
                            id="amt_${rowCount}" 
                            value="${row.amt}" 
                            class="form-control" readonly>
                    </td>
                </tr>
                `;

                $('#tbodyid').append(tr);
            });

            subAmount();
        }
    });
});



/* =========================
   ADD ROW (MANUAL ITEM)
========================= */
$("#add_row").unbind('click').bind('click', function () {

    let cnor = $('#cnor').val();
    if (cnor === '') {
        swal('Please Select Vendor First!');
        return false;
    }

    let row_id = $("#item_table tbody tr").length + 1;

    $.ajax({
        url: 'getitemmst.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {

            let html = `
            <tr id="row_${row_id}">
                <td>
                    <button type="button" class="btn btn-default"
                        onclick="removeRow(${row_id})">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
                <td>${row_id}</td>

                <td>
                    <select class="select2 form-control item"
                        id="item_${row_id}" name="item[]"
                        onchange="getItemData(${row_id})">
                        <option value="">~~SELECT~~</option>
            `;

            $.each(response, function (i, v) {
                html += `<option value="${v.code}">${v.item}</option>`;
            });

            html += `
                    </select>
                </td>

                <td><textarea name="descr[]" id="descr_' + row_id + '" class="form-control"></textarea></td>


                <td>
                    <input type="text" name="qty[]" id="qty_${row_id}"
                        onkeyup="qtykeyup(${row_id})"
                        class="form-control">
                </td>

                <td>
                    <input type="text" name="rate[]" id="rate_${row_id}"
                        onkeyup="qtykeyup(${row_id})"
                        class="form-control">
                </td>

                <td>
                    <input type="text" name="amt[]" id="amt_${row_id}"
                        class="form-control" readonly>
                </td>
            </tr>
            `;

            $("#item_table tbody").append(html);
            $(".item").select2();
        }
    });

    return false;
});

/* =========================
   REMOVE ROW
========================= */
function removeRow(id) {
    $("#row_" + id).remove();
    subAmount();
}

/* =========================
   ITEM DATA FETCH
========================= */
function getItemData(row_id) {
    let item = $("#item_" + row_id).val();
    if (item === '') return;

    $.ajax({
        url: 'getitemdtl.php',
        type: 'POST',
        data: { item: item },
        dataType: 'json',
        success: function (response) {
            $("#unit_" + row_id).val(response[0].unit);
            $("#itemnm_" + row_id).val(response[0].itemnm);
        }
    });
}

/* =========================
   CALCULATION
========================= */
function qtykeyup() {
    subAmount();
}

function subAmount() {

    let totalQty = 0;
    let ttl = 0;
    let disc = parseFloat($('#disc').val()) || 0;

    $("#item_table tbody tr").each(function () {
    let id = $(this).attr('id').split('_')[1];

    let qty = parseFloat($('#qty_' + id).val()) || 0;
    let rate = parseFloat($('#rate_' + id).val()) || 0;
    let amt = parseFloat($('#amt_' + id).val()) || 0; // existing amt

    // Only recalc if both qty & rate > 0
    if (qty > 0 && rate > 0) {
        amt = qty * rate;
        $('#amt_' + id).val(amt.toFixed(2));
    }

    totalQty += qty;
    ttl += amt;
});
;


    $('#tqty').val(totalQty);
    $('#ttl').val(ttl.toFixed(2));

    let gttl = ttl - disc;
    let round = Math.round(gttl);

    $('#gttl').val(round.toFixed(2));
    $('#roundoff').val((round - gttl).toFixed(2));

        calcExtra('pkg');
    calcExtra('fwd');
    calcExtra('dis');
    calcExtra('cgst');
    calcExtra('sgst');
    calcExtra('igst');
    calcGrandTotal();
}

function calcExtra(type){
    let ttl = parseFloat($('#ttl').val()) || 0;

    let per = parseFloat($('#'+type+'_per').val()) || 0;
    let amt = (ttl * per) / 100;

    $('#'+type+'_amt').val(amt.toFixed(2));
    calcGrand();
}

function calcExtraAmt(type){
    let ttl = parseFloat($('#ttl').val()) || 0;

    let amt = parseFloat($('#'+type+'_amt').val()) || 0;
    let per = (amt / ttl) * 100;

    $('#'+type+'_per').val(per.toFixed(2));
    calcGrand();
}

function calcGrand(){
    let ttl = parseFloat($('#ttl').val()) || 0;

    let pkg = parseFloat($('#pkg_amt').val()) || 0;
    let fwd = parseFloat($('#fwd_amt').val()) || 0;
    let dis = parseFloat($('#dis_amt').val()) || 0;
    let cgst = parseFloat($("#cgst_amt").val()) || 0;
    let sgst = parseFloat($("#sgst_amt").val()) || 0;
    let igst = parseFloat($("#igst_amt").val()) || 0;

    let gttl = ttl + pkg + fwd + cgst + sgst + igst - dis;
    $('#gttl').val(gttl.toFixed(2));
}

</script>
 
<style>
	* {
  box-sizing: border-box;
}
html {
  font-family: helvetica;
}

html, body {
  max-width: 100vw;
}

table {
 margin: auto;
  border-collapse: collapse;
  overflow-x: auto;
  display: block;
  width: fit-content;
  max-width: 100%;
  box-shadow: 0 0 1px 1px rgba(0, 0, 0, .1);
}

td, th {
  border: solid rgb(200, 200, 200) 1px;
  padding: .5rem;
}

th {
  text-align: left;
  
  text-transform: uppercase;
  padding-top: 1rem;
  
  border-top: none;
}

td {
  white-space: nowrap;
  border-bottom: none;
  color: rgb(20, 20, 20);
}

td:first-of-type, th:first-of-type {
  border-left: none;
}

td:last-of-type, th:last-of-type {
  border-right: none;
}
@media screen and (max-width: 768px) {
   .item_table tr {
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
          -ms-flex-direction: column;
              flex-direction: column;
      border-bottom: 3px solid #ccc;
      display:block;
      
   }
   /*  IE9 FIX   */
   .item_table td {
      float: left\9;
     
      padding: .1rem;
   }
.form-horizontal .table input {
        margin: 0px;
        padding: 0px;
        width: 100px;
        outline: none;
        height: 37px;
        border-radius: 5px;
    }
   .item{
    padding: 0px 0px 0px 0px;
  width: 181px;
    cursor: pointer;
    
  }


}




</style>
<script>
$( document ).ready(function() {
$("#entries").addClass("menu-open");
$("#entriesa").addClass("active");
$("#entriesa").css("background-color","#007cbc");
$("#po").addClass("menu-open");
$("#poa").addClass("active");
$("#poa").css("background-color","ofwhite");
$("#invchallentry").addClass("active");

});
</script> 
</body>
</html>
