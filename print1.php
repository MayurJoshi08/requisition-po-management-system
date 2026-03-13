<?php
//error_reporting(0);
//ini_set('display_errors', 1);
require_once '../admintemplate/vendor3/autoload.php';
ob_start();
include('config.php');
session_start();
if ($_SESSION['dcname']==''){header("Location:login.php");}else{
$username=$_SESSION['dcname'];
$type=$_SESSION['dctype'];
	include('config.php');
}

$icno=$_GET['code'];


$sql="select * from `salesentry` where invno='$icno'";
//echo  $icno;

if(mysqli_query($con,$sql)){
                        $data =mysqli_query($con,$sql);
						$row = mysqli_fetch_array($data);
	
												$icno1=$row['icno'];
										$dt=$row['dt'];
										$date=date("d-m-Y",strtotime($dt));
										$cncode=$row['cnor'];
										$q4=mysqli_query($con,"select * from custmst where code='$cncode'");
										$r4=mysqli_fetch_array($q4);
										$cnmobile=$r4['mobile'];
										$cncity=$r4['city'];
										$cnstate=$r4['state'];
										$cnadrs=$r4['adrs'];
										$cngstinno=$r4['gstinno'];
										$cnstcode=$r4['stcode'];
										$cnor=$r4['name'];
	
										$cneecode=$row['cnee'];
										$q5=mysqli_query($con,"select * from custmst where code='$cneecode'");
										$r5=mysqli_fetch_array($q5);
										$cneemobile=$r5['mobile'];
										$cneecity=$r5['city'];
										$cneestate=$r5['state'];
										$cneeadrs=$r5['adrs'];
										$cneegstinno=$r5['gstinno'];
										$cneestcode=$r5['stcode'];
										$cnee=$r5['name'];
	
										$vehno=$row['vehno'];
										$tcode=$row['trans'];
										$q3=mysqli_query($con,"select name from transportmst where code='$tcode'");
										$r3=mysqli_fetch_array($q3);
										$trans=$r3[0];
										$lrno=$row['lrno'];
										$lrdt=$row['lrdt'];
										$distance=$row['distance'];
										$dispby=$row['dispby'];
										$ttl=$row['ttl'];
	                                    $othrch=$row['otherch'];
										$cgst=$row['cgst'];
										$sgst=$row['sgst'];
										$igst=$row['igst'];
										$camt=$row['camt'];
										$samt=$row['samt'];
										$iamt=$row['iamt'];
										$tcs=$row['tcs'];
										$cess=$row['cess'];
										$roundoff=$row['roundoff'];
										$gttl=$row['gttl'];
										$ewaybillno=$row['ewaybillno'];
										$ewaybilldt=$row['ewaybilldt'];
										$validdt=$row['validdt'];
										$tcsper=$row['tcsper'];
										$vesselnm=$row['vesselnm'];
										$dctyp=$row['ictype'];
										if($dctyp=='I'){$dctype='Inward';}
										if($dctyp=='O'){$ictype='Outward';}
										$suptyp=$row['suptype'];			
										if($suptyp=='1'){$suptype="Supply";}
										if($suptyp=='2'){$suptype="Import";}
										if($suptyp=='3'){$suptype="Export";}
										if($suptyp=='4'){$suptype="Job Work";}
										if($suptyp=='5'){$suptype="For Own Use";}
										if($suptyp=='6'){$suptype="Job work Returns";}
										if($suptyp=='7'){$suptype="Sales Return";}
										if($suptyp=='8'){$suptype="Others";}
										if($suptyp=='9'){$suptype="SKD/CKD/Lots";}
										if($suptyp=='10'){$suptype="Line Sales";}
										if($suptyp=='11'){$suptype="Receipient Not Known";}
										if($suptyp=='12'){$suptype="Exhibition or Fairs";}
							
										$fpincode=$row['fpincode'];
										$tpincode=$row['tpincode'];
										$taxtype=$row['taxtype'];
										$chtype=$row['chtype'];
										$pono=$row['pono'];
										$podt=$row['podt'];
										$ewbbill=$row['ewbbill'];
										$ackno=$row['ackno'];
										$ackdt=$row['ackdt'];
										$irnno=$row['irn'];
										
									}
