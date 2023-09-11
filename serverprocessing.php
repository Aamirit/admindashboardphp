<?php

require_once('db.php'); 


$table = 'reviews';


$start = $_POST['start'];
$length = $_POST['length'];


$columns = array('id', 'name', 'email', 'review');
$orderBy = $columns[$_POST['order'][0]['column']];
$orderDir = $_POST['order'][0]['dir'];


$search = $_POST['search']['value'];


$totalRecordsQuery = "SELECT COUNT(*) as total FROM $table";
$totalRecordsResult = mysqli_query($connection, $totalRecordsQuery);
$totalRecordsData = mysqli_fetch_assoc($totalRecordsResult);
$totalRecords = $totalRecordsData['total'];

$filteredRecordsQuery = "SELECT COUNT(*) as total FROM $table WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
$filteredRecordsResult = mysqli_query($connection, $filteredRecordsQuery);
$filteredRecordsData = mysqli_fetch_assoc($filteredRecordsResult);
$filteredRecords = $filteredRecordsData['total'];


$query = "SELECT id, name, email, review FROM $table WHERE name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY $orderBy $orderDir LIMIT $start, $length";
$result = mysqli_query($connection, $query);


$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



$response = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data 
);

echo json_encode($response);
?>
