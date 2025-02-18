<?php
require '../config/database.php';

header('Content-Type: application/json');

$query = isset($_GET['query']) ? $_GET['query'] : "";

$filter = [];
if (!empty($query)) {
    $filter = ['$text' => ['$search' => $query]];
}

$collection = $db->offers;
$offers = $collection->find($filter);

$result = [];
foreach ($offers as $offer) {
    $offer['_id'] = (string) $offer['_id']; 
    $result[] = $offer;
}

echo json_encode($result);
?>
