<?php
require '../lib/functionFin_wageTea.php';


$key = trim($_POST['key']);

    $listBill = searchLuongGV($connection, $key);


print_r(json_encode($listBill)) ;



