document.addEventListener("DOMContentLoaded", function () {

    // 1. XỬ LÝ ẨN/HIỆN MẬT KHẨU (Dùng chung cho cả Login và Register)
    // Tìm tất cả các icon có class là 'eye'
    const eyeIcons = document.querySelectorAll('.eye');

    eyeIcons.forEach(icon => {
        // Thêm sự kiện click cho từng icon
        icon.addEventListener('click', function () {
            // Tìm thẻ input nằm ngay trước icon con mắt
            const input = this.previousElementSibling;

            if (input && input.tagName === 'INPUT') {
                if (input.type === 'password') {
                    input.type = 'text'; // Hiện chữ
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash'); // Đổi icon thành gạch chéo
                } else {
                    input.type = 'password'; // Ẩn chữ
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye'); // Trở lại icon mắt bình thường
                }
            }
        });
    });

    // 2. KIỂM TRA MẬT KHẨU NHẬP LẠI (Dành riêng cho Register)
    const registerForm = document.getElementById('registerForm');

    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            const pass1 = document.getElementById('pass1').value;
            const pass2 = document.getElementById('pass2').value;

            if (pass1 !== pass2) {
                event.preventDefault(); // Chặn không cho form submit lên server
                alert("Mật khẩu nhập lại không khớp. Vui lòng kiểm tra lại!");
            }
        });
    }

});