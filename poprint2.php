<?php
//error_reporting(0);
//ini_set('display_errors', 1);
require_once '../admintemplate/vendor3/autoload.php';

ob_start();
include('config.php');
//session_start();
if ($_SESSION['dcname']==''){header("Location:login.php");}else{
$username=$_SESSION['dcname'];
$type=$_SESSION['dctype'];
	include('config.php');
}

$icno=$_GET['code'];


$sql="select * from `poentry` where code='$icno'";
//echo  $icno;

if(mysqli_query($con,$sql)){
                        $data =mysqli_query($con,$sql);
						$row = mysqli_fetch_array($data);
	
										$icno1=$row['code'];
										$dt=$row['dt'];
										$date=date("d-m-Y",strtotime($dt));
										$cncode=$row['vendor'];
										$q4=mysqli_query($con,"select * from vendormst where code='$cncode'");
										$r4=mysqli_fetch_array($q4);
										$cnmobile=$r4['mobile'];
										$cncity=$r4['city'];
										$cnstate=$r4['state'];
										$cnadrs=$r4['adrs'];
										$cnemail=$r4['email'];
										$cngstin=$r4['gstin'];
										$vendor=$r4['name'];


										$ttl=$row['ttl'];
										$gttl=$row['gttl'];

                    $factory = $row['factory'];
										$potype = $row['potype'];
$reqcode = $row['reqcode'];
$reqdate = $row['reqdate'];
$tqty = $row['tqty'];
$disc = $row['disc'];
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
$payment_term = $row['payment_term'];
$freight_term = $row['freight_term'];
$delivery_term = $row['delivery_term'];
$created_at = $row['created_at'];
$updated_at = $row['updated_at'];

$sign = $row['sign'];
																	
									}
else{echo "not working";}


 


function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? 'Rs ' . $Rupees . 'Only ' : '') . $paise;
}


//echo numberTowords(500000);
//echo getIndianCurrency(50000);
	?>
<!DOCTYPE HTML>
<html lang="en">
	<style>
  table{
	  
   	  height: 620px;
        width:580px;
        border:1px solid black;
	    border-collapse:collapse;
	 
  }
		
	.vertical-text {
	transform: rotate(270deg);
	transform-origin: left top 0;
}


</style>
	
	<link href="//db.onlinewebfonts.com/c/cd0381aa3322dff4babd137f03829c8c?family=Tahoma" rel="stylesheet" type="text/css"/> 
	<!--<head>
		<!-- Fontfaces CSS
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

	</head>-->
	<head>
   <!-- <style>
    /* Page margins are defined using CSS */
    @page {
      margin: 1cm;
      margin-top:2.5cm;
      margin-bottom: 2.5cm;

    /* Header frame starts within margin-top of @page */
      @frame header {
      -pdf-frame-content: headerContent; /* headerContent is the #id of the element */
      top: 1cm;
      margin-left: 2cm;
      margin-right:2cm;
      height:1cm;
      }

    /* Footer frame starts outside margin-bottom of @page */
      @frame footer {
        -pdf-frame-content: footerContent;
        bottom: 2cm;
        margin-left: 1cm;
        margin-right: 1cm;
        height: 1cm;
      }
    }
    </style>-->
    </head>
	<body>
