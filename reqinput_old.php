<?php
include('config.php');

if (!isset($_SESSION['dcname']) || $_SESSION['dcname'] == '') {
    header("Location: login.php");
    exit;
}

date_default_timezone_set('Asia/Kolkata');

/* ---------- DELETE ---------- */
if (isset($_GET['delete'])) {
    $code = mysqli_real_escape_string($con, $_GET['delete']);

    mysqli_query($con, "DELETE FROM reqchild WHERE code='$code'");
    mysqli_query($con, "DELETE FROM reqentry WHERE code='$code'");

    header("Location: reqsearch.php");
    exit;
}

/* ---------- SAVE OR UPDATE ---------- */
if (isset($_POST['save']) || isset($_POST['update'])) {

    $code = mysqli_real_escape_string($con, $_POST['code']);
    $dt = $_POST['dt'];
    $vendor = $_POST['vendor'];
    $ttl = $_POST['ttl'];

    $category = isset($_POST['category']) ? implode(',', $_POST['category']) : '';
    $payment = $_POST['payment_term'];
    $freight = $_POST['freight_term'];
    $delivery = $_POST['delivery_term'];
    $prepared_by = $_POST['prepared_by'];

    $pkg_per = floatval($_POST['pkg_per']);
    $pkg_amt = floatval($_POST['pkg_amt']);
    $fwd_per = floatval($_POST['fwd_per']);
    $fwd_amt = floatval($_POST['fwd_amt']);
    $dis_per = floatval($_POST['dis_per']);
    $dis_amt = floatval($_POST['dis_amt']);
    $grandttl = floatval($_POST['grandttl']);

    /* ----- UPDATE MODE: DELETE OLD ----- */
    if (isset($_POST['update'])) {
        mysqli_query($con, "DELETE FROM reqchild WHERE code='$code'");
        mysqli_query($con, "DELETE FROM reqentry WHERE code='$code'");
    }

    /* ----- INSERT MASTER ----- */
    mysqli_query($con, "
        INSERT INTO reqentry
        (code, dt, vendor, ttl, category, payment_term, freight_term, delivery_term, prepared_by,
         pkg_per, pkg_amt, fwd_per, fwd_amt, dis_per, dis_amt, grandttl)
        VALUES
        ('$code','$dt','$vendor','$ttl','$category','$payment','$freight','$delivery','$prepared_by',
         $pkg_per,$pkg_amt,$fwd_per,$fwd_amt,$dis_per,$dis_amt,$grandttl)
    ") or die(mysqli_error($con));

    /* ----- INSERT CHILD ----- */
    $items  = $_POST['item'];
    $qty    = $_POST['qty'];
    $rate   = $_POST['rate'];
    $amt    = $_POST['amt'];
    $lpdt   = $_POST['lpdt'];
    $descr  = $_POST['descr'];
    $reason = $_POST['reason'];

    for ($i = 0; $i < count($items); $i++) {
        if (!empty($items[$i]) || !empty($descr[$i])) {

            $srno = $i + 1;

            $item   = mysqli_real_escape_string($con, $items[$i]);
            $qty_v  = floatval($qty[$i]);
            $rate_v = floatval($rate[$i]);
            $amt_v  = floatval($amt[$i]);
            $lpdt_v = mysqli_real_escape_string($con, $lpdt[$i]);
            $descr_v = mysqli_real_escape_string($con, $descr[$i]);
            $reason_v = mysqli_real_escape_string($con, $reason[$i]);

            mysqli_query($con, "
                INSERT INTO reqchild
                (code, srno, item, qty, rate, amt, lpdt, descr, reason)
                VALUES
                ('$code','$srno','$item',$qty_v,$rate_v,$amt_v,'$lpdt_v','$descr_v','$reason_v')
            ") or die(mysqli_error($con));
        }
    }

    header("Location: reqsearch.php");
    exit;
}
?>
