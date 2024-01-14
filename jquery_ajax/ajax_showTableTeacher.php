<?php

require '../lib/functionTeacher.php';
$key = trim($_POST['key']);

$listTeacher = searchTeacher($connection, $key);


$i = 1;
$nam = 0;
$nu = 0;
if (!$listTeacher) {
    echo ' <h2>Không tìm thấy kết quả phù hợp "' .$key . '"</h2>';
} else {
    foreach ($listTeacher as $teacher) : ?>
        <tr>
            <td><?php echo $i++ ?></td>
            <td><?php echo $teacher['MaGV']; ?></td>
            <td><?php echo $teacher['TenGV']; ?></td>

            <?php if ($teacher['GioiTinh'] == 'Nam') {
                $nam++;
            } else {
                $nu++;
            }
            ?>

            <td><?php echo $teacher['GioiTinh']; ?></td>
            <td><?php echo $teacher['Tuoi']; ?></td>
            <td><?php echo $teacher['DiaChi']; ?></td>
            <!-- <td><?php
                $listClass = classOfTeacher($connection, $teacher['MaGV']);
                foreach ($listClass as $class) :
                    echo $class['MaLop'] . ' ; ';
                endforeach;
                ?></td> -->
           

        </tr>
<?php endforeach;
} ?>