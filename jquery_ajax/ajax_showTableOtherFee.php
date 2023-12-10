<?php


require '../lib/functionFin_OtherFee.php';

$key = trim($_POST['key']);

$listBill = searchChiPhiKhac($connection, $key);
print_r(json_encode($listBill)) ;