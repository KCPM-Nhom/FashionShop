function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    // 1. Ẩn tất cả các tab nội dung
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        tabcontent[i].classList.remove("active");
    }

    // 2. Bỏ class 'active' ở tất cả các nút
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // 3. Hiển thị tab hiện tại và thêm class 'active' cho nút vừa bấm
    document.getElementById(tabName).style.display = "flex";
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.className += " active";

    // --- ĐOẠN THÊM MỚI: ĐỔI TÊN TIÊU ĐỀ ---
    const mainTitle = document.getElementById("main-title");
    if (tabName === 'tab-noibat') mainTitle.innerText = "Sản Phẩm Nổi Bật";
    if (tabName === 'tab-banchay') mainTitle.innerText = "Sản Phẩm Bán Chạy";
    if (tabName === 'tab-khuyenmai') mainTitle.innerText = "Sản Phẩm Khuyến Mãi";
}