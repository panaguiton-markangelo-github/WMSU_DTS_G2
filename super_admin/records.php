<?php

include '../include/database.php';

$db = new Connection();

if (isset($_POST['type']) && isset($_POST['schoolYear']) && !empty($_POST['type']) && !empty($_POST['schoolYear'])) {
    $type = $_POST['type'];
    $schoolYear = $_POST['schoolYear'];

    $rows = $model->fetch_filter($type, $schoolYear);
} elseif (isset($_POST['type']) && empty($_POST['schoolYear'])) {
    $schoolYear = $_POST['schoolYear'];

    $rows = $model->fetch_std_filter($schoolYear);
} elseif (empty($_POST['type']) && isset($_POST['schoolYear'])) {
    $schoolYear = $_POST['schoolYear'];

    $rows = $model->fetch_res_filter($schoolYear);
} else {
    $rows = $model->fetch();
}

echo json_encode($rows);