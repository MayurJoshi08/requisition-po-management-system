<?php
// error_reporting(0);
include('config.php');
session_start();

if ($_SESSION['dcname'] == '') {
    header("Location: login.php");
    exit;
} else {
    $username = $_SESSION['dcname'];
    $type = $_SESSION['dctype'];
}

/* =========================
   DELETE
========================= */
if (isset($_GET['delete'])) {

    $code = $_GET['delete'];

    mysqli_query($con, "DELETE FROM inventry WHERE code='$code'");
    mysqli_query($con, "DELETE FROM invchild WHERE code='$code'");
    // invchild auto deleted due to FK CASCADE

    header("Location: invreport.php");
    exit;
}

/* =========================
   SAVE
========================= */
if (isset($_POST['save']) && $_POST['save'] == "Save") {

    $code       = $_POST['code'];
    $dt         = $_POST['dt'];
    $rem        = $_POST['rem'];
    $descr      = $_POST['descr'];
    $total_amt  = $_POST['total_amt'];
    $approved   = $_POST['approved'];
    $received   = $_POST['received'];

    // PO CODE ARRAY → STRING
    $pocode = '';
    if (!empty($_POST['pocode'])) {
        $pocode = implode(',', $_POST['pocode']);
    }

    /* MASTER INSERT */
    mysqli_query($con, "
        INSERT INTO inventry
        (code, dt, pocode, rem, total_amt, approved, received, descr)
        VALUES
        ('$code','$dt','$pocode','$rem','$total_amt','$approved','$received','$descr')
    ");

    /* CHILD INSERT */
    if (!empty($_POST['invno'])) {

        for ($i = 0; $i < count($_POST['invno']); $i++) {

            if ($_POST['invno'][$i] == '') continue;

            $invno   = $_POST['invno'][$i];
            $invdate = $_POST['invdate'][$i];
            $amt     = $_POST['amt'][$i];

            mysqli_query($con, "
                INSERT INTO invchild
                (code, invno, invdate, amt)
                VALUES
                ('$code','$invno','$invdate','$amt')
            ");
        }
    }

    header("Location: invreport.php");
    exit;
}


/* =========================
   UPDATE
========================= */
if (isset($_POST['update']) && $_POST['update'] == "Update") {

    mysqli_begin_transaction($con);

    try {

        $code       = $_POST['code'];
        $dt         = $_POST['dt'];
        $rem        = $_POST['rem'];
        $descr      = $_POST['descr'];
        $total_amt  = $_POST['total_amt'];
        $approved   = $_POST['approved'];
        $received   = $_POST['received'];

        // PO CODE ARRAY → STRING
        $pocode = '';
        if (!empty($_POST['pocode'])) {
            $pocode = implode(',', $_POST['pocode']);
        }

        /* =========================
           DELETE MASTER
        ========================= */
        mysqli_query($con, "DELETE FROM inventry WHERE code='$code'");

        /* =========================
           INSERT MASTER
        ========================= */
        mysqli_query($con, "
            INSERT INTO inventry
            (code, dt, pocode, rem, total_amt, approved, received, descr)
            VALUES
            ('$code','$dt','$pocode','$rem','$total_amt','$approved','$received','$descr')
        ");

        /* =========================
           DELETE CHILD
        ========================= */
        mysqli_query($con, "DELETE FROM invchild WHERE code='$code'");

        /* =========================
           INSERT CHILD
        ========================= */
        if (!empty($_POST['invno'])) {

            for ($i = 0; $i < count($_POST['invno']); $i++) {

                if (empty($_POST['invno'][$i])) continue;

                $invno   = $_POST['invno'][$i];
                $invdate = $_POST['invdate'][$i];
                $amt     = $_POST['amt'][$i];

                mysqli_query($con, "
                    INSERT INTO invchild
                    (code, invno, invdate, amt)
                    VALUES
                    ('$code','$invno','$invdate','$amt')
                ");
            }
        }

        mysqli_commit($con);

        header("Location: invreport.php");
        exit;

    } catch (Exception $e) {

        mysqli_rollback($con);
        echo "Update failed!";
    }
}

?>