<table id="table" style="border:1px;padding:25px;padding-top:none;padding-bottom:none">
  <tr>
    <td colspan="1" style="width:320px; border:0px solid green;">
      <table style="table-layout: fixed; width: 700px; border-collapse: collapse; margin: 0; padding: 0; border: 1px solid black;">
        <tr>
          <!-- Main Title -->
          <td style="width:100%; height:50px; font-size:27px; text-align:center; padding:0 0 0 0; border-bottom: 0px solid black;">
            <img src="img/latterhad.png" style="height:100px; width:300px;" alt="Company Logo">
          </td>
        </tr>
        <tr>
          <td style="width:100%; border: none; margin-top:0px; padding:0px; padding-top: 10px;">
            <table style="width:100%; border: 1.5px solid black; border-collapse: collapse; margin-top:0;">
              <tr>
                <td colspan="2" style="width:100%; font-size:18px; text-align:center; padding:5px; border: 1px solid black;">
                  <b><?php echo ($potype == "WO") ? "WORK ORDER" : "PURCHASE ORDER"; ?></b>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td style="width:100%; border: none; margin-top:50px; padding:0;">
            <table style="width:100%; border: 1.5px solid black; border-collapse: collapse; margin-top:0;">
              <tr>
                <td style="width:50%; font-size:14px; font-weight:bold; text-align:left; padding:3px; border: 1px solid black; border-bottom:none;">
                  Requisition No: <?php echo $reqcode; ?>
                </td>
                <td style="width:50%; font-size:14px;font-weight:bold; text-align:left; padding:3px; border: 1px solid black;border-bottom:none;">
                  <?php echo ($potype == "WO") ? "F WO No" : "F PO No"; ?> : <?php echo $icno1; ?>
                </td>
              </tr>
              <tr>
                <td style="width:50%; font-size:14px; font-weight:bold; text-align:left; padding:3px; border: 1px solid black;">
                  Date : <?php echo date("d-m-Y", strtotime($reqdate)); ?>
                </td>
                <td style="width:50%; font-size:14px; font-weight:bold; text-align:left; padding:3px; border: 1px solid black;">
                  Date : <?php echo date("d-m-Y", strtotime($dt)); ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td style="width:100%; border: none; margin-top:50px; padding:0;">
            <table style="width:100%; border: 1.5px solid black; border-collapse: collapse; margin-top:0;">
              <tr>
                <td colspan="2" style="width:50%; font-size:15px; font-weight:bold; text-align:left; padding:3px; border: 1px solid black;">
                  <?php echo $vendor; ?>
                </td>
                <td colspan="2" style="width:50%; font-size:15px; text-align:left; padding:3px; border: 1px solid black;border-bottom:none;">
                  Supply At
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width:50%; font-size:14px; text-align:left; padding:3px; border: 1px solid black;">
                  <?php echo $cnadrs; ?><br>
                  <?php echo $cncity; ?><br>
                  Mob. <?php echo $cnmobile; ?><br>
                  Email. <?php echo $cnemail; ?><br>
                  GST No. <?php echo $cngstin; ?>
                </td>
                <td colspan="2" style="width:50%; font-size:14px; text-align:left; padding:3px; border: 1px solid black;">
<?php if ($factory == 'AMD') { ?>
    <b>Zetts Cosmetics PVT LTD.</b><br>
    10-11 Crystal Industrial & Logistic Park,<br>
    Bhayla, Bavla,<br>
    Ahmedabad, Gujarat - 382220<br>
    GST No. 24AAACZ2026J2ZH
<?php } else { ?>
    <b>Zetts Cosmetics PVT LTD.</b><br>
    Shed No. 408 - 412, Kandla SEZ<br>
    Gandhidham - 370230<br>
    Kutch, Gujarat<br>
    GST No. 24AAACZ2026J1ZI
<?php } ?>
</td>

                <!--<td colspan="2" style="width:50%; font-size:14px; text-align:left; padding:3px; border: 1px solid black;">
                  <b>Zetts Cosmetics PVT LTD.</b><br>
                  Shed No. 408 - 412, Kandla SEZ<br>
                  Gandhidham - 370230<br>
                  Kutch, Gujarat<br>
                  GST No. 24AAACZ2026J1ZI
                </td>-->
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<?php
// Fetch all rows from pochild first
$sqlc = mysqli_query($con, "SELECT * FROM pochild WHERE code='$icno'");
$allRows = [];
while ($r = mysqli_fetch_assoc($sqlc)) {
    $allRows[] = $r;
}
$totalRows = count($allRows);

/* ================= FETCH GROUPING ================= */
$grpStart = [];
$grpSkip  = [];

