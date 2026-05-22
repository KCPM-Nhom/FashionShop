document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // 1. XỬ LÝ THANH TÌM KIẾM
    // ==========================================
    const searchIcon = document.getElementById('search-icon');
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.querySelector('.search-input');

    searchIcon.addEventListener('click', function (e) {
        if (searchForm.classList.contains('active') && searchInput.value.trim() !== "") {
            searchForm.submit();
        } else {
            e.preventDefault();
            searchForm.classList.toggle('active');
            if (searchForm.classList.contains('active')) {
                searchInput.focus();
            }
        }
    });

    // ==========================================
    // 2. XỬ LÝ MENU SẢN PHẨM (Click để mở)
    // ==========================================
    const dropdownLinks = document.querySelectorAll('.dropdown > a');

    dropdownLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const subMenu = this.nextElementSibling;
            const icon = this.querySelector('i');

            if (subMenu) {
                subMenu.classList.toggle('show');
                if (icon) {
                    icon.classList.toggle('rotate');
                }
            }
        });
    });

    // ==========================================
    // 3. XỬ LÝ MENU USER (Click để mở)
    // ==========================================
    const userDropdownLink = document.querySelector('.user-dropdown > a');
    const userSubMenu = document.querySelector('.user-sub-menu');

    if (userDropdownLink && userSubMenu) {
        userDropdownLink.addEventListener('click', function (e) {
            e.preventDefault(); // Ngăn trình duyệt nhảy trang khi click thẻ <a>
            userSubMenu.classList.toggle('show');
        });
    }

    // ==========================================
    // 4. ĐÓNG TẤT CẢ MENU KHI BẤM RA NGOÀI
    // ==========================================
    document.addEventListener('click', function (e) {
        // Đóng thanh tìm kiếm
        if (!searchForm.contains(e.target)) {
            searchForm.classList.remove('active');
        }

        // Đóng menu sản phẩm
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.sub-menu.show, .sub-menu-level-2.show').forEach(menu => {
                menu.classList.remove('show');
            });
            document.querySelectorAll('.dropdown a i.rotate, .dropdown-item a i.rotate').forEach(icon => {
                icon.classList.remove('rotate');
            });
        }

        // Đóng menu user
        if (!e.target.closest('.user-dropdown')) {
            if (userSubMenu && userSubMenu.classList.contains('show')) {
                userSubMenu.classList.remove('show');
            }
        }
    });
});