<?php
require '../lib/functionStudent.php';

$listStudent = listStudent($connection);
$listph_hs = listph_hs($connection);
$lisths_lop = lisths_lop($connection);
$listtk_hs = listtk_hs($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['sudent_name_edit'])) {

		$mahs = $_POST['id_edit'];
		$ten = trim($_POST['sudent_name_edit']);
		$gt = $_POST['gender_edit'];
		$ns = $_POST['birthday_edit'];
		$tuoi = $_POST['age_edit'];
		$dc = trim($_POST['address_edit']);
		$sdt = $_POST['phone_number_edit'];
		$email = trim($_POST['email_edit']);
		updateStudentbyID($connection, $mahs, $ten, $gt, $ns, $tuoi, $dc, $sdt, $email);
		header("Location: manageStudent.php");
	}

	if (isset($_POST['refesh'])) {
		header("Location: manageStudent.php");
	}

	if (isset($_POST['search'])) {
		$key = trim($_POST['keyword']);
		$listStudent = searchStudent($connection, $key);
	}

	if (isset($_POST['mahs_delete'])) {
		$mahs = $_POST['mahs_delete'];
		deletetk_hs($connection, $mahs);
		deleteStudent_ph_hs($connection, $mahs);
		deleteNgaydk($connection, $mahs);

		deleteLKPHHS($connection, $mahs);
		deleteDiemDanh($connection, $mahs);
		$listMaHD = selectMaHD($connection, $mahs);
		foreach ($listMaHD as $hd) {
			deleteLSTHP($connection, $hd['MaHD']);
		}
		deleteStudent($connection, $mahs);
		header("Location: manageStudent.php");
	}

	if (isset($_POST['username-login'])) {
		$username = $_POST['username-login'];
		$pass = $_POST['new-password'];

		updatePassHS($connection, $username, $pass);
		header("Location: manageStudent.php");
	}
}

$jsonListStudent = json_encode($listStudent);
$jsonListph_hs = json_encode($listph_hs);
$jsonLisths_lop = json_encode($lisths_lop);
$jsonListtk_hs = json_encode($listtk_hs);

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/manageStudent.css">

	<script src="https://code.jquery.com/jquery-3.6.4.js"></script>
</head>

