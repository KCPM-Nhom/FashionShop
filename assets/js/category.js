/* Xử lý cập nhật tham số sắp xếp (sort) trên URL và tải lại trang */
function applySort(sortType) {
    // Lấy tất cả các tham số hiện tại trên thanh URL
    const urlParams = new URLSearchParams(window.location.search);
    
    // Thêm hoặc cập nhật biến 'sort'
    urlParams.set('sort', sortType);
    
    // Tải lại trang với URL mới
    window.location.search = urlParams.toString();
}