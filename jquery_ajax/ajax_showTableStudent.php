<?php 
require '../lib/functionStudent.php';


$key = trim($_POST['key']);

    $listStudent = searchStudent($connection, $key);

$i = 1;
$nam = 0;
$nu = 0;
if (!$listStudent) {
    echo ' <h2>Không tìm thấy kết quả phù hợp "' . $key  . '"</h2>';
} else {
    foreach ($listStudent as $Student) : ?>
        <?php if ($Student['GioiTinh'] == 'Nam') {
            $nam++;
        } else {
            $nu++;
        }
        ?>
        <tr>
            <td><?php echo $i++ ?></td>
            <td><?php echo $Student['MaHS']; ?></td>
            <td><?php echo $Student['TenHS']; ?></td>
            <td><?php echo $Student['GioiTinh']; ?></td>
            <td><?php echo $Student['Tuoi']; ?></td>
            <td style="width :200px"><?php echo $Student['DiaChi']; ?></td>
            <!-- <td><?php
                $listClass = classOfStudent($connection, $Student['MaHS']);
                foreach ($listClass as $class) :
                    if ($class['TrangThai'] =="Đang mở") {
                        echo $class['MaLop'] . '; ';
                    }
                  
                endforeach;
                ?></td> -->


        </tr>
<?php endforeach;
} ?>