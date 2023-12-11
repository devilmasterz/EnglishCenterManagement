<?php
    require '../lib/functionFin_History.php';
    $key = trim($_POST['key']);
    $listBill = searchHistory($connection, $key);
    print_r(json_encode($listBill)) ;