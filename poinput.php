<?php
// error_reporting(0); 
include('config.php');
//session_start(); 
if ($_SESSION['dcname'] == '') {
    header("Location: login.php");
} else {
    $username = $_SESSION['dcname'];
    $type = $_SESSION['dctype'];
}

if(isset($_GET['delete'])){
		
$invno = $_GET['delete'];
    //echo $icno;
    $sql = "DELETE FROM `poentry` where code ='$invno'";
    $que = mysqli_query($con,$sql);
    if ($que) {
		mysqli_query($con,"DELETE FROM `pochild` where code = '$invno'");
        header("location: posearch.php");
        //echo "done";
    }
    else {
        echo "couldn`t";
    }
}
if ($_POST['send'] == 'Save') {

    $code    = $_POST['invno'];     // Invoice No stored as code
    $potype  = $_POST['potype'];
    $dt      = $_POST['dt'];
    $vendor  = $_POST['cnor'];

    $reqcode = isset($_POST['reqcode'])
        ? implode(',', $_POST['reqcode'])
        : '';

    $reqdate = $_POST['reqdate'];

    $tqty = $_POST['tqty'];
    $ttl  = $_POST['ttl'];
$pkg_per = $_POST['pkg_per'];
$pkg_amt = $_POST['pkg_amt'];
$fwd_per = $_POST['fwd_per'];
$fwd_amt = $_POST['fwd_amt'];
$dis_per = $_POST['dis_per'];
$dis_amt = $_POST['dis_amt'];
    $gttl = $_POST['gttl'];

        $payment = $_POST['payment_term'];
    $freight = $_POST['freight_term'];
    $delivery = $_POST['delivery_term'];
    $sign = $_POST['sign'];
    $factory = $_POST['factory'];
        $cgst_per = floatval($_POST['cgst_per']);
$cgst_amt = floatval($_POST['cgst_amt']);

$sgst_per = floatval($_POST['sgst_per']);
$sgst_amt = floatval($_POST['sgst_amt']);

$igst_per = floatval($_POST['igst_per']);
$igst_amt = floatval($_POST['igst_amt']);

    // MASTER INSERT
mysqli_query($con, "
    INSERT INTO poentry
    (code, potype, dt, reqcode, reqdate, vendor, tqty, ttl,gttl,
     pkg_per, pkg_amt, fwd_per, fwd_amt, dis_per, dis_amt,
     payment_term, freight_term, delivery_term, sign, factory, cgst_per, cgst_amt, sgst_per, sgst_amt, igst_per, igst_amt)
    VALUES
    ('$code', '$potype', '$dt', '$reqcode', '$reqdate', '$vendor',
     '$tqty', '$ttl', '$gttl',
     '$pkg_per', '$pkg_amt', '$fwd_per', '$fwd_amt',
     '$dis_per', '$dis_amt', '$payment', '$freight', '$delivery', '$sign', '$factory', '$cgst_per','$cgst_amt','$sgst_per','$sgst_amt','$igst_per','$igst_amt')
");


    // CHILD INSERT
for ($i = 0; $i < count($_POST['item']); $i++) {

    $item  = mysqli_real_escape_string($con, trim($_POST['item'][$i]));
    $descr = mysqli_real_escape_string($con, trim($_POST['descr'][$i]));

    // Skip only if BOTH empty
    if ($item === '' && $descr === '') continue;

    $srno = $i + 1;

    mysqli_query($con, "
        INSERT INTO pochild
        (code, srno, item, descr, qty, rate, amt)
        VALUES (
            '$code',
            '$srno',
            '$item',
            '$descr',
            '".floatval($_POST['qty'][$i])."',
            '".floatval($_POST['rate'][$i])."',
            '".floatval($_POST['amt'][$i])."'
        )
    ");
}

    header("location: posearch.php");
}
if ($_POST['upd'] == 'Update') {

    $code   = $_POST['invno'];
    $potype = $_POST['potype'];
    $dt     = $_POST['dt'];
    $vendor = $_POST['cnor'];

    $reqcode = isset($_POST['reqcode'])
        ? implode(',', $_POST['reqcode'])
        : '';

    $reqdate = $_POST['reqdate'];

    $tqty = $_POST['tqty'];
    $ttl  = $_POST['ttl'];
    $disc = $_POST['disc'];
    $gttl = $_POST['gttl'];

    $pkg_per = $_POST['pkg_per'];
$pkg_amt = $_POST['pkg_amt'];
$fwd_per = $_POST['fwd_per'];
$fwd_amt = $_POST['fwd_amt'];
$dis_per = $_POST['dis_per'];
$dis_amt = $_POST['dis_amt'];

        $payment = $_POST['payment_term'];
    $freight = $_POST['freight_term'];
    $delivery = $_POST['delivery_term'];
    $sign = $_POST['sign'];
    $factory = $_POST['factory'];

        $cgst_per = floatval($_POST['cgst_per']);
$cgst_amt = floatval($_POST['cgst_amt']);

$sgst_per = floatval($_POST['sgst_per']);
$sgst_amt = floatval($_POST['sgst_amt']);

$igst_per = floatval($_POST['igst_per']);
$igst_amt = floatval($_POST['igst_amt']);

     mysqli_query($con,"DELETE FROM poentry WHERE code='$code'");
    // UPDATE MASTER
mysqli_query($con, "
    INSERT INTO poentry
    (code, potype, dt, reqcode, reqdate, vendor, tqty, ttl,gttl,
     pkg_per, pkg_amt, fwd_per, fwd_amt, dis_per, dis_amt,
     payment_term, freight_term, delivery_term, sign, factory, cgst_per, cgst_amt, sgst_per, sgst_amt, igst_per, igst_amt)
    VALUES
    ('$code', '$potype', '$dt', '$reqcode', '$reqdate', '$vendor',
     '$tqty', '$ttl', '$gttl',
     '$pkg_per', '$pkg_amt', '$fwd_per', '$fwd_amt',
     '$dis_per', '$dis_amt', '$payment', '$freight', '$delivery', '$sign', '$factory', '$cgst_per','$cgst_amt','$sgst_per','$sgst_amt','$igst_per','$igst_amt')
");

    // DELETE OLD CHILD
    mysqli_query($con,"DELETE FROM pochild WHERE code='$code'");

    // INSERT NEW CHILD
for ($i = 0; $i < count($_POST['item']); $i++) {

    $item  = mysqli_real_escape_string($con, trim($_POST['item'][$i]));
    $descr = mysqli_real_escape_string($con, trim($_POST['descr'][$i]));

    // Skip only if BOTH empty
    if ($item === '' && $descr === '') continue;

    $srno = $i + 1;

    mysqli_query($con, "
        INSERT INTO pochild
        (code, srno, item, descr, qty, rate, amt)
        VALUES (
            '$code',
            '$srno',
            '$item',
            '$descr',
            '".floatval($_POST['qty'][$i])."',
            '".floatval($_POST['rate'][$i])."',
            '".floatval($_POST['amt'][$i])."'
        )
    ");
}


    header("location: posearch.php");
}

?>