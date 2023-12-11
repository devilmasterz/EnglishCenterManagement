<?php
require '../lib/functionFinance.php';


$key = trim($_POST['key']);
$listBill = searchHDHocPhi($connection, $key);

print_r(json_encode($listBill)) ;

?>