$sqlg = mysqli_query($con, "SELECT grp_name, rowws FROM req_grouping WHERE code='$reqcode'");
while ($g = mysqli_fetch_assoc($sqlg)) {

    $rows = array_map('intval', explode(',', $g['rowws']));
    sort($rows);

    $startSr = $rows[0];
    $rowspan = count($rows);

    $grpStart[$startSr] = $rowspan;

    foreach ($rows as $rno) {
        if ($rno != $startSr) {
            $grpSkip[$rno] = true;
        }
    }
}
// Set rows per page based on your layout, example 12 here:
$rowsPerPage = 35;

// Calculate total pages
$pageCount = ceil($totalRows / $rowsPerPage);

$sr = 1; // serial number across pages

for ($page = 0; $page < $pageCount; $page++) {
    // Start table
    echo '<table border="1" id="dtl_table" style="width:100%; border-collapse: collapse; border:1px solid black; border-top:0px; margin-top:-2px; table-layout: fixed;padding:26px;padding-top:none;padding-bottom:none">';
    
    // Header
    echo '<thead>
    <tr style="font-weight:bold;text-align:center;">
        <td style="width:40px;border:1px solid #000;">Sr no.</td>
        <td style="width:355px;border:1px solid #000;">ITEM DESCRIPTION</td>
        <td style="width:58px;border:1px solid #000;">QTY</td>
        <td style="width:95px;border:1px solid #000;">UNIT PRICE</td>
        <td style="width:100px;border:1px solid #000;">TOTAL (Rs)</td>
    </tr>
    </thead><tbody>';

    // Rows for this page
    $start = $page * $rowsPerPage;
    $end = min(($page + 1) * $rowsPerPage, $totalRows);

    $printedRows = $end - $start;   // rows printed on last page
$maxRows     = 30;

    for ($i = $start; $i < $end; $i++) {

        $r = $allRows[$i];
        $srno = $r['srno'];

        echo '<tr>';

        /* ================= SR ================= */
        echo '<td align="center" style="border:1px solid #000;padding:3px;font-size:12px;">'
             . $sr++ . '</td>';

        /* ================= ITEM + DESCR ================= */
        echo '<td style="border:1px solid #000;padding:3px;font-size:12px;width:345px;">';
        if (!empty($r['item'])) echo $r['item'];
        if (!empty($r['item']) && !empty($r['descr'])) echo "<br>";
        if (!empty($r['descr'])) echo nl2br($r['descr']);
        echo '</td>';

        /* ================= QTY ================= */
        if (isset($grpStart[$srno])) {
            echo '<td rowspan="'.$grpStart[$srno].'" align="center"
                  style="border:1px solid #000;padding:3px;
                         vertical-align:middle;font-size:12px;">'
                 . ($r['qty'] > 0 ? number_format($r['qty'],2) : '') . '</td>';
        } elseif (!isset($grpSkip[$srno])) {
            echo '<td align="center" style="border:1px solid #000;padding:3px;font-size:12px;">'
                 . ($r['qty'] > 0 ? number_format($r['qty'],2) : '') . '</td>';
        }

        /* ================= RATE ================= */
        if (isset($grpStart[$srno])) {
            echo '<td rowspan="'.$grpStart[$srno].'" align="right"
                  style="border:1px solid #000;padding:3px;
                         vertical-align:middle;font-size:12px;">'
                 . ($r['rate'] > 0 ? number_format($r['rate'],2) : '') . '</td>';
        } elseif (!isset($grpSkip[$srno])) {
            echo '<td align="right" style="border:1px solid #000;padding:3px;font-size:12px;">'
                 . ($r['rate'] > 0 ? number_format($r['rate'],2) : '') . '</td>';
        }

        /* ================= AMT ================= */
        if (isset($grpStart[$srno])) {
            echo '<td rowspan="'.$grpStart[$srno].'" align="right"
                  style="border:1px solid #000;padding:3px;
                         vertical-align:middle;font-size:12px;">'
                 . ($r['amt'] > 0 ? number_format($r['amt'],2) : '') . '</td>';
        } elseif (!isset($grpSkip[$srno])) {
            echo '<td align="right" style="border:1px solid #000;padding:3px;font-size:12px;">'
                 . ($r['amt'] > 0 ? number_format($r['amt'],2) : '') . '</td>';
        }

        echo '</tr>';
    }

    // If last page, add P&F charges, Discount, Note, Total etc.
    if ($page == $pageCount - 1) {

        // P&F charges row
        if ((!empty($pkg_per) && $pkg_per != 0) || (!empty($pkg_amt) && $pkg_amt != 0) || (!empty($fwd_per) && $fwd_per != 0) || (!empty($fwd_amt) && $fwd_amt != 0)) {
            echo '<tr>
                <td align="center" style="border:1px solid #000;padding:3px;font-size:12px;"></td>
                <td style="border:1px solid #000;padding:3px;font-size:12px;">P & F charges<br>';
            $total_per = (!empty($pkg_per) ? $pkg_per : 0) + (!empty($fwd_per) ? $fwd_per : 0);
            if ($total_per != 0) {
                echo "@" . $total_per . "%";
            }
            echo '</td>
                <td align="center" style="border:1px solid #000;padding:3px;"></td>
                <td align="right" style="border:1px solid #000;padding:3px;"></td>';
            $total_amt = (!empty($pkg_amt) ? $pkg_amt : 0) + (!empty($fwd_amt) ? $fwd_amt : 0);
            echo '<td align="right" style="border:1px solid #000;padding:3px;font-size:12px;">' . ($total_amt != 0 ? number_format($total_amt, 2) : '') . '</td>
            </tr>';
        }


        // ------------------------- GST -------------------------
if (
    (!empty($cgst_amt) && $cgst_amt != 0) ||
    (!empty($sgst_amt) && $sgst_amt != 0) ||
    (!empty($igst_amt) && $igst_amt != 0)
) {

    echo '<tr>
        <td align="center" style="border:1px solid #000;padding:3px;font-size:12px;"></td>
        <td style="border:1px solid #000;padding:3px;font-size:12px;">
            ';

    $gst_text = [];

    if (!empty($cgst_per) && $cgst_per != 0) {
        $gst_text[] = "CGST @$cgst_per%";
    }
    if (!empty($sgst_per) && $sgst_per != 0) {
        $gst_text[] = "SGST @$sgst_per%";
    }
    if (!empty($igst_per) && $igst_per != 0) {
        $gst_text[] = "IGST @$igst_per%";
    }

    echo implode(' <br>  ', $gst_text);

    echo '</td>
        <td align="center" style="border:1px solid #000;padding:3px;"></td>
        <td align="right" style="border:1px solid #000;padding:3px;"></td>';

    $gst_amt =
        (!empty($cgst_amt) ? $cgst_amt : 0) +
        (!empty($sgst_amt) ? $sgst_amt : 0) +
        (!empty($igst_amt) ? $igst_amt : 0);

    echo '<td align="right" style="border:1px solid #000;padding:3px;font-size:12px;">'
        . ($gst_amt != 0 ? number_format($gst_amt, 2) : '')
        . '</td>
    </tr>';
}


        // Discount row
        if ((!empty($dis_per) && $dis_per != 0) || (!empty($dis_amt) && $dis_amt != 0)) {
            echo '<tr>
                <td align="center" style="border:1px solid #000;padding:3px;"></td>
                <td style="border:1px solid #000;padding:3px;font-size:12px;">Discount<br>';
            if (!empty($dis_per) && $dis_per != 0) {
                echo "@" . $dis_per . "%";
            }
            echo '</td>
                <td align="center" style="border:1px solid #000;padding:3px;"></td>
                <td align="right" style="border:1px solid #000;padding:3px;"></td>';
            echo '<td align="right" style="border:1px solid #000;padding:3px;font-size:12px;">' . (!empty($dis_amt) && $dis_amt != 0 ? number_format($dis_amt, 2) : '') . '</td>
            </tr>';
        }

if ($printedRows > 25 && $printedRows <= 32) {
    $blankRows = 2;
} 
elseif ($printedRows > 8) {
    $blankRows = 3;
} 
else {
    $blankRows = 5;
}

        for ($b = 0; $b < $blankRows; $b++) {
    echo '<tr>
        <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
        <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
        <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
        <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
        <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
    </tr>';
}




        // Note rows
        echo '<tr>
            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
            <td colspan="3" style="border:1px solid #000;padding:3px;font-size:11px"><b>NOTE :</b> The incoming goods into SEZ shall bear the following declaration / endorsement on the invoice :<br></td>
            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
            </tr>';

        echo '<tr>
            <td style="width:50px;border:1px solid #000;padding:3px;">&nbsp;</td>
            <td colspan="3" style="width:480px;border:1px solid #000;padding:3px;font-size:11px;text-align:center">
            "SUPPLY MEANT FOR EXPORT / SUPPLY TO SEZ UNIT OR SEZ DEVELOPER FOR AUTHORISED OPERATIONS ON PAYMENT OF INTEGRATED TAX"<br>OR<br>
            "SUPPLY MEANT FOR EXPORT / SUPPLY TO SEZ UNIT OR SEZ DEVELOPER FOR AUTHORISED OPERATIONS UNDER BOND OR LETTER OF UNDERTAKING WITHOUT PAYMENT OF INTEGRATED TAX ARN NO __________ VALID UP TO __________"
            </td>
            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
            </tr>';

        echo '<tr>
            <td style="width:50px;border:1px solid #000;padding:3px;">&nbsp;</td>
            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
            </tr>';

        // Final Total row
        echo '<tr>
            <td colspan="4" style="border:1px solid #000;text-align:right;font-weight:bold;">Total</td>
            <td style="border:1px solid #000;text-align:right;font-weight:bold;">' . number_format($gttl, 2) . '</td>
            </tr>';
    } else {
        // For non-last pages, no filler rows (no blank rows)
    }

    echo '</tbody></table>';

    // Page break after each page except last
    if ($page < $pageCount - 1) {
        echo '<div style="page-break-after: always;"></div>';
    }
}
?>

