<?php
require '../lib/functionParent.php';
$key = trim($_POST['key']);

    $listParent = searchParent($connection, $key);
    $listph_hs = listph_hs($connection);
$i = 1;
$nam = 0;
$nu = 0;
if (!$listParent) {
    echo ' <h2>Không tìm thấy kết quả phù hợp "' .$key . '"</h2>';
} else {
    foreach ($listParent as $Parent) : ?>
        <?php if ($Parent['GioiTinh'] == 'Nam') $nam++;
        else $nu++; ?>
        <tr>
            <td><?php echo $i++ ?></td>
            <td><?php echo $Parent['MaPH']; ?></td>
            <td><?php echo $Parent['TenPH']; ?></td>
            <td><?php echo $Parent['GioiTinh']; ?></td>
            <td><?php echo $Parent['Tuoi']; ?></td>
            <td style="width :200px"><?php echo $Parent['DiaChi']; ?></td>
            <td><?php

                foreach ($listph_hs as $hs) :
                    if ($hs['MaPH'] === $Parent['MaPH']) {
                        echo $hs['TenHS'];
                        echo '<br>';
                    }
                endforeach;
                ?></td>


        </tr>
<?php endforeach;
} ?>