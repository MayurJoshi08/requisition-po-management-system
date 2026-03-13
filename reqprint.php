<?php
//error_reporting(0);
//ini_set('display_errors', 1);
require_once '../admintemplate/vendor3/autoload.php';

ob_start();
include('config.php');
//session_start();
if ($_SESSION['dcname'] == '') {
    header("Location:login.php");
} else {
    $username = $_SESSION['dcname'];
    $type = $_SESSION['dctype'];
    include('config.php');
}

$icno = $_GET['code'];


$sql = "select * from `reqentry_new` where code='$icno'";
//echo  $icno;

if (mysqli_query($con, $sql)) {
    $data = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($data);
    $id = $row['id'];
    $code = $row['code'];
    $dt = $row['dt'];
    $cncode = $row['vendor'];
    $q4 = mysqli_query($con, "select * from vendormst where code='$cncode'");
    $r4 = mysqli_fetch_array($q4);
    $cnmobile = $r4['mobile'];
    $cncity = $r4['city'];
    $cnstate = $r4['state'];
    $cnadrs = $r4['adrs'];
    $cnemail = $r4['email'];
    $cngstin = $r4['gstin'];
    $vendor = $r4['name'];
    $ttl = $row['ttl'];
    $category = $row['category'];
    $payment_term = $row['payment_term'];
    $freight_term = $row['freight_term'];
    $delivery_term = $row['delivery_term'];
    $prepared_by = $row['prepared_by'];
    $created_at = $row['created_at'];
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

$checked_by = $row['checked_by'];
$approved_by_prepare= $row['approved_by_prepare'];

} else {
    echo "not working";
}





function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety'
    );
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else
            $str[] = null;
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
    table {

        height: 620px;
        width: 580px;
        border: 1px solid black;
        border-collapse: collapse;

    }

    .vertical-text {
        transform: rotate(270deg);
        transform-origin: left top 0;
    }
</style>