<table style="width:99.7%; border-collapse: collapse; margin-left:0px;padding:26px;padding-top:none;padding-bottom:none">
  <tr>
    <td style="width:100%; border: 1px; text-align:right; margin-top:50px; padding: 3px; border-bottom:none;border-top:none;">
      For Zetts Cosmetics Pvt. Ltd.<br><br><br><br>
     <?php 
            echo !empty(trim($sign)) 
                ? htmlspecialchars($sign) 
                : 'Mr. Sudesh Gupta'; 
        ?>
    </td>
  </tr>

  <tr>
    <td style="width:100%; border: 1px; text-align:left; margin-top:50px; padding:3px; font-size:12px;">
      If you have any questions about this order, please contact : wm@zetts.info/kuldeep@zetts.info
    </td>
  </tr>
  <tr>
    <td style="width:100%; border: 1px; margin-top:50px; font-size:11px; padding:0; line-height:15px">
      <b>Terms & Condition</b><br>
      1) IGST Nil. You will send under bond or claim to refund.<br>
      2) Payment Term : <?php echo $payment_term; ?><br>
      3) Freight : <?php echo $freight_term; ?><br>
      4) Delivery : <?php echo $delivery_term; ?>
    </td>
  </tr>
</table>

<page_footer>
  <table width="100%" style="padding:31px; padding-bottom:0; padding-top:0; font-size:10px; text-align:center; border-collapse:collapse;">
    <tr>
      <td style="text-align: center;">
        <img src="img/latterfooter.png" style="height:60px; width:700px;" alt="Company Logo">
      </td>
    </tr>
  </table>
</page_footer>

</body>

</html>


<?php
// Get the HTML content
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

$content = ob_get_clean();

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'en', [10, 10, 10, 10]);
    $html2pdf->writeHTML($content);
    $filename = $potype . '_' . $icno1 . '_' . date('d-m-Y', strtotime($dt)) . '.pdf';

    $html2pdf->output($filename, 'I');
} catch (Html2PdfException $e) {
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}

?>