<body>
	<header>
		<div class="logo">
			<img src="../assets/images/logo-web.png" alt="Logo">

		</div>
		<nav>
			<ul>
				<li><a href="./ListClass.php">Quản lý lớp học</a></li>
				<li><a style="color: #0088cc;" href="../manage/manageStudent.php">Quản lý học viên</a></li>
				<li><a href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
				<li><a href="../manage/manageParent.php">Quản lý phụ huynh</a></li>
				<li><a href="../manage/ManageFinance.php">Quản lý tài chính</a></li>
				<li><a href="../manage/manageStatistical.php">Báo cáo thống kê</a></li>
				<li><a href="../pages/home/home.php" style="display: flex;"><img src="../assets/images/icon-logout.png" alt="" style="width:20px"></a></li>

			</ul>
		</nav>
	</header>
	<main>

		<h1>Quản lý Học viên</h1>
		<div class="search-container">
			<form id="form-search" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 50%; margin: unset;display: inline-flex;" autocomplete="off">
				<input type="text" name="keyword" placeholder="Tìm kiếm..." style="width: 70%" value="<?php if (isset($_POST['keyword'])) {
																											echo $_POST['keyword'];
																										}
																										?>">
				<input type="submit" name="search" value="Tìm kiếm" style="width: 100px">
				<button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
			</form>

		</div>

		<table id="table-1">
			<thead>
				<tr>
					<th onclick="sortTable(0)">STT</th>
					<th onclick="sortTable(1)">Mã học viên</th>
					<th onclick="sortTable(2)">Họ Tên</th>
					<th onclick="sortTable(3)">Giới tính</th>
					<th onclick="sortTable(4)">Tuổi</th>
					<th onclick="sortTable(5)" style="width :200px">Địa chỉ</th>
					<th onclick="sortTable(6)">Lớp đang học</th>


				</tr>
			</thead>
			<tbody class="tbody-1">
				<?php $i = 1;
				$nam = 0;
				$nu = 0;
				if (!$listStudent) {
					echo ' <h2>Không tìm thấy kết quả phù hợp "' . $_POST['keyword'] . '"</h2>';
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
							<td><?php
								$listClass = classOfStudent($connection, $Student['MaHS']);
								foreach ($listClass as $class) :
									echo $class['MaLop'] . ' ; ';
								endforeach;
								?></td>


						</tr>
				<?php endforeach;
				} ?>



			</tbody>
		</table>

		<!-- Thong tin chi tiet -->
		<div class="modal-bg">
			<div class="modal-content">


				<h2>Thông tin học viên</h2>
				<button id="edit-button" style="position: absolute;top: 40px;right: 60px;">Sửa</button>

				<button id="delete-button" name="delete" style="position: absolute;top: 40px;right: 11px; background-color: #e90000">Xóa</button>

				<div class="container">

					<div class="header">
						<img id="img" alt="Avatar" class="avatar">

						<h1 class="name" id="Student-name"></h1>
					</div>

					<div class="detail">

						<div class="tab">
							<button class="tablinks" id="tb1" onclick="openTab(event, 'tab1')">Chung</button>
							<button class="tablinks" id="tb2" onclick="openTab(event, 'tab2')"> Lớp học</button>
							<button class="tablinks" id="tb3" onclick="openTab(event, 'tab3')">Tài khoản</button>
						</div>

						<div id="tab1" class="tabcontent">

							<table>
								<tr>
									<th>Mã học viên:</th>
									<td id="Student-id"></td>
								</tr>
								<tr>
									<th>Giới tính:</th>
									<td id="Student-gender" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Ngày sinh:</th>
									<td id="Student-date" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Tuổi:</th>
									<td id="Student-age" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Địa chỉ:</th>
									<td id="Student-address" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Lớp đang học</th>
									<td id="Student-class" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Phụ huynh:</th>
									<td id="Student-parent"></td>
								</tr>

								<tr>
									<th>Số điện thoại: </th>
									<td id="Student-phone" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Email:</th>
									<td id="Student-email" contenteditable="false"></td>
								</tr>
							</table>
						</div>


						<div id="tab2" class="tabcontent">
							<div class="class-of-student">

							</div>
						</div>

						<div id="tab3" class="tabcontent">
							<div>
								<table>
									<tr>
										<td>
											<h3 style="text-align: center;"> Tên đăng nhập : </h3>
										</td>
										<td>
											<label id="name-login"> </label>
										</td>
									</tr>
									<tr>
										<td>
											<h3 style="text-align: center;"> Mật khẩu : </h3>
										</td>
										<td>
											<input type="password" id="password" style="height: 21px;font-size: 18px;" readonly>
											<button style="background-color: slategray;" onclick="togglePassword()">Hiện/ẩn</button>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<button style=" background-color: peru;" id="change-pass-btn">Đổi mật khẩu</button>
										</td>
									</tr>
								</table>
							</div>

							<div id="div-change-pass">
								<form action="#" method="POST" id="change-pass" name="change-pass">
									<table>

										<tr>
											<td>
												<label> Tên đăng nhập : </label>
											</td>
											<td>
												<input type="text" id="username-login" name="username-login" readonly>
											</td>
										</tr>
										<tr>

											<td>
												<label for="new-password">Mật khẩu mới:</label>
											</td>
											<td>
												<input type="password" id="new-password" name="new-password" autocomplete="false"><br>
											</td>
										</tr>
										<tr>
											<td>
												<h5 id="err-pass" style="color: red;font-style: italic;  font-size: 14px;"></h5>
											</td>

										</tr>

										<tr>
											<td>
												<label for="confirm-password">Nhập lại mật khẩu mới:</label>
											</td>
											<td>
												<input type="password" id="confirm-password" name="confirm-password" autocomplete="false"><br>
											</td>
										</tr>
										<tr>
											<td>
												<h5 id="err-repass" style="color: red;font-style: italic;  font-size: 14px;"></h5>
											</td>

										</tr>

										<tr>
											<td style="text-align :center">
												<button type="button" id="cancle-change-pass" style=" font-size: 14px;padding: 14px 20px;">Hủy bỏ</button>
											</td>
											<td style="text-align :center">
												<input type="submit" name="change" id="change" style="width: unset" value="Đổi mật khẩu">
											</td>
										</tr>

									</table>
								</form>
							</div>
						</div>

					</div>


				</div>

				<button class="close-btn">Đóng</button>
			</div>
		</div>

		<!-- Sua thong tin -->
		<div class="modal-bg-edit">
			<div class="modal-content-edit">
				<div>
					<form id="form_edit" name="form_edit" method="post">


						<!-- <label for="Student_id">Mã giáo viên: 1</label>
						<input type="text" id="Student_id" name="Student_id" required> -->

						<button type="button" id="ss">s</button>
						<h1>Sửa thông tin học viên</h1>
						
						<h2 id="Student-id_edit"></h2>
						<input type="hidden" id="id_edit" name="id_edit">

						<label for="Student_name">Tên học viên: <label id="lb_name_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="sudent_name_edit" name="sudent_name_edit" required>

						<label for="gender">Giới tính:</label>
						<select id="gender_edit" name="gender_edit">
							<option>Nam</option>
							<option>Nữ</option>
						</select>

						<label for="birthday">Ngày sinh:</label>
						<input type="date" id="birthday_edit" name="birthday_edit" required><label id="lb_birthday_edit" style="color:red; font-size:13px ; font-style: italic "></label>

						<label for="age" style="margin-left: 150px;">Tuổi:</label>
						<input type="number" id="age_edit" name="age_edit" required> <label id="lb_age_edit" style="color:red; font-size:13px ; font-style: italic "></label>
						<br>
						<label for="address">Địa chỉ: <label id="lb_address_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="address_edit" name="address_edit" required>

						<!-- <label for="education">Trình độ: <label id="lb_education_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="education_edit" name="education_edit" required> -->

						<label for="phone_number">Số điện thoại: <label id="lb_phone_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="tel" id="phone_number_edit" name="phone_number_edit" required>

						<label for="email">Email: <label id="lb_email_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="email" id="email_edit" name="email_edit" required>


						<input type="submit" id='update' name="update" value="Cập nhật">

					</form>
					<button class="cancle-btn">Hủy bỏ</button>
				</div>
			</div>
		</div>



		<!-- Thong bao -->

		<div class="add-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Thêm giáo viên thành công!</h3>
		</div>
		<div class="update-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Thay đổi thành công!</h3>
		</div>
		<div class="delete-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Xóa thành công!</h3>
		</div>

		<div class="delete-ques">
			<img src="../assets/images/Help-icon.png" alt="" style=" width: 40px;">
			<h4>Bạn chắc chắn muốn xóa?</h4>
			<div style="display:flex ;justify-content: space-evenly;align-items: center">

				<button style="background-color:#52a95f; height: 44px;width: 80px" id="delete-cancle">Hủy bỏ</button>
				<form id="form-delete" action="" method="POST">
					<input type="hidden" id="mahs_delete" name="mahs_delete">
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete" name="delete" value="Xóa"></input>
				</form>
			</div>
		</div>

		<div class="delete-cant">
			<img src="../assets/images/Close-icon.png" alt="" style=" width: 40px;">
			<h3>Học viên đang có lớp theo học <br> Không thể xóa!</h3>
			<button id="close">Đóng</button>
		</div>

		<div class="change-pass-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Thay đổi mật khẩu thành công!</h3>
		</div>

		<p style="margin-left: 80%; font-style:italic; font-size:13px"> <?php echo '*Tổng số học viên: ' . $i - 1 . '  Nam: ' . $nam . '  Nữ: ' . $nu ?> </p>


	</main>




	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>

	<script>
	ds_hocsinh = <?php print_r($jsonListStudent); ?>;
        ds_ph_hs = <?php print_r($jsonListph_hs); ?>;
        ds_hs_lop = <?php print_r($jsonLisths_lop); ?>;
        ds_tk_hs = <?php print_r($jsonListtk_hs); ?>;

	</script>;

<script src="../../assets/js/manageStudent.js"></script>



</html>