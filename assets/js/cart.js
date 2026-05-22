document.addEventListener('DOMContentLoaded', function () {
    const selectAllCb = document.getElementById('selectAll');
    const itemCbs = document.querySelectorAll('.item-checkbox');
    const btnDeleteSelected = document.getElementById('deleteSelected');

    // Kiểm tra xem các phần tử có tồn tại trên trang không (tránh lỗi khi giỏ hàng trống)
    if (selectAllCb && itemCbs.length > 0 && btnDeleteSelected) {

        // Cập nhật trạng thái của nút Xóa và ô Chọn tất cả
        function updateState() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            const totalCount = itemCbs.length;

            selectAllCb.checked = (checkedCount === totalCount && totalCount > 0);
            btnDeleteSelected.disabled = (checkedCount === 0);
        }

        // Sự kiện khi bấm ô Chọn tất cả
        selectAllCb.addEventListener('change', function () {
            itemCbs.forEach(cb => {
                cb.checked = selectAllCb.checked;
            });
            updateState();
        });

        // Sự kiện khi bấm từng ô check nhỏ
        itemCbs.forEach(cb => {
            cb.addEventListener('change', updateState);
        });

        // =========================================================
        // SỰ KIỆN KHI BẤM NÚT "XÓA SẢN PHẨM ĐÃ CHỌN"
        // =========================================================
        btnDeleteSelected.addEventListener('click', function () {
            const checkedCbs = document.querySelectorAll('.item-checkbox:checked');
            if (checkedCbs.length > 0) {
                if (confirm('Bạn có chắc muốn xóa các sản phẩm đã chọn khỏi giỏ hàng?')) {
                    // Gom tất cả cart_id từ các checkbox đang được chọn
                    const ids = Array.from(checkedCbs).map(cb => cb.value);

                    // Gửi chuỗi các cart_id (ví dụ: "1,5,8") sang file PHP xử lý xóa nhiều
                    window.location.href = 'process/remove_cart_multiple.php?ids=' + ids.join(',');
                }
            }
        });
    }

    // =========================================================
    // XỬ LÝ NÚT TĂNG GIẢM SỐ LƯỢNG TRONG GIỎ HÀNG
    // =========================================================
    const cartItems = document.querySelectorAll('.cart-item');
    cartItems.forEach(item => {
        const btns = item.querySelectorAll('.btn-qty');
        // Checkbox đang giữ giá trị là cart_id (đã được echo ở file PHP)
        const checkbox = item.querySelector('.item-checkbox');

        if (btns.length >= 2 && checkbox) {
            const btnMinus = btns[0];
            const btnPlus = btns[1];
            const cartId = checkbox.value;

            btnMinus.addEventListener('click', function (e) {
                e.preventDefault(); // Ngăn hành vi mặc định của button/thẻ a
                // Gọi file update_cart.php với lệnh giảm và truyền cart_id
                window.location.href = `process/update_cart.php?action=decrease&cart_id=${cartId}`;
            });

            btnPlus.addEventListener('click', function (e) {
                e.preventDefault();
                // Gọi file update_cart.php với lệnh tăng và truyền cart_id
                window.location.href = `process/update_cart.php?action=increase&cart_id=${cartId}`;
            });
        }
    });
});

// =========================================================
// HÀM TĂNG GIẢM SỐ LƯỢNG Ở TRANG CHI TIẾT SẢN PHẨM (detail.php)
// (Hàm này mình giữ nguyên vì nó xài độc lập, không dính tới DB giỏ hàng)
// =========================================================
function updateQty(change) {
    let qtyInput = document.getElementById('qty_input');
    if (qtyInput) {
        let currentVal = parseInt(qtyInput.value);
        if (isNaN(currentVal)) currentVal = 1; // Đảm bảo luôn là số

        let newVal = currentVal + change;

        // Không cho phép số lượng nhỏ hơn 1
        if (newVal < 1) newVal = 1;

        qtyInput.value = newVal;
    }
}