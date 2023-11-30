$(document).ready(function () {
    $('#ss').on('click', function () {

        const id = document.getElementById('id_edit').value;
        const phone_number = document.getElementById('phone_number_edit').value;
        const email = document.getElementById('email_edit').value;
        const gender = document.getElementById('gender_edit').value;
        const Student_name = document.getElementById('sudent_name_edit').value;
        const age = document.getElementById('age_edit').value;

        const address = document.getElementById('address_edit').value;

        const birthday = document.getElementById('birthday_edit').value;



        $.ajax({
            url: '../jquery_ajax/ajax_updateInforStudent.php',
            type: 'POST',
            data: {
                id: id,
                name: Student_name,
                gender: gender,
                birthday: birthday,
                age: age,
                address: address,
                phone: phone_number,
                email: email,
            },
            success: function (res) {
                document.getElementById('lb_address_edit').innerHTML = res;
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });


    })


})

function convertDateFormat(dateString) {
    var dateParts = dateString.split("-");
    var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    return formattedDate;
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


const rows = document.querySelectorAll('.tbody-1 tr');
const modalBg = document.querySelector('.modal-bg');
const modalContent = document.querySelector('.modal-content');




var stt_select;
var ds_hocsinh;
var listClass;
var student_select;





// khi nhấn vào 1 hàng , hiển thị thông tin chi tiêt
rows.forEach((row) => {
    row.addEventListener('click', () => {

        stt_select = row.cells[1].textContent;

        listClass = row.cells[6].textContent;


        for (var i = 0; i < ds_hocsinh.length; i++) {
            if (stt_select == ds_hocsinh[i].MaHS)
                student_select = ds_hocsinh[i];
        }

        // lay tt phu huynh
        var phhs = [];
        var j = 0;
        for (var i = 0; i < ds_ph_hs.length; i++) {
            if (ds_ph_hs[i].MaHS === student_select.MaHS) {
                phhs[j++] = ds_ph_hs[i].TenPH;
            }
        }

        document.getElementById('Student-name').textContent = student_select.TenHS;
        document.getElementById('Student-gender').textContent = student_select.GioiTinh;
        document.getElementById('Student-age').textContent = student_select.Tuoi;
        document.getElementById('Student-class').textContent = listClass;
        document.getElementById('Student-id').textContent = student_select.MaHS;
        document.getElementById('Student-address').textContent = student_select.DiaChi;
        document.getElementById('Student-date').textContent = convertDateFormat(student_select.NgaySinh);
        document.getElementById('Student-phone').textContent = student_select.SDT;
        document.getElementById('Student-email').textContent = student_select.Email;



        phhs.forEach(function (name) {
            const pTag = document.createElement("p"); // Tạo thẻ p mới
            pTag.innerText = name; // Gán giá trị tên vào thẻ p
            const tdTag = document.getElementById("Student-parent"); // Lấy đối tượng td có id là Student-parent
            tdTag.appendChild(pTag);

        });

        // document.getElementById('Student-parent').textContent =

        document.getElementById('mahs_delete').value = student_select.MaHS;

        var img = document.getElementById("img");

        if (student_select.GioiTinh == "Nam") {
            img.src = "../assets/images/Student-male-icon.png";
        } else {
            img.src = "../assets/images/Student-female-icon.png";
        }

        document.getElementById("tab1").classList.add("show");
        document.getElementById("tab2").classList.remove("show");
        document.getElementById("tab3").classList.remove("show");
        document.getElementById("tb1").classList.add("active");
        document.getElementById("tb2").classList.remove("active");
        document.getElementById("tb3").classList.remove("active");

        // thong tin lop cua hoc vien
        var classes = [];
        var k = 0;
        for (var i = 0; i < ds_hs_lop.length; i++) {
            if (ds_hs_lop[i].MaHS === student_select.MaHS) {
                classes[k++] = ds_hs_lop[i];
            }
        }


        var html = '';
        var color = '';
        if (classes.length === '0') {
            html += '<p>Học viên chưa tham gia lớp học nào </p>';
        } else {
            html += '<p> Số lớp đã tham gia: ' + classes.length + '</p>';

            for (var i = 0; i < classes.length; i++) {

                if (classes[i]['TrangThai'] == 'Đang mở') {
                    color = '#00c608';
                } else if (classes[i]['TrangThai'] == 'Chưa mở') {
                    color = '#ad9d0b';
                } else {
                    color = '#ad0b0b';
                }

                html += '<div class="class">' +
                    '<p></p>' +
                    '<table>' +
                    '<tr>' +

                    '<td>' +
                    '<p id="id-class">Mã lớp học:  ' + classes[i]['MaLop'] + '</p>' +
                    '</td>' +

                    '<td>' +
                    '<p id="num-of-session">Số buổi học:  ' + classes[i]['SoBuoiDaToChuc'] + '/' + classes[i]['SoBuoi'] + ' (Vắng : ' + classes[i]['SoBuoiNghi'] + ') </p>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +

                    '<td>' +
                    '<p id="name-class">Tên lớp học:  ' + classes[i]['TenLop'] + '</p>' +
                    '</td>' +

                    '<td>' +
                    '<p id="name =name-teacher">Tên giáo viên:  ' + classes[i]['TenGV'] + '</p>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +

                    '<td>' +
                    '<p id="fee-class">Học phí:  ' + numberWithCommas(classes[i]['HocPhi']) + '/buổi' + '</p>' +
                    '</td>' +

                    '<td>' +
                    '<p id="de-fee-class">Giảm học phí:  ' + classes[i]['GiamHocPhi'] + '%' + '</p>' +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +

                    '<td>' +
                    '<p id="status-class" style ="color:' + color + '" >Trạng thái:  ' + classes[i]['TrangThai'] + '</p>' +
                    '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</div>';
            }

            document.querySelector(".class-of-student").innerHTML = html;

        }

        // thong tin tai khoan
        var username = '';
        var pass = '';
        for (var i = 0; i < ds_tk_hs.length; i++) {
            if (ds_tk_hs[i].MaHS === student_select.MaHS) {
                username = ds_tk_hs[i]['UserName'];
                pass = ds_tk_hs[i]['Password']
            }
        }
        document.getElementById('name-login').textContent = username;
        document.getElementById('username-login').value = username;
        document.getElementById('password').value = pass;

        modalBg.style.display = 'block';
    });
});
document.querySelector('.close-btn').addEventListener('click', () => {

    document.getElementById('div-change-pass').style.display = 'none';
    modalBg.style.display = 'none';
    const paragraphs = document.getElementsByTagName("p");
    while (paragraphs.length > 0) {
        paragraphs[0].parentNode.removeChild(paragraphs[0]);
    }
    document.querySelector(".class-of-student").innerHTML = '';

});



const editButton = document.getElementById('edit-button');
// const tdList = document.querySelectorAll('td[contenteditable]');

const modalBgEdit = document.querySelector('.modal-bg-edit');
const modalContentEdit = document.querySelector('.modal-content-edit');

// Khi  nhấn vào nút "Sửa"
editButton.addEventListener('click', () => {
    document.getElementById('lb_phone_edit').textContent = "";
    document.getElementById('lb_email_edit').textContent = "";
    document.getElementById('lb_name_edit').textContent = "";

    document.getElementById('lb_address_edit').textContent = "";
    // document.getElementById('lb_education_edit').textContent = "";
    document.getElementById('lb_age_edit').textContent = "";
    document.getElementById('lb_birthday_edit').textContent = "";

    modalBgEdit.style.display = "block";


    document.getElementById('sudent_name_edit').value = student_select.TenHS;

    var gt = student_select.GioiTinh;
    var selectTag = document.getElementById("gender_edit");
    for (var i = 0; i < selectTag.options.length; i++) {
        if (selectTag.options[i].value == gt) {
            selectTag.options[i].selected = true; // nếu giống nhau, đặt thuộc tính selected cho option
            break;
        }
    }

    document.getElementById('birthday_edit').value = student_select.NgaySinh;
    document.getElementById('age_edit').value = student_select.Tuoi;
    document.getElementById('Student-id_edit').textContent = "Mã Học viên : " + student_select.MaHS;
    document.getElementById('address_edit').value = student_select.DiaChi;
    document.getElementById('phone_number_edit').value = student_select.SDT;
    document.getElementById('email_edit').value = student_select.Email;
    // document.getElementById('education_edit').value = student_select.TrinhDo;
    document.getElementById('id_edit').value = student_select.MaHS;
});

document.querySelector('.cancle-btn').addEventListener('click', () => {
    modalBgEdit.style.display = 'none';

});



// Khi nhấn nút Cập nhật
const submit_update = document.getElementById('update');
submit_update.addEventListener('click', function (event) {

    var check = true;

    const form1 = document.getElementById('form_edit');
    // Ngăn chặn việc submit form mặc định để xử lý dữ liệu trước khi gửi form đi
    event.preventDefault();
    const id = document.getElementById('id_edit').value;
    const phone_number = document.getElementById('phone_number_edit').value;
    const email = document.getElementById('email_edit').value;
    const gender = document.getElementById('gender_edit').value;
    const Student_name = document.getElementById('sudent_name_edit').value;
    const age = document.getElementById('age_edit').value;

    const address = document.getElementById('address_edit').value;

    const birthday = document.getElementById('birthday_edit').value;

    var erorr_empty = "*Dữ liệu không để trống";

    //Kiểm tra dữ liệu nhập vào
    if (!Student_name) {
        document.getElementById('lb_name_edit').textContent = erorr_empty;
        check = false;
    } else
        document.getElementById('lb_name_edit').textContent = "";

    if (!birthday) {
        document.getElementById('lb_birthday_edit').textContent = erorr_empty;
        check = false;
    } else
        document.getElementById('lb_birthday_edit').textContent = "";

    if (!age) {
        document.getElementById('lb_age_edit').textContent = erorr_empty;
        check = false;
    } else
        document.getElementById('lb_age_edit').textContent = "";

    if (!address) {

        document.getElementById('lb_address_edit').textContent = erorr_empty;
        check = false;
    } else
        document.getElementById('lb_address_edit').textContent = "";

    if (!(/^(0[0-9]{9})$/.test(phone_number))) {
        document.getElementById('lb_phone_edit').textContent = "*Số điện thoại không chính xác (0..; 10 chữ số)";
        check = false;
    } else
        document.getElementById('lb_phone_edit').textContent = "";

    if (!(/\S+@\S+\.\S+/.test(email))) {
        document.getElementById('lb_email_edit').textContent = "*Email không chính xác (example@xxx.com)";
        check = false;
    } else
        document.getElementById('lb_email_edit').textContent = "";

    if (!check)
        return;




    // var data = {
    // 	id: id,
    // 	name: Student_name,
    // 	gender: gender,
    // 	birthday: birthday,
    // 	age: age,
    // 	address: address,
    // 	phone: phone_number,
    // 	email: email,
    // }

    // $.post('ajax_updateStudent.php', {
    // 	data: data
    // }, function(response) {
    // 	document.getElementById('lb_address_edit').innerHTML = response;

    // })

    // fetch('ajax_updateStudent.php', {
    // 		method: 'POST',
    // 		headers: {
    // 			'Content-Type': 'application/json',
    // 		},
    // 		body: JSON.stringify({
    // 			data: data
    // 		}),
    // 	})
    // 	.then(function(response) {
    // 		return response.text();
    // 	})
    // 	.then(function(response) {
    // 		document.getElementById('lb_address_edit').innerHTML = response;
    // 	})
    // 	.catch(function(error) {
    // 		console.error('Error:', error);
    // 	});



    $.ajax({
        type: 'POST',
        url: 'ajax_updateStudent.php',
        data: {
            id: id,
            name: Student_name,
            gender: gender,
            birthday: birthday,
            age: age,
            address: address,
            phone: phone_number,
            email: email,
        },
        success: function (res) {
            document.getElementById('lb_address_edit').innerHTML = res;
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });


    document.querySelector('.update-success').style.display = 'block';
    setTimeout(function () {   
        document.querySelector('.update-success').style.display = 'none';
        // 	// form1.submit();
    }, 1000);
    // // Gửi form đi nếu tất cả dữ liệu hợp lệ

});


// Khi nhan nut Xoa
document.getElementById('delete-button').addEventListener('click', () => {
    document.querySelector('.delete-ques').style.display = 'block';
});
document.getElementById('delete-cancle').addEventListener('click', () => {
    document.querySelector('.delete-ques').style.display = 'none';
});
document.getElementById('delete').addEventListener('click', function (event) {

    const form3 = document.getElementById('form-delete');

    event.preventDefault();
    document.querySelector('.delete-ques').style.display = 'none';
    if (listClass.length != 0) {
        document.querySelector('.delete-cant').style.display = 'block';
        return;
    }

    document.querySelector('.delete-success').style.display = 'block';
    setTimeout(function () {
        document.querySelector('.delete-success').style.display = 'none';


        form3.submit();
    }, 1000);

});

document.getElementById('close').addEventListener('click', () => {
    document.querySelector('.delete-cant').style.display = 'none';
});

// document.getElementById('refesh-btn').addEventListener('click', () => {
// 	location.reload();
// 	header("Location: manageStudent.php");
// });

// Open detail tab
document.getElementById("tab1").classList.add("show");

function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove("show");
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).classList.add("show");
    evt.currentTarget.classList.add("active");
}

//  Tài khoản
// ẩn hiện mk
function togglePassword() {
    var passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
// Đổi mật khẩu

document.getElementById('change-pass-btn').addEventListener('click', () => {
    document.getElementById('div-change-pass').style.display = 'block';

});



document.getElementById('change').addEventListener('click', function (event) {

    const form4 = document.getElementById('change-pass');
    event.preventDefault();


    var pass = document.getElementById("new-password").value;

    var con_pass = document.getElementById('confirm-password').value;

    var err_pass = '';
    var err_repass = '';
    var check_pass = true;
    console.log(pass);
    if (!pass) {
        err_pass = '*Bạn chưa nhập mật khẩu';
        check_pass = false;
    }
    if (!con_pass) {
        err_repass = '*Bạn chưa xác nhận mật khẩu';
        check_pass = false;
    } else if (pass !== con_pass) {
        err_repass = "*Mật khẩu không trùng khớp";
        check_pass = false;
    }

    document.getElementById('err-pass').textContent = err_pass;
    document.getElementById('err-repass').textContent = err_repass;


    if (!check_pass) {
        return;

    }



    document.querySelector('.change-pass-success').style.display = 'block';


    setTimeout(function () {
        document.querySelector('.change-pass-success').style.display = 'none';
        document.getElementById('err-pass').textContent = '';
        document.getElementById('err-repass').textContent = '';

        form4.submit();
    }, 1000);
});

document.getElementById('cancle-change-pass').addEventListener('click', () => {
    document.getElementById('div-change-pass').style.display = 'none';
    document.getElementById('err-pass').textContent = '';
    document.getElementById('err-repass').textContent = '';

});




var sortDirection = {}; // Store the current sort direction for each column

function sortTable(columnIndex) {
    var table = document.getElementById('table-1');
    var tbody = table.querySelector('.tbody-1');
    var rows = Array.from(tbody.getElementsByTagName('tr'));
    var sttValues = rows.map(function (row) {
        return parseInt(row.getElementsByTagName('td')[0].innerText.trim());
    });

    rows.sort(function (a, b) {


        if (columnIndex === 4) {
            var aValue = parseFloat(a.getElementsByTagName('td')[columnIndex].innerText.trim());
            var bValue = parseFloat(b.getElementsByTagName('td')[columnIndex].innerText.trim());

            if (sortDirection[columnIndex] === 'asc') {
                return aValue - bValue;
            } else {
                return bValue - aValue;
            }
        } else {
            var aValue = a.getElementsByTagName('td')[columnIndex].innerText.trim();
            var bValue = b.getElementsByTagName('td')[columnIndex].innerText.trim();
            if (sortDirection[columnIndex] === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        }


    });



    rows.forEach(function (row, index) {
        var sttCell = row.getElementsByTagName('td')[0];
        sttCell.innerText = sttValues[index];
    });

    rows.forEach(function (row) {
        tbody.appendChild(row);
    });


    // Reverse the sort direction for the clicked column
    if (sortDirection[columnIndex] === 'asc') {
        sortDirection[columnIndex] = 'desc';
    } else {
        sortDirection[columnIndex] = 'asc';
    }

    // Update the sort icon in the column header
    updateSortIcon(columnIndex);



}




function updateSortIcon(columnIndex) {
    var table = document.getElementById('table-1');
    var headers = table.querySelectorAll('th');

    headers.forEach(function (header) {
        // Remove the sort icon from all column headers
        var icon = header.querySelector('img');
        if (icon) {
            header.removeChild(icon);
        }
    });

    // Add the sort icon to the clicked column header
    var clickedHeader = headers[columnIndex];
    var sortIcon = document.createElement('img');
    sortIcon.src = '../assets/images/arrow-up-down-bold-icon.png';
    sortIcon.style.width = '20px';
    sortIcon.style.backgroundColor = 'white';
    sortIcon.style.borderRadius = '30px';
    if (sortDirection[columnIndex] === 'asc') {
        sortIcon.style.transform = 'rotate(180deg)';
    }
    clickedHeader.appendChild(sortIcon);
}




