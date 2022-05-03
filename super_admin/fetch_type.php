<?php


include '../include/database.php';

$db = new Connection();

$rows = $db->fetch_type();

echo json_encode($rows);