else{echo "not working";}


	$company='DEMO TRADING COMPANY';
	$image = 'img/demo.webp';
	$gstin = '';
	$adress = 'Address';
		$mail = '';

	

 


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
    <style>
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
    </style>
    </head>
	<body>
<?php for($i=0;$i<3;$i++){
		if($i==0){$label='Original';}
		if($i==1){$label='Duplicate';}
		if($i==2){$label='Triplicate';}
		?>
		<!--<link href="https://fonts.googleapis.com/css?family=Times New Roman" rel="stylesheet">-->
	
	<table style="padding-top:5px;">
		
		<tr>
			<td style="width:100px;border-bottom:none;border-top:none;margin-top:50px">
				<table border="1.5" style="margin-top:0px">
					
					<tr>
						<td style="border-right:none">
							 <?php if ($image): ?>
							<img src="<?= $image ?>"style="height:70px;width:90px;">
							<?php endif; ?>
						</td>
						<td colspan="2" style="width:503px;height:50px;font-size:27px;text-align:center;padding-bottom:0px;margin-bottom:5px; border-bottom: 1px;border-left:none" valign="left"><br><b><?php echo $company; ?></b></td>
						
					</tr>
					<tr>
						<td colspan="3" style="width:713px;font-weight:bold;font-size:13px;text-align:left;padding-top:5px;border-top:none;margine-top:200px; border-top: none;">&nbsp;&nbsp;TAX INVOICE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GSTIN: <?php echo $gstin; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $label; ?>
						</td>
						
						
					
					</tr>
				</table>
				<table>
					<tr>
						<td style="width:45%;border:1.5px;vertical-align:top;">
								<table>
							<tr>
								<td style="font-size:12px;padding-left:7px;">
								<table>
									<tr>
										<td style="font-size:13px;width:80px;"><b>Invoice no :</b></td>
										<td style="font-size:13px;width:100px;"><?php echo $icno;?></td>
									</tr>
									<tr>
										<td style="font-size:13px;width:50px;"><b>Date :</b></td>
										<td style="font-size:13px;width:100px"><?php echo $date; ?></td>
									</tr>
								
								</table>
								</td>
							</tr>
							</table>
						</td>
						<td style="width:300px;border:1.5px">
						<table>
								<tr>
									<td style="font-size:13px;width:80px;">&nbsp;&nbsp;&nbsp;<b>Transport :</b></td>
										<td style="font-size:13px;width:200px"><?php echo $trans;?></td>
							</tr>
							<tr>
									<td style="font-size:13px;width:100px">&nbsp;&nbsp;&nbsp;<b>Vehicle No :</b></td>
										<td style="font-size:13px;width:130px"><?php echo $vehno;?></td>
							
								</tr>
								
								
							</table>
						</td>
					</tr>
			
					<tr>
					<td style="width:50%;border:1.5px;vertical-align:top">
								<table>
							<tr>
									<td style="width:45%;vertical-align:top">
								<table>
							<tr>
								<td style="font-size:12px;padding-left:7px;"><b style="font-size:15px">BILLING TO:</b><br>
									
								<table>
									<tr>
										<td style="font-size:13px;width:60px"><b>M/s </b></td>
										<td style="font-size:13px;width:270px;">: <?php echo $cnor; ?></td>
									</tr>
									
									<tr>
										<td style="font-size:13px;width:80px"><b>Mobile No </b></td>
										<td style="font-size:13px;width:200px">: <?php echo $cnmobile;?></td>
									</tr>
									<tr>
										<td style="font-size:13px;width:40px"><b>Address</b></td>
										<td style="font-size:13px;width:250px">:  <?php echo $cnadrs; ?></td>
									</tr>
									<!--<tr>
										<td style="font-size:13px;width:40px"><b>GSTIN</b></td>
										<td style="font-size:13px;width:200px">:  <?php echo $cngstinno;?></td>
									</tr>-->
									<tr>
										<td style="font-size:13px;width:40px"><b>City</b></td>
										<td style="font-size:13px;width:200px">:  <?php echo $cncity;?></td>
									</tr>
									<tr>
										<td style="font-size:13px;width:40px"><b>STATE</b></td>
										<td style="font-size:13px;width:150px">:  <?php echo $cnstate;?>   <b>CODE</b> : <?php echo $cnstcode;?></td>
									</tr>
								
								</table>
								</td>
							</tr>
							</table>
						</td>
								
							</tr>
							</table>

						</td>
						<td style="width:320px;border:1.5px;vertical-align:top">
								<table>
							<tr>
									<td style="width:322px;vertical-align:top">
								<table>
							<tr>
								<td style="font-size:12px;padding-left:7px;"><b style="font-size:15px">DELIVERY TO:</b><br>
								<table>
									<tr>
										<td style="font-size:13px;width:60px"><b>M/s </b></td>
										<td style="font-size:13px;width:248px;">: <?php echo $cnee; ?></td>
									</tr>
									
									<tr>
										<td style="font-size:13px;width:80px"><b>Mobile No </b></td>
										<td style="font-size:13px;width:200px">:   <?php echo $cneemobile;?></td>
									</tr>
									<tr>
										<td style="font-size:13px;width:40px"><b>Address</b></td>
										<td style="font-size:13px;width:248px">:  <?php echo $cneeadrs;?></td>
									</tr>
									<!--<tr>
										<td style="font-size:13px;width:40px"><b>GSTIN</b></td>
										<td style="font-size:13px;width:200px">:  <?php echo $cneegstinno;?></td>
									</tr>-->
									<tr>
										<td style="font-size:13px;width:40px"><b>City</b></td>
										<td style="font-size:13px;width:200px">:  <?php echo $cneecity; ?></td>
									</tr>
									<tr>
										<td style="font-size:13px;width:40px"><b>STATE</b></td>
										<td style="font-size:13px;width:200px">:  <?php echo $cneestate;?> <b>CODE</b> :  <?php echo $cneestcode;?></td>
									</tr>
								
								</table>
								</td>
							</tr>
							</table>
						</td>
								
							</tr>
							</table>

						</td>
						</tr>
				</table>			
			</td>
		</tr>
		<tr>
							<td colspan="3">
								<div style="background: url; background-repeat: no-repeat; background-size: cover; background-position: center center;" class="bg">
								
<table style="font-size:12px">
    <tr>
        <td style="width:30px;border:1.5px;text-align:center;font-size:12px;background-color:#b7d7e8;font-weight:bold">Sr<br>No</td>
        <td style="width:320px;border:1.5px;text-align:center;background-color:#b7d7e8;font-weight:bold">Description Of Goods</td>
        <td style="width:60px;border:1.5px;text-align:center;background-color:#b7d7e8;font-weight:bold;">Qty</td>
        <td style="width:60px;border:1.5px;text-align:center;background-color:#b7d7e8;font-weight:bold">Unit</td>
        <td style="width:100px;border:1.5px;text-align:center;background-color:#b7d7e8;font-weight:bold;">Rate</td>
        <td style="width:100px;border:1.5px;text-align:center;background-color:#b7d7e8;font-weight:bold;">Amount</td>
    </tr>
    <?php 
    $srno = 0;
    $sql = "SELECT * FROM `saleschild` WHERE invno='$icno'";
    $height = 300;
    $tqty = 0;

    if (mysqli_query($con, $sql)) {
        $data = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($data)) {
    ?>
    <tr style="color:black;text-align:right;vertical-align:top;">
        <td style="width:30px;border:1.5px;height:12px;text-align:center;border-bottom:none"><?php echo ++$srno; ?></td>
        <td style="color:black;border:1.5px;text-align:left;border-bottom:none">
            <?php
            $item = $row['item'];
            $query1 = mysqli_query($con, "SELECT name FROM itemmst WHERE code=$item");
            $results1 = mysqli_fetch_array($query1);
            $itemnm = $results1['name'];
            echo wordwrap($itemnm, 35, "<br>\n") . "<br>" . $row['size']; 
            ?>
        </td>
        <td style="color:black;border:1.5px;text-align:center;border-bottom:none"><?php echo $row['qty']; ?></td>
        <td style="color:black;border:1.5px;text-align:center;border-bottom:none"><?php echo $row['unit']; ?></td>
        <td style="color:black;border:1.5px;text-align:center;border-bottom:none"><?php echo $row['rate']; ?></td>
        <td style="color:black;border:1.5px;text-align:center;border-bottom:none"><?php echo $row['amt']; ?></td>
    </tr>
    <?php 
        $tqty += $row['qty'];
        $height -= 11;
        }
    } 
    ?>
    <tr>
        <td style="border:1.5px;height:<?php echo $height; ?>;"></td>
        <td style="border:1.5px;"></td>
        <td style="border:1.5px;"></td>
        <td style="border:1.5px;"></td>
        <td style="border:1.5px;"></td>
        <td style="border:1.5px;"></td>
    </tr>
    <tr>
        <td style="border:1.5px;height:15px;text-align:right" colspan="2"><b>Total Qty : </b></td>
        <td style="border:1.5px;text-align:center"><?php echo number_format((float)$tqty, 2, '.', ''); ?></td>
        <td style="border:1.5px;"></td>
        <td style="border:1.5px;"></td>
        <td style="border:1.5px;"></td>
    </tr>
    <tr>
        <td style="border:1.5px;font-size:12px;height:40px;width:90px" colspan="2">
            &nbsp;&nbsp;<b>Declaration : </b><br><br>					
            &nbsp;&nbsp;We declare that this invoice shows the actual price of the goods &nbsp;&nbsp;and that all particulars are true and correct.
        </td>																
        <td style="border:1.5px" colspan="4">
            <table>
                <tr>
                    <td style="border-bottom:1.5px;width:192px;font-size:13px;height:25px"valign="middle"><b>Total Net Value :</b></td>
                    <td style="border-bottom:1.5px;width:150px;font-size:13px;text-align:right"valign="middle"><?php echo $ttl; ?></td>
                </tr>
                <tr>
                    <td style="width:150px;height:25px"valign="middle"><b>Other Charges :</b></td>
                    <td style="width:103px;text-align:right"valign="middle"><?php echo number_format((float)$othrch, 2, '.', ''); ?></td>
                </tr>
                <tr>
                    <td style="border-bottom:1.5px;width:150px;height:25px"valign="middle"><b>Round Off</b></td>
                    <td style="border-bottom:1.5px;width:103px;text-align:right"valign="middle"><?php echo $roundoff; ?></td>
                </tr>
                <tr>
                    <td style="border-bottom:1.5px;width:150px;height:30px" valign="middle"><b>Total Payable Amount :</b></td>
                    <td style="border-bottom:1.5px;width:103px;text-align:right" valign="middle"><?php echo $gttl; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border:1.5px;font-size:13px;vertical-align:top;" colspan="6">
            <b>&nbsp;&nbsp;Amount In Words :</b> <br>&nbsp;&nbsp;<?php $word = getIndianCurrency($gttl); echo wordwrap($word, 100, "<br>\n"); ?>
        </td>
    </tr>

    <?php if ($ewaybillno != "") { ?>
    <tr>
        <td style="font-size:13px;padding-top:5px;border:1.5px" colspan="6">&nbsp;&nbsp;<b>EWB No :</b> <?php echo $ewaybillno; ?> <b>/EWB Date :</b> <?php echo $ewaybilldt; ?></td>
    </tr>
    <?php } ?>

    <tr>
        <td style="border:1.5px;font-size:14px;vertical-align:top;border-right:none; border-bottom: none;" colspan="3"><br>&nbsp;&nbsp;<b>Company Bank Details :</b><br>
        <br>&nbsp;&nbsp;<b>Bank Name&nbsp;&nbsp;:</b> HDFC Bank 
        <br>&nbsp;&nbsp;<b>A/C.No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> 50200086637981 
        <br>&nbsp;&nbsp;<b>IFSC &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> HDFC0007494, GANDHIDHAM</td>
        <td style="border:1.5px;width:150px;font-size:13px;text-align:right; border-bottom: none;" colspan="3">
            For <?php echo ucwords(strtolower($company)); ?>,<br><br><br><br><br>
            Authorized Signatory
        </td>
    </tr>
</table>

								</div>
								<table>
									<tr>
						<td style="width:713px;text-align:center;padding-bottom:5px;font-size:12px;margin-bottom:0px; border: 1.7px; border-top: 1px;" valign="top"><?php echo $adress ?><br><?php echo $mail; ?></td>
						
					</tr>		
								</table>
									
							</td>
					</tr>
		
	</table>
<?php } ?>
	</body>
	
</html>

		<?php 

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;


    $content = ob_get_clean();
//for($i=1; $i>=4; $i++){
	try {
    $html2pdf = new Html2Pdf('P', 'A4', 'fr',10,10,10,10);
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
		//
	
    $html2pdf->output("Invoice.pdf");
		//
	//header('location:lrentry.php');
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
		exit;
}
//}
?>
