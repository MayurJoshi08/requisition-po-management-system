<?php
include('config.php');


$mainCon = mysqli_connect('127.0.0.1', 'root', '', 'Reception');

if (!$mainCon) {
    die('Main Reception DB connection failed');
}



$data = [];

$q = mysqli_query($mainCon, "SELECT DISTINCT item FROM reqchild ORDER BY item ASC");
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = [
        'item' => $row['item']
    ];
}

echo json_encode($data);
?>
