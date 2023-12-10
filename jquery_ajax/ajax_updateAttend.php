<?php


require '../lib/functionUserTeacher.php';



$thoiGian = $_POST['time'];
$malop = $_POST['malop'];
$danhSachDiemDanh = $_POST['danhSachDiemDanh'];
$magv  =$_POST['magv'];

foreach ($danhSachDiemDanh as $index => $student) {

    $maHS = $student['maHS'];
    $tenHS = $student['tenHS'];
    $diemDanh = $student['diemDanh'] ? 1 : 0;


    $old_dd = selectdd($connection, $maHS, $malop, $thoiGian);

    if ($diemDanh !=  $old_dd[0]['dd']) {

        $soBuoiNghi =  selectSoBuoiNghi($connection, $maHS, $malop);
        if ($diemDanh == 0) {
            $so =   $soBuoiNghi[0]['SoBuoiNghi'] + 1;
        } else {
            $so =   $soBuoiNghi[0]['SoBuoiNghi'] - 1;
        }
        updateSoBuoiNghi($connection, $so, $malop, $maHS);
    }
    updateDiemDanh($connection, $diemDanh, $malop, $maHS, $thoiGian);
}


$result = [
    "dslop" => listClassActive($connection, $magv),
    "dsdd" =>  listDD($connection, $magv),
];

echo json_encode($result);