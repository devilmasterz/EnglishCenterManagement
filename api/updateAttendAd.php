
<?php
include "../lib/FunctionClass.php";


$malop = $_POST['malop'];

$time = $_POST['date'];
$datajs = json_decode($_POST['data'], true);


$getCodeStudentByTimeandCodeClass = getCodeStudentByTimeandCodeClass($malop, $time, $connection);
foreach ($getCodeStudentByTimeandCodeClass as $data) {
    $checkBoxOld = $data['dd'];
    
    if ($datajs !== null && is_array($datajs)) {

        foreach ($datajs as $item) {
            if($item['MaHS'] ==  $data['MAHS']){
                $checkBoxNew = $item['isChecked'];
               
                if ($checkBoxOld != $checkBoxNew) {
                    updatediemdanhStudent($malop, $data['MAHS'], $checkBoxNew, $connection);
                }
                editdiemdanhClass($malop, $data['MAHS'], $time, $checkBoxNew, $connection);
    
            }
        }
    }



    
    
}


