// Hàm chuyển đổi giữa 2 tab Hồ sơ và Đổi mật khẩu
function showSection(sectionId, element) {
    // Ẩn tất cả các section
    document.querySelectorAll('.profile-section').forEach(section => {
        section.classList.remove('active');
    });
    // Hiện section được chọn
    document.getElementById(sectionId).classList.add('active');

    // Cập nhật trạng thái active cho menu sidebar
    document.querySelectorAll('.sidebar-menu li a').forEach(link => {
        link.classList.remove('active');
    });
    element.classList.add('active');
}