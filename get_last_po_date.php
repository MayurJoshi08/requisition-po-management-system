<?php
include('config.php');

$item = $_POST['item'] ?? '';

$response = ['status' => 'fail'];

if ($item != '') {

    // get last pochild entry for this item
    $sql = "
        SELECT rc.code, re.dt
        FROM pochild rc
        JOIN poentry re ON re.code = rc.code
        WHERE rc.item = '$item'
        ORDER BY re.dt DESC
        LIMIT 1
    ";

    $res = mysqli_query($con, $sql);

    if ($row = mysqli_fetch_assoc($res)) {
        $dt = date('d.m.Y', strtotime($row['dt']));
        $response = [
            'status' => 'success',
            'date' => $dt
        ];
    }
}

echo json_encode($response);
