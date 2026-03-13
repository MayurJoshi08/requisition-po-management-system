<?php
include('config.php');

$codes = $_POST['codes'];

$codeList = "'" . implode("','", $codes) . "'";

/* ================= HEADER DATA ================= */
$reqEntry = [];

$q1 = mysqli_query($con,"
    SELECT 
        r.code,
        r.dt,
        r.vendor,
        r.payment_term,
        r.freight_term,
        r.delivery_term,
        r.pkg_per,
        r.pkg_amt,
        r.fwd_per,
        r.fwd_amt,
        r.dis_per,
        r.dis_amt,
        r.cgst_per,
        r.cgst_amt,
        r.sgst_per,
        r.sgst_amt,
        r.igst_per,
        r.igst_amt,
        r.grandttl,
        v.name AS vendor_name
    FROM reqentry r
    LEFT JOIN vendormst v ON v.code = r.vendor
    WHERE r.code IN ($codeList)
");

while($r = mysqli_fetch_assoc($q1)){
    $reqEntry[] = $r;
}

/* ================= ITEM DATA ================= */
$reqChild = [];

$q2 = mysqli_query($con,"
    SELECT code, item, descr, qty, rate, amt
    FROM reqchild
    WHERE code IN ($codeList)
");

while($r = mysqli_fetch_assoc($q2)){
    $reqChild[] = $r;
}

echo json_encode([
    'entry' => $reqEntry,
    'child' => $reqChild
]);
