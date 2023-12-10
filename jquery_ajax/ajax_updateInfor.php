<?php
require '/../lib/functionPersonal.php';


    $mahs = $_POST['id'];
    $ten = trim($_POST['name']);
    $gt = $_POST['gender'];
    $ns = $_POST['birthday'];
    $tuoi = $_POST['age'];
    $dc = trim($_POST['address']);
    $sdt = $_POST['phone'];
    $email = trim($_POST['email']);
    $user = $_POST['user'];
    if($user == "student"){

        updateStudentbyID($connection, $mahs, $ten, $gt, $ns, $tuoi, $dc, $sdt, $email);
        $detailStudent = selectStudent($connection, $mahs);
        print_r(json_encode($detailStudent));
    }


   