<link href="//db.onlinewebfonts.com/c/cd0381aa3322dff4babd137f03829c8c?family=Tahoma" rel="stylesheet"
    type="text/css" />
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
    <?php for ($i = 0; $i < 1; $i++) {
        if ($i == 0) {
            $label = 'Original';
        }
        ?>
        <!--<link href="https://fonts.googleapis.com/css?family=Times New Roman" rel="stylesheet">-->

        <table style="padding:35px; padding-top:0; padding-bottom:0; width:100%; border-collapse: collapse;">
            <tr>
                <td style="width:100%; height:50px; border: none; margin-top:0px; padding:0;">
                    <table style="width:100%; border: 1.5px solid black; border-collapse: collapse; margin-top:0;">
                        <tr>
                            <td colspan="2"
                                style="width:100%; height:20px; font-size:22px; text-align:center; padding:0 0 0 0; border-bottom: 0px solid black;">
                                ZETTS COSMETICS PVT. LTD.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width:100%; border: none; margin-top:0px; padding:0px;">
                    <table style="width:100%; border: 1.5px solid black; border-collapse: collapse; margin-top:0;">
                        <tr>
                            <td colspan="2"
                                style="width:100%; font-size:18px; text-align:center; padding:3px; border: 1px solid black;">
                                <b>Requisition Form</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width:100%; border: none; margin-top:50px; padding:0;">
                    <table style="width:100%; border: 1.5px solid black; border-collapse: collapse; margin-top:0;">
                        <tr>
                            <td
                                style="width:20%; font-size:14px; font-weight:bold; text-align:left; padding:3px; border: 1px solid black; ">
                                Requisition No:
                            </td>
                            <td
                                style="width:60%; font-size:14px;font-weight:bold; text-align:left; padding:3px; border: 1px solid black;">
                                Vendor Name :
                            </td>
                            <td
                                style="width:20%; font-size:14px; font-weight:bold; text-align:left; padding:3px; border: 1px solid black;">
                                Date :
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="width:100%; border: none; margin-top:50px; padding:0;">
                    <table style="width:100%; border: 1.5px solid black; border-collapse: collapse; margin-top:0;">
                        <tr>
                            <td
                                style="width:20%; font-size:12px; font-weight:normal; text-align:left; padding:3px; border: 1px solid black; ">
                                <?php echo $icno; ?>
                            </td>
                            <td
                                style="width:60%; font-size:12px;font-weight:normal; text-align:left; padding:3px; border: 1px solid black;">
                                <?php echo $vendor; ?>
                            </td>
                            <td
                                style="width:20%; font-size:12px; font-weight:normal; text-align:left; padding:3px; border: 1px solid black;">
                                <?php echo date("d-m-Y", strtotime($dt)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="width:100%; padding:0;">

                    <table width="100%" style="border-collapse:collapse;border:1px solid #000;font-size:12px;">

                        <tr style="font-weight:bold;text-align:center;font-size:13px;">
                            <td style="width:25px;border:1px solid #000;">Sr No.</td>
                            <td style="width:250px;border:1px solid #000;">ITEM DESCRIPTION</td>
                            <td style="width:60px;border:1px solid #000;">QTY</td>
                            <td style="width:80px;border:1px solid #000;">UNIT PRICE</td>
                            <td style="width:90px;border:1px solid #000;">TOTAL (Rs)</td>
                            <td style="width:130px;border:1px solid #000;">Reason for<br> Requirement</td>
                        </tr>

<?php
$sr = 1;
$total = 0;

/* ================= FETCH CHILD ================= */
$sqlc = mysqli_query($con, "SELECT * FROM reqchild WHERE code='$icno' ORDER BY srno");
$data = [];
while ($r = mysqli_fetch_assoc($sqlc)) {
    $data[] = $r;
}

/* ================= FETCH GROUPING ================= */
$grpStart = [];   // index => rowspan
$grpSkip  = [];   // index => skip cells

$sqlg = mysqli_query($con, "SELECT grp_name, rowws FROM req_grouping WHERE code='$icno'");
while ($g = mysqli_fetch_assoc($sqlg)) {

    $rows = array_map('intval', explode(',', $g['rowws']));
    sort($rows);

    // convert srno to array index (srno-1)
    $startIndex = $rows[0] - 1;
    $rowspan = count($rows);

    $grpStart[$startIndex] = $rowspan;

    foreach ($rows as $rno) {
        $idx = $rno - 1;
        if ($idx != $startIndex) {
            $grpSkip[$idx] = true;
        }
    }
}

/* ================= REASON ROWSPAN (ORIGINAL) ================= */
$rowCount = count($data);
$printedReason = [];
$reasonRowspan = [];

for ($i = 0; $i < $rowCount; $i++) {

    $reason = $data[$i]['reason'];

    if (!isset($reasonRowspan[$i])) {

        if ($reason === '') {
            $reasonRowspan[$i] = 1;
            continue;
        }

        $count = 1;
        for ($j = $i + 1; $j < $rowCount; $j++) {
            if ($data[$j]['reason'] === $reason) {
                $count++;
            } else {
                break;
            }
        }
        $reasonRowspan[$i] = $count;
    }
}

/* ================= PRINT ROWS ================= */
for ($i = 0; $i < $rowCount; $i++) {

    $r = $data[$i];
    echo "<tr>";

    echo "<td align='center' style='width:25px;border:1px solid #000;padding:3px;'>
            ".$sr++."
          </td>";

    echo "<td style='width:240px;border:1px solid #000;padding:3px;'>
            {$r['item']}<br>".nl2br($r['descr'])."
          </td>";

    /* ================= QTY ================= */
    if (isset($grpStart[$i])) {
        echo "<td rowspan='{$grpStart[$i]}' align='center'
              style='border:1px solid #000;padding:3px;vertical-align:middle;'>
              ".($r['qty'] > 0 ? number_format($r['qty'],2) : '')."
              </td>";
    } elseif (!isset($grpSkip[$i])) {
        echo "<td align='center' style='border:1px solid #000;padding:3px;'>
              ".($r['qty'] > 0 ? number_format($r['qty'],2) : '')."
              </td>";
    }

    /* ================= RATE ================= */
    if (isset($grpStart[$i])) {
        echo "<td rowspan='{$grpStart[$i]}' align='right'
              style='border:1px solid #000;padding:3px;vertical-align:middle;'>
              ".($r['rate'] > 0 ? number_format($r['rate'],2) : '')."
              </td>";
    } elseif (!isset($grpSkip[$i])) {
        echo "<td align='right' style='border:1px solid #000;padding:3px;'>
              ".($r['rate'] > 0 ? number_format($r['rate'],2) : '')."
              </td>";
    }

    /* ================= AMT ================= */
    if (isset($grpStart[$i])) {
        echo "<td rowspan='{$grpStart[$i]}' align='right'
              style='border:1px solid #000;padding:3px;vertical-align:middle;'>
              ".($r['amt'] > 0 ? number_format($r['amt'],2) : '')."
              </td>";
    } elseif (!isset($grpSkip[$i])) {
        echo "<td align='right' style='border:1px solid #000;padding:3px;'>
              ".($r['amt'] > 0 ? number_format($r['amt'],2) : '')."
              </td>";
    }

    /* ================= REASON + LPDT (ORIGINAL) ================= */
    if (!isset($printedReason[$i])) {

        $rowspan = $reasonRowspan[$i];

        echo "<td rowspan='$rowspan'
              style='width:110px;border:1px solid #000;padding:3px;
                     vertical-align:middle;text-align:left;'>
              ".nl2br($r['reason'])."<br>{$r['lpdt']}
              </td>";

        for ($k = $i; $k < $i + $rowspan; $k++) {
            $printedReason[$k] = true;
        }
    }

    echo "</tr>";
}
?>


                        <?php
                        // Check if any P&F value is non-zero AND not empty
                        if (
                            (!empty($pkg_per) && $pkg_per != 0) ||
                            (!empty($pkg_amt) && $pkg_amt != 0) ||
                            (!empty($fwd_per) && $fwd_per != 0) ||
                            (!empty($fwd_amt) && $fwd_amt != 0)
                        ) {
                            ?>
                            <tr>
                                <td align="center" style="width:25px;border:1px solid #000;padding:3px;"></td>

                                <td style="border:1px solid #000;padding:3px;">
                                    P & F charges<br>
                                    <?php
                                    $pf_text = [];
                                    if (!empty($pkg_per) && $pkg_per != 0) {
                                        $pf_text[] = "@$pkg_per%";
                                    }
                                    if (!empty($fwd_per) && $fwd_per != 0) {
                                        $pf_text[] = "@$fwd_per%";
                                    }
                                    //echo implode(' + ', $pf_text);
                                    $total_per = (!empty($pkg_per) ? $pkg_per : 0) + (!empty($fwd_per) ? $fwd_per : 0);
                                    if ($total_per != 0) {
                                        echo "@" . $total_per . "%";
                                    }
                                    ?>
                                </td>

                                <td align="center" style="border:1px solid #000;padding:3px;"></td>

                                <td align="right" style="border:1px solid #000;padding:3px;"></td>

                                <td align="right" style="border:1px solid #000;padding:3px;">
                                    <?php
                                    $total_amt = (!empty($pkg_amt) ? $pkg_amt : 0) + (!empty($fwd_amt) ? $fwd_amt : 0);
                                    if ($total_amt != 0) {
                                        echo number_format($total_amt, 2);
                                    }
                                    ?>
                                </td>

                                <td align="right" style="border:1px solid #000;padding:3px;"></td>
                            </tr>
                            <?php
                        }

                        // ------------------------- GST -------------------------
if (
    (!empty($cgst_amt) && $cgst_amt != 0) ||
    (!empty($sgst_amt) && $sgst_amt != 0) ||
    (!empty($igst_amt) && $igst_amt != 0)
) {
    ?>
    <tr>
        <td align="center" style="width:25px;border:1px solid #000;padding:3px;"></td>

        <td style="border:1px solid #000;padding:3px;">
            
            <?php
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

            echo implode(' <br> ', $gst_text);
            ?>
        </td>

        <td align="center" style="border:1px solid #000;padding:3px;"></td>

        <td align="right" style="border:1px solid #000;padding:3px;"></td>

        <td align="right" style="border:1px solid #000;padding:3px;">
            <?php
            $gst_amt =
                (!empty($cgst_amt) ? $cgst_amt : 0) +
                (!empty($sgst_amt) ? $sgst_amt : 0) +
                (!empty($igst_amt) ? $igst_amt : 0);

            if ($gst_amt != 0) {
                echo number_format($gst_amt, 2);
            }
            ?>
        </td>

        <td align="right" style="border:1px solid #000;padding:3px;"></td>
    </tr>
    <?php
}



                        // ------------------------- Discount -------------------------
                        if (
                            (!empty($dis_per) && $dis_per != 0) ||
                            (!empty($dis_amt) && $dis_amt != 0)
                        ) {
                            ?>
                            <tr>
                                <td align="center" style="width:25px;border:1px solid #000;padding:3px;"></td>

                                <td style="border:1px solid #000;padding:3px;">
                                    Discount<br>
                                    <?php
                                    $dis_text = [];
                                    if (!empty($dis_per) && $dis_per != 0) {
                                        $dis_text[] = "@$dis_per%";
                                    }
                                    echo implode(' + ', $dis_text);
                                    ?>
                                </td>

                                <td align="center" style="border:1px solid #000;padding:3px;"></td>

                                <td align="right" style="border:1px solid #000;padding:3px;"></td>

                                <td align="right" style="border:1px solid #000;padding:3px;">
                                    <?php
                                    if (!empty($dis_amt) && $dis_amt != 0) {
                                        echo number_format($dis_amt, 2);
                                    }
                                    ?>
                                </td>

                                <td align="right" style="border:1px solid #000;padding:3px;"></td>
                            </tr>
                            <?php
                        }
                        ?>

                        <tr>
                            <td style="width:25px;border:1px solid #000;padding:3px;">&nbsp;</td>
                            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
                            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
                            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
                            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
                            <td style="border:1px solid #000;padding:3px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4"
                                style="border:1px solid #000;text-align:center;font-size:14px;font-weight:bold;">Total</td>
                            <td style="border:1px solid #000;text-align:right;font-weight:bold;font-size:14px;">
                                <?php echo number_format($grandttl, 2); ?></td>
                            <td style="border:1px solid #000;text-align:right;font-size:14px;font-weight:bold;"></td>
                        </tr>

                    </table>

                </td>
            </tr>


            <tr>
                <td style="width:100%; border: 0px; text-align:center; margin-top:0px; padding: 0px;border-bottom:none;">
                    <table style="width:100%; border-collapse: collapse; margin-top:0px;">
                        <thead>
                            <tr>
                                <th style="font-size:12px;width:25px;border:1px solid #000; padding:3px;">Sr<br>No</th>
                                <th style="font-size:12px;width:222.5px;border:1px solid #000; padding:3px;">Category</th>
                                <th style="font-size:12px;width:50px;border:1px solid #000; padding:3px;">&nbsp;</th>
                                <th style="font-size:12px;width:25px;border:1px solid #000; padding:3px;">Sr<br>No</th>
                                <th style="font-size:12px;width:222.5px;border:1px solid #000; padding:3px;">Category</th>
                                <th style="font-size:12px;width:50px;border:1px solid #000; padding:3px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Example: total 8 items, two columns of 4 each
                            $selCategory = explode(',', $row['category']);

                            $catMap = [
                                'M/c Spares' => 'M/c Spares',
                                'Stationary' => 'Stationary',
                                'Cleaning' => 'Cleaning',
                                'General Maintenance' => 'Maintenance',
                                'AMC / Service Contract / Yearly' => 'AMC',
                                'Capital Expenditure' => 'Capital',
                                'General Office Expense' => 'Office',
                                'Miscellaneous / Others' => 'Misc'
                            ];

                            $categories = array_keys($catMap);
                            $rows = ceil(count($categories) / 2);

                            for ($i = 0; $i < $rows; $i++) {

                                $leftIndex = $i;
                                $rightIndex = $i + $rows;

                                echo '<tr>';

                                // LEFT
                                $leftName = $categories[$leftIndex];
                                $leftCode = $catMap[$leftName];
                                $leftTick = in_array($leftCode, $selCategory) ? '<span style="font-family:zapfdingbats;font-size:12px;">4</span>' : '';

                                echo '<td style="border:1px solid #000;text-align:center;">' . ($leftIndex + 1) . '</td>';
                                echo '<td style="border:1px solid #000;text-align:left">' . $leftName . '</td>';
                                echo '<td style="border:1px solid #000;text-align:center;">' . $leftTick . '</td>';

                                // RIGHT
                                if (isset($categories[$rightIndex])) {

                                    $rightName = $categories[$rightIndex];
                                    $rightCode = $catMap[$rightName];

                                    // TCPDF SAFE TICK
                                    $rightTick = in_array($rightCode, $selCategory)
                                        ? '<span style="font-family:zapfdingbats;font-size:12px;">4</span>'
                                        : '';

                                    echo '<td style="border:1px solid #000;text-align:center;">' . ($rightIndex + 1) . '</td>';
                                    echo '<td style="border:1px solid #000;text-align:left">' . $rightName . '</td>';
                                    echo '<td style="border:1px solid #000;text-align:center;">' . $rightTick . '</td>';

                                } else {
                                    echo '<td style="border:1px solid #000;">&nbsp;</td>';
                                    echo '<td style="border:1px solid #000;">&nbsp;</td>';
                                    echo '<td style="border:1px solid #000;">&nbsp;</td>';
                                }

                                echo '</tr>';
                            }

                            ?>
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr>
                <td style="width:100%; padding:0;">

                    <table style="width:100%; border-collapse:collapse;">
                        <tr>

                            <td
                                style="width:50%; border:1px solid #000; padding:5px; line-height:20px; font-size:11px;vertical-align:top;">
                                <b>Terms & Conditions</b><br>
                                1) Payment Term : <?php echo $payment_term; ?><br>
                                2) Freight : <?php echo $freight_term; ?><br>
                                3) Delivery : <?php echo $delivery_term; ?>
                            </td>

                            <td style="width:50%; border:1px solid #000; padding:0px; vertical-align:top;font-size:12px">
                                <table style="width:100%; border-collapse:collapse;">
                                    <tr>
                                        <!--<td style="padding:2px; width:70%; border:1px; height:12px;vertical-align:middle;">Prepared By :
                                            <?php echo $prepared_by; ?>
                                        </td>-->
                                        <td style="padding:2px; width:70%; border:1px; height:12px; vertical-align:top; font-size:12px;">
    
    Prepared By : <?php echo $prepared_by; ?>
</td>
                                        <td rowspan="4"
                                            style=" width:30%; border:0px; text-align:center; vertical-align:mitopddle;">
                                            Approved By
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%; padding:2px; border:1px; height:30px; vertical-align:top;">Signature :<br>
                                   <?php
if(!empty($approved_by_prepare))
{
    $sign = str_replace(" ","",$prepared_by);



    //echo htmlspecialchars($approved_by_prepare);

    echo "<div style='text-align:center;'>
        <img src='signature/".$sign."sign.png' style='height:50px; max-width:100%; object-fit:contain;'>
      </div>";
}
?></td>
                                    </tr>
                                    <tr>
    <td style="width:70%; padding:2px; border:1px; height:12px;vertical-align:middle;">
        Checked By : 
        <?php 
            echo !empty(trim($checked_by)) 
                ? htmlspecialchars($checked_by) 
                : 'Mr. Sudesh Gupta'; 
        ?>
    </td>
</tr>

                                    <tr>
                                        <td style="width:70%; padding:2px; border:1px; height:30px">Signature :</td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>

                </td>
            </tr>

        </table>



    <?php } ?>
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
    $filename = $icno . '_' . date('d-m-Y', strtotime($dt)) . '.pdf';

    $html2pdf->output($filename, 'I');

} catch (Html2PdfException $e) {
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}

